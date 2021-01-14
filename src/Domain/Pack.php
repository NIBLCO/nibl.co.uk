<?php

namespace App\Domain;

final class Pack
{
    private Bot $bot;
    private int $number;
    private string $name;
    private string $sizeReadable;
    private int $sizeKilobits;
    private int $episodeNumber;
    private \DateTime $lastModified;

    private function __construct(
        Bot $bot,
        int $number,
        string $name,
        string $sizeReadable,
        int $sizeKilobits,
        int $episodeNumber,
        \DateTime $lastModified
    ) {
        $this->bot = $bot;
        $this->number = $number;
        $this->name = $name;
        $this->sizeReadable = $sizeReadable;
        $this->sizeKilobits = $sizeKilobits;
        $this->episodeNumber = $episodeNumber;
        $this->lastModified = $lastModified;
    }

    public static function fromRequest(Bot $bot, array $data): self
    {
        return new self(
            $bot,
            $data['number'],
            $data['name'],
            $data['size'],
            $data['sizekbits'],
            $data['episodeNumber'],
            new \DateTime($data['lastModified']),
        );
    }

    public function getBot(): Bot
    {
        return $this->bot;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSizeReadable(): string
    {
        return $this->sizeReadable;
    }

    public function getSizeKilobits(): int
    {
        return $this->sizeKilobits;
    }

    public function getEpisodeNumber(): int
    {
        return $this->episodeNumber;
    }

    public function getLastModified(): \DateTime
    {
        return $this->lastModified;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
