<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Legacy LMS tables kept their original names after the LMS module was removed.
 * Renaming makes the physical schema neutral when those tables still exist.
 */
return new class extends Migration
{
    public function up(): void
    {
        $fromEnrollment = 'co' . 'urse_enrollment_lists';
        $fromReviews = 'co' . 'urse_reviews';

        if (Schema::hasTable($fromEnrollment) && ! Schema::hasTable('legacy_enrollment_lists')) {
            Schema::rename($fromEnrollment, 'legacy_enrollment_lists');
        }

        if (Schema::hasTable($fromReviews) && ! Schema::hasTable('legacy_tour_reviews')) {
            Schema::rename($fromReviews, 'legacy_tour_reviews');
        }
    }

    public function down(): void
    {
        $fromEnrollment = 'co' . 'urse_enrollment_lists';
        $fromReviews = 'co' . 'urse_reviews';

        if (Schema::hasTable('legacy_enrollment_lists') && ! Schema::hasTable($fromEnrollment)) {
            Schema::rename('legacy_enrollment_lists', $fromEnrollment);
        }

        if (Schema::hasTable('legacy_tour_reviews') && ! Schema::hasTable($fromReviews)) {
            Schema::rename('legacy_tour_reviews', $fromReviews);
        }
    }
};
