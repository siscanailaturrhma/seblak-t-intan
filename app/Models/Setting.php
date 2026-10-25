<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function warungBuka(): bool
    {
        return self::where('key', 'warung_buka')->value('value') !== '0';
    }

    public static function setWarungBuka(bool $buka): void
    {
        self::updateOrCreate(['key' => 'warung_buka'], ['value' => $buka ? '1' : '0']);
    }
}