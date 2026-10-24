<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->boolean('use_spice_level')->default(false)->after('is_available');
            $table->json('option_groups')->nullable()->after('use_spice_level');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->json('selections')->nullable();
            $table->string('spice_level')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn(['use_spice_level', 'option_groups']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('selections');
        });
    }
};