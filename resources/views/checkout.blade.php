<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan - {{ $usaha['nama'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-50 text-stone-800 antialiased">

    <header class="bg-white border-b border-orange-100">
        <div class="max-w-2xl mx-auto flex items-center justify-between px-4 py-3">
            <a href="{{ route('home') }}" class="text-xl font-extrabold text-red-600">🌶️ {{ $usaha['nama'] }}</a>
            <a href="{{ route('home') }}" class="text-sm font-medium hover:text-red-600">&larr; Ubah pesanan</a>
        </div>
    </header>

    <main class="max-w-2xl mx-auto px-4 py-8">

        <div class="bg-white rounded-2xl border border-orange-100 shadow-sm p-5">
            <h1 class="text-xl font-extrabold mb-3">Pesananmu</h1>
            @foreach ($lines as $line)
                <div class="flex justify-between text-sm py-2 border-b border-orange-100">
                    <span>{{ $line['menu']->name }} <span class="text-stone-500">x{{ $line['quantity'] }}</span></span>
                    <span class="font-semibold">Rp {{ number_format($line['subtotal'], 0, ',', '.') }}</span>
                </div>
            @endforeach
            <div class="flex justify-between pt-3">
                <span class="font-bold">Total</span>
                <span class="text-xl font-extrabold text-red-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>

        @if ($errors->any())
            <div class="mt-6 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 text-sm">
                <p class="font-bold mb-1">Mohon periksa lagi:</p>
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('order.store') }}"
              class="mt-6 bg-white rounded-2xl border border-orange-100 shadow-sm p-5 space-y-6">
            @csrf

            <div>
                <label class="block font-bold mb-2">Level pedas</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                    @foreach ($levels as $level)
                        <label class="flex items-center gap-2 border border-orange-200 rounded-lg px-3 py-2 cursor-pointer has-[:checked]:bg-red-50 has-[:checked]:border-red-400">
                            <input type="radio" name="spice_level" value="{{ $level }}"
                                   {{ old('spice_level', $levels[0]) === $level ? 'checked' : '' }}>
                            <span class="text-sm">{{ $level }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block font-bold mb-2">Rasa</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                    @foreach ($rasa as $item)
                        <label class="flex items-center gap-2 border border-orange-200 rounded-lg px-3 py-2 cursor-pointer has-[:checked]:bg-red-50 has-[:checked]:border-red-400">
                            <input type="radio" name="flavor" value="{{ $item }}"
                                   {{ old('flavor', $rasa[0]) === $item ? 'checked' : '' }}>
                            <span class="text-sm">{{ $item }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

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

            <button type="submit" class="w-full bg-red-600 text-white font-bold py-3 rounded-full hover:bg-red-700">
                Pesan &amp; konfirmasi lewat WhatsApp
            </button>
        </form>
    </main>

</body>
</html>