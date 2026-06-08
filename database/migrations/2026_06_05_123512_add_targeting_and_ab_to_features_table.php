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
    {Schema::table('features', function (Blueprint $table) {
    $table->json('allowed_roles')->nullable(); // For Targeting
    $table->float('traffic_percentage')->default(100); // For A/B Testing
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('features', function (Blueprint $table) {
            //
        });
    }
};
