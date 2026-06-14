<!DOCTYPE html>
<html class="light" lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>EventSpeak - Schedule</title>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }

    body {
      font-family: 'Inter', sans-serif;
    }

    h1,
    h2,
    h3 {
      font-family: 'Manrope', sans-serif;
    }

    #calendarGrid .cal-cell {
      min-height: 56px;
      border: 1px solid #f1f5f9;
      padding: 4px;
      position: relative;
    }

    #calendarGrid .cal-cell .day-num {
      width: 28px;
      height: 28px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 12px;
      transition: background 0.15s;
    }

    #calendarGrid .cal-cell .event-dot {
      font-size: 9px;
      margin-top: 4px;
      color: #004253;
      font-weight: 600;
      line-height: 1.2;
      max-width: 100%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .event-pill {
      font-size: 9px;
      margin-top: 3px;
      padding: 2px 5px;
      border-radius: 4px;
      font-weight: 600;
      display: block;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .pill-peserta {
      background: #e0f2fe;
      color: #0369a1;
    }

    .pill-organizer {
      background: #d1fae5;
      color: #065f46;
    }

    .pill-speaker {
      background: #ede9fe;
      color: #6d28d9;
    }
  </style>
</head>

<body class="bg-background text-on-surface font-body">

  {{-- TOP NAVBAR --}}
  <nav class="fixed top-0 w-full z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md shadow-[0px_20px_40px_rgba(25,28,30,0.06)] h-20">
    <div class="flex justify-between items-center px-4 md:px-8 h-full max-w-full mx-auto">
      <div class="flex items-center gap-3 md:gap-12">
        <span class="text-2xl font-black text-teal-900 dark:text-teal-100 font-headline tracking-tight">EventSpeak</span>
        <div class="hidden md:flex gap-8 items-center">
          <a class="font-manrope text-slate-600 hover:text-teal-600 tracking-tight transition-colors" href="/">Browse</a>
          <a class="font-manrope text-slate-600 hover:text-teal-600 tracking-tight transition-colors" href="/eksplorasi">Event</a>
          <a class="text-teal-700 border-b-2 border-teal-700 pb-1 font-headline font-semibold tracking-tight" href="/schedule">Schedule</a>
          <a class="font-manrope text-slate-600 hover:text-teal-600 tracking-tight transition-colors" href="/pembicara/daftar">Become a Speaker</a>
          <a class="font-manrope text-slate-600 hover:text-teal-600 tracking-tight transition-colors" href="/team">Team</a>
        </div>
      </div>
      <div class="flex items-center gap-3 md:gap-4">
        @if(session()->has('user_id'))
        <div class="flex items-center gap-3">
          <div class="relative" id="notifWrapper">
            <button onclick="toggleNotif()" class="relative w-10 h-10 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center transition">
              <span class="material-symbols-outlined text-slate-600 text-xl">notifications</span>
              @if(count($notifikasi) > 0)
              <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center">
                {{ count($notifikasi) > 9 ? '9+' : count($notifikasi) }}
              </span>
              @endif
            </button>
            <div id="notifPopup" class="hidden absolute right-0 top-12 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 z-50 overflow-hidden">
              <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 text-sm">Notifikasi</h3>
                <span class="text-xs text-slate-400">{{ count($notifikasi) }} pesan</span>
              </div>
              <div class="max-h-80 overflow-y-auto divide-y divide-slate-50">
                @forelse($notifikasi as $notif)
                <div class="flex items-start gap-3 px-4 py-3 hover:bg-slate-50 transition">
                  <span class="material-symbols-outlined {{ $notif['color'] }} text-xl mt-0.5">{{ $notif['icon'] }}</span>
                  <div class="flex-1">
                    <p class="text-xs text-slate-700 leading-relaxed">{!! $notif['pesan'] !!}</p>
                    @if($notif['waktu'])
                    <p class="text-[10px] text-slate-400 mt-1">{{ \Carbon\Carbon::parse($notif['waktu'])->diffForHumans() }}</p>
                    @endif
                  </div>
                </div>
                @empty
                <div class="px-4 py-8 text-center text-slate-400 text-sm">Tidak ada notifikasi</div>
                @endforelse
              </div>
            </div>
          </div>
          <a href="{{ route('pengguna.profil') }}" class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white shadow-md overflow-hidden hover:scale-105 transition-transform">
            @if($user && $user->foto_profil)
            <img src="{{ asset('uploads/profil/' . $user->foto_profil) }}" class="w-full h-full object-cover">
            @else
            <i class="fa-solid fa-user text-sm"></i>
            @endif
          </a>
        </div>
        @else
        <div class="flex items-center gap-4">
          <a href="{{ route('login') }}" class="text-sm font-bold text-primary">Login</a>
          <a href="#" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-bold">Daftar</a>
        </div>
        @endif
      </div>
    </div>
  </nav>

  {{-- MAIN --}}
  <main class="pt-28 pb-16 px-4 md:px-8 w-full min-h-screen max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="mb-10">
      <h1 class="font-headline text-4xl font-extrabold tracking-tight text-primary mb-2">Jadwal Event Kamu</h1>
      <p class="text-slate-500 text-lg">
        Event yang kamu ikuti, selenggarakan, dan event tempat kamu menjadi pembicara.
      </p>
    </div>

    @if(!session()->has('user_id'))
    <div class="flex flex-col items-center justify-center py-32 text-center">
      <span class="material-symbols-outlined text-6xl text-slate-300 mb-4">lock</span>
      <h2 class="font-headline font-bold text-xl text-slate-600 mb-2">Kamu belum login</h2>
      <p class="text-slate-400 text-sm mb-6">Login dulu untuk melihat jadwal event yang kamu ikuti.</p>
      <a href="{{ route('login') }}" class="px-6 py-3 bg-primary text-white font-bold rounded-xl hover:opacity-90 transition shadow-lg">Login Sekarang</a>
    </div>

    @elseif(
    $schedules->isEmpty()
    && $eventDiselenggarakan->isEmpty()
    && $eventSebagaiPembicara->isEmpty()
    )
    <div class="flex flex-col items-center justify-center py-32 text-center">
      <span class="material-symbols-outlined text-6xl text-slate-300 mb-4">event_busy</span>
      <h2 class="font-headline font-bold text-xl text-slate-600 mb-2">Belum ada event terdaftar</h2>
      <p class="text-slate-400 text-sm mb-6">Yuk, mulai ikuti event dan tambahkan ke jadwalmu!</p>
      <a href="{{ route('pengguna.eksplorasi') }}" class="px-6 py-3 bg-primary text-white font-bold rounded-xl hover:opacity-90 transition shadow-lg">Eksplorasi Event</a>
    </div>

    @else

    {{-- ===== KALENDER BESAR ===== --}}
    @php

    $eventDiikutiByDate = [];
    foreach ($schedules as $s) {
    $key = \Carbon\Carbon::parse($s->Tanggal)->format('Y-m-d');
    $eventDiikutiByDate[$key][] = $s->Nama_Event;
    }

    $eventOrganizedByDate = [];
    foreach ($eventDiselenggarakan as $e) {
    $key = \Carbon\Carbon::parse($e->Tanggal)->format('Y-m-d');
    $eventOrganizedByDate[$key][] = $e->Nama_Event;
    }

    $eventSpeakerByDate = [];
    foreach ($eventSebagaiPembicara as $e) {
    $key = \Carbon\Carbon::parse($e->Tanggal)->format('Y-m-d');
    $eventSpeakerByDate[$key][] = $e->Nama_Event;
    }

    $today = \Carbon\Carbon::today();

    @endphp

    <div class="mb-12 bg-white rounded-3xl shadow-sm border border-slate-100 p-8 w-full">

      {{-- Header --}}
      <div class="flex items-center justify-between mb-8">
        <div>
          <h2 class="font-headline font-extrabold text-3xl text-primary" id="calendarTitle"></h2>
          <p class="text-slate-400 text-sm mt-1">Tanggal bertanda adalah jadwal event kamu</p>
        </div>
        <div class="flex items-center gap-2">
          <button onclick="changeMonth(-1)" class="w-11 h-11 rounded-xl hover:bg-slate-100 border border-slate-200 flex items-center justify-center transition">
            <span class="material-symbols-outlined text-slate-500">chevron_left</span>
          </button>
          <button onclick="changeMonth(1)" class="w-11 h-11 rounded-xl hover:bg-slate-100 border border-slate-200 flex items-center justify-center transition">
            <span class="material-symbols-outlined text-slate-500">chevron_right</span>
          </button>
        </div>
      </div>

      {{-- Nama Hari --}}
      <div class="grid grid-cols-7 pb-3 mb-1 border-b border-slate-100">
        @foreach(['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
        <div class="text-center text-xs font-bold text-slate-400 uppercase tracking-wider py-2">{{ $hari }}</div>
        @endforeach
      </div>

      {{-- Grid Tanggal --}}
      <div class="grid grid-cols-7" id="calendarGrid"></div>

      {{-- Legend --}}
      <div class="flex flex-wrap items-center gap-6 mt-6 pt-5 border-t border-slate-100">
        <div class="flex items-center gap-2">
          <div class="w-9 h-9 rounded-xl bg-yellow-400 flex items-center justify-center shadow-sm">
            <span class="text-yellow-900 text-sm font-black"></span>
          </div>
          <span class="text-sm text-slate-500">Hari Ini</span>
        </div>
        <div class="flex items-center gap-2">
          <span class="event-pill pill-peserta">Event</span>
          <span class="text-sm text-slate-500">Diikuti</span>
        </div>

        <div class="flex items-center gap-2">
          <span class="event-pill pill-organizer">Event</span>
          <span class="text-sm text-slate-500">Diselenggarakan</span>
        </div>

        <div class="flex items-center gap-2">
          <span class="event-pill pill-speaker">Event</span>
          <span class="text-sm text-slate-500">Sebagai Pembicara</span>
        </div>
      </div>
    </div>

    {{-- ===== GRID KARTU SCHEDULE ===== --}}
    <h2 class="font-headline font-bold text-xl text-primary mb-6">Event Terdaftar</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
      @foreach($schedules as $schedule)
      @php
      $tgl = \Carbon\Carbon::parse($schedule->Tanggal);
      $isUpcoming = $tgl->isFuture();
      $isToday = $tgl->isToday();
      @endphp

      <div class="flex flex-col bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100 max-w-sm">
        <div class="relative bg-primary px-4 pt-4 pb-5">
          <div class="absolute top-4 right-4">
            @if($isToday)
            <span class="bg-yellow-400 text-yellow-900 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">Hari Ini</span>
            @elseif($isUpcoming)
            <span class="bg-white/20 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">Upcoming</span>
            @else
            <span class="bg-slate-500/30 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">Selesai</span>
            @endif
          </div>
          <div class="flex items-end gap-3">
            <span class="text-4xl font-black text-white leading-none">{{ $tgl->format('d') }}</span>
            <div class="pb-1">
              <p class="text-white/70 text-xs font-semibold uppercase tracking-widest">{{ $tgl->translatedFormat('F') }}</p>
              <p class="text-white/70 text-xs font-semibold">{{ $tgl->format('Y') }}</p>
            </div>
          </div>
          <div class="mt-4">
            <span class="bg-white/10 text-white/80 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">{{ $schedule->Jenis_Event }}</span>
          </div>
        </div>

        <div class="px-4 py-3 flex flex-col flex-1 gap-2">
          <h3 class="font-headline font-bold text-slate-800 text-xs leading-snug group-hover:text-primary transition-colors line-clamp-2">
            {{ $schedule->Nama_Event }}
          </h3>
          <div class="flex items-center gap-2 text-slate-400">
            <span class="material-symbols-outlined text-sm">mic</span>
            <p class="text-[11px] font-medium truncate">{{ $schedule->Pemateri ?? 'Belum ada pembicara' }}</p>
          </div>
          <div class="flex items-center gap-2 text-slate-400">
            <span class="material-symbols-outlined text-sm">location_on</span>
            <p class="text-[11px] font-medium truncate">{{ $schedule->Lokasi ?? '-' }}</p>
          </div>
          <div class="flex items-center gap-2 text-slate-400">
            <span class="material-symbols-outlined text-sm">confirmation_number</span>
            <p class="text-[11px] font-medium">{{ $schedule->nomor_tiket }}</p>
          </div>
          <div class="border-t border-slate-50 mt-auto pt-3 flex items-center justify-between">
            <div class="flex flex-col">
              <span class="text-[8px] text-slate-400 uppercase font-bold tracking-tighter">Harga</span>
              <span class="text-primary font-black text-sm leading-none">
                {{ (!$schedule->Harga || $schedule->Harga == 0) ? 'FREE' : 'Rp ' . number_format($schedule->Harga, 0, ',', '.') }}
              </span>
            </div>
            <a href="{{ route('tiket.show', $schedule->id_peserta ?? 0) }}"
              class="inline-flex items-center gap-1.5 px-3 py-1 bg-primary text-white rounded-lg font-bold text-[10px] hover:bg-slate-800 transition-all active:scale-95 shadow-lg shadow-primary/10 uppercase tracking-widest">
              <span class="material-symbols-outlined text-sm">confirmation_number</span>
              Tiket
            </a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @if($eventDiselenggarakan->count())

    <h2 class="font-headline font-bold text-xl text-primary mt-14 mb-6 flex items-center gap-2">
      <span class="material-symbols-outlined text-teal-500">business</span>
      Event Diselenggarakan
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">

      @foreach($eventDiselenggarakan as $ev)
      @php
      $tgl = \Carbon\Carbon::parse($ev->Tanggal);
      $isUpcoming = $tgl->isFuture();
      $isToday = $tgl->isToday();
      @endphp

      <div class="flex flex-col bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100 max-w-sm">
        <div class="relative bg-teal-700 px-4 pt-4 pb-5">
          <div class="absolute top-4 right-4">
            @if($isToday)
            <span class="bg-yellow-400 text-yellow-900 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">Hari Ini</span>
            @elseif($isUpcoming)
            <span class="bg-white/20 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">Upcoming</span>
            @else
            <span class="bg-slate-500/30 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">Selesai</span>
            @endif
          </div>
          <div class="flex items-end gap-3">
            <span class="text-4xl font-black text-white leading-none">{{ $tgl->format('d') }}</span>
            <div class="pb-1">
              <p class="text-white/70 text-xs font-semibold uppercase tracking-widest">{{ $tgl->translatedFormat('F') }}</p>
              <p class="text-white/70 text-xs font-semibold">{{ $tgl->format('Y') }}</p>
            </div>
          </div>
          <div class="mt-4">
            <span class="bg-white/10 text-white/80 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">{{ $ev->Jenis_Event }}</span>
          </div>
        </div>

        <div class="px-4 py-3 flex flex-col flex-1 gap-2">
          <h3 class="font-headline font-bold text-slate-800 text-xs leading-snug line-clamp-2">
            {{ $ev->Nama_Event }}
          </h3>
          <div class="flex items-center gap-2 text-slate-400">
            <span class="material-symbols-outlined text-sm">mic</span>
            <p class="text-[11px] font-medium truncate">{{ $ev->Pemateri ?? 'Belum ada pembicara' }}</p>
          </div>
          <div class="flex items-center gap-2 text-slate-400">
            <span class="material-symbols-outlined text-sm">location_on</span>
            <p class="text-[11px] font-medium truncate">{{ $ev->Lokasi ?? '-' }}</p>
          </div>
          <div class="border-t border-slate-50 mt-auto pt-3 flex items-center justify-between">
            <div class="flex flex-col">
              <span class="text-[8px] text-slate-400 uppercase font-bold tracking-tighter">Harga</span>
              <span class="text-teal-700 font-black text-sm leading-none">
                {{ (!$ev->Harga || $ev->Harga == 0) ? 'FREE' : 'Rp ' . number_format($ev->Harga, 0, ',', '.') }}
              </span>
            </div>
            <a href="{{ route('event.show', $ev->id) }}"
              class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-700 text-white rounded-lg font-bold text-[10px] hover:bg-emerald-800 transition-all active:scale-95 shadow-lg shadow-emerald-700/10 uppercase tracking-widest">
              <span class="material-symbols-outlined text-sm">visibility</span>
              Lihat
            </a>
          </div>
        </div>
      </div>
      @endforeach

    </div>

    @endif
    @if($eventSebagaiPembicara->count())

    <h2 class="font-headline font-bold text-xl text-primary mt-14 mb-6 flex items-center gap-2">
      <span class="material-symbols-outlined text-tertiary">record_voice_over</span>
      Event Sebagai Pembicara
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">

      @foreach($eventSebagaiPembicara as $ev)
      @php
      $tgl = \Carbon\Carbon::parse($ev->Tanggal);
      $isUpcoming = $tgl->isFuture();
      $isToday = $tgl->isToday();
      @endphp

      <div class="flex flex-col bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-100 max-w-sm">
        <div class="relative bg-tertiary px-4 pt-4 pb-5">
          <div class="absolute top-4 right-4">
            @if($isToday)
            <span class="bg-yellow-400 text-yellow-900 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">Hari Ini</span>
            @elseif($isUpcoming)
            <span class="bg-white/20 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">Upcoming</span>
            @else
            <span class="bg-slate-500/30 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">Selesai</span>
            @endif
          </div>
          <div class="flex items-end gap-3">
            <span class="text-4xl font-black text-white leading-none">{{ $tgl->format('d') }}</span>
            <div class="pb-1">
              <p class="text-white/70 text-xs font-semibold uppercase tracking-widest">{{ $tgl->translatedFormat('F') }}</p>
              <p class="text-white/70 text-xs font-semibold">{{ $tgl->format('Y') }}</p>
            </div>
          </div>
          <div class="mt-4">
            <span class="bg-white/10 text-white/80 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">{{ $ev->Jenis_Event }}</span>
          </div>
        </div>

        <div class="px-4 py-3 flex flex-col flex-1 gap-2">
          <h3 class="font-headline font-bold text-slate-800 text-xs leading-snug line-clamp-2">
            {{ $ev->Nama_Event }}
          </h3>
          <div class="flex items-center gap-2 text-slate-400">
            <span class="material-symbols-outlined text-sm">mic</span>
            <p class="text-[11px] font-medium truncate">Pembicara</p>
          </div>
          <div class="flex items-center gap-2 text-slate-400">
            <span class="material-symbols-outlined text-sm">location_on</span>
            <p class="text-[11px] font-medium truncate">{{ $ev->Lokasi ?? '-' }}</p>
          </div>
          <div class="border-t border-slate-50 mt-auto pt-3 flex items-center justify-between">
            <div class="flex flex-col">
              <span class="text-[8px] text-slate-400 uppercase font-bold tracking-tighter">Harga</span>
              <span class="text-tertiary font-black text-sm leading-none">
                {{ (!$ev->Harga || $ev->Harga == 0) ? 'FREE' : 'Rp ' . number_format($ev->Harga, 0, ',', '.') }}
              </span>
            </div>
            <a href="{{ route('event.show', $ev->id) }}"
              class="inline-flex items-center gap-1.5 px-3 py-1 bg-tertiary text-white rounded-lg font-bold text-[10px] hover:opacity-90 transition-all active:scale-95 shadow-lg shadow-tertiary/10 uppercase tracking-widest">
              <span class="material-symbols-outlined text-sm">visibility</span>
              Lihat
            </a>
          </div>
        </div>
      </div>
      @endforeach

    </div>

    @endif
    @endif

  </main>

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

  <script>
    const eventDiikutiByDate = @json($eventDiikutiByDate);
    const eventOrganizedByDate = @json($eventOrganizedByDate);
    const eventSpeakerByDate = @json($eventSpeakerByDate);
    const todayStr = '{{ $today->format("Y-m-d") }}';

    let currentYear = @json($today -> year);
    let currentMonth = @json($today -> month - 1);

    const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    function renderCalendar() {
      document.getElementById('calendarTitle').textContent = monthNames[currentMonth] + ' ' + currentYear;
      const grid = document.getElementById('calendarGrid');
      grid.innerHTML = '';

      const firstDay = new Date(currentYear, currentMonth, 1).getDay();
      const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

      for (let i = 0; i < firstDay; i++) {
        grid.innerHTML += `<div class="cal-cell border border-slate-50"></div>`;
      }

      for (let d = 1; d <= daysInMonth; d++) {
        const dateStr = currentYear + '-' + String(currentMonth + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
        const isToday = dateStr === todayStr;
        const diikuti = eventDiikutiByDate[dateStr] || [];
        const organized = eventOrganizedByDate[dateStr] || [];
        const speaker = eventSpeakerByDate[dateStr] || [];

        const hasEvent =
          diikuti.length > 0 ||
          organized.length > 0 ||
          speaker.length > 0;

        let numCls = 'day-num ';
        if (isToday && hasEvent) numCls += 'bg-teal-500 border-2 border-yellow-400 text-white';
        else if (isToday) numCls += 'bg-yellow-400 text-yellow-900';
        else if (hasEvent) numCls += 'bg-primary text-white';
        else numCls += 'text-slate-600 hover:bg-slate-100 cursor-default';

        let eventsHtml = '';

        diikuti.forEach(name => {
          eventsHtml += `<span class="event-pill pill-peserta">${name}</span>`;
        });

        organized.forEach(name => {
          eventsHtml += `<span class="event-pill pill-organizer">${name}</span>`;
        });

        speaker.forEach(name => {
          eventsHtml += `<span class="event-pill pill-speaker">${name}</span>`;
        });

        grid.innerHTML += `
          <div class="cal-cell">
            <div class="${numCls}">${d}</div>
            ${eventsHtml}
          </div>`;
      }
    }

    function changeMonth(dir) {
      currentMonth += dir;
      if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
      }
      if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
      }
      renderCalendar();
    }

    renderCalendar();

    function toggleNotif() {
      document.getElementById('notifPopup').classList.toggle('hidden');
    }

    document.addEventListener('click', function(e) {
      const wrapper = document.getElementById('notifWrapper');
      if (wrapper && !wrapper.contains(e.target)) {
        document.getElementById('notifPopup').classList.add('hidden');
      }
    });
  </script>

</body>

</html>