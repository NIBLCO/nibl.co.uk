<?php

namespace App\Domain;

final class SiteNews implements \JsonSerializable
{
    private const SHORT_TEXT_LENGTH = 140;
    private int $id;
    private string $createdBy;
    private string $context;
    private \DateTime $createdAt;
    private ?\DateTime $publishedAt;

    private function __construct(int $id, string $createdBy, string $context, \DateTime $createdAt, ?\DateTime $publishedAt)
    {
        $this->id = $id;
        $this->createdBy = $createdBy;
        $this->context = $context;
        $this->createdAt = $createdAt;
        $this->publishedAt = $publishedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }

    public function getContext(): string
    {
        return $this->context;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getPublishedAt(): ?\DateTime
    {
        return $this->publishedAt;
    }

    public function isPublished(): bool
    {
        return null !== $this->publishedAt;
    }

    public function isLongContext(): bool
    {
        return strlen($this->context) > self::SHORT_TEXT_LENGTH;
    }

    public static function fromData(array $data): self
    {
        $createdAt = new \DateTime($data['sn_created_at']);
        $publishedAt = null !== $data['sn_published_at'] ? new \DateTime($data['sn_published_at']) : null;

        return new self($data['sn_id'], $data['sn_created_by'], $data['sn_context'], $createdAt, $publishedAt);
    }

    public function jsonSerialize(): array
    {
        return [
            'sn_id' => $this->id,
            'sn_created_by' => $this->createdBy,
            'sn_context' => $this->context,
            'sn_created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'sn_published_at' => $this->publishedAt->format('Y-m-d H:i:s'),
        ];
    }
}
