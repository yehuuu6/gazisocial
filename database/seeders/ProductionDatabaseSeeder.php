<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Tag;
use App\Models\Faculty;
use Illuminate\Support\Str;

class ProductionDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles.
        $contributor = Role::create(['slug' => 'contributor', 'name' => 'Contributor', 'color' =>
        'purple', 'level' => 0]);
        $member = Role::create(['slug' => 'member', 'name' => 'Üye', 'color' => 'orange', 'level' => 0]);
        $gazili = Role::create(['slug' => 'student', 'name' => 'Öğrenci', 'color' => 'green', 'level' => 1]);
        $admin = Role::create(['slug' => 'moderator', 'name' => 'Moderatör', 'color' => 'red', 'level' => 2]);
        $gazisocial = Role::create(['slug' => 'gazisocial', 'name' => 'Gazi Social', 'color' => 'blue', 'level' => 3]);

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
        $tags->push(Tag::create(['name' => 'Dev Center', 'color' => 'blue']));
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
                'description' => 'Diş hekimi olacak herkesi bekleriz...',
                'slug' => Str::slug('Diş Hekimliği Fakültesi'),
                'url' => 'https://dent.gazi.edu.tr',
            ],
            [
                'type' => 'faculty',
                'name' => 'Eczacılık Fakültesi',
                'description' => 'Eczacılık okuyan öğrenciler katılabilir!',
                'slug' => Str::slug('Eczacılık Fakültesi'),
                'url' => 'https://pharmacy.gazi.edu.tr',
            ],
            [
                'type' => 'faculty',
                'name' => 'Fen Fakültesi',
                'description' => 'Fen bölümü öğrencileri burada toplanıyor.',
                'slug' => Str::slug('Fen Fakültesi'),
                'url' => 'https://fen.gazi.edu.tr',
            ],
            [
                'type' => 'faculty',
                'name' => 'Gazi Eğitim Fakültesi',
                'description' => 'Geleceğin eğitmenleri burada!',
                'slug' => Str::slug('Gazi Eğitim Fakültesi'),
                'url' => 'https://gef.gazi.edu.tr',
            ],
            [
                'type' => 'faculty',
                'name' => 'Hemşirelik Fakültesi',
                'description' => 'Her şeyden değerli hemşirelerimiz...',
                'slug' => Str::slug('Hemşirelik Fakültesi'),
                'url' => 'https://hemsirelik.gazi.edu.tr',
            ],
            [
                'type' => 'faculty',
                'name' => 'Mimarlık Fakültesi',
                'description' => '"Builder" olmak isteyenler burada!',
                'slug' => Str::slug('Mimarlık Fakültesi'),
                'url' => 'https://mim.gazi.edu.tr',
            ],
            [
                'type' => 'faculty',
                'name' => 'Mühendislik Fakültesi',
                'description' => 'Mühendislik öğrencileri buraya, "Hello, World!"',
                'slug' => Str::slug('Mühendislik Fakültesi'),
                'url' => 'https://mf.gazi.edu.tr',
            ],
            [
                'type' => 'faculty',
                'name' => 'Sağlık Bilimleri Fakültesi',
                'description' => 'Sağlık bilimleri yolcusu kalmasın!',
                'slug' => Str::slug('Sağlık Bilimleri Fakültesi'),
                'url' => 'https://sbf.gazi.edu.tr',
            ],
            [
                'type' => 'faculty',
                'name' => 'Spor Bilimleri Fakültesi',
                'description' => 'Atlet yetiştiriyoruz burada.',
                'slug' => Str::slug('Spor Bilimleri Fakültesi'),
                'url' => 'https://sporbilimleri.gazi.edu.tr',
            ],
            [
                'type' => 'faculty',
                'name' => 'Teknoloji Fakültesi',
                'description' => 'Teknoloji fakültesi var mı? Evet, var!',
                'slug' => Str::slug('Teknoloji Fakültesi'),
                'url' => 'https://tf.gazi.edu.tr',
            ],
            [
                'type' => 'faculty',
                'name' => 'Tıp Fakültesi',
                'description' => 'Bir günde anatomi atlasını ezberleyip, iki günde ne kadar az uyuyabileceğini keşfetme yeri!',
                'slug' => Str::slug('Tıp Fakültesi'),
                'url' => 'https://med.gazi.edu.tr',
            ],
            [
                'type' => 'faculty',
                'name' => 'Uygulamalı Bilimler Fakültesi',
                'description' => 'Uygulamalı bilimlerin merkezi burası!',
                'slug' => Str::slug('Uygulamalı Bilimler Fakültesi'),
                'url' => 'https://ubf.gazi.edu.tr',
            ],
            [
                'type' => 'vocational',
                'name' => 'Yabancı Diller Yüksekokulu',
                'description' => 'Dizileri altyazısız izleyenler, evet burası sizin yuvanız!',
                'slug' => Str::slug('Yabancı Diller Yüksekokulu'),
                'url' => 'https://ydyo.gazi.edu.tr',
            ],
            [
                'type' => 'vocational',
                'name' => 'Sağlık Hizmetleri Meslek Yüksekokulu',
                'description' => 'Sağlık hizmetleri meslek yüksekokulu öğrencileri burada toplanıyor.',
                'slug' => Str::slug('Sağlık Hizmetleri Meslek Yüksekokulu'),
                'url' => 'https://shmyo.gazi.edu.tr',
            ],
            [
                'type' => 'vocational',
                'name' => 'Teknik Bilimler Meslek Yüksekokulu',
                'description' => 'Teknik bilimler meslek yüksekokulu öğrencileri burada toplanıyor.',
                'slug' => Str::slug('Teknik Bilimler Meslek Yüksekokulu'),
                'url' => 'https://teknikbilimler.gazi.edu.tr',
            ],
            [
                'type' => 'vocational',
                'name' => 'TUSAŞ-Kazan Meslek Yüksekokulu',
                'description' => 'TUSAŞ-Kazan meslek yüksekokulu öğrencileri burada toplanıyor.',
                'slug' => Str::slug('TUSAŞ-Kazan Meslek Yüksekokulu'),
                'url' => 'https://kazanmyo.gazi.edu.tr',
            ]
        ];

        foreach ($faculties as $faculty) {
            Faculty::create($faculty);
        }
    }
}
