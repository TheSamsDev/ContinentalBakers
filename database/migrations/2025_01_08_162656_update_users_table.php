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
            // Add new fields
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('avatar')->nullable();
            $table->string('language')->nullable();

            // Remove last_name if exists
            if (Schema::hasColumn('users', 'last_name')) {
                $table->dropColumn('last_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove added fields
            $table->dropColumn(['phone', 'address', 'state', 'zip_code', 'avatar', 'language']);

            // Restore last_name if needed
            $table->string('last_name')->nullable();
        });
    }
};
