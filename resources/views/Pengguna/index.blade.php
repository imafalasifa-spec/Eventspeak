<!DOCTYPE html>
<html class="light" lang="id">

<head>
  <title>EventSpeak</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
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
          borderRadius: {
            DEFAULT: "0.125rem",
            lg: "0.25rem",
            xl: "0.5rem",
            full: "0.75rem",
          },
          fontFamily: {
            headline: ["Manrope"],
            body: ["Inter"],
            label: ["Inter"],
          },
        },
      },
    };
  </script>
  <style>
    .material-symbols-outlined {
      font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
    }

    .material-symbols-outlined.fill-1 {
      font-variation-settings: "FILL" 1, "wght" 400, "GRAD" 0, "opsz" 24;
    }

    body {
      font-family: 'Inter', sans-serif;
    }

    h1,
    h2,
    h3 {
      font-family: 'Manrope', sans-serif;
    }

    borderRadius {
      full: "9999px",
    }
  </style>
</head>

<body class="bg-background text-on-surface font-body antialiased">

  {{-- TOP NAVBAR --}}
  <nav class="fixed top-0 w-full z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md shadow-[0px_20px_40px_rgba(25,28,30,0.06)] h-20">
    <div class="flex justify-between items-center px-4 md:px-8 h-full max-w-full mx-auto">
      <div class="flex items-center gap-3 md:gap-12">
        <span class="text-2xl font-black text-teal-900 dark:text-teal-100 font-headline tracking-tight">EventSpeak</span>
        <div class="hidden md:flex gap-8 items-center">
          <a class="text-teal-700 border-b-2 border-teal-700 pb-1 font-headline font-semibold tracking-tight" href="/">Browse</a>
          <a class="font-manrope text-slate-600 hover:text-teal-600 tracking-tight transition-colors" href="/eksplorasi">Event</a>
          <a class="font-manrope text-slate-600 hover:text-teal-600 tracking-tight transition-colors" href="/schedule">Schedule</a>
          <a class="font-manrope text-slate-600 hover:text-teal-600 tracking-tight transition-colors" href="/pembicara/daftar">Become a Speaker</a>
          <a class="font-manrope text-slate-600 hover:text-teal-600 tracking-tight transition-colors" href="/team">Team</a>
        </div>
      </div>
      <div class="flex items-center gap-3 md:gap-4">
        {{-- Cek apakah ada session user_id --}}
        @if(session()->has('user_id'))
        <div class="flex items-center gap-3">

          {{-- Ikon Notifikasi --}}
          <div class="relative" id="notifWrapper">
            <button onclick="toggleNotif()" class="relative w-10 h-10 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center transition">
              <span class="material-symbols-outlined text-slate-600 text-xl">notifications</span>
              @if(count($notifikasi) > 0)
              <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center">
                {{ count($notifikasi) > 9 ? '9+' : count($notifikasi) }}
              </span>
              @endif
            </button>

            {{-- Popup Notifikasi --}}
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
                <div class="px-4 py-8 text-center text-slate-400 text-sm">
                  Tidak ada notifikasi
                </div>
                @endforelse
              </div>
            </div>
          </div>


          {{-- Klik nama atau foto langsung ke halaman profil --}}
          <a href="{{ route('pengguna.profil') }}" class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white shadow-md overflow-hidden hover:scale-105 transition-transform">
            @if($user && $user->foto_profil)
            {{-- Path ke storage --}}
            <img src="{{ asset('uploads/profil/' . $user->foto_profil) }}" class="w-full h-full object-cover">
            @else
            <i class="fa-solid fa-user text-sm"></i>
            @endif
          </a>
        </div>
        @else
        {{-- Tampilan jika belum login --}}
        <div class="flex items-center gap-4">
          <a href="{{ route('login') }}" class="text-sm font-bold text-primary">Login</a>
          <a href="{{ route('pengguna.registrasi') }}" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-bold">Daftar</a>
        </div>
        @endif
      </div>
    </div>
  </nav>

  <main class="pt-20">

    {{-- HERO SECTION --}}
    <section class="relative overflow-hidden pt-16 md:pt-20 pb-10 md:pb-32 px-4 md:px-8">
      <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
        <div class="relative z-10 mb-8 lg:mb-0 order-2 lg:order-1">
          <h1 class="text-3xl sm:text-4xl md:text-6xl lg:text-7xl font-headline font-extrabold text-primary leading-tight tracking-tight mb-6 md:mb-8">
            Tingkatkan Skill Lewat
            <span class="text-tertiary">Event Terbaik</span>
          </h1>
          <p class="text-base sm:text-lg md:text-xl text-on-surface-variant max-w-md md:max-w-xl mb-6 md:mb-10 leading-relaxed">
            Temukan workshop, webinar, dan bootcamp yang dikurasi oleh para ahli di bidangnya.
          </p>
          {{-- Ganti auth()->check() menjadi session()->has('user_id') --}}
          <a href="{{ session()->has('user_id') ? '/eksplorasi' : '/login' }}"
            class="inline-flex w-fit px-6 md:px-8 py-2 md:py-4 text-sm md:text-lg bg-primary text-on-primary rounded-lg font-headline font-bold hover:opacity-90 transition-all items-center gap-2">
            Mulai Eksplorasi
            <span class="material-symbols-outlined">arrow_forward</span>
          </a>
        </div>
        <div class="relative order-1 lg:order-2">
          <div class="absolute -top-12 -left-12 w-64 h-64 bg-secondary-fixed/30 rounded-full blur-3xl"></div>
          <div class="relative rounded-2xl overflow-hidden shadow-2xl transform rotate-0 lg:rotate-2">
            <img alt="Live Workshop Scene" class="w-full h-[200px] sm:h-[300px] md:h-[500px] object-cover"
              src="https://lh3.googleusercontent.com/aida-public/AB6AXuADM6JWAR3AvTBr080eEX5ONiC3AolSKtvnwXzegWvAvGMjHBGASZQLtVI7G6uPFd-7qHRJwUbDfNCirZAuy7vHBs-F_ElrMk_l-HgymmqV3I9lFQcdoPiYyQFqAHRueSVacrEnpe1-GPEGf8vbmqyws4AImEMHiae8LS88r0Xt1CRQkcZvBBNb1-G9Zz_riXp7_1G9kWRykuxqkaGBP23nSoTx_zIEVvb2Y-PqsKp6w-P4R9YCQYgotd9hEjcsGHwR2U3CW2jopeAu">
            <div class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent"></div>
          </div>
        </div>
      </div>
    </section>

    {{-- KATEGORI SECTION --}}
    <section class="py-12 md:py-24 bg-surface-container-low">
      <div class="max-w-7xl mx-auto px-4 md:px-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-3 mb-6 md:mb-16">
          <div>
            <span class="text-tertiary font-headline font-bold uppercase tracking-[0.2em] text-sm">Pilih Fokusmu</span>
            <h2 class="text-4xl font-headline font-extrabold text-primary mt-2">Kategori Populer</h2>
          </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 md:gap-8">
          <div class="bg-surface-container-lowest p-10 rounded-2xl group hover:shadow-xl transition-all duration-300">
            <div class="w-16 h-16 bg-primary-container/10 rounded-xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
              <span class="material-symbols-outlined text-primary text-4xl">construction</span>
            </div>
            <h3 class="text-2xl font-headline font-bold text-primary mb-4">Workshop</h3>
            <p class="text-on-surface-variant leading-relaxed mb-6">Sesi praktek langsung intensif dengan pengawasan mentor profesional.</p>
            <a class="text-primary font-bold flex items-center gap-2 group-hover:gap-4 transition-all" href="/eksplorasi">
              Jelajahi Workshop <span class="material-symbols-outlined">trending_flat</span>
            </a>
          </div>
          <div class="bg-surface-container-lowest p-10 rounded-2xl group hover:shadow-xl transition-all duration-300">
            <div class="w-16 h-16 bg-secondary-container/10 rounded-xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
              <span class="material-symbols-outlined text-secondary text-4xl">videocam</span>
            </div>
            <h3 class="text-2xl font-headline font-bold text-primary mb-4">Webinar</h3>
            <p class="text-on-surface-variant leading-relaxed mb-6">Seminar online interaktif membahas tren industri terbaru.</p>
            <a class="text-primary font-bold flex items-center gap-2 group-hover:gap-4 transition-all" href="/eksplorasi">
              Jelajahi Webinar <span class="material-symbols-outlined">trending_flat</span>
            </a>
          </div>
          <div class="bg-surface-container-lowest p-10 rounded-2xl group hover:shadow-xl transition-all duration-300">
            <div class="w-16 h-16 bg-tertiary-fixed-dim/10 rounded-xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform">
              <span class="material-symbols-outlined text-tertiary text-4xl">school</span>
            </div>
            <h3 class="text-2xl font-headline font-bold text-primary mb-4">Bootcamp</h3>
            <p class="text-on-surface-variant leading-relaxed mb-6">Program akselerasi karir mendalam selama beberapa minggu.</p>
            <a class="text-primary font-bold flex items-center gap-2 group-hover:gap-4 transition-all" href="/eksplorasi">
              Jelajahi Bootcamp <span class="material-symbols-outlined">trending_flat</span>
            </a>
          </div>
        </div>
      </div>
    </section>

    {{-- EVENT POPULER SECTION --}}
    <section class="py-24">
      <div class="max-w-7xl mx-auto px-4 md:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-16">
          <div>
            <h2 class="text-4xl font-headline font-extrabold text-primary">Event Populer Minggu Ini</h2>
            <p class="text-on-surface-variant mt-2 text-lg">Pilihan kurasi untuk pertumbuhan intelektual Anda.</p>
          </div>
          <a href="/eksplorasi" class="ml-auto inline-flex items-center gap-1 text-primary text-sm font-semibold sm:text-lg hover:underline">
            Lihat Semua <span class="material-symbols-outlined text-[18px] sm:text-[20px]">arrow_forward</span>
          </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-10">
          @forelse ($events as $event)

          @php
          $isPublished = $event->Pemateri && $event->Pemateri != '';
          @endphp

          {{-- Sembunyikan event draft dari pengguna biasa --}}
          @if(!$isPublished && !$isPenyelenggara && !$isPembicara)
          @continue
          @endif

          <div class="bg-surface-container-lowest rounded-2xl overflow-hidden group shadow-sm hover:shadow-lg transition-all duration-300">

            {{-- Gambar --}}
            <div class="relative h-48">
              <img
                alt="{{ $event->Nama_Event }}"
                src="{{ asset('upload/' . $event->Gambar) }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                onerror="this.src='https://via.placeholder.com/400x192'">
              {{-- Badge Jenis Event --}}
              <div class="absolute top-3 right-3 bg-secondary-fixed text-on-secondary-fixed-variant px-3 py-1 rounded-full text-[10px] font-bold uppercase">
                {{ $event->Jenis_Event }}
              </div>
              {{-- Tanggal --}}
              <div class="absolute bottom-3 left-3 bg-primary/80 backdrop-blur text-on-primary px-3 py-1 rounded-md text-[10px] font-bold">
                📅 {{ \Carbon\Carbon::parse($event->Tanggal)->format('d M Y') }}
              </div>
            </div>

            {{-- Konten --}}
            <div class="p-5">

              {{-- Badge Status (hanya penyelenggara & pembicara) + Judul --}}
              <div class="flex items-start gap-2 mb-2">
                <h3 class="text-base font-headline font-bold text-primary leading-tight flex-1">
                  {{ $event->Nama_Event }}
                </h3>
                @if($isPenyelenggara || $isPembicara)
                @if($isPublished)
                <span class="flex-shrink-0 inline-flex items-center gap-1 bg-teal-100 text-teal-700 text-[9px] px-2 py-0.5 rounded-full font-bold whitespace-nowrap">
                  Published
                </span>
                @else
                <span class="flex-shrink-0 inline-flex items-center gap-1 bg-surface-container text-teal-600 text-[9px] px-2 py-0.5 rounded-full font-bold whitespace-nowrap">
                  Draft
                </span>
                @endif
                @endif
              </div>

              {{-- Pemateri --}}
              <div class="flex items-center gap-1 text-slate-400 mb-1">
                <span class="material-symbols-outlined text-xs">person</span>
                <p class="text-xs font-medium truncate">
                  @if($isPublished)
                  {{ $event->Pemateri }}
                  @else
                  <span class="italic text-teal-400">Menunggu Pembicara</span>
                  @endif
                </p>
              </div>

              {{-- Lokasi --}}
              <div class="flex items-center gap-1 text-slate-400 mb-4">
                <span class="material-symbols-outlined text-xs">location_on</span>
                <p class="text-xs truncate">{{ $event->Lokasi ?? '-' }}</p>
              </div>

              {{-- Harga + Tombol --}}
              <div class="flex items-center justify-between border-t border-outline-variant/10 pt-4">
                <div>
                  <p class="text-[9px] text-slate-400 uppercase tracking-wider mb-0.5">Harga</p>
                  <span class="text-tertiary font-bold text-base">
                    {{ (!$event->Harga || $event->Harga == 0) ? 'Gratis' : 'Rp ' . number_format($event->Harga, 0, ',', '.') }}
                  </span>
                </div>

                {{-- Tombol berdasarkan role & status --}}
                @if($isPublished)
                {{-- Event Published — semua bisa daftar --}}
                <a href="/event/{{ $event->id }}"
                  class="px-4 py-2 bg-teal-900 hover:bg-teal-700 text-white rounded-lg font-bold text-xs transition">
                  Daftar
                </a>
                @else
                {{-- Event Draft --}}
                @if($isPembicara)
                <a href="{{ route('event.show', $event->id) }}"
                  class="px-4 py-2 bg-tertiary hover:opacity-90 text-white rounded-lg font-bold text-xs transition inline-block">
                  Lamar Pembicara
                </a>
                @elseif($isPenyelenggara)
                <span class="px-3 py-1.5 bg-teal-50 text-teal-500 border border-teal-200 rounded-lg text-[10px] font-semibold">
                  Menunggu Pembicara
                </span>
                @endif
                @endif

              </div>
            </div>
          </div>

          @empty
          <p class="text-on-surface-variant col-span-3 text-center py-12">Belum ada event tersedia.</p>
          @endforelse
        </div>

      </div>
    </section>

    {{-- TESTIMONI SECTION --}}
    <section class="py-24 bg-surface-container overflow-hidden">
      <div class="max-w-7xl mx-auto px-4 md:px-8 relative">
        <div class="text-center mb-20 relative z-10">
          <h2 class="text-4xl font-headline font-extrabold text-primary">Apa Kata Mereka?</h2>
          <p class="text-on-surface-variant mt-4 text-lg">Testimoni dari alumni EventSpeak yang telah bertransformasi.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
          <div class="bg-surface-container-lowest p-8 rounded-2xl shadow-sm border-l-4 border-tertiary">
            <p class="text-on-surface italic leading-relaxed mb-8">"EventSpeak benar-benar platform yang berbeda. Kurasi speakernya jempolan dan materi bootcamp-nya sangat relevan dengan industri saat ini."</p>
            <div class="flex items-center gap-4">
              <div>
                <p class="font-headline font-bold text-primary">Sarah Amelia</p>
                <p class="text-xs text-on-surface-variant">Lead Designer at Creativa</p>
              </div>
            </div>
          </div>
          <div class="bg-surface-container-lowest p-8 rounded-2xl shadow-sm border-l-4 border-primary">
            <p class="text-on-surface italic leading-relaxed mb-8">"Webinar di sini tidak pernah membosankan. Interaksinya hidup dan insight yang didapat sangat eksklusif."</p>
            <div class="flex items-center gap-4">
              <div>
                <p class="font-headline font-bold text-primary">Budi Santoso</p>
                <p class="text-xs text-on-surface-variant">Senior Dev at TechnoID</p>
              </div>
            </div>
          </div>
          <div class="bg-surface-container-lowest p-8 rounded-2xl shadow-sm border-l-4 border-secondary">
            <p class="text-on-surface italic leading-relaxed mb-8">"Proses pendaftarannya sangat seamless. Dari pemilihan jadwal hingga sertifikat digital, semuanya terorganisir dengan sangat baik."</p>
            <div class="flex items-center gap-4">
              <div>
                <p class="font-headline font-bold text-primary">Diana Putri</p>
                <p class="text-xs text-on-surface-variant">Marketing Manager at GlobalLink</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

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
    const menuBtn = document.getElementById('menuBtn');
    const closeMenu = document.getElementById('closeMenu');
    const mobileMenu = document.getElementById('mobileMenu');
    if (menuBtn) menuBtn.addEventListener('click', () => mobileMenu.classList.remove('translate-x-full'));
    if (closeMenu) closeMenu.addEventListener('click', () => mobileMenu.classList.add('translate-x-full'));
    function toggleNotif() {
        const popup = document.getElementById('notifPopup');
        popup.classList.toggle('hidden');
    }

    // Tutup popup kalau klik di luar
    document.addEventListener('click', function(e) {
        const wrapper = document.getElementById('notifWrapper');
        if (wrapper && !wrapper.contains(e.target)) {
            document.getElementById('notifPopup').classList.add('hidden');
        }
    });
  </script>

</body>

</html>