<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>EventSpeak - Our Team</title>
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
  <nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md shadow-sm h-20">
    <div class="flex justify-between items-center px-8 h-full max-w-7xl mx-auto">
      <div class="flex items-center gap-12">
        <a href="{{ route('pengguna.index') }}" class="text-2xl font-black text-primary font-headline tracking-tight">EventSpeak</a>
        <div class="hidden md:flex gap-8 items-center">
          <a class="font-manrope text-slate-600 hover:text-teal-600 tracking-tight transition-colors" href="/">Browse</a>
          <a class="font-manrope text-slate-600 hover:text-teal-600 tracking-tight transition-colors" href="/eksplorasi">Event</a>
          <a class="font-manrope text-slate-600 hover:text-teal-600 tracking-tight transition-colors" href="/schedule">Schedule</a>
          <a class="font-manrope text-slate-600 hover:text-teal-600 tracking-tight transition-colors" href="/pembicara/daftar">Become a Speaker</a>
          <a class="text-teal-700 border-b-2 border-teal-700 pb-1 font-headline font-semibold tracking-tight" href="/team">Team</a>
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

  <main class="pt-40 pb-24 px-6 md:px-12 max-w-7xl mx-auto">
    <header class="mb-32 text-center max-w-3xl mx-auto">
      <span class="text-xs font-bold tracking-[0.2em] text-primary/60 uppercase mb-4 block">The Team</span>
      <h1 class="text-5xl md:text-6xl font-extrabold text-primary tracking-tight leading-[1.1] mb-8">
        Bersama Menciptakan Ruang Belajar yang Lebih Baik.
      </h1>
      <p class="text-lg text-on-surface-variant leading-relaxed">
        Temui tim di balik EventSpeak yang berkomitmen menghadirkan platform terbaik untuk webinar dan workshop edukatif.
      </p>
    </header>

    <div class="space-y-32">
      <div class="group flex flex-col md:flex-row gap-12 items-center">
        <div class="w-full md:w-1/2 aspect-[4/3] overflow-hidden rounded-3xl shadow-lg">
          <img alt="kirana"
            class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700"
            src="{{ asset('upload/kirana.png') }}">
        </div>
        <div class="w-full md:w-1/2">
          <span class="text-xs font-bold text-primary tracking-widest uppercase mb-2 block">Lead Developer</span>
          <h2 class="text-4xl font-bold text-primary mb-4 font-headline">Kirana Isna Dewi</h2>
          <p class="text-on-surface-variant leading-relaxed mb-6">
            Bertanggung jawab dalam merancang arsitektur sistem utama dan memastikan kinerja aplikasi tetap stabil serta aman.
          </p>
          <div class="flex gap-4">
            <a href="#" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all"><i class="fa-brands fa-github"></i></a>
            <a href="#" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all"><i class="fa-solid fa-envelope"></i></a>
          </div>
        </div>
      </div>

      <div class="group flex flex-col md:flex-row-reverse gap-12 items-center">
        <div class="w-full md:w-1/2 aspect-[4/3] overflow-hidden rounded-3xl shadow-lg">
          <img alt="ima"
            class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700"
            src="{{ asset('upload/ima.jpg') }}">
        </div>
        <div class="w-full md:w-1/2">
          <span class="text-xs font-bold text-primary tracking-widest uppercase mb-2 block">UI/UX Designer</span>
          <h2 class="text-4xl font-bold text-primary mb-4 font-headline">Ima Muhimmah Falasifa</h2>
          <p class="text-on-surface-variant leading-relaxed mb-6">
            Merancang pengalaman pengguna yang intuitif dan menarik agar setiap interaksi berjalan dengan lancar.
          </p>
          <div class="flex gap-4">
            <a href="#" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all"><i class="fa-brands fa-behance"></i></a>
            <a href="#" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all"><i class="fa-brands fa-dribbble"></i></a>
          </div>
        </div>
      </div>

      <div class="group flex flex-col md:flex-row gap-12 items-center">
        <div class="w-full md:w-1/2 aspect-[4/3] overflow-hidden rounded-3xl shadow-lg">
          <img alt="faren"
            class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700"
            src="{{ asset('upload/faren.png') }}">
        </div>
        <div class="w-full md:w-1/2">
          <span class="text-xs font-bold text-primary tracking-widest uppercase mb-2 block">Backend Engineer</span>
          <h2 class="text-4xl font-bold text-primary mb-4 font-headline">Faren Tresandra Nafasya</h2>
          <p class="text-on-surface-variant leading-relaxed mb-6">
            Mengelola sisi server, database, dan API guna memastikan keamanan dan efisiensi data platform.
          </p>
          <div class="flex gap-4">
            <a href="#" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all"><i class="fa-solid fa-code"></i></a>
            <a href="#" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all"><i class="fa-brands fa-linkedin"></i></a>
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