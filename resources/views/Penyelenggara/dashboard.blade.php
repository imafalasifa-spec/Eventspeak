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
                <a class="flex items-center gap-3 px-4 py-3 text-teal-700 font-bold bg-white rounded-lg shadow-sm text-sm" href="{{ route('penyelenggara.dashboard') }}">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">stars</span>
                    <span>Dashboard Penyelenggara</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-100 transition rounded-lg font-medium text-sm"
                    href="{{ route('penyelenggara.pembicara') }}">
                    <span class="material-symbols-outlined">mic</span>
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
            <!-- Alert Notifikasi Sukses Laravel -->
            @if(session('success'))
            <div class="max-w-6xl mx-auto mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                <p class="font-bold">Sukses</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
            @endif

            <header class="mb-12 max-w-6xl mx-auto">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div>
                        <span class="text-primary font-bold tracking-wider uppercase text-xs">Organizer Hub</span>
                        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tighter text-slate-900 mt-2">Welcome back!</h1>
                    </div>
                    <a href="{{ route('penyelenggara.createevent') }}" class="bg-gradient-to-r from-primary to-primary-container text-white py-2 px-4 rounded-lg text-sm font-medium flex items-center justify-center gap-2 shadow active:scale-95 duration-200">
                        <span class="material-symbols-outlined text-base">add_circle</span>
                        <span>Create Event</span>
                    </a>
                </div>
            </header>

            <!-- Bento Grid Stats -->
            <section class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-6 mb-16">
                <div class="md:col-span-2 bg-gradient-to-br from-primary to-slate-900 p-8 rounded-xl text-white flex flex-col justify-between relative min-h-[200px]">
                    <div class="relative z-10">
                        <p class="text-slate-300 font-medium uppercase tracking-wider text-xs mb-1">Nama Instansi</p>
                        <h3 class="text-3xl font-black tracking-tight">{{ $penyelenggara->instansi ?? '-' }}</h3>
                        <p class="text-sm text-slate-200 mt-2">Peran: {{ $penyelenggara->peran ?? '-' }}</p>
                    </div>
                </div>
                <a href="#event" class="block">
                    <div class="bg-white p-8 rounded-xl shadow-sm border border-slate-100 flex flex-col justify-between min-h-[200px]">
                        <div>
                            <p class="text-slate-400 font-medium uppercase tracking-wider text-xs mb-1">Active Events</p>
                            <h3 class="text-5xl font-bold tracking-tight text-slate-900">{{ $totalEvent }}</h3>
                        </div>
                        <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden mt-4">
                            <div class="h-full bg-primary rounded-full" style="width: 100%"></div>
                        </div>
                        <p class="text-slate-500 text-xs mt-2">Semua event aktif Anda</p>
                    </div>
                </a>
                <a href="#financial" class="block">
                    <div class="relative bg-gradient-to-br from-teal-500 to-primary p-8 rounded-xl flex flex-col justify-between min-h-[200px] overflow-hidden">
                        <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full"></div>
                        <div class="absolute -right-2 -bottom-12 w-48 h-48 bg-white/5 rounded-full"></div>
                        <div class="relative z-10">
                            <p class="text-teal-200 font-bold uppercase tracking-widest text-xs mb-1">Total Pendapatan</p>
                            <h3 class="text-3xl font-black tracking-tight text-white mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                            <p class="text-teal-200 text-xs mt-2">Dari seluruh peserta event</p>
                        </div>
                        <div class="relative z-10 mt-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-teal-300 text-sm">trending_up</span>
                            <span class="text-teal-200 text-xs font-medium">{{ $eventsPublished->count() }} event aktif</span>
                        </div>
                    </div>
                </a>
            </section>

            <!-- Events List Section -->
            <section class="max-w-6xl mx-auto mt-16" id="event" style="scroll-margin-top: 100px;">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">Your Events</h2>
                </div>

                {{-- TAB BUTTONS --}}
                <div class="flex items-center gap-3 mb-8">
                    <button onclick="showTab('published')" id="tab-published"
                        class="px-5 py-2 rounded-full text-sm font-bold bg-primary text-white transition">
                        Published ({{ $eventsPublished->count() }})
                    </button>
                    <button onclick="showTab('draft')" id="tab-draft"
                        class="px-5 py-2 rounded-full text-sm font-bold bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition">
                        Draft ({{ $eventsMenunggu->count() }})
                    </button>
                </div>

                {{-- PANEL PUBLISHED --}}
                <div id="panel-published" class="space-y-6">
                    @forelse($eventsPublished as $data)
                    <div class="bg-white rounded-xl p-6 transition-all hover:translate-x-1 duration-300 border-l-4 border-teal-500 shadow-sm border border-slate-100">
                        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                            <div class="flex items-center gap-6">
                                <a href="{{ route('event.show', $data->id) }}" class="w-24 h-24 rounded-xl overflow-hidden bg-slate-200 flex-shrink-0 block hover:opacity-80 transition">
                                    <img src="{{ asset('upload/' . ($data->Gambar ?? 'default.png')) }}"
                                        class="w-full h-full object-cover" alt="Event Banner"
                                        onerror="this.src='https://via.placeholder.com/96'">
                                </a>
                                <div>
                                    <div class="flex gap-2 mb-1 flex-wrap">
                                        <span class="bg-teal-100 text-teal-700 text-[10px] px-2 py-0.5 rounded font-semibold">Published</span>
                                        <span class="bg-blue-100 text-teal-700 text-[10px] px-2 py-0.5 rounded">{{ $data->Jenis_Event ?? '-' }}</span>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-900 tracking-tight">{{ $data->Nama_Event }}</h3>
                                    <p class="text-teal-700 font-semibold mt-1">
                                        <span class="material-symbols-outlined text-sm align-middle">person</span>
                                        {{ $data->Pemateri }}
                                    </p>
                                    <div class="flex flex-wrap gap-x-6 mt-2 text-slate-500 text-sm">
                                        <div class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">calendar_today</span>
                                            <span>{{ $data->Tanggal ?? '-' }}</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">location_on</span>
                                            <span>{{ $data->Lokasi ?? '-' }}</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">payments</span>
                                            <span>Rp {{ number_format((int)($data->Harga ?? 0), 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('penyelenggara.editEvent', $data->id) }}"
                                    class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-xl text-sm transition">
                                    Edit
                                </a>
                                <button onclick="openDeleteModal('{{ $data->id }}')"
                                    class="px-4 py-2 bg-tertiary hover:bg-tertiary text-white font-medium rounded-xl text-sm transition">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 bg-white rounded-xl border border-dashed border-slate-300">
                        <span class="material-symbols-outlined text-5xl text-slate-300 block mb-2">event_busy</span>
                        <p class="text-slate-500">Belum ada event yang dipublish.</p>
                    </div>
                    @endforelse
                </div>

                {{-- PANEL DRAFT --}}
                <div id="panel-draft" class="space-y-6 hidden">
                    @forelse($eventsMenunggu as $data)
                    @php
                    // Cek apakah ada lamaran yang sudah diterima untuk event ini
                    $lamaranDiterima = DB::table('lamaran_pembicara')
                    ->join('pembicara', 'lamaran_pembicara.id_pembicara', '=', 'pembicara.id_pembicara')
                    ->where('lamaran_pembicara.id_event', $data->id)
                    ->where('lamaran_pembicara.status', 'diterima')
                    ->select('pembicara.nama_pembicara', 'pembicara.bidang_keahlian')
                    ->first();

                    // Ambil semua lamaran pending untuk event ini
                    $lamaranEvent = DB::table('lamaran_pembicara')
                    ->join('pembicara', 'lamaran_pembicara.id_pembicara', '=', 'pembicara.id_pembicara')
                    ->where('lamaran_pembicara.id_event', $data->id)
                    ->select('lamaran_pembicara.id', 'lamaran_pembicara.status', 'pembicara.nama_pembicara', 'pembicara.bidang_keahlian', 'pembicara.email_pembicara')
                    ->orderBy('lamaran_pembicara.id', 'desc')
                    ->get();
                    @endphp

                    <div class="bg-white rounded-xl overflow-hidden border-l-4 {{ $lamaranDiterima ? 'border-green-400' : 'border-slate-400' }} shadow-sm border border-slate-100">
                        {{-- Card Info Event --}}
                        <div class="p-6">
                            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                                <div class="flex items-center gap-6">
                                    <a href="{{ route('event.show', $data->id) }}" class="w-24 h-24 rounded-xl overflow-hidden bg-slate-200 flex-shrink-0 block hover:opacity-80 transition">
                                        <img src="{{ asset('upload/' . ($data->Gambar ?? 'default.png')) }}"
                                            class="w-full h-full object-cover" alt="Event Banner"
                                            onerror="this.src='https://via.placeholder.com/96'">
                                    </a>
                                    <div>
                                        <div class="flex gap-2 mb-1 flex-wrap">
                                            <span class="bg-slate-100 text-slate-700 text-[10px] px-2 py-0.5 rounded font-semibold">Draft</span>
                                            <span class="bg-teal-100 text-teal-700 text-[10px] px-2 py-0.5 rounded">{{ $data->Jenis_Event ?? '-' }}</span>
                                            @if($lamaranDiterima)
                                            <span class="bg-green-100 text-green-700 text-[10px] px-2 py-0.5 rounded font-semibold">✅ Pembicara Siap</span>
                                            @endif
                                        </div>
                                        <h3 class="text-xl font-bold text-slate-900 tracking-tight">{{ $data->Nama_Event }}</h3>
                                        @if($lamaranDiterima)
                                        <p class="text-green-700 font-semibold text-sm mt-1">
                                            <span class="material-symbols-outlined text-sm align-middle">person</span>
                                            {{ $lamaranDiterima->nama_pembicara }} · {{ $lamaranDiterima->bidang_keahlian }}
                                        </p>
                                        @else
                                        <p class="text-tertiary text-sm mt-1 italic">Menunggu pembicara mendaftar...</p>
                                        @endif
                                        <div class="flex flex-wrap gap-x-6 mt-2 text-slate-500 text-sm">
                                            <div class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-sm">calendar_today</span>
                                                <span>{{ $data->Tanggal ?? '-' }}</span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-sm">location_on</span>
                                                <span>{{ $data->Lokasi ?? '-' }}</span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-sm">payments</span>
                                                <span>Rp {{ number_format((int)($data->Harga ?? 0), 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-2 flex-wrap justify-end">
                                    @if($lamaranDiterima)
                                    {{-- Tombol Publish hanya muncul jika sudah ada lamaran diterima --}}
                                    <form action="{{ route('penyelenggara.publishEvent', $data->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl text-sm transition">
                                            Publish
                                        </button>
                                    </form>
                                    @endif
                                    <a href="{{ route('penyelenggara.editEvent', $data->id) }}"
                                        class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-xl text-sm transition">
                                        Edit
                                    </a>
                                    <button onclick="openDeleteModal('{{ $data->id }}')"
                                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl text-sm transition">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Section Pelamar Pembicara per Event --}}
                        @if($lamaranEvent->isNotEmpty())
                        <div class="border-t border-slate-100 bg-slate-50 px-6 py-4">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Pelamar Pembicara</p>
                            <div class="space-y-2">
                                @foreach($lamaranEvent as $lmr)
                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 bg-white rounded-lg px-4 py-3 border border-slate-100">
                                    <div>
                                        <p class="font-semibold text-slate-800 text-sm">{{ $lmr->nama_pembicara }}</p>
                                        <p class="text-xs text-slate-500">{{ $lmr->bidang_keahlian }} · {{ $lmr->email_pembicara }}</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @if($lmr->status === 'pending')
                                        <form action="{{ route('penyelenggara.terimaLamaran', $lmr->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-teal-700 hover:bg-teal-600 text-white rounded-lg text-xs font-semibold transition">
                                                Terima
                                            </button>
                                        </form>
                                        <form action="{{ route('penyelenggara.tolakLamaran', $lmr->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs font-semibold transition">
                                                Tolak
                                            </button>
                                        </form>
                                        @elseif($lmr->status === 'diterima')
                                        <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full font-semibold">✅ Diterima</span>
                                        @else
                                        <span class="text-xs bg-red-100 text-red-600 px-3 py-1 rounded-full font-semibold">❌ Ditolak</span>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-12 bg-white rounded-xl border border-dashed border-slate-300">
                        <span class="material-symbols-outlined text-5xl text-slate-300 block mb-2">check_circle</span>
                        <p class="text-slate-500">Tidak ada event draft. Semua event sudah punya pemateri!</p>
                    </div>
                    @endforelse
                </div>

                <!-- Financial Section -->
                <section class="max-w-6xl mx-auto mt-16" id="financial" style="scroll-margin-top: 100px;">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">Financial</h2>
                    </div>

                    @if(session('success_tarik'))
                    <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-xl">
                        <p class="font-bold">Berhasil!</p>
                        <p class="text-sm">{{ session('success_tarik') }}</p>
                    </div>
                    @endif

                    @if(session('error_tarik'))
                    <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-xl">
                        <p class="font-bold">Gagal!</p>
                        <p class="text-sm">{{ session('error_tarik') }}</p>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-gradient-to-br from-teal-600 to-primary p-8 rounded-xl text-white col-span-1 md:col-span-2">
                            <p class="text-teal-200 text-xs font-bold uppercase tracking-widest mb-1">Total Pendapatan</p>
                            <h3 class="text-4xl font-black tracking-tight mb-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                            <p class="text-teal-200 text-sm">Dari seluruh peserta event kamu</p>
                        </div>
                        <div class="bg-white border border-slate-100 rounded-xl p-8 shadow-sm flex flex-col justify-between">
                            <div>
                                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Saldo Tersedia</p>
                                <h3 class="text-4xl font-black tracking-tight text-slate-900">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                            </div>
                            <button onclick="openTarikModal()"
                                class="mt-6 w-full py-3 bg-primary text-white font-bold rounded-xl hover:opacity-90 transition text-sm">
                                Tarik Tunai
                            </button>
                        </div>
                    </div>

                    {{-- Tabel per event --}}
                    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100">
                            <h3 class="font-bold text-slate-800">Rincian per Event</h3>
                        </div>
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                                <tr>
                                    <th class="px-6 py-3 text-left">Event</th>
                                    <th class="px-6 py-3 text-left">Harga Tiket</th>
                                    <th class="px-6 py-3 text-left">Peserta</th>
                                    <th class="px-6 py-3 text-left">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($eventsPublished as $ev)
                                @php
                                $jumlahPeserta = DB::table('peserta')->where('id_event', $ev->id)->count();
                                $totalEv = $jumlahPeserta * $ev->Harga;
                                @endphp
                                <tr class="hover:bg-slate-50 transition cursor-pointer" onclick="openPesertaModal({{ $ev->id }}, '{{ $ev->Nama_Event }}')">
                                    <td class="px-6 py-4 font-medium text-slate-800 hover:text-teal-700 hover:underline">{{ $ev->Nama_Event }}</td>
                                    <td class="px-6 py-4 text-slate-500">Rp {{ number_format($ev->Harga, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-slate-500">{{ $jumlahPeserta }} orang</td>
                                    <td class="px-6 py-4 font-bold text-teal-700">Rp {{ number_format($totalEv, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- Grafik 2 kolom --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                        {{-- Grafik Pendapatan Per Bulan --}}
                        <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-6">
                            <h3 class="font-bold text-slate-800 mb-4">Pendapatan per Bulan</h3>
                            <canvas id="chartPendapatan" height="200"></canvas>
                        </div>

                        {{-- Grafik Peserta Per Event --}}
                        <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-6">
                            <h3 class="font-bold text-slate-800 mb-4">Peserta per Event</h3>
                            <canvas id="chartPeserta" height="200"></canvas>
                        </div>

                    </div>
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

    <!-- Modal Hapus Event (Laravel standard Form) -->
    <div id="deleteModal" class="fixed inset-0 bg-black/40 hidden z-50 items-center justify-center p-4">
        <div class="bg-white p-6 rounded-xl w-80 text-center shadow-lg">
            <h2 class="text-lg font-bold mb-2 text-red-600">Hapus Event</h2>
            <p class="text-sm text-slate-600 mb-6">Anda yakin mau menghapus event ini?</p>

            <!-- Hidden Form untuk Trigger DELETE di Route Laravel -->
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="flex justify-center gap-4">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-200 rounded-lg text-sm font-medium text-slate-700">Tidak</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700">Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tarik Tunai -->
    <div id="tarikModal" class="fixed inset-0 bg-black/40 hidden z-50 items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-md shadow-xl p-8">
            <h2 class="text-xl font-extrabold text-slate-900 mb-1">Tarik Tunai</h2>
            <p class="text-sm text-slate-500 mb-6">Saldo tersedia: <span class="font-bold text-teal-700">Rp {{ number_format($saldo, 0, ',', '.') }}</span></p>

            <form action="{{ route('penyelenggara.tarikSaldo') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Metode --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Metode Tarik Tunai</label>
                    <div class="flex gap-3">
                        <button type="button" onclick="setMetode('E-Wallet')"
                            id="btn-ewallet"
                            class="flex-1 py-2 rounded-xl border-2 border-slate-200 text-sm font-semibold text-slate-600 hover:border-teal-500 hover:text-teal-600 transition">
                            E-Wallet
                        </button>
                        <button type="button" onclick="setMetode('Transfer Bank')"
                            id="btn-bank"
                            class="flex-1 py-2 rounded-xl border-2 border-slate-200 text-sm font-semibold text-slate-600 hover:border-teal-500 hover:text-teal-600 transition">
                            Transfer Bank
                        </button>
                    </div>
                    <input type="hidden" name="metode" id="input-metode">
                </div>

                {{-- Tujuan --}}
                <div id="section-tujuan" class="hidden">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tujuan</label>
                    <div id="options-tujuan" class="grid grid-cols-3 gap-2"></div>
                    <input type="hidden" name="tujuan" id="input-tujuan">
                </div>

                {{-- Nomor --}}
                <div id="section-nomor" class="hidden">
                    <label class="block text-sm font-bold text-slate-700 mb-2" id="label-nomor">Nomor HP / Rekening</label>
                    <input type="text" name="nomor_tujuan" id="input-nomor"
                        placeholder="Masukkan nomor HP/rekening"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400">
                </div>

                {{-- Password --}}
                <div id="section-password" class="hidden">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Password Akun</label>
                    <input type="password" name="password"
                        placeholder="Masukkan password akun kamu"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400">
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="closeTarikModal()"
                        class="flex-1 py-3 rounded-xl border border-slate-200 text-slate-600 font-semibold text-sm hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 py-3 rounded-xl bg-primary text-white font-bold text-sm hover:opacity-90 transition">
                        Lanjutkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Peserta -->
    <div id="pesertaModal"
        class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center">

        <div class="bg-white rounded-3xl overflow-hidden shadow-2xl w-full max-w-4xl">

            <!-- HEADER -->
            <div class="bg-teal-900 text-white px-8 py-6 relative">

                <button onclick="closePesertaModal()"
                    class="absolute top-4 right-5 text-white text-4xl opacity-70 hover:opacity-100">
                    ×
                </button>

                <div class="uppercase text-sm tracking-widest font-semibold">
                    EVENTSPEAK • E-TICKET
                </div>

                <h2 id="pesertaModalTitle"
                    class="text-4xl font-bold mt-2">
                    Nama Event
                </h2>

                <span
                    class="inline-block mt-3 px-4 py-1 rounded-full bg-white/20 text-sm">
                    webinar
                </span>
            </div>

            <!-- BODY -->
            <div class="p-6">

                <div class="flex justify-end mb-4">

                    <button
                        onclick="exportPesertaExcel()"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                        Export Excel
                    </button>

                </div>

                <div id="pesertaModalContent"></div>

            </div>

        </div>

    </div>

    <!-- JavaScript Actions -->
    <script>
        const ewalletOptions = ['Dana', 'ShopeePay', 'GoPay'];
        const bankOptions = ['BNI', 'BRI', 'Mandiri', 'BCA'];

        function setMetode(metode) {
            document.getElementById('input-metode').value = metode;
            document.getElementById('input-tujuan').value = '';
            document.getElementById('section-nomor').classList.add('hidden');
            document.getElementById('section-password').classList.add('hidden');

            const options = metode === 'E-Wallet' ? ewalletOptions : bankOptions;
            const label = metode === 'E-Wallet' ? 'Nomor HP' : 'Nomor Rekening';
            document.getElementById('label-nomor').textContent = label;

            const container = document.getElementById('options-tujuan');
            container.innerHTML = '';
            options.forEach(opt => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.textContent = opt;
                btn.className = 'py-2 rounded-xl border-2 border-slate-200 text-sm font-semibold text-slate-600 hover:border-teal-500 hover:text-teal-600 transition';
                btn.onclick = () => setTujuan(opt, btn);
                container.appendChild(btn);
            });

            document.getElementById('section-tujuan').classList.remove('hidden');

            // Highlight active metode button
            document.getElementById('btn-ewallet').className = 'flex-1 py-2 rounded-xl border-2 border-slate-200 text-sm font-semibold text-slate-600 hover:border-teal-500 transition';
            document.getElementById('btn-bank').className = 'flex-1 py-2 rounded-xl border-2 border-slate-200 text-sm font-semibold text-slate-600 hover:border-teal-500 transition';
            const activeBtn = metode === 'E-Wallet' ? 'btn-ewallet' : 'btn-bank';
            document.getElementById(activeBtn).className = 'flex-1 py-2 rounded-xl border-2 border-teal-500 text-sm font-semibold text-teal-600 transition';
        }

        function setTujuan(tujuan, btn) {
            document.getElementById('input-tujuan').value = tujuan;
            document.querySelectorAll('#options-tujuan button').forEach(b => {
                b.className = 'py-2 rounded-xl border-2 border-slate-200 text-sm font-semibold text-slate-600 hover:border-teal-500 transition';
            });
            btn.className = 'py-2 rounded-xl border-2 border-teal-500 text-sm font-semibold text-teal-600 transition';
            document.getElementById('section-nomor').classList.remove('hidden');
            document.getElementById('section-password').classList.remove('hidden');
        }

        function openTarikModal() {
            document.getElementById('tarikModal').classList.remove('hidden');
            document.getElementById('tarikModal').classList.add('flex');
        }

        function closeTarikModal() {
            document.getElementById('tarikModal').classList.add('hidden');
            document.getElementById('tarikModal').classList.remove('flex');
        }

        function showTab(tab) {
            document.getElementById('panel-published').classList.add('hidden');
            document.getElementById('panel-draft').classList.add('hidden');

            document.getElementById('tab-published').className = 'px-5 py-2 rounded-full text-sm font-bold bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 transition';
            document.getElementById('tab-draft').className = 'px-5 py-2 rounded-full text-sm font-bold bg-white border border-slate-200 text-slate-600 hover:bg-teal-50 hover:border-teal-300 transition';

            document.getElementById('panel-' + tab).classList.remove('hidden');

            if (tab === 'published') {
                document.getElementById('tab-published').className = 'px-5 py-2 rounded-full text-sm font-bold bg-primary text-white transition';
            } else {
                document.getElementById('tab-draft').className = 'px-5 py-2 rounded-full text-sm font-bold bg-teal-500 text-white transition';
            }
        }

        function openModal() {
            const modal = document.getElementById("logoutModal");
            const box = document.getElementById("modalBox");
            modal.classList.remove("hidden");
            modal.classList.add("flex");
            setTimeout(() => {
                box.classList.remove("scale-95", "opacity-0");
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById("logoutModal");
            const box = document.getElementById("modalBox");
            box.classList.add("scale-95", "opacity-0");
            setTimeout(() => {
                modal.classList.add("hidden");
                modal.classList.remove("flex");
            }, 200);
        }

        function openDeleteModal(id) {
            // Membuat URL dinamis sesuai konfigurasi route `penyelenggara.deleteEvent`
            const actionUrl = `/penyelenggara/event/${id}/delete`;
            document.getElementById("deleteForm").setAttribute("action", actionUrl);
            document.getElementById("deleteModal").classList.remove("hidden");
            document.getElementById("deleteModal").classList.add("flex");
        }

        function closeDeleteModal() {
            document.getElementById("deleteModal").classList.add("hidden");
            document.getElementById("deleteModal").classList.remove("flex");
        }
        // Data dari Laravel
        const pendapatanLabels = @json($pendapatanPerBulan -> pluck('bulan'));
        const pendapatanData = @json($pendapatanPerBulan -> pluck('total'));

        const pesertaLabels = @json($pesertaPerEvent -> pluck('Nama_Event'));
        const pesertaData = @json($pesertaPerEvent -> pluck('total_peserta'));

        // Grafik 1 - Pendapatan per Bulan
        new Chart(document.getElementById('chartPendapatan'), {
            type: 'bar',
            data: {
                labels: pendapatanLabels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: pendapatanData,
                    backgroundColor: 'rgba(0, 66, 83, 0.8)',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => 'Rp ' + ctx.raw.toLocaleString('id-ID')
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: val => 'Rp ' + val.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });

        // Grafik 2 - Peserta per Event
        new Chart(document.getElementById('chartPeserta'), {
            type: 'bar',
            data: {
                labels: pesertaLabels,
                datasets: [{
                    label: 'Jumlah Peserta',
                    data: pesertaData,
                    backgroundColor: 'rgba(20, 184, 166, 0.8)',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => ctx.raw + ' peserta'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        function openPesertaModal(eventId, eventNama) {

            window.currentEventId = eventId;
            window.currentEventNama = eventNama;

            document.getElementById('pesertaModalTitle').textContent = eventNama;

            document.getElementById('pesertaModalContent').innerHTML =
                '<div class="text-center text-slate-400 py-8">Memuat data...</div>';

            document.getElementById('pesertaModal').classList.remove('hidden');
            document.getElementById('pesertaModal').classList.add('flex');

            fetch('/penyelenggara/peserta/' + eventId)
                .then(res => res.json())
                .then(data => {

                    if (data.length === 0) {
                        document.getElementById('pesertaModalContent').innerHTML =
                            '<div class="text-center text-slate-400 py-8">Belum ada peserta yang mendaftar.</div>';
                        return;
                    }

                    let html =
                        `<table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-left">#</th>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">No WA</th>
                            <th class="px-4 py-3 text-left">Metode Bayar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">`;

                    data.forEach((p, i) => {

                        html += `
                    <tr>
                        <td class="px-4 py-3">${i + 1}</td>
                        <td class="px-4 py-3">${p.nama_user}</td>
                        <td class="px-4 py-3">${p.no_wa}</td>
                        <td class="px-4 py-3">${p.metode_bayar}</td>
                    </tr>
                `;
                    });

                    html += `
                    </tbody>
                </table>`;

                    document.getElementById('pesertaModalContent').innerHTML = html;
                });
        }

        function closePesertaModal() {
            document.getElementById('pesertaModal').classList.add('hidden');
            document.getElementById('pesertaModal').classList.remove('flex');
        }

        function exportPesertaExcel() {

            if (!window.currentEventId) {
                alert('Event tidak ditemukan');
                return;
            }

            window.location.href =
                '/penyelenggara/export-peserta/' +
                window.currentEventId;
        }
    </script>
</body>

</html>