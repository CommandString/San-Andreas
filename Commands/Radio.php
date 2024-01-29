<?php

namespace Commands;

use Core\Commands\Command;
use Core\Commands\CommandHandler;
use Core\Radio\Playback;
use Core\Radio\RadioStation;
use Core\Radio\Song;
use Discord\Builders\CommandBuilder;
use Discord\Builders\MessageBuilder;
use Discord\Helpers\Collection;
use Discord\Parts\Interactions\Command\Choice;
use Discord\Parts\Interactions\Command\Option;
use Discord\Parts\Interactions\Interaction;
use LogicException;

use function Core\getOptionFromInteraction as getOption;
use function Core\messageWithContent;
use function Core\newSlashCommandChoice as newChoice;
use function Core\newSlashCommandOption as newOption;

#[Command(['radio', ['play'], ['pause'], ['unpause'], ['stop']])]
class Radio implements CommandHandler
{
    public function handle(Interaction $interaction): void
    {
        $voiceChannel = $interaction->member->getVoiceChannel();

        if ($voiceChannel === null) {
            $interaction->respondWithMessage(MessageBuilder::new()->setContent('You must be in a voice channel!'), true);

            return;
        }

        Playback::resolve($voiceChannel)->then(function (Playback $playback) use ($interaction) {
            $subcommands = ['play', 'pause', 'unpause', 'stop'];

            foreach ($subcommands as $subcommand) {
                if ($options = getOption($interaction, $subcommand)) {
                    $this->{$subcommand}($interaction, $options->options, $playback);
                    return;
                }
            }

            $interaction->respondWithMessage(MessageBuilder::new()->setContent('Invalid subcommand.'), true);
        });
    }

    private function play(Interaction $interaction, Collection $options, Playback $playback): void {
        $options = getOption($interaction, 'play')->options;

        try {
            $station = new RadioStation(getOption($options, 'station')->value);
        } catch (LogicException) {
            $interaction->respondWithMessage(MessageBuilder::new()->setContent('Invalid station!'), true);

            return;
        }

        $song = $station->getSongByTimestamp(getOption($options, 'song')->value ?? 0) ?? $station->getSongs()[0];

        $playback->play($station, $song);
        $name = str_replace('*', '\*', $song->name);

        $interaction->respondWithMessage(messageWithContent("Playing **{$name}** by **{$song->artist}** on **{$station->getName()}**."), true);
    }

    private function unpause(Interaction $interaction, Collection $options, Playback $playback): void {
        if ($playback->getPlayState() === Playback::STATE_PLAYING) {
            $interaction->respondWithMessage(messageWithContent("Playback isn't paused."), true);
            return;
        }

        $playback->setPlayState(Playback::STATE_PLAYING);
        $interaction->respondWithMessage(messageWithContent('Unpaused playback.'), true);
    }

    private function pause(Interaction $interaction, Collection $options, Playback $playback): void {
        if ($playback->getPlayState() === Playback::STATE_PAUSED) {
            $interaction->respondWithMessage(messageWithContent('Playback is already paused.'), true);
        }

        $playback->setPlayState(Playback::STATE_PAUSED);
        $interaction->respondWithMessage(messageWithContent('Paused playback.'), true);
    }

    private function stop(Interaction $interaction, Collection $options, Playback $playback): void {
        $playback->close();

        $interaction->respondWithMessage(messageWithContent('Stopped playback.'), true);
    }

    public function getConfig(): CommandBuilder|array
    {
        return (new CommandBuilder())
            ->setName('radio')
            ->setDescription('Play music from the GTA:SA radio')
            ->addOption(
                newOption('play', 'Play a specific station', Option::SUB_COMMAND)
                    ->addOption(
                        newOption('song', 'Play a specific song', Option::INTEGER)
                            ->setAutoComplete(true)
                    )
            )
            ->addOption(newOption('pause', 'Pause playback', Option::SUB_COMMAND))
            ->addOption(newOption('unpause', 'Unpause playback', Option::SUB_COMMAND))
            ->addOption(newOption('stop', 'Stop playback', Option::SUB_COMMAND));
    }

    public function autocomplete(Interaction $interaction): void
    {
        $options = getOption($interaction, 'play')->options;
        $currentInput = getOption($options, 'song')->value;
        $station = new RadioStation(getOption($options, 'station')->value);

        $songs = [];

        foreach ($station->getSongs() as $song) {
            if (str_starts_with(strtolower($song->name), strtolower($currentInput))) {
                $songs[] = $song;
            } elseif (str_starts_with(strtolower($song->artist), strtolower($currentInput))) {
                $songs[] = $song;
            }

            if (count($songs) === 25) {
                break;
            }
        }

        if (empty($songs) || count($songs) < 25) {
            foreach ($station->getSongs() as $song) {
                if (!in_array($song, $songs)) {
                    $songs[] = $song;
                }

                if (count($songs) === 25) {
                    break;
                }
            }
        }

        $buildAutocompleteChoice = static fn (Song $song): Choice => newChoice("{$song->name} by {$song->artist}", $song->timestamp);

        $choices = [];

        foreach ($songs as $song) {
            $choices[] = $buildAutocompleteChoice($song);
        }

        $interaction->autoCompleteResult($choices);
    }
}
