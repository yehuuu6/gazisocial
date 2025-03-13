<?php

namespace App\Enums\ZalimKasaba;

enum PlayerRole: string
{
    case GODFATHER = 'godfather';
    case MAFIOSO = 'mafioso';
    case JANITOR = 'janitor';
    case DOCTOR = 'doctor';
    case LOOKOUT = 'lookout';
    case ANGEL = 'angel';
    case HUNTER = 'hunter';
    case WITCH = 'witch';
    case GUARD = 'guard';
    case JESTER = 'jester';

    public static function getUniqueRoles(): array
    {
        return [
            self::GODFATHER,
            self::MAFIOSO,
            self::WITCH,
        ];
    }

    public static function getMafiaRoles(): array
    {
        return [
            self::GODFATHER,
            self::MAFIOSO,
            self::JANITOR,
        ];
    }

    public static function getTownRoles(): array
    {
        return [
            self::DOCTOR,
            self::LOOKOUT,
            self::GUARD,
            self::HUNTER
        ];
    }

    public static function getChaosRoles(): array
    {
        return [
            self::WITCH,
        ];
    }

    public static function getNeutralRoles(): array
    {
        return [
            self::JESTER,
            self::ANGEL,
        ];
    }

    public function getFaction(): string
    {
        if (in_array($this, PlayerRole::getMafiaRoles())) {
            return 'Mafya 🌹';
        } elseif (in_array($this, PlayerRole::getTownRoles())) {
            return 'Kasaba 🏘️';
        } elseif (in_array($this, PlayerRole::getChaosRoles())) {
            return 'Kaos 🌀';
        } elseif (in_array($this, PlayerRole::getNeutralRoles())) {
            return 'Tarafsız 🕊️';
        } else {
            return 'Bilinmiyor';
        }
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::GODFATHER => 'Mafyanın liderisin. Her gece birinin öldürülmesi için emir ver. Gece mafya ile konuşabilirsin.',
            self::MAFIOSO => 'Baron tarafından sana verilen emirleri yerine getir. Gece mafya ile konuşabilirsin.',
            self::JANITOR => 'Mafya tarafından öldürülen kişinin rolünü temizle. Gece mafya ile konuşabilirsin.',
            self::DOCTOR => 'Kendini ya da başkasını koru. Kendini sadece bir kez koruyabilirsin.',
            self::LOOKOUT => 'Birinin evini dikizle ve kimlerin onu ziyaret ettiğini öğren.',
            self::GUARD => 'Birini gece boyunca sorgula ve o gece yeteneğini kullanmasına engel ol.',
            self::HUNTER => 'Geceleri silahını kullanarak birini vurabilirsin. Vurduğun kişi masum biriyse, intihar edersin.',
            self::WITCH => 'Her gece birini zehirlersin; zehirlenen kişiyi sonraki gece doktor tedavi etmez ise ölür.',
            self::JESTER => 'İdam edilmek isteyen bir manyaksın. Eğer idam edilirsen, gece bir kişiyi öldürebilirsin.',
            self::ANGEL => 'Geceleri insan formundan melek formuna dönüşebilirsin. Bu sayede saldırılardan korunursun.',
        };
    }

    public function getGoal(): string
    {
        if (in_array($this, PlayerRole::getMafiaRoles())) {
            return 'Mafyaya boyun eğmeyen herkesi yok et.';
        } elseif (in_array($this, PlayerRole::getTownRoles())) {
            return 'Kasabadaki bütün kötüleri yok et.';
        } elseif (in_array($this, PlayerRole::getChaosRoles())) {
            return 'Kasaba halkını yok etmek için mafya ile iş birliği yap.';
        } elseif ($this === PlayerRole::JESTER) {
            return 'İdam edilmek.';
        } elseif ($this === PlayerRole::ANGEL) {
            return 'Oyunun sonuna kadar hayatta kal.';
        } else {
            return 'Bilinmiyor';
        }
    }
}
