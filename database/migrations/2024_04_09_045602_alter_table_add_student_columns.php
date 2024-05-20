<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'admission_number')) {
                $table->string('admission_number', 100)->nullable()->after('remember_token');
            }
            if (!Schema::hasColumn('users', 'roll_number')) {
                $table->string('roll_number', 50)->nullable()->after('admission_number');
            }
            if (!Schema::hasColumn('users', 'class_id')) {
                $table->foreignId('class_id')->nullable()->constrained('classes', 'id');
            }
            if (!Schema::hasColumn('users', 'gender')) {
                $table->string('gender', 10)->nullable()->after('class_id');
            }
            if (!Schema::hasColumn('users', 'date_of_birth')) {
                $table->timestamp('date_of_birth')->nullable()->after('gender');
            }
            if (!Schema::hasColumn('users', 'phone_number')) {
                $table->string('phone_number', 16)->nullable()->after('date_of_birth');
            }
            if (!Schema::hasColumn('users', 'admission_date')) {
                $table->timestamp('admission_date')->nullable()->after('phone_number');
            }
            if (!Schema::hasColumn('users', 'profile_image')) {
                $table->string('profile_image', 100)->nullable()->after('admission_date');
            }
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->tinyInteger('is_active')->default(0)->after('profile_image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'admission_number')) {
                $table->dropColumn('admission_number');
            }
            if (Schema::hasColumn('users', 'roll_number')) {
                $table->dropColumn('roll_number');
            }
            if (Schema::hasColumn('users', 'class_id')) {
                $table->dropColumn('class_id');
            }
            if (Schema::hasColumn('users', 'gender')) {
                $table->dropColumn('gender');
            }
            if (Schema::hasColumn('users', 'date_of_birth')) {
                $table->dropColumn('date_of_birth');
            }
            if (Schema::hasColumn('users', 'phone_number')) {
                $table->dropColumn('phone_number');
            }
            if (Schema::hasColumn('users', 'admission_date')) {
                $table->dropColumn('admission_date');
            }
            if (Schema::hasColumn('users', 'profile_image')) {
                $table->dropColumn('profile_image');
            }
            if (Schema::hasColumn('users', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};
