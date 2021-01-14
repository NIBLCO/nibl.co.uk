<?php

namespace App\Domain;

final class BotQueryDto
{
    private QueryDto $queryDto;
    private int $pageNumber;

    private function __construct(int $pageNumber, QueryDto $queryDto)
    {
        $this->pageNumber = $pageNumber;
        $this->queryDto = $queryDto;
    }

    public function getQueryDto(): QueryDto
    {
        return $this->queryDto;
    }

    public function getPageNumber(): int
    {
        return $this->pageNumber;
    }

    public static function fromRequest(array $params): self
    {
        $page = 0;
        $rawPage = $params['page'];
        if (isset($rawPage) && is_numeric($rawPage)) {
            $page = (int) $rawPage;
        }

        return new self($page, QueryDto::fromRequest($params));
    }

    public function nextPageNumber(): int
    {
        return $this->pageNumber + 1;
    }

    public function previousPageNumber(): ?int
    {
        if ($this->pageNumber === 0) {
            return null;
        }

        return $this->pageNumber - 1;
    }
}
