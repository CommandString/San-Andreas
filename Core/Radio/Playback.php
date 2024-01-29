<?php

namespace Core\Radio;

use Discord\Parts\Channel\Channel;
use Discord\Voice\VoiceClient;
use LogicException;
use React\ChildProcess\Process;
use React\Promise\Promise;
use React\Promise\PromiseInterface;

use function Core\discord;

class Playback
{
    public const STATE_PLAYING = true;
    public const STATE_PAUSED = false;

    /** @var static[] */
    private static array $playbacks = [];

    private Process $ffmpeg;

    protected function __construct(
        public readonly VoiceClient $client
    ) {
        self::$playbacks[$client->getChannel()->guild_id] = $this;
    }

    public function play(RadioStation $station, Song $song): void
    {
        if (isset($this->ffmpeg)) {
            $this->client->stop();
            $this->ffmpeg->terminate();
        }

        $this->ffmpeg = $this->client->ffmpegEncode($station->getStreamUrl(), [
            '-ss', $song->timestamp,
        ]);

        $this->ffmpeg->start();
        $this->client->playOggStream($this->ffmpeg);
    }

    public function setPlayState(bool $state): void
    {
        if ($this->client->isSpeaking() && !$this->client->isPaused() && !$state) {
            $this->client->pause();
        } elseif ($this->client->isPaused() && $state) {
            $this->client->unpause();
        }
    }

    public function getPlayState(): bool
    {
        return $this->client->isSpeaking() && !$this->client->isPaused();
    }

    public static function resolve(Channel $channel): ?PromiseInterface
    {
        if ($channel->type !== Channel::TYPE_GUILD_VOICE) {
            throw new LogicException('Channel must be a voice channel.');
        }

        return new Promise(static function (callable $resolve) use ($channel) {
            $existingPlayback = self::$playbacks[$channel->guild_id] ?? null;

            if ($existingPlayback !== null && $existingPlayback->client->getChannel()) {
                $resolve($existingPlayback);

                return;
            }

            discord()->joinVoiceChannel($channel)->then(static fn (VoiceClient $vc) => $resolve(new self($vc)));
        });
    }

    public function close(): void
    {
        unset(self::$playbacks[$this->client->getChannel()->guild_id]);
        $this->client->close();
        $this->ffmpeg->terminate();
    }

    public function __destruct() {
        $this->close();
    }
}
