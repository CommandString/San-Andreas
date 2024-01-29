<?php

namespace Core\Radio;

class Song
{
    public function __construct(
        public readonly string $artist,
        public readonly string $name,
        public readonly int $timestamp
    ) {
    }

    public function getNextSong(): ?self
    {
        $next = false;

        foreach (Songs::getAllSongs() as $station) {
            foreach ($station as $song) {
                if ($song == $this) {
                    $next = true;

                    continue;
                }

                if ($next) {
                    return $song;
                }
            }
        }

        return null;
    }

    public function getDuration(): ?int
    {
        $start = $this->timestamp;
        $end = $this->getNextSong()->timestamp ?? 0;

        $duration = $end - $start;

        return ($duration > 0) ? $duration : null;
    }
}
