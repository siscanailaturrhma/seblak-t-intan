<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedInteger('queue_number')->nullable()->after('id');
        });

        $counter = [];
        foreach (DB::table('orders')->orderBy('id')->get() as $order) {
            $day = Carbon::parse($order->created_at, 'UTC')->setTimezone('Asia/Jakarta')->toDateString();
            $counter[$day] = ($counter[$day] ?? 0) + 1;
            DB::table('orders')->where('id', $order->id)->update(['queue_number' => $counter[$day]]);
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('queue_number');
        });
    }
};