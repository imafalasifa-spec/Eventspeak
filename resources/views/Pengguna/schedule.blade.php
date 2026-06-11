<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>EventSpeak - Schedule</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            primary: "#004253",
            background: "#f8f9fb",
            "surface-container": "#eceef0",
            "on-surface": "#191c1e",
            "primary-container": "#005b71",
            "on-primary": "#ffffff",
            tertiary: "#7e0016",
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

<body class="bg-background text-on-surface">
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
        {{-- Cek apakah ada session user_id --}}
        @if(session()->has('user_id'))
        <div class="flex items-center gap-3">
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

  <main class="pt-32 pb-20 px-6 md:px-8 max-w-7xl mx-auto">
    <div class="mb-12 text-center md:text-left">
      <span class="text-primary font-bold tracking-widest text-xs uppercase bg-primary/5 px-3 py-1 rounded-full">Your Calendar</span>
      <h1 class="text-5xl font-extrabold text-primary tracking-tighter mt-4 mb-4">Event Schedule</h1>
      <p class="text-slate-500 max-w-2xl text-lg leading-relaxed">
        Temukan jadwal belajar terbaikmu bulan ini.
      </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

      <div class="lg:col-span-8 bg-white rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden border border-slate-100">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
          <h2 class="text-xl font-bold text-primary">
            {{ \Carbon\Carbon::create($year, $month)->translatedFormat('F Y') }}
          </h2>
        </div>

        <div class="grid grid-cols-7 bg-white text-slate-400 text-[10px] font-black uppercase tracking-widest py-4 text-center border-b border-slate-50">
          <div>Sun</div>
          <div>Mon</div>
          <div>Tue</div>
          <div>Wed</div>
          <div>Thu</div>
          <div>Fri</div>
          <div>Sat</div>
        </div>

        <div class="grid grid-cols-7 gap-px bg-slate-100">
          {{-- Logika Penanggalan --}}
          @php
          $startOfMonth = \Carbon\Carbon::create($year, $month, 1);
          $daysInMonth = $startOfMonth->daysInMonth;
          $dayOfWeek = $startOfMonth->dayOfWeek; // 0 (Sun) - 6 (Sat)
          @endphp

          {{-- Empty slots for previous month --}}
          @for ($x = 0; $x < $dayOfWeek; $x++)
            <div class="bg-slate-50/50 min-h-[110px] p-4 opacity-20 text-right text-sm">
        </div>
        @endfor

        {{-- Main Calendar Days --}}
        @for ($i = 1; $i <= $daysInMonth; $i++)
          @php
          $currentDate=sprintf('%04d-%02d-%02d', $year, $month, $i);
          $eventsToday=$events->filter(function($event) use ($currentDate) {
          return \Carbon\Carbon::parse($event->Tanggal)->format('Y-m-d') == $currentDate;
          });
          $isToday = $currentDate == date('Y-m-d');
          @endphp

          <div class="bg-white min-h-[110px] p-4 text-right transition-all hover:bg-slate-50 group relative cursor-pointer">
            <span class="text-sm font-bold {{ $isToday ? 'bg-primary text-white w-7 h-7 inline-flex items-center justify-center rounded-full' : ($eventsToday->count() > 0 ? 'text-primary' : 'text-slate-400') }}">
              {{ $i }}
            </span>

            <div class="mt-3 flex flex-col gap-1">
              @foreach($eventsToday as $e)
              <div class="h-1.5 w-full rounded-full 
                                        {{ strtolower($e->Jenis_Event) == 'bootcamp' ? 'bg-tertiary' : (strtolower($e->Jenis_Event) == 'webinar' ? 'bg-primary' : 'bg-teal-500') }}"
                title="{{ $e->Nama_Event }}">
              </div>
              @endforeach
            </div>
          </div>
          @endfor
      </div>
    </div>

    <div class="lg:col-span-4 space-y-6">
      <div class="bg-primary rounded-3xl p-8 text-white shadow-2xl shadow-primary/20 relative overflow-hidden">
        <h3 class="text-2xl font-black mb-1">Highlights</h3>
        <p class="text-white/60 text-xs font-bold uppercase tracking-widest mb-6">Upcoming Events</p>

        <div class="space-y-4">
          @forelse($events->take(2) as $upcoming)
          <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/10">
            <span class="inline-block px-2 py-0.5 rounded bg-white/20 text-[8px] font-bold uppercase mb-2">
              {{ $upcoming->Jenis_Event }}
            </span>
            <h4 class="font-bold text-sm leading-tight mb-2">{{ $upcoming->Nama_Event }}</h4>
            <p class="text-[10px] text-white/70">{{ \Carbon\Carbon::parse($upcoming->Tanggal)->format('d M | H:i') }} WIB</p>
          </div>
          @empty
          <p class="text-white/50 text-sm">Tidak ada event terdekat.</p>
          @endforelse
        </div>
      </div>

      <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Legend</h3>
        <div class="space-y-3">
          <div class="flex items-center gap-3">
            <span class="w-3 h-3 rounded-full bg-teal-500"></span>
            <span class="text-xs font-semibold text-slate-600">Workshops</span>
          </div>
          <div class="flex items-center gap-3">
            <span class="w-3 h-3 rounded-full bg-primary"></span>
            <span class="text-xs font-semibold text-slate-600">Webinars</span>
          </div>
          <div class="flex items-center gap-3">
            <span class="w-3 h-3 rounded-full bg-tertiary"></span>
            <span class="text-xs font-semibold text-slate-600">Bootcamps</span>
          </div>
        </div>
      </div>
    </div>
    </div>
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
</body>

</html>