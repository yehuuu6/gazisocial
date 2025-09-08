<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Role;
use App\Models\Faculty;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\ZalimKasaba\GameRole;

class ProductionDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles.
        $member = Role::create(['name' => 'Üye', 'color' => 'orange', 'level' => 0]);
        $gazili = Role::create(['name' => 'Gazili', 'color' => 'green', 'level' => 0]);
        $moderator = Role::create(['name' => 'Moderatör', 'color' => 'red', 'level' => 1]);
        $admin = Role::create(['name' => 'Yönetici', 'color' => 'purple', 'level' => 2]);
        $gazisocial = Role::create(['name' => 'Gazi Social', 'color' => 'blue', 'level' => 3]);

        // Create Tags.
        $tags = collect();

        $tags->push(Tag::create(['name' => 'Staj', 'color' => 'red']));
        $tags->push(Tag::create(['name' => 'Soru', 'color' => 'orange']));
        $tags->push(Tag::create(['name' => 'İtiraf', 'color' => 'amber']));
        $tags->push(Tag::create(['name' => 'Etkinlik', 'color' => 'yellow']));
        $tags->push(Tag::create(['name' => 'Erasmus', 'color' => 'lime']));
        $tags->push(Tag::create(['name' => 'Burs', 'color' => 'green']));
        $tags->push(Tag::create(['name' => 'Proje', 'color' => 'emerald']));
        $tags->push(Tag::create(['name' => 'Ulaşım', 'color' => 'teal']));
        $tags->push(Tag::create(['name' => 'Kampüs', 'color' => 'cyan']));
        $tags->push(Tag::create(['name' => 'İş İlanı', 'color' => 'sky']));
        $tags->push(Tag::create(['name' => 'Yarışma', 'color' => 'blue']));
        $tags->push(Tag::create(['name' => 'Spor', 'color' => 'indigo']));
        $tags->push(Tag::create(['name' => 'Yurt', 'color' => 'violet']));
        $tags->push(Tag::create(['name' => 'Yazılım', 'color' => 'purple']));
        $tags->push(Tag::create(['name' => 'Gündem', 'color' => 'fuchsia']));
        $tags->push(Tag::create(['name' => 'Arkadaşlık', 'color' => 'pink']));
        $tags->push(Tag::create(['name' => 'Duyuru', 'color' => 'rose']));

        // Create faculties
        $faculties = [
            [
                'type' => 'faculty',
                'name' => 'Diş Hekimliği Fakültesi',
                'slug' => Str::slug('Diş Hekimliği Fakültesi'),
                'url' => 'https://dent.gazi.edu.tr',
            ],
            [
                'type' => 'faculty',
                'name' => 'Eczacılık Fakültesi',
                'slug' => Str::slug('Eczacılık Fakültesi'),
                'url' => 'https://pharmacy.gazi.edu.tr',
            ],
            [
                'type' => 'faculty',
                'name' => 'Fen Fakültesi',
                'slug' => Str::slug('Fen Fakültesi'),
                'url' => 'https://fen.gazi.edu.tr',
            ],
            [
                'type' => 'faculty',
                'name' => 'Gazi Eğitim Fakültesi',
                'slug' => Str::slug('Gazi Eğitim Fakültesi'),
                'url' => 'https://gef.gazi.edu.tr',
            ],
            [
                'type' => 'faculty',
                'name' => 'Hemşirelik Fakültesi',
                'slug' => Str::slug('Hemşirelik Fakültesi'),
                'url' => 'https://hemsirelik.gazi.edu.tr',
            ],
            [
                'type' => 'faculty',
                'name' => 'Mimarlık Fakültesi',
                'slug' => Str::slug('Mimarlık Fakültesi'),
                'url' => 'https://mim.gazi.edu.tr',
            ],
            [
                'type' => 'faculty',
                'name' => 'Mühendislik Fakültesi',
                'slug' => Str::slug('Mühendislik Fakültesi'),
                'url' => 'https://mf.gazi.edu.tr',
            ],
            [
                'type' => 'faculty',
                'name' => 'Sağlık Bilimleri Fakültesi',
                'slug' => Str::slug('Sağlık Bilimleri Fakültesi'),
                'url' => 'https://sbf.gazi.edu.tr',
            ],
            [
                'type' => 'faculty',
                'name' => 'Spor Bilimleri Fakültesi',
                'slug' => Str::slug('Spor Bilimleri Fakültesi'),
                'url' => 'https://sporbilimleri.gazi.edu.tr',
            ],
            [
                'type' => 'faculty',
                'name' => 'Teknoloji Fakültesi',
                'slug' => Str::slug('Teknoloji Fakültesi'),
                'url' => 'https://tf.gazi.edu.tr',
            ],
            [
                'type' => 'faculty',
                'name' => 'Tıp Fakültesi',
                'slug' => Str::slug('Tıp Fakültesi'),
                'url' => 'https://med.gazi.edu.tr',
            ],
            [
                'type' => 'faculty',
                'name' => 'Uygulamalı Bilimler Fakültesi',
                'slug' => Str::slug('Uygulamalı Bilimler Fakültesi'),
                'url' => 'https://ubf.gazi.edu.tr',
            ],
            [
                'type' => 'vocational',
                'name' => 'Yabancı Diller Yüksekokulu',
                'slug' => Str::slug('Yabancı Diller Yüksekokulu'),
                'url' => 'https://ydyo.gazi.edu.tr',
            ],
            [
                'type' => 'vocational',
                'name' => 'Sağlık Hizmetleri Meslek Yüksekokulu',
                'slug' => Str::slug('Sağlık Hizmetleri Meslek Yüksekokulu'),
                'url' => 'https://shmyo.gazi.edu.tr',
            ],
            [
                'type' => 'vocational',
                'name' => 'Teknik Bilimler Meslek Yüksekokulu',
                'slug' => Str::slug('Teknik Bilimler Meslek Yüksekokulu'),
                'url' => 'https://teknikbilimler.gazi.edu.tr',
            ],
            [
                'type' => 'vocational',
                'name' => 'TUSAŞ-Kazan Meslek Yüksekokulu',
                'slug' => Str::slug('TUSAŞ-Kazan Meslek Yüksekokulu'),
                'url' => 'https://kazanmyo.gazi.edu.tr',
            ]
        ];

        foreach ($faculties as $faculty) {
            Faculty::create($faculty);
        }

        $godfather = GameRole::create([
            'icon' => '⚜️',
            'name' => 'Baron',
            'enum' => 'godfather',
        ]);

        $mafioso = GameRole::create([
            'icon' => '💀',
            'name' => 'Tetikçi',
            'enum' => 'mafioso',
        ]);

        $janitor = GameRole::create([
            'icon' => '🧽',
            'name' => 'Temizlikçi',
            'enum' => 'janitor',
            'ability_limit' => 3,
        ]);

        $doctor = GameRole::create([
            'icon' => '🩺',
            'name' => 'Doktor',
            'enum' => 'doctor',
        ]);

        $lookout = GameRole::create([
            'icon' => '👀',
            'name' => 'Dikizci',
            'enum' => 'lookout',
        ]);

        $guard = GameRole::create([
            'icon' => '🔦',
            'name' => 'Bekçi',
            'enum' => 'guard',
        ]);

        $villager = GameRole::create([
            'icon' => '👨‍🌾',
            'name' => 'Köylü',
            'enum' => 'villager',
        ]);

        $hunter = GameRole::create([
            'icon' => '🏹',
            'name' => 'Avcı',
            'enum' => 'hunter',
            'ability_limit' => 2,
        ]);

        $witch = GameRole::create([
            'icon' => '🔮',
            'name' => 'Cadı',
            'enum' => 'witch',
            'ability_limit' => 2,
        ]);

        $angel = GameRole::create([
            'icon' => '🌟',
            'name' => 'Melek',
            'enum' => 'angel',
            'ability_limit' => 3,
        ]);

        $jester = GameRole::create([
            'icon' => '🤡',
            'name' => 'Zibidi',
            'enum' => 'jester',
        ]);
    }
}
