<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateStaffAdminCommand extends Command
{
    protected $signature = 'admin:create-staff
                            {email : Email for the staff account}
                            {--name=Staff : Display name}
                            {--type=data-entry : Staff type: data-entry, accountant, travel-agent, sales-agent, or booking-agent}
                            {--password= : Password (min 4 chars); generated if omitted}';

    protected $description = 'Create a staff admin account for an operational role.';

    public function handle(): int
    {
        $email = $this->argument('email');

        if (Admin::where('email', $email)->exists()) {
            $this->error('An admin with this email already exists.');

            return self::FAILURE;
        }

        $typeInput = (string) $this->option('type');
        $adminType = match ($typeInput) {
            'accountant' => Admin::TYPE_STAFF_ACCOUNTANT,
            'travel-agent' => Admin::TYPE_AGENT_TRAVEL,
            'sales-agent' => Admin::TYPE_AGENT_SALES,
            'booking-agent' => Admin::TYPE_AGENT_BOOKING,
            default => Admin::TYPE_STAFF_DATA_ENTRY,
        };

        $password = $this->option('password');
        if (! $password) {
            $password = bin2hex(random_bytes(8));
            $this->warn('Generated password: ' . $password);
        }

        if (strlen($password) < 4) {
            $this->error('Password must be at least 4 characters.');

            return self::FAILURE;
        }

        Admin::create([
            'name' => $this->option('name'),
            'email' => $email,
            'password' => Hash::make($password),
            'status' => Admin::STATUS_ACTIVE,
            'admin_type' => $adminType,
        ]);

        $this->info('Staff admin created. Login at /admin/login with email: ' . $email);

        return self::SUCCESS;
    }
}