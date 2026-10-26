@extends('layouts.app')

@section('content')

@php $warungBuka = \App\Models\Setting::warungBuka(); @endphp
    <div class="{{ $warungBuka ? 'bg-green-600' : 'bg-gray-800' }} text-white text-center text-sm font-bold py-2">
        {{ $warungBuka ? 'Warung BUKA, yuk pesan sekarang!' : 'Warung TUTUP, pesanan belum bisa dibuat.' }}
    </div>

    {{-- BERANDA --}}
<section id="beranda" class="bg-[#9f2630] text-white">
    <div class="overflow-hidden">
        <img src="{{ asset('images/banner.png') }}" alt="{{ $usaha['nama'] }}" class="block w-full h-auto scale-110">
    </div>
    <div class="text-center py-5">
        <a href="#menu" class="inline-block bg-white text-red-600 font-bold px-8 py-3 rounded-full shadow hover:bg-orange-100">
            Lihat Menu
        </a>
    </div>
</section>

{{-- MENU --}}
<section id="menu" class="max-w-6xl mx-auto px-4 pt-16">
    <h2 class="text-3xl font-extrabold text-center">Menu & Harga</h2>
    <p class="text-center text-stone-500 mt-2">Pilih Seblak dan Jajanan Favoritmu.</p>

    @forelse ($categories as $category)
        <h3 class="mt-12 mb-4 text-xl font-bold text-red-600">{{ $category->name }}</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($category->menus as $menu)
                <div class="bg-white rounded-2xl shadow-sm border border-orange-100 overflow-hidden flex flex-col">
                    @if ($menu->image_url)
                        <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" class="h-48 w-full object-cover">
                    @else
                        <div class="h-48 flex items-center justify-center bg-orange-100 text-5xl">🍜</div>
                    @endif
                    <div class="p-4 flex flex-col flex-1">
                        <h4 class="font-bold text-lg">{{ $menu->name }}</h4>
                        <p class="text-sm text-stone-500 mt-1 flex-1">{{ $menu->description }}</p>
                        <div class="flex items-center justify-between mt-4">
                            <span class="font-extrabold text-red-600">
                                @if ($menu->price == 0)
                                    Pilih sendiri isinya
                                @else
                                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                                @endif
                            </span>
                            <a href="{{ route('order.create', $menu) }}" class="bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-full hover:bg-red-700">
                                Pesan
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @empty
        <p class="text-center text-stone-500 mt-10">Menu belum tersedia.</p>
    @endforelse
</section>

{{-- PROFIL --}}
<section id="profil" class="max-w-3xl mx-auto px-4 pt-20 text-center">
    <h2 class="text-3xl font-extrabold">Tentang Kami</h2>
    <p class="mt-4 text-stone-600 leading-relaxed">{{ $usaha['profil'] }}</p>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-8 text-sm">
        <div class="bg-white rounded-xl p-4 border border-orange-100">🔥 Level pedas bebas diatur</div>
        <div class="bg-white rounded-xl p-4 border border-orange-100">🧆 Topping lengkap</div>
        <div class="bg-white rounded-xl p-4 border border-orange-100">📲 Pesan online, konfirmasi lewat WhatsApp</div>
    </div>
</section>

{{-- LOKASI --}}
<section id="lokasi" class="max-w-6xl mx-auto px-4 pt-20">
    <h2 class="text-3xl font-extrabold text-center">Lokasi</h2>
    <p class="text-center text-stone-600 mt-3">{{ $usaha['alamat'] }}</p>
    <p class="text-center text-stone-500 text-sm">{{ $usaha['jam'] }}</p>
    <div class="mt-6 rounded-2xl overflow-hidden border border-orange-100 shadow-sm">
        <iframe
            src="https://maps.google.com/maps?q={{ urlencode($usaha['peta']) }}&output=embed"
            class="w-full h-80" style="border:0" loading="lazy"></iframe>
    </div>
</section>

@endsection