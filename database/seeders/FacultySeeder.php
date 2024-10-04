<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
