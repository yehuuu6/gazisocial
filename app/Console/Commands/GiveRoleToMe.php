<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class GiveRoleToMe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'op-me';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::where('email', 'eren.aydin@gazi.edu.tr')->first();
        $role = Role::where('slug', 'gazi-social')->first();

        // If the user already has the role, do nothing
        if ($user && $role && $user->roles->contains($role->id))
        {
            $this->warn('User already has the role.');
            return;
        }

        if ($user && $role) {
            $user->roles()->attach($role);
            $this->info('Role assigned successfully.');
        } else {
            $this->error('User or role not found.');
        }
    }
}
