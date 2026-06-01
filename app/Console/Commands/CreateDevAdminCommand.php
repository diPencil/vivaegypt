<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateDevAdminCommand extends Command
{
    protected $signature = 'admin:create-dev
                            {email : Email for the dev admin account}
                            {--name=Dev Admin : Display name}
                            {--password= : Password (min 4 chars); generated if omitted}';

    protected $description = 'Create a dev admin account (admin_type=dev_admin). Same /admin login; full panel access plus exclusive theme/menu routes (see config/admin_roles.php).';

    public function handle(): int
    {
        $email = $this->argument('email');

        if (Admin::where('email', $email)->exists()) {
            $this->error('An admin with this email already exists.');

            return self::FAILURE;
        }

        $password = $this->option('password');
        if (! $password) {
            $password = bin2hex(random_bytes(8));
            $this->warn('Generated password: '.$password);
        }

        if (strlen($password) < 4) {
            $this->error('Password must be at least 4 characters.');

            return self::FAILURE;
        }

        Admin::create([
            'name'     => $this->option('name'),
            'email'    => $email,
            'password' => Hash::make($password),
            'status'   => Admin::STATUS_ACTIVE,
            'admin_type' => Admin::TYPE_DEV_ADMIN,
        ]);

        $this->info('Dev admin created. Login at /admin/login with email: '.$email);

        return self::SUCCESS;
    }
}
