<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Organizer Dashboard | EventSpeak</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        background: "#f8f9fb",
                        "surface-container": "#eceef0",
                        "tertiary-fixed-dim": "#ffb3b0",
                        "on-tertiary-fixed": "#410007",
                        "secondary-container": "#c0e6f4",
                        "outline-variant": "#bfc8cc",
                        "secondary-fixed": "#c3e8f7",
                        "on-primary-fixed": "#001f28",
                        "tertiary-container": "#a51526",
                        "surface-container-low": "#f2f4f6",
                        "surface-dim": "#d8dadc",
                        "on-surface": "#191c1e",
                        "error-container": "#ffdad6",
                        primary: "#004253",
                        "tertiary-fixed": "#ffdad8",
                        "on-secondary-fixed-variant": "#274c57",
                        "on-background": "#191c1e",
                        "on-secondary-fixed": "#001f28",
                        error: "#ba1a1a",
                        "secondary-fixed-dim": "#a7ccda",
                        "on-tertiary-fixed-variant": "#92001b",
                        "on-tertiary-container": "#ffb4b2",
                        "inverse-primary": "#8dd0e9",
                        "surface-container-highest": "#e1e3e4",
                        "surface-tint": "#19667d",
                        "on-secondary": "#ffffff",
                        "primary-fixed": "#b7eaff",
                        "inverse-on-surface": "#eff1f3",
                        "primary-container": "#005b71",
                        secondary: "#406370",
                        "surface-container-high": "#e6e8ea",
                        "on-primary-container": "#8ed1ea",
                        "primary-fixed-dim": "#8dd0e9",
                        "on-tertiary": "#ffffff",
                        "inverse-surface": "#2e3132",
                        "surface-bright": "#f8f9fb",
                        "on-primary-fixed-variant": "#004e61",
                        "on-secondary-container": "#446874",
                        "on-primary": "#ffffff",
                        outline: "#70787d",
                        "surface-variant": "#e1e3e4",
                        tertiary: "#7e0016",
                        "on-error": "#ffffff",
                        "on-error-container": "#93000a",
                        "on-surface-variant": "#40484c",
                        surface: "#f8f9fb",
                        "surface-container-lowest": "#ffffff",
                    },
                    borderRadius: {
                        DEFAULT: "0.125rem",
                        lg: "0.25rem",
                        xl: "0.5rem",
                        full: "0.75rem",
                    },
                    fontFamily: {
                        headline: ["Manrope"],
                        body: ["Inter"],
                    },
                },
            },
        };
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3 {
            font-family: 'Manrope', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="bg-surface text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Header Navigation -->
    <header class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md shadow-[0px_20px_40px_rgba(25,28,30,0.06)] h-20">
        <div class="flex justify-between items-center px-8 h-full max-w-full mx-auto">
            <div class="flex items-center gap-12">
                <span class="text-2xl font-black text-teal-900 font-headline tracking-tight">EventSpeak</span>
                <div class="hidden md:flex gap-8 items-center">
                    <a class="text-slate-600 hover:text-teal-600 font-medium transition-colors" href="{{ route('pengguna.index') }}">Browse</a>
                    <a class="text-slate-600 hover:text-teal-600 font-medium transition-colors" href="{{ route('pengguna.eksplorasi') }}">Event</a>
                    <a class="text-slate-600 hover:text-teal-600 font-medium transition-colors" href="{{ route('pengguna.schedule') }}">Schedule</a>
                    <a class="text-slate-600 hover:text-teal-600 font-medium transition-colors" href="{{ route('pembicara.index') }}">Become a Speaker</a>
                    <a class="text-slate-600 hover:text-teal-600 font-medium transition-colors" href="{{ route('pengguna.team') }}">Team</a>
                </div>
            </div>
            <div class="flex items-center gap-4">
                {{-- Avatar Default Native Style --}}
                <div class="flex items-center gap-4">
                    {{-- Avatar Kecil untuk Navigasi --}}
                    {{-- Navigasi Atas --}}
                    <a href="{{ route('pengguna.profil') }}" class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white shadow-md overflow-hidden hover:scale-105 transition-transform">
                        @if($user && $user->foto_profil)
                        {{-- Path ke storage --}}
                        <img src="{{ asset('uploads/profil/' . $user->foto_profil) }}" class="w-full h-full object-cover">
                        @else
                        <i class="fa-solid fa-user text-sm"></i>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="flex flex-1 pt-20">
        <!-- Sidebar Navigation -->
        <aside class="h-[calc(100vh-80px)] w-64 sticky left-0 top-20 flex flex-col p-6 gap-2 bg-slate-50 border-r border-slate-100">
            <div class="mb-8 px-2">
                <h2 class="font-extrabold text-xl text-on-background">{{ $user->nama_user ?? 'User' }}</h2>
                <p class="font-body text-xs font-semibold text-teal-700 tracking-wider uppercase">Penyelenggara</p>
            </div>
            <nav class="flex-grow space-y-1">
                <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-100 transition rounded-lg font-medium text-sm" href="{{ route('pengguna.profil') }}">
                    <span class="material-symbols-outlined">person</span>
                    <span>Profil</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-100 transition rounded-lg font-medium text-sm" href="{{ route('penyelenggara.dashboard') }}">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">stars</span>
                    <span>Dashboard Penyelenggara</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-teal-700 font-bold bg-white rounded-lg shadow-sm text-sm"
                    href="{{ route('penyelenggara.pembicara') }}">
                    <span class="material-symbols-outlined"style="font-variation-settings: 'FILL' 1;">mic</span>
                    <span>Pembicara Terdaftar</span>
                </a>
            </nav>
            <div class="mt-auto pt-6 border-t border-slate-200">
                <div class="space-y-1">
                    <a class="flex items-center gap-3 px-4 py-2 text-slate-500 hover:bg-slate-100 rounded-lg text-sm transition" href="#">
                        <span class="material-symbols-outlined">help</span>
                        <span>Help Center</span>
                    </a>
                    <button onclick="openModal()" class="w-full flex items-center gap-3 px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg text-sm transition text-left">
                        <span class="material-symbols-outlined">logout</span>
                        <span>Sign Out</span>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 pb-12 px-8 pt-8">
            <section class="max-w-6xl mx-auto">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">
                        Pembicara Terdaftar
                    </h2>

                    <span class="text-sm text-slate-400">
                        {{ $pembicaraTerdaftar->count() }} pembicara
                    </span>
                </div>

                @if($pembicaraTerdaftar->isEmpty())

                <div class="text-center py-12 bg-white rounded-xl border border-dashed border-slate-300">
                    <span class="material-symbols-outlined text-5xl text-slate-300 block mb-2">
                        mic_off
                    </span>

                    <p class="text-slate-500">
                        Belum ada pembicara yang terdaftar.
                    </p>
                </div>

                @else

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    @foreach($pembicaraTerdaftar as $p)

                    <div class="bg-white border border-slate-100 rounded-xl p-5 shadow-sm">

                        <div class="flex items-center gap-4">

                            <div class="w-14 h-14 rounded-full bg-primary flex items-center justify-center text-white font-bold text-xl overflow-hidden">

                                @if($p->foto_profil)

                                <img src="{{ asset('uploads/profil/' . $p->foto_profil) }}"
                                    class="w-full h-full object-cover">

                                @else

                                {{ strtoupper(substr($p->nama_pembicara,0,1)) }}

                                @endif

                            </div>

                            <div>
                                <h3 class="font-bold text-slate-900">
                                    {{ $p->nama_pembicara }}
                                </h3>

                                <p class="text-sm text-slate-500">
                                    {{ $p->bidang_keahlian }}
                                </p>
                            </div>

                        </div>

                        <div class="mt-4 space-y-1 text-sm text-slate-500">

                            <p>
                                <span class="font-semibold text-slate-700">
                                    Topik:
                                </span>

                                {{ $p->topik_event }}
                            </p>

                            <p>
                                <span class="font-semibold text-slate-700">
                                    Jenis Event:
                                </span>

                                {{ $p->jenis_event }}
                            </p>

                        </div>

                    </div>

                    @endforeach

                </div>

                @endif
            </section>
        </main>
    </div>

    {{-- FOOTER --}}
    <footer class="w-full py-16 px-4 md:px-8 mt-auto bg-slate-100">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12 max-w-7xl mx-auto px-4 md:px-8">
            <div class="col-span-1">
                <span class="font-manrope font-bold text-teal-800 text-2xl block mb-6">EventSpeak</span>
                <p class="text-slate-500 text-sm leading-relaxed mb-8">Platform webinar, workshop, dan bootcamp terintegrasi untuk membantu mahasiswa dan profesional menemukan event edukatif.</p>
                <div class="flex gap-4">
                    <a class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-teal-800 hover:bg-teal-800 hover:text-white transition-all" href="#"><i class="fa-brands fa-instagram text-[20px]"></i></a>
                    <a class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-teal-800 hover:bg-teal-800 hover:text-white transition-all" href="#"><i class="fa-brands fa-linkedin-in text-[20px]"></i></a>
                    <a class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-teal-800 hover:bg-teal-800 hover:text-white transition-all" href="#"><i class="fa-brands fa-x-twitter text-[20px]"></i></a>
                </div>
            </div>
            <div class="col-span-1">
                <h4 class="font-headline font-bold text-teal-900 mb-6">Support</h4>
                <ul class="space-y-4 text-sm mb-8">
                    <li><a class="text-slate-500 hover:text-teal-600 transition-colors" href="#">Privacy Policy</a></li>
                    <li><a class="text-slate-500 hover:text-teal-600 transition-colors" href="#">Terms of Service</a></li>
                    <li><a class="text-slate-500 hover:text-teal-600 transition-colors" href="#">Help Center</a></li>
                </ul>
                <h4 class="font-headline font-bold text-teal-900 mb-6">Contact</h4>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-center gap-2 text-slate-500"><span class="material-symbols-outlined text-sm">mail</span> eventspeak@gmail.com</li>
                    <li class="flex items-center gap-2 text-slate-500"><span class="material-symbols-outlined text-sm">call</span> +62 812-3456-7890</li>
                </ul>
            </div>
            <div class="col-span-1">
                <h4 class="font-headline font-bold text-teal-900 mb-6">Get in Touch</h4>
                <div class="flex flex-col gap-4">
                    <input class="w-full bg-white border border-slate-200 rounded-lg px-4 py-2 text-sm outline-none focus:ring-1 focus:ring-teal-500" placeholder="Name" type="text">
                    <input class="w-full bg-white border border-slate-200 rounded-lg px-4 py-2 text-sm outline-none focus:ring-1 focus:ring-teal-500" placeholder="Email" type="email">
                    <textarea class="w-full bg-white border border-slate-200 rounded-lg px-4 py-2 text-sm outline-none focus:ring-1 focus:ring-teal-500 min-h-[80px]" placeholder="Message"></textarea>
                    <button class="w-full py-3 bg-primary text-on-primary font-bold rounded-xl hover:opacity-90 transition-opacity">Send Message</button>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 md:px-8 mt-16 pt-8 border-t border-slate-200 text-center">
            <p class="text-sm text-slate-500">© 2026 EventSpeak</p>
        </div>
    </footer>

    <!-- Modal Sign Out -->
    <div id="logoutModal" class="fixed inset-0 bg-black/40 hidden z-50 items-center justify-center p-4">
        <div id="modalBox" class="bg-white rounded-xl p-6 w-[90%] max-w-sm shadow-lg transform scale-95 opacity-0 transition duration-200">
            <h2 class="text-lg font-bold mb-2">Konfirmasi</h2>
            <p class="text-slate-600 text-sm mb-6">Anda yakin ingin keluar?</p>
            <div class="flex justify-end gap-3">
                <button onclick="closeModal()" class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-lg text-sm font-medium">Batalkan</button>
                <a href="{{ route('logout') }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">Keluar</a>
            </div>
        </div>
    </div>

    
    <!-- JavaScript Actions -->
</body>

</html>