<?php

namespace App\Traits;

trait ColorLabelTranslator
{
    public static function getColors(): array
    {
        return [
            'red' => 'Kırmızı',
            'orange' => 'Turuncu',
            'amber' => 'Kehribar',
            'yellow' => 'Sarı',
            'lime' => 'Limon',
            'green' => 'Yeşil',
            'emerald' => 'Zümrüt',
            'teal' => 'Turkuaz',
            'cyan' => 'Camgöbeği',
            'sky' => 'Gökyüzü',
            'blue' => 'Mavi',
            'indigo' => 'Çivit',
            'violet' => 'Menekşe',
            'purple' => 'Mor',
            'fuchsia' => 'Fuşya',
            'pink' => 'Pembe',
            'rose' => 'Gül',
            'gray' => 'Gri',
            'slate' => 'Kara',
            'zinc' => 'Çinko',
            'neutral' => 'Nötr',
            'stone' => 'Taş',
        ];
    }

    public static function getColorLabel(string $text): string
    {
        // Translate to turkish

        return match ($text) {
            'red' => 'Kırmızı',
            'orange' => 'Turuncu',
            'amber' => 'Kehribar',
            'yellow' => 'Sarı',
            'lime' => 'Limon',
            'green' => 'Yeşil',
            'emerald' => 'Zümrüt',
            'teal' => 'Turkuaz',
            'cyan' => 'Camgöbeği',
            'sky' => 'Gökyüzü',
            'blue' => 'Mavi',
            'indigo' => 'Çivit',
            'violet' => 'Menekşe',
            'purple' => 'Mor',
            'fuchsia' => 'Fuşya',
            'pink' => 'Pembe',
            'rose' => 'Gül',
            'gray' => 'Gri',
            'slate' => 'Kara',
            'zinc' => 'Çinko',
            'neutral' => 'Nötr',
            'stone' => 'Taş',
            default => $text,
        };
    }
}
