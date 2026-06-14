<!DOCTYPE html>
<html class="light" lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>EventSpeak - Eksplorasi</title>
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
          <a class="text-teal-700 border-b-2 border-teal-700 pb-1 font-headline font-semibold tracking-tight" href="/eksplorasi">Event</a>
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
          <a href="#" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-bold">Daftar</a>
        </div>
        @endif
      </div>
    </div>
  </nav>

  <main class="pt-28 pb-16 px-8 w-full min-h-screen flex flex-col md:flex-row gap-12 max-w-7xl mx-auto">

    <aside class="w-full md:w-72 flex-shrink-0">
      <form action="{{ route('pengguna.eksplorasi') }}" method="GET" class="space-y-10">
        <div class="space-y-4">
          <h3 class="font-headline font-bold text-xl text-primary">Cari Event</h3>
          <div class="relative">
            <input type="text" name="keyword" value="{{ request('keyword') }}"
              class="w-full pl-12 pr-4 py-3 bg-white border-slate-200 rounded-xl focus:ring-primary"
              placeholder="Design, AI, Business...">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">search</span>
          </div>
        </div>

        <div class="space-y-4">
          <h3 class="font-headline font-bold text-lg text-primary">Kategori</h3>
          <div class="space-y-2">
            @foreach(['Workshop', 'Webinar', 'Bootcamp'] as $kat)
            <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-100 cursor-pointer">
              <input type="checkbox" name="jenis_event[]" value="{{ $kat }}"
                class="rounded text-primary focus:ring-primary"
                {{ is_array(request('jenis_event')) && in_array($kat, request('jenis_event')) ? 'checked' : '' }}>
              <span class="text-slate-700">{{ $kat }}</span>
            </label>
            @endforeach
          </div>
        </div>

        <div class="space-y-4">
          <h3 class="font-headline font-bold text-lg text-primary">Rentang Harga</h3>
          <input type="range" name="max_harga" min="0" max="5000000" step="50000"
            value="{{ request('max_harga', 5000000) }}"
            class="w-full accent-primary"
            oninput="this.nextElementSibling.innerText = 'Rp ' + Number(this.value).toLocaleString('id-ID')">
          <div class="text-right text-sm text-slate-500 font-medium">
            Rp {{ number_format(request('max_harga', 5000000), 0, ',', '.') }}
          </div>
        </div>

        <button type="submit" class="w-full py-4 bg-primary text-white font-bold rounded-xl hover:opacity-90 transition shadow-lg">
          Terapkan Filter
        </button>
        <a href="{{ route('pengguna.eksplorasi') }}" class="block text-center text-sm text-slate-500 underline">Reset Filter</a>
      </form>
    </aside>

    <section class="flex-grow">
      <div class="mb-12">
        <h1 class="font-headline text-4xl font-extrabold tracking-tight text-primary mb-2">Temukan Panggung Intelektual Anda</h1>
        <p class="text-slate-500 text-lg">Eksplorasi event terbaik untuk meningkatkan skill Anda.</p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        @forelse ($events as $event)
        @php
        $isPublished = $event->Pemateri && $event->Pemateri != '';
        @endphp

        <div class="flex flex-col bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 group border border-slate-100">

          {{-- Gambar --}}
          <div class="relative w-full aspect-[16/11] overflow-hidden">
            <img
              alt="{{ $event->Nama_Event }}"
              src="{{ asset('upload/' . $event->Gambar) }}"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
              onerror="this.src='https://via.placeholder.com/400x275'">

            {{-- Badge Jenis Event --}}
            <div class="absolute top-4 right-4">
              <span class="bg-white/90 backdrop-blur-md text-primary px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest shadow-sm">
                {{ $event->Jenis_Event }}
              </span>
            </div>

            {{-- Tanggal --}}
            <div class="absolute bottom-4 left-4">
              <div class="bg-black/50 backdrop-blur-md text-white px-3 py-1.5 rounded-xl text-[10px] font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">calendar_today</span>
                {{ \Carbon\Carbon::parse($event->Tanggal)->format('d M') }}
                @if($event->Jam)
                , {{ \Carbon\Carbon::parse($event->Jam)->format('H:i') }} WIB
                @endif
              </div>
            </div>
          </div>
          {{-- Konten --}}
          <div class="px-5 py-4 flex flex-col flex-1">

            {{-- Judul + Badge Status --}}
            <div class="flex items-start gap-2 mb-1">
              <h3 class="text-sm font-headline font-extrabold text-slate-800 leading-tight line-clamp-1 group-hover:text-primary transition-colors flex-1">
                {{ $event->Nama_Event }}
              </h3>
              @if($isPenyelenggara || $isPembicara)
              @if($isPublished)
              <span class="flex-shrink-0 bg-teal-100 text-teal-700 text-[9px] px-2 py-0.5 rounded-full font-bold whitespace-nowrap">
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
            <div class="flex items-center gap-1 text-slate-400 mb-4">
              <span class="material-symbols-outlined text-xs">person</span>
              <p class="text-[10px] font-medium truncate">
                @if($isPublished)
                {{ $event->Pemateri }}
                @else
                <span class="italic text-teal-400">Menunggu Pembicara</span>
                @endif
              </p>
            </div>

            {{-- Harga + Tombol --}}
            <div class="flex items-center justify-between pt-3 border-t border-slate-50 mt-auto">
              <div class="flex flex-col">
                <span class="text-[8px] text-slate-400 uppercase font-bold tracking-tighter">Harga</span>
                <span class="text-primary font-black text-sm leading-none">
                  {{ (!$event->Harga || $event->Harga == 0) ? 'FREE' : 'Rp' . number_format($event->Harga, 0, ',', '.') }}
                </span>
              </div>

              {{-- Tombol berdasarkan role & status --}}
              @if($isPublished)
              <a href="/event/{{ $event->id }}"
                class="inline-flex items-center justify-center px-4 py-1.5 bg-primary text-white rounded-lg font-bold text-[10px] hover:bg-slate-800 transition-all active:scale-95 shadow-lg shadow-primary/10 uppercase tracking-widest">
                Daftar
              </a>
              @else
              @if($isPembicara)
              <form action="{{ route('pembicara.lamar', $event->id) }}" method="POST">
                @csrf
                <button type="submit"
                  class="px-4 py-2 bg-tertiary hover:opacity-90 text-white rounded-lg font-bold text-xs transition inline-block">
                  Lamar
                </button>
              </form>
              @elseif($isPenyelenggara)
              <span class="px-3 py-1.5 bg-teal-50 text-teal-500 border border-teal-200 rounded-lg text-[10px] font-semibold">
                Menunggu Pembicara
              </span>
              @else
              <span class="px-3 py-1.5 bg-slate-100 text-slate-400 rounded-lg text-[10px] font-semibold">
                Segera Hadir
              </span>
              @endif
              @endif

            </div>
          </div>
        </div>

        @empty
        <div class="col-span-full py-20 text-center">
          <p class="text-slate-400 text-sm">Belum ada event tersedia.</p>
        </div>
        @endforelse
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