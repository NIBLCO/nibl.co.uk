<?php

namespace App\Infrastructure\Transformer;

use App\Domain\Bot;
use App\Domain\Pack;

final class PackTransformer
{
    /**
     * @param Bot[] $botList
     * @return Pack[]
     */
    public function transform(array $botList, array $rawPacksData): array
    {
        $transformedPacks = [];
        foreach ($rawPacksData as $data) {
            $botInstance = null;
            foreach ($botList as $bot) {
                if ($data['botId'] === $bot->getId()) {
                    $botInstance = $bot;

                    break;
                }
            }

            $transformedPacks[] = Pack::fromRequest($botInstance, $data);
        }

        return $transformedPacks;
    }
}
