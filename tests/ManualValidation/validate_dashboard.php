<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Config;

function testDashboardForUser($role, $permissions = []) {
    echo "\n--- Testing for Role: $role | Permissions: [" . implode(',', $permissions) . "] ---\n";
    
    // Create a mock user
    $user = new User();
    $user->is_staff = 1;
    $user->staff_role = $role;
    
    $dashboardMode = match (true) {
        $user->isStaffAccountant() => 'accountant',
        $user->isSalesAgent() => 'sales',
        $user->isTravelAgent(), $user->isBookingAgent() => 'operations',
        $user->isStaffDataEntry() => 'data_entry',
        default => 'default',
    };

    echo "Dashboard Mode: $dashboardMode\n";

    // Replicate controller card logic
    $allPotentialCards = [
        ['section' => 'booking_services', 'label' => 'Booking Services'],
        ['section' => 'finance', 'label' => 'Total Sales'],
        ['section' => 'bookings', 'label' => 'Total Bookings'],
        ['section' => 'finance', 'label' => 'Withdrawals'],
        ['section' => 'products', 'label' => 'Products'],
    ];

    $visibleCards = array_filter($allPotentialCards, function ($card) use ($user, $permissions) {
        $isRoleAllowed = match ($card['section']) {
            'finance' => $user->isStaffAccountant(),
            'bookings' => $user->isStaffAccountant() || $user->isBookingAgent(),
            'booking_services' => $user->isStaffDataEntry() || $user->isTravelAgent(),
            'products' => $user->isStaffDataEntry() || $user->isSalesAgent(),
            default => false,
        };
        
        $isPermissionAllowed = in_array($card['section'], $permissions);

        return $isRoleAllowed || $isPermissionAllowed;
    });

    echo "Visible Cards:\n";
    foreach ($visibleCards as $card) {
        echo "- " . $card['label'] . "\n";
    }
}

testDashboardForUser(User::TYPE_STAFF_DATA_ENTRY);
testDashboardForUser(User::TYPE_STAFF_ACCOUNTANT);
testDashboardForUser(User::TYPE_STAFF_DATA_ENTRY, ['finance']);
testDashboardForUser(User::TYPE_STAFF_ACCOUNTANT, ['booking_services']);
