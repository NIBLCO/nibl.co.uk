<?php

namespace App\Domain;

use App\Infrastructure\Service\HTMLPurify;

final class QueryDto
{
    private ?string $query;
    private SortDto $sortDto;

    private function __construct(?string $query, SortDto $sortDto)
    {
        $this->query = $query;
        $this->sortDto = $sortDto;
    }

    public function getValue(): ?string
    {
        return $this->query;
    }

    public static function fromRequest(array $params): self
    {
        $query = null;
        $rawQuery = $params['query'];
        if (isset($rawQuery) && strlen($rawQuery) > 2) {
            $query = HTMLPurify::purify($rawQuery);
        }

        return new self($query, SortDto::fromRequest($params));
    }

    /** Check if clean query can be send to API */
    public function isValid(): bool
    {
        if (null === $this->query) {
            return false;
        }

        return strlen($this->query) > 2;
    }

    public function getSortData(): SortDto
    {
        return $this->sortDto;
    }
}
