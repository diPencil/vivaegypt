<?php

namespace Modules\SpecialBooking\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SpecialBooking\App\Models\TransferVehicle;

class SpecialBookingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = [
            [
                'title' => 'Limousine',
                'slug' => 'limousine',
                'short_description' => 'Comfortable private sedan for up to 3 passengers.',
                'capacity_text' => '1-3 Passengers',
                'icon_class' => 'fas fa-car-side',
                'sort_order' => 1,
                'status' => true,
            ],
            [
                'title' => 'HIACE',
                'slug' => 'hiace',
                'short_description' => 'Spacious minivan perfect for small families or groups.',
                'capacity_text' => '4-10 Passengers',
                'icon_class' => 'fas fa-shuttle-van',
                'sort_order' => 2,
                'status' => true,
            ],
            [
                'title' => 'Coaster',
                'slug' => 'coaster',
                'short_description' => 'Mid-sized bus for medium groups and airport transfers.',
                'capacity_text' => '11-20 Passengers',
                'icon_class' => 'fas fa-bus-alt',
                'sort_order' => 3,
                'status' => true,
            ],
            [
                'title' => 'Large Bus',
                'slug' => 'large-bus',
                'short_description' => 'Full-sized coach for large groups and long distance tours.',
                'capacity_text' => '21-50 Passengers',
                'icon_class' => 'fas fa-bus',
                'sort_order' => 4,
                'status' => true,
            ],
        ];

        foreach ($vehicles as $vehicle) {
            TransferVehicle::updateOrCreate(
                ['slug' => $vehicle['slug']],
                $vehicle
            );
        }
    }
}
