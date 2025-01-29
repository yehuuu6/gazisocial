<?php

namespace App\Traits;

trait OrderByManager
{
    public function getSqlTerminology(string $order): string
    {
        return match ($order) {
            'latest' => 'created_at',
            'popular' => 'popularity',
            default => 'created_at',
        };
    }

    public function validateOrderType(string $typeToCheck): void
    {
        $validOrderTypes = ['latest', 'popular'];

        if (!in_array($typeToCheck, $validOrderTypes)) {
            $this->redirect(route('posts.index'), navigate: true);
        }
    }
}
