<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialBookingPermissionsSeeder extends Seeder
{
    public function run()
    {
        $storedValue = DB::table('global_settings')
            ->where('key', 'staff_role_permissions')
            ->value('value');

        if (! $storedValue) {
            $this->command->warn('No existing permissions matrix found in the database.');
            return;
        }

        $this->command->info('Original JSON permissions value: ' . $storedValue);

        $decoded = json_decode($storedValue, true);

        if (is_array($decoded)) {
            // Append Catalog to Data Entry
            if (isset($decoded['staff_data_entry'])) {
                $decoded['staff_data_entry'][] = 'special_booking_catalog';
                $decoded['staff_data_entry'] = array_values(array_unique($decoded['staff_data_entry']));
            }

            // Append Requests to accountant and agent roles
            foreach (['staff_accountant', 'agent_travel', 'agent_sales', 'agent_booking'] as $role) {
                if (isset($decoded[$role])) {
                    $decoded[$role][] = 'special_booking_requests';
                    $decoded[$role] = array_values(array_unique($decoded[$role]));
                }
            }

            $newValue = json_encode($decoded);

            DB::table('global_settings')
                ->where('key', 'staff_role_permissions')
                ->update(['value' => $newValue]);

            $this->command->info('Successfully updated JSON permissions matrix to: ' . $newValue);
        } else {
            $this->command->error('Permissions matrix is not a valid JSON structure.');
        }
    }
}
