<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;

class TutupWarung
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod("post") && ! $request->is("admin*", "livewire*") && ! Setting::warungBuka()) {
            return response("<!doctype html><html lang=\"id\"><head><meta charset=\"utf-8\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"><title>Warung Tutup</title></head><body style=\"font-family:Arial;text-align:center;padding:60px 20px\"><h1>Warung sedang tutup</h1><p>Maaf, pesanan belum bisa dibuat sekarang. Silakan coba lagi saat warung buka.</p><a href=\"/\">Kembali ke beranda</a></body></html>", 503);
        }
        return $next($request);
    }
}
