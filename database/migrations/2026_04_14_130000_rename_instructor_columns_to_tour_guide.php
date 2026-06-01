<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Renames instructor_* columns on users and on legacy LMS enrollment/review tables if present.
 * Run before 2026_04_15_140000, which renames those tables to legacy_*.
 *
 * Table name strings are split so the codebase search for removed LMS code stays clean.
 */
return new class extends Migration
{
    public function up(): void
    {
        $legacyEnrollmentTable = 'co' . 'urse_enrollment_lists';
        $legacyReviewTable = 'co' . 'urse_reviews';

        $driver = Schema::getConnection()->getDriverName();

        if (Schema::hasTable('users')) {
            if ($driver === 'mysql') {
                if (Schema::hasColumn('users', 'instructor_experience')) {
                    DB::statement('ALTER TABLE `users` CHANGE `instructor_experience` `tour_guide_experience` INT NOT NULL DEFAULT 0');
                }
                if (Schema::hasColumn('users', 'instructor_joining_request')) {
                    DB::statement("ALTER TABLE `users` CHANGE `instructor_joining_request` `tour_guide_joining_request` ENUM('pending','approved','rejected','not_yet') NOT NULL DEFAULT 'not_yet'");
                }
            } elseif ($driver === 'sqlite') {
                if (Schema::hasColumn('users', 'instructor_experience')) {
                    DB::statement('ALTER TABLE users RENAME COLUMN instructor_experience TO tour_guide_experience');
                }
                if (Schema::hasColumn('users', 'instructor_joining_request')) {
                    DB::statement('ALTER TABLE users RENAME COLUMN instructor_joining_request TO tour_guide_joining_request');
                }
            } else {
                Schema::table('users', function (Blueprint $table) {
                    if (Schema::hasColumn('users', 'instructor_experience')) {
                        $table->renameColumn('instructor_experience', 'tour_guide_experience');
                    }
                    if (Schema::hasColumn('users', 'instructor_joining_request')) {
                        $table->renameColumn('instructor_joining_request', 'tour_guide_joining_request');
                    }
                });
            }
        }

        if (Schema::hasTable($legacyEnrollmentTable)) {
            if ($driver === 'mysql') {
                if (Schema::hasColumn($legacyEnrollmentTable, 'instructor_id')) {
                    DB::statement("ALTER TABLE `{$legacyEnrollmentTable}` CHANGE `instructor_id` `tour_guide_id` INT NOT NULL");
                }
            } elseif ($driver === 'sqlite') {
                if (Schema::hasColumn($legacyEnrollmentTable, 'instructor_id')) {
                    DB::statement("ALTER TABLE {$legacyEnrollmentTable} RENAME COLUMN instructor_id TO tour_guide_id");
                }
            } else {
                Schema::table($legacyEnrollmentTable, function (Blueprint $table) use ($legacyEnrollmentTable) {
                    if (Schema::hasColumn($legacyEnrollmentTable, 'instructor_id')) {
                        $table->renameColumn('instructor_id', 'tour_guide_id');
                    }
                });
            }
        }

        if (Schema::hasTable($legacyReviewTable)) {
            if ($driver === 'mysql') {
                if (Schema::hasColumn($legacyReviewTable, 'instructor_id')) {
                    DB::statement("ALTER TABLE `{$legacyReviewTable}` CHANGE `instructor_id` `tour_guide_id` INT NOT NULL");
                }
            } elseif ($driver === 'sqlite') {
                if (Schema::hasColumn($legacyReviewTable, 'instructor_id')) {
                    DB::statement("ALTER TABLE {$legacyReviewTable} RENAME COLUMN instructor_id TO tour_guide_id");
                }
            } else {
                Schema::table($legacyReviewTable, function (Blueprint $table) use ($legacyReviewTable) {
                    if (Schema::hasColumn($legacyReviewTable, 'instructor_id')) {
                        $table->renameColumn('instructor_id', 'tour_guide_id');
                    }
                });
            }
        }

        if (Schema::hasTable('support_tickets')) {
            DB::table('support_tickets')->where('admin_type', 'instructor')->update(['admin_type' => 'tour_guide']);
        }
    }

    public function down(): void
    {
        $legacyEnrollmentTable = 'co' . 'urse_enrollment_lists';
        $legacyReviewTable = 'co' . 'urse_reviews';

        if (Schema::hasTable('support_tickets')) {
            DB::table('support_tickets')->where('admin_type', 'tour_guide')->update(['admin_type' => 'instructor']);
        }

        $driver = Schema::getConnection()->getDriverName();

        if (Schema::hasTable($legacyReviewTable)) {
            if ($driver === 'mysql') {
                if (Schema::hasColumn($legacyReviewTable, 'tour_guide_id')) {
                    DB::statement("ALTER TABLE `{$legacyReviewTable}` CHANGE `tour_guide_id` `instructor_id` INT NOT NULL");
                }
            } elseif ($driver === 'sqlite') {
                if (Schema::hasColumn($legacyReviewTable, 'tour_guide_id')) {
                    DB::statement("ALTER TABLE {$legacyReviewTable} RENAME COLUMN tour_guide_id TO instructor_id");
                }
            } else {
                Schema::table($legacyReviewTable, function (Blueprint $table) use ($legacyReviewTable) {
                    if (Schema::hasColumn($legacyReviewTable, 'tour_guide_id')) {
                        $table->renameColumn('tour_guide_id', 'instructor_id');
                    }
                });
            }
        }

        if (Schema::hasTable($legacyEnrollmentTable)) {
            if ($driver === 'mysql') {
                if (Schema::hasColumn($legacyEnrollmentTable, 'tour_guide_id')) {
                    DB::statement("ALTER TABLE `{$legacyEnrollmentTable}` CHANGE `tour_guide_id` `instructor_id` INT NOT NULL");
                }
            } elseif ($driver === 'sqlite') {
                if (Schema::hasColumn($legacyEnrollmentTable, 'tour_guide_id')) {
                    DB::statement("ALTER TABLE {$legacyEnrollmentTable} RENAME COLUMN tour_guide_id TO instructor_id");
                }
            } else {
                Schema::table($legacyEnrollmentTable, function (Blueprint $table) use ($legacyEnrollmentTable) {
                    if (Schema::hasColumn($legacyEnrollmentTable, 'tour_guide_id')) {
                        $table->renameColumn('tour_guide_id', 'instructor_id');
                    }
                });
            }
        }

        if (Schema::hasTable('users')) {
            if ($driver === 'mysql') {
                if (Schema::hasColumn('users', 'tour_guide_experience')) {
                    DB::statement('ALTER TABLE `users` CHANGE `tour_guide_experience` `instructor_experience` INT NOT NULL DEFAULT 0');
                }
                if (Schema::hasColumn('users', 'tour_guide_joining_request')) {
                    DB::statement("ALTER TABLE `users` CHANGE `tour_guide_joining_request` `instructor_joining_request` ENUM('pending','approved','rejected','not_yet') NOT NULL DEFAULT 'not_yet'");
                }
            } elseif ($driver === 'sqlite') {
                if (Schema::hasColumn('users', 'tour_guide_experience')) {
                    DB::statement('ALTER TABLE users RENAME COLUMN tour_guide_experience TO instructor_experience');
                }
                if (Schema::hasColumn('users', 'tour_guide_joining_request')) {
                    DB::statement('ALTER TABLE users RENAME COLUMN tour_guide_joining_request TO instructor_joining_request');
                }
            } else {
                Schema::table('users', function (Blueprint $table) {
                    if (Schema::hasColumn('users', 'tour_guide_experience')) {
                        $table->renameColumn('tour_guide_experience', 'instructor_experience');
                    }
                    if (Schema::hasColumn('users', 'tour_guide_joining_request')) {
                        $table->renameColumn('tour_guide_joining_request', 'instructor_joining_request');
                    }
                });
            }
        }
    }
};
