<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $usaha['nama'])</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-50 text-stone-800 antialiased">

    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-orange-100">
        <nav class="max-w-6xl mx-auto flex items-center justify-between px-4 py-3">
            <a href="#beranda" class="text-xl font-extrabold text-red-600">
                 {{ $usaha['nama'] }}
            </a>
            <div class="hidden sm:flex gap-6 text-sm font-medium">
                <a href="#menu" class="hover:text-red-600">Menu</a>
                <a href="#profil" class="hover:text-red-600">Profil</a>
                <a href="#lokasi" class="hover:text-red-600">Lokasi</a>
            </div>
        </nav>
        <div class="sm:hidden flex justify-center gap-5 text-sm font-medium pb-2">
            <a href="#menu">Menu</a>
            <a href="#profil">Profil</a>
            <a href="#lokasi">Lokasi</a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-stone-900 text-stone-300 text-center text-sm py-6 mt-16">
        &copy; {{ date('Y') }} {{ $usaha['nama'] }}. All rights reserved. Developed by Sisca Taurin N.
    </footer>

</body>
</html>