<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class StatusWarung extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingStorefront;

    protected static ?string $navigationLabel = 'Buka / Tutup';

    protected static ?string $title = 'Status Warung';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.status-warung';

    public bool $buka = true;

    public function mount(): void
    {
        $this->buka = Setting::warungBuka();
    }

    public function ubah(): void
    {
        $this->buka = ! $this->buka;
        Setting::setWarungBuka($this->buka);

        Notification::make()
            ->title($this->buka ? 'Warung sekarang BUKA' : 'Warung sekarang TUTUP')
            ->success()
            ->send();
    }
}