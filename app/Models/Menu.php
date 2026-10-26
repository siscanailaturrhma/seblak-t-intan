<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'image',
        'is_available',
        'use_spice_level',
        'option_groups',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'use_spice_level' => 'boolean',
        'option_groups' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Kelompok pilihan yang tampil untuk pelanggan (level pedas + pilihan buatan admin).
     */
    public function resolvedOptionGroups(): array
    {
        $groups = [];

        if ($this->use_spice_level) {
            $groups[] = [
                'name' => 'Level pedas',
                'type' => 'single',
                'required' => true,
                'choices' => collect(config('seblak.level_pedas'))
                    ->map(fn ($level) => ['name' => $level, 'price' => 0])
                    ->all(),
            ];
        }

        foreach ($this->option_groups ?? [] as $group) {
            if (! empty($group['use_toppings'])) {
                $choices = Topping::where('is_available', true)
                    ->orderBy('name')
                    ->get()
                    ->map(fn ($topping) => ['name' => $topping->name, 'price' => (int) $topping->price])
                    ->all();
            } else {
                $choices = collect($group['choices'] ?? [])
                    ->filter(fn ($choice) => filled($choice['name'] ?? null))
                    ->map(fn ($choice) => [
                        'name' => $choice['name'],
                        'price' => (int) ($choice['price'] ?? 0),
                    ])
                    ->values()
                    ->all();
            }

            if (empty($choices)) {
                continue;
            }
            $groups[] = [
                'name' => $group['name'] ?? 'Pilihan',
                'type' => $group['type'] ?? 'single',
                'required' => (bool) ($group['required'] ?? false),
                'multiply' => (bool) ($group['multiply_base'] ?? false),
                'choices' => $choices,
            ];
        }

        return $groups;
    }

    public function getImageUrlAttribute(): ?string { if (! $this->image) { return asset("images/menu-dummy.svg"); } $disk = config("filesystems.menu_disk"); return $disk === "public" ? asset("storage/" . $this->image) : \Illuminate\Support\Facades\Storage::disk($disk)->url($this->image); }
}
