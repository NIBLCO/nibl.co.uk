<?php

namespace App\Domain;

final class SortDto
{
    private const DEFAULT_SORT = 'name';
    private const ALLOWED_SORT_PARAMS = ['name', 'number', 'size', 'sizekbits', 'episodeNumber'];
    private string $by;
    private SortDirectionEnum $direction;

    private function __construct(string $by, SortDirectionEnum $sortDirectionEnum)
    {
        $this->by = $by;
        $this->direction = $sortDirectionEnum;
    }

    public static function fromRequest(array $params): self
    {
        $by = self::DEFAULT_SORT;
        $direction = SortDirectionEnum::ASC();

        $byParam = $params['by'];
        if (isset($byParam) && in_array($byParam, self::ALLOWED_SORT_PARAMS, true)) {
            $by = $byParam;
        }

        $directionParam = strtoupper($params['direction']);
        if (isset($directionParam) && in_array($directionParam, SortDirectionEnum::toArray(), true)) {
            $direction = new SortDirectionEnum($directionParam);
        }

        return new self($by, $direction);
    }

    public function getDirection(): SortDirectionEnum
    {
        return $this->direction;
    }

    public function getBy(): string
    {
        return $this->by;
    }
}
