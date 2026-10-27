<?php

namespace App\Filament\Resources\Menus\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('name')
                    ->label('Nama menu')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->label('Harga')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->helperText('Isi 0 kalau harganya dihitung dari pilihan pelanggan (misalnya seblak prasmanan).'),
                FileUpload::make('image')
                    ->label('Foto')
                    ->image()
                    ->disk(config('filesystems.menu_disk'))
                    ->directory("menus")->saveUploadedFileUsing(function ($file) { $path = "menus/" . \Illuminate\Support\Str::ulid() . "." . strtolower($file->getClientOriginalExtension() ?: "jpg"); \Illuminate\Support\Facades\Storage::disk(config("filesystems.menu_disk"))->put($path, file_get_contents($file->getRealPath())); return $path; })
                    ->visibility('public'),
                Toggle::make('is_available')
                    ->label('Tersedia')
                    ->default(true),
                Section::make('Pilihan menu')
                    ->description('Atur apa saja yang bisa dipilih pelanggan untuk menu ini. Kosongkan kalau menu ini hanya perlu jumlah.')
                    ->schema([
                        Toggle::make('use_spice_level')
                            ->label('Pilihan Level Pedas'),
                        Repeater::make('option_groups')
                            ->reorderableWithButtons()
                            ->label('Pilihan')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama kelompok')
                                    ->placeholder('Contoh: Topping, Isian, Jenis mie')
                                    ->required(),
                                Select::make('type')
                                    ->label('Cara memilih')
                                    ->options([
                                        'single' => 'Pilih salah satu',
                                        'multiple' => 'Boleh lebih dari satu (centang)',
                                        'quantity' => 'Pilih dengan jumlah (+/-)',
                                    ])
                                    ->default('single')
                                    ->required(),
                                Toggle::make('required')
                                    ->label('Wajib Dipilih')
                                    ->default(true),
                                Toggle::make('multiply_base')
                                    ->label('Harga Menu'),
                                Repeater::make('choices')
                                    ->label('Daftar Pilihan')
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Nama Pilihan')
                                            ->required(),
                                        TextInput::make('price')
                                            ->label('Tambahan Harga')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->default(0),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(0)
                                    ->addActionLabel('Tambah Pilihan')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->addActionLabel('Tambah Kelompok Pilihan')
                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                            ->collapsible()
                            ->cloneable()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}