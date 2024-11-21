<?php
namespace App\Console\Commands;

use App\Models\User;
use App\Models\Role;
use Illuminate\Console\Command;

class AssignAdminRole extends Command
{
    protected $signature = 'assign:admin-role {email}';

    protected $description = 'Assign admin role to a user';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found.");
            return;
        }

        $role = Role::firstOrCreate(['name' => 'admin']);
        $user->roles()->attach($role);

        $this->info("Admin role assigned to user with email {$email}.");
    }
}