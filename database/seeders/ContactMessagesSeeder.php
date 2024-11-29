<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ContactMessage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContactMessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        // Create a message with %50 chance for each user
        $users->each(function ($user) {
            if (rand(0, 1)) {
                ContactMessage::factory()->create([
                    'name' => $user->name,
                    'email' => $user->email,
                ]);
            }
        });

        // Create 20 more anonymous messages
        ContactMessage::factory(20)->create();
    }
}
