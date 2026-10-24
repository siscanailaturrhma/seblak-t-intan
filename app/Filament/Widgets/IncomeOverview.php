<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class IncomeOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $rupiah = fn ($angka) => 'Rp ' . number_format((float) $angka, 0, ',', '.');

        $hariIni = Order::whereDate('created_at', today());
        $bulanIni = Order::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month);

        return [
            Stat::make('Pemasukan hari ini', $rupiah($hariIni->sum('total_price')))
                ->description($hariIni->count() . ' pesanan hari ini'),
            Stat::make('Pemasukan bulan ini', $rupiah($bulanIni->sum('total_price')))
                ->description($bulanIni->count() . ' pesanan bulan ini'),
            Stat::make('Total semua pemasukan', $rupiah(Order::sum('total_price')))
                ->description(Order::count() . ' pesanan seluruhnya'),
        ];
    }
}