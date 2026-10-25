<x-filament-panels::page>
    <x-filament::section>
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="text-lg font-bold">
                    Status sekarang: {{ $buka ? 'BUKA' : 'TUTUP' }}
                </div>
                <p class="text-sm text-gray-500">Pembeli melihat status ini di website.</p>
            </div>
            <x-filament::button wire:click="ubah" :color="$buka ? 'danger' : 'success'">
                {{ $buka ? 'Tutup warung' : 'Buka warung' }}
            </x-filament::button>
        </div>
    </x-filament::section>
</x-filament-panels::page>