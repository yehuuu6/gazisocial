<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Role;
use App\Models\Faculty;
use App\Models\User;
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
        $gazisocialRole = Role::where('slug', 'gazi-social')->first();
        $user = User::where('username', 'yehuuu6')->first();
        $user->roles()->attach($gazisocialRole->id);
    }
}
