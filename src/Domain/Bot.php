<?php

namespace App\Domain;

final class Bot
{
    private int $id;
    private string $name;
    private ?string $owner;
    private \DateTime $lastProcessed;
    private bool $isBatchEnabled;
    private int $packSize;

    private function __construct(int $id, string $name, ?string $owner, \DateTime $lastProcessed, bool $isBatchEnabled, int $packSize)
    {
        $this->id = $id;
        $this->name = $name;
        $this->owner = $owner;
        $this->lastProcessed = $lastProcessed;
        $this->isBatchEnabled = $isBatchEnabled;
        $this->packSize = $packSize;
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['owner'] ?? null,
            new \DateTime($data['lastProcessed']),
            $data['batchEnable'],
            $data['packSize']
        );
    }

    /**
     * @return self[]
     */
    public static function fromRawCollection(array $collection): array
    {
        $items = [];
        foreach ($collection as $data) {
            $items[] = self::fromRequest($data);
        }

        usort($items, static function ($first, $second) {
            return strcmp($first->getName(), $second->getName());
        });

        return $items;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOwner(): ?string
    {
        return $this->owner;
    }

    public function getLastProcessed(): \DateTime
    {
        return $this->lastProcessed;
    }

    public function isBatchEnabled(): bool
    {
        return $this->isBatchEnabled;
    }

    public function getPackSize(): int
    {
        return $this->packSize;
    }

    public function isArchive()
    {
        $now = new \DateTime();
        $diff = $this->getLastProcessed()->diff($now);

        return $diff->y >= 5;
    }

    public function isOld()
    {
        $now = new \DateTime();
        $diff = $this->getLastProcessed()->diff($now);

        return $diff->y > 1 && $diff->y <= 4;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
