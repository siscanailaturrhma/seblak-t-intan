@php
    $hasQuantityGroup = collect($groups)->contains(fn ($group) => $group['type'] === 'quantity');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan {{ $menu->name }} - {{ $usaha['nama'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-50 text-stone-800 antialiased">

    <header class="bg-white border-b border-orange-100">
        <div class="max-w-2xl mx-auto flex items-center justify-between px-4 py-3">
            <a href="{{ route('home') }}" class="text-xl font-extrabold text-red-600"> {{ $usaha['nama'] }}</a>
            <a href="{{ route('home') }}" class="text-sm font-medium hover:text-red-600">&larr; Kembali ke menu</a>
        </div>
    </header>

    <main class="max-w-2xl mx-auto px-4 py-8">

        <div class="bg-white rounded-2xl border border-orange-100 shadow-sm overflow-hidden">
            @if ($menu->image_url)
                <img onerror="this.onerror=null;this.src='/images/menu-dummy.svg'" src="{{ $menu->image_url }}" alt="{{ $menu->name }}" class="h-56 w-full object-cover">
            @endif
            <div class="p-5">
                <h1 class="text-2xl font-extrabold">{{ $menu->name }}</h1>
                <p class="text-stone-500 mt-1">{{ $menu->description }}</p>
                @if ($menu->price == 0)
                    <p class="mt-3 font-semibold text-red-600">Harga Dihitung Dari Pilihanmu.</p>
                @else
                    <p class="mt-3 text-xl font-extrabold text-red-600">
                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                    </p>
                @endif
            </div>
        </div>

        @if ($errors->any())
            <div class="mt-6 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 text-sm">
                <p class="font-bold mb-1">Mohon Periksa Lagi:</p>
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="order-form" method="POST" action="{{ route('order.store') }}"
              data-price="{{ $menu->price }}"
              class="mt-6 bg-white rounded-2xl border border-orange-100 shadow-sm p-5 space-y-6">
            @csrf
            <input type="hidden" name="menu_id" value="{{ $menu->id }}">

            @foreach ($groups as $g => $group)
                <div>
                    <label class="block font-bold mb-2">
                        {{ $group['name'] }}
                        <span class="text-sm font-normal text-stone-500">
                            @if ($group['type'] === 'single')
                                (pilih salah satu)
                            @elseif ($group['type'] === 'multiple')
                                (boleh lebih dari satu)
                            @else
                                (pilih jumlahnya)
                            @endif
                        </span>
                    </label>

                    @if ($group['type'] === 'single')
                        @php
                            $current = old("options.$g", $group['required'] ? 0 : '');
                        @endphp

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            @unless ($group['required'])
                                <label class="flex items-center gap-2 border border-orange-200 rounded-lg px-3 py-2 cursor-pointer text-sm has-[:checked]:bg-red-50 has-[:checked]:border-red-400">
                                    <input type="radio" name="options[{{ $g }}]" value="" data-price="0"
                                           {{ (string) $current === '' ? 'checked' : '' }}>
                                    Tidak perlu
                                </label>
                            @endunless

                            @foreach ($group['choices'] as $c => $choice)
                                <label class="flex items-center gap-2 border border-orange-200 rounded-lg px-3 py-2 cursor-pointer text-sm has-[:checked]:bg-red-50 has-[:checked]:border-red-400">
                                    <input type="radio" name="options[{{ $g }}]" value="{{ $c }}"
                                           data-price="{{ $choice['price'] }}"
                                           {{ (string) $current === (string) $c ? 'checked' : '' }}>
                                    <span>
                                        {{ $choice['name'] }}
                                        @if ($choice['price'] > 0)
                                            <span class="block text-xs text-stone-500">+ Rp {{ number_format($choice['price'], 0, ',', '.') }}</span>
                                        @endif
                                    </span>
                                </label>
                            @endforeach
                        </div>

                    @elseif ($group['type'] === 'multiple')
                        @php
                            $selected = (array) old("options.$g", []);
                        @endphp

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            @foreach ($group['choices'] as $c => $choice)
                                <label class="flex items-center gap-2 border border-orange-200 rounded-lg px-3 py-2 cursor-pointer text-sm has-[:checked]:bg-red-50 has-[:checked]:border-red-400">
                                    <input type="checkbox" name="options[{{ $g }}][]" value="{{ $c }}"
                                           data-price="{{ $choice['price'] }}"
                                           {{ in_array($c, $selected) ? 'checked' : '' }}>
                                    <span>
                                        {{ $choice['name'] }}
                                        @if ($choice['price'] > 0)
                                            <span class="block text-xs text-stone-500">+ Rp {{ number_format($choice['price'], 0, ',', '.') }}</span>
                                        @endif
                                    </span>
                                </label>
                            @endforeach
                        </div>

                    @else
                        @foreach ($group['choices'] as $c => $choice)
                            <div class="flex items-center justify-between border border-orange-200 rounded-lg px-3 py-2 mb-2">
                                <span class="text-sm">{{ $choice['name'] }}</span>
                                <div class="flex items-center gap-3">
                                    @if ($choice['price'] > 0)
                                        <span class="text-sm text-stone-500">Rp {{ number_format($choice['price'], 0, ',', '.') }}</span>
                                    @endif
                                    <div class="flex items-center gap-2">
                                        <button type="button" data-step="-1"
                                                class="w-8 h-8 rounded-full border border-red-300 text-red-600 font-bold hover:bg-red-50">−</button>
                                        <input type="text" inputmode="numeric" readonly
                                               name="options[{{ $g }}][{{ $c }}]"
                                               value="{{ old("options.$g.$c", 0) }}"
                                               data-qty data-price="{{ $choice['price'] }}" data-multiply="{{ ! empty($group['multiply']) ? 1 : 0 }}"
                                               class="w-8 text-center font-bold bg-transparent">
                                        <button type="button" data-step="1"
                                                class="w-8 h-8 rounded-full bg-red-600 text-white font-bold hover:bg-red-700">+</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endforeach

            @unless ($hasQuantityGroup)
                <div>
                    <label for="quantity" class="block font-bold mb-2">Jumlah</label>
                    <input id="quantity" type="number" name="quantity" min="1" max="50" required placeholder="Isi jumlah"
                           value="{{ old('quantity') }}"
                           class="w-28 border border-orange-200 rounded-lg px-3 py-2">
                </div>
            @endunless

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label for="customer_name" class="block font-bold mb-2">Nama kamu</label>
                    <input id="customer_name" type="text" name="customer_name" value="{{ old('customer_name') }}"
                           class="w-full border border-orange-200 rounded-lg px-3 py-2" required>
                </div>
                <div>
                    <label for="customer_phone" class="block font-bold mb-2">No. WhatsApp</label>
                    <input id="customer_phone" type="text" name="customer_phone" value="{{ old('customer_phone') }}"
                           placeholder="08123456789"
                           class="w-full border border-orange-200 rounded-lg px-3 py-2" required>
                </div>
            </div>

            <div class="border-t border-orange-100 pt-4 flex items-center justify-between">
                <span class="font-bold">Total</span>
                <span id="total" class="text-2xl font-extrabold text-red-600">Rp 0</span>
            </div>

            <button type="submit" class="w-full bg-red-600 text-white font-bold py-3 rounded-full hover:bg-red-700">
                Pesan &amp; konfirmasi lewat WhatsApp
            </button>
        </form>
    </main>

    <script>
        var form = document.getElementById('order-form');
        var basePrice = Number(form.dataset.price);
        var totalEl = document.getElementById('total');

        function hitung() {
            var extras = 0;
            var count = 0;
            var hasMultiply = false;

            form.querySelectorAll('input[type="radio"]:checked').forEach(function (el) {
                extras += Number(el.dataset.price || 0);
            });
            form.querySelectorAll('input[type="checkbox"]:checked').forEach(function (el) {
                extras += Number(el.dataset.price || 0);
            });
            form.querySelectorAll('[data-qty]').forEach(function (el) {
                var qty = parseInt(el.value) || 0;
                extras += qty * Number(el.dataset.price || 0);
                if (el.dataset.multiply === '1') {
                    hasMultiply = true;
                    count += qty;
                }
            });

            var total;
            if (hasMultiply) {
                total = basePrice * count + extras;
            } else {
                var jumlah = 1;
                var qtyInput = document.getElementById('quantity');
                if (qtyInput) {
                    jumlah = Math.max(0, parseInt(qtyInput.value) || 0);
                }
                total = (basePrice + extras) * jumlah;
            }

            totalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        form.querySelectorAll('[data-step]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var input = btn.parentElement.querySelector('input');
                var next = (parseInt(input.value) || 0) + Number(btn.dataset.step);
                input.value = Math.min(99, Math.max(0, next));
                hitung();
            });
        });

        form.addEventListener('input', hitung);
        form.addEventListener('change', hitung);
        hitung();
    </script>

</body>
</html>