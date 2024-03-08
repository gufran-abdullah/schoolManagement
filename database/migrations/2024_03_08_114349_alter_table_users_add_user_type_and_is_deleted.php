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
            if (!Schema::hasColumn('users', 'user_type')) {
                $table->tinyInteger('user_type')->default(3)->comment('1 - Admin, 2 - Teacher, 3 - Student, 4 - Parent')->after('remember_token');
            }
            if (!Schema::hasColumn('users', 'is_deleted')) {
                $table->tinyInteger('is_deleted')->default(0)->after('user_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'user_type')) {
                $table->dropColumn('user_type');
            }
            if (Schema::hasColumn('users', 'is_deleted')) {
                $table->dropColumn('is_deleted');
            }
        });
    }
};
