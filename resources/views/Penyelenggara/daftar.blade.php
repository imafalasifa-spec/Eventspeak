<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Become an Organizer | EventSpeak</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
      .glass-nav {
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
      }
      .hero-gradient {
        background: linear-gradient(135deg, #004253 0%, #005b71 100%);
      }
      .tonal-shift {
        background-color: #f2f4f6;
      }
      body {
        font-family: 'Inter', sans-serif;
      }
      h1, h2, h3 {
        font-family: 'Manrope', sans-serif;
      }
    </style>
</head>

<body class="bg-surface text-on-surface antialiased min-h-screen">
    <!-- Header -->
    <header class="fixed top-0 w-full z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md shadow-[0px_20px_40px_rgba(25,28,30,0.06)] h-20">
      <div class="flex justify-between items-center px-8 h-full max-w-full mx-auto">
        <div class="flex items-center gap-12">
          <!-- Hamburger (Mobile) -->
          <button onclick="toggleTopMenu()" class="md:hidden text-2xl">
            <span class="material-symbols-outlined">menu</span>
          </button>
          <span class="text-2xl font-black text-teal-900 dark:text-teal-100 font-headline tracking-tight">EventSpeak</span>
          
          <div id="topMenu" class="hidden md:flex gap-8 items-center flex-col md:flex-row absolute md:static top-20 left-0 w-full md:w-auto bg-white md:bg-transparent p-4 md:p-0 shadow md:shadow-none">
            <a class="font-manrope text-slate-600 dark:text-slate-400 hover:text-teal-600 tracking-tight transition-colors" href="{{ route('pengguna.index') }}">Browse</a>
            <a class="font-manrope text-slate-600 dark:text-slate-400 hover:text-teal-600 tracking-tight transition-colors" href="{{ route('pengguna.eksplorasi') }}">Event</a>
            <a class="font-manrope text-slate-600 dark:text-slate-400 hover:text-teal-600 tracking-tight transition-colors" href="{{ route('pengguna.schedule') }}">Schedule</a>
            <a class="font-manrope text-slate-600 dark:text-slate-400 hover:text-teal-600 tracking-tight transition-colors" href="{{ route('pembicara.index') }}">Become a Speaker</a>
            <a class="font-manrope text-slate-600 dark:text-slate-400 hover:text-teal-600 tracking-tight transition-colors" href="{{ route('pengguna.team') }}">Team</a>
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
          <a href="{{ route('pengguna.registrasi') }}" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-bold">Daftar</a>
        </div>
        @endif
      </div>
      </div>
    </header>

    <div class="flex pt-20 min-h-screen">
        <!-- Sidebar -->
        <aside class="h-[calc(100vh-80px)] w-64 sticky left-0 top-20 flex flex-col p-6 gap-2 bg-slate-50 border-r border-slate-100">
            <div class="mb-8 px-2">
                <!-- Data dinamis user Laravel -->
                <h2 class="font-manrope font-extrabold text-xl text-on-background">{{ Auth::user()->name ?? 'User Name' }}</h2>
                <p class="font-inter text-xs font-medium text-slate-500 tracking-wider uppercase">Premium Member</p>
            </div>
            <nav class="flex-grow space-y-1">
                <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-100 transition-transform hover:translate-x-1 rounded-lg font-medium text-sm" href="{{ route('pengguna.profil') }}">
                    <span class="material-symbols-outlined">person</span>
                    <span>Profil</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-teal-700 font-bold bg-white rounded-lg shadow-sm font-medium text-sm" href="{{ route('penyelenggara.pendaftaran') }}">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">stars</span>
                    <span>Menjadi Penyelenggara</span>
                </a>
            </nav>
            <div class="mt-auto pt-6 border-t border-slate-200">
                <div class="space-y-1">
                    <a class="flex items-center gap-3 px-4 py-2 text-slate-500 hover:bg-slate-100 rounded-lg text-sm transition-transform hover:translate-x-1" href="#">
                        <span class="material-symbols-outlined">help</span>
                        <span>Help Center</span>
                    </a>
                    <button onclick="openModal()" class="w-full flex items-center gap-3 px-4 py-2 text-error hover:bg-error-container/20 rounded-lg text-sm transition-transform hover:translate-x-1">
                        <span class="material-symbols-outlined">logout</span>
                        <span>Sign Out</span>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow p-12 bg-surface">
            <div class="max-w-4xl mx-auto">
                <section class="mb-12 relative overflow-hidden rounded-[2rem] bg-teal-900 p-12 text-white">
                    <div class="relative z-10">
                        <span class="inline-block px-4 py-1 rounded-full bg-white/10 backdrop-blur-md text-xs font-bold tracking-widest uppercase mb-4">The Editorial Architect</span>
                        <h1 class="text-5xl font-extrabold leading-tight tracking-tighter mb-4 max-w-2xl">Shape the Conversations of Tomorrow.</h1>
                        <p class="text-indigo-100 text-lg max-w-xl opacity-90 leading-relaxed">
                            Bergabunglah sebagai penyelenggara di EventSpeak. Kami menyediakan platform bagi para visioner untuk membangun, mengelola, dan menskalakan acara berkualitas tinggi dengan presisi arsitektural.
                        </p>
                    </div>
                    <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-teal-500/20 blur-3xl rounded-full"></div>
                    <div class="absolute right-10 top-10 opacity-20">
                        <span class="material-symbols-outlined text-[10rem]">architecture</span>
                    </div>
                </section>

                <div class="bg-surface-container-low rounded-[2rem] p-10">
                    <!-- Menampilkan Error jika Validasi Laravel Gagal -->
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-xl text-sm">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form Action diganti menggunakan route Laravel -->
                    <form action="{{ route('penyelenggara.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                        @csrf {{-- Proteksi Token CSRF Laravel --}}
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-slate-700 tracking-wide uppercase px-1">Nama Perusahaan / Instansi</label>
                                <input name="instansi" value="{{ old('instansi') }}" required class="w-full bg-surface-container-lowest border-none rounded-xl py-4 px-6 focus:ring-2 focus:ring-indigo-500/40 transition-all text-on-surface shadow-sm outline-none" placeholder="e.g. Nexus Media Group" type="text" />
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-slate-700 tracking-wide uppercase px-1">Peran dalam Agensi</label>
                                <select name="peran" class="w-full bg-surface-container-lowest border-none rounded-xl py-4 px-6 focus:ring-2 focus:ring-indigo-500/40 transition-all text-on-surface shadow-sm outline-none appearance-none">
                                    <option value="Director / Founder" {{ old('peran') == 'Director / Founder' ? 'selected' : '' }}>Director / Founder</option>
                                    <option value="Event Producer" {{ old('peran') == 'Event Producer' ? 'selected' : '' }}>Event Producer</option>
                                    <option value="Marketing Manager" {{ old('peran') == 'Marketing Manager' ? 'selected' : '' }}>Marketing Manager</option>
                                    <option value="Project Coordinator" {{ old('peran') == 'Project Coordinator' ? 'selected' : '' }}>Project Coordinator</option>
                                </select>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 tracking-wide uppercase px-1">Deskripsi Agensi</label>
                            <textarea name="deskripsi_instansi" required class="w-full bg-surface-container-lowest border-none rounded-xl py-4 px-6 focus:ring-2 focus:ring-indigo-500/40 transition-all text-on-surface shadow-sm outline-none" placeholder="Ceritakan visi dan keahlian agensi Anda..." rows="4">{{ old('deskripsi_instansi') }}</textarea>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700 tracking-wide uppercase px-1">Portofolio / Pitch Deck</label>
                            <div class="relative group">
                                <div class="border-2 border-dashed border-outline-variant/40 group-hover:border-indigo-400 rounded-2xl p-12 transition-all bg-surface-container-lowest flex flex-col items-center justify-center text-center cursor-pointer">
                                    <span class="material-symbols-outlined text-teal-600 text-3xl">upload_file</span>
                                    <p class="text-on-surface font-semibold mb-1" id="fileName">Unggah Portofolio Anda</p>
                                    <input id="uploadFile" name="portofolio_instansi" class="absolute inset-0 opacity-0 cursor-pointer" type="file" required />
                                </div>
                            </div>
                        </div>
                        <div class="pt-6 border-t border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-6">
                            <div class="flex items-center gap-3">
                                <input class="w-5 h-5 rounded border-slate-300 text-teal-600 focus:ring-teal-500" id="terms" type="checkbox" required />
                                <label class="text-sm text-slate-500" for="terms">Saya menyetujui <a class="text-teal-600 font-bold hover:underline" href="#">Ketentuan Penyelenggara</a></label>
                            </div>
                            <button type="submit" class="bg-gradient-to-r from-teal-600 to-teal-500 text-white px-10 py-4 rounded-xl font-bold tracking-tight shadow-lg hover:-translate-y-1 transition-all">
                                Kirim Pendaftaran
                            </button>
                        </div>
                    </form>
                </div>

                <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-8 bg-white rounded-3xl shadow-sm border border-slate-50">
                        <span class="material-symbols-outlined text-teal-600 mb-4 text-3xl">verified</span>
                        <h3 class="font-bold text-lg mb-2">Verifikasi Cepat</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Tim kurasi kami meninjau aplikasi Anda dalam waktu 24-48 jam kerja.</p>
                    </div>
                    <div class="p-8 bg-white rounded-3xl shadow-sm border border-slate-50">
                        <span class="material-symbols-outlined text-teal-600 mb-4 text-3xl">analytics</span>
                        <h3 class="font-bold text-lg mb-2">Dashboard Pintar</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Akses ke data analitik real-time dan manajemen tiket terintegrasi.</p>
                    </div>
                    <div class="p-8 bg-white rounded-3xl shadow-sm border border-slate-50">
                        <span class="material-symbols-outlined text-teal-600 mb-4 text-3xl">groups</span>
                        <h3 class="font-bold text-lg mb-2">Komunitas Eksklusif</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Terhubung dengan jaringan pembicara dan venue premium di seluruh dunia.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="w-full py-16 px-8 mt-auto bg-slate-100 dark:bg-slate-950">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-12 max-w-7xl mx-auto">
        <div class="col-span-1">
          <span class="font-manrope font-bold text-teal-800 dark:text-teal-400 text-2xl block mb-6">EventSpeak</span>
          <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-8">
            Platform webinar, workshop, dan bootcamp terintegrasi untuk membantu mahasiswa dan profesional menemukan serta mengikuti event edukatif.
          </p>
          <div class="flex gap-4">
            <a class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-800 flex items-center justify-center text-teal-800 dark:text-teal-400 hover:bg-teal-800 hover:text-white transition-all" href="#"><i class="fa-brands fa-instagram text-[20px]"></i></a>
            <a class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-800 flex items-center justify-center text-teal-800 dark:text-teal-400 hover:bg-teal-800 hover:text-white transition-all" href="#"><i class="fa-brands fa-linkedin-in text-[20px]"></i></a>
            <a class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-800 flex items-center justify-center text-teal-800 dark:text-teal-400 hover:bg-teal-800 hover:text-white transition-all" href="#"><i class="fa-brands fa-x-twitter text-[20px]"></i></a>
          </div>
        </div>

        <div class="col-span-1">
          <h4 class="font-headline font-bold text-teal-900 dark:text-teal-200 mb-6">Support</h4>
          <ul class="space-y-4 font-inter text-sm mb-8">
            <li><a class="text-slate-500 dark:text-slate-400 hover:text-teal-600 transition-colors" href="#">Privacy Policy</a></li>
            <li><a class="text-slate-500 dark:text-slate-400 hover:text-teal-600 transition-colors" href="#">Terms of Service</a></li>
            <li><a class="text-slate-500 dark:text-slate-400 hover:text-teal-600 transition-colors" href="#">Help Center</a></li>
          </ul>
          <h4 class="font-headline font-bold text-teal-900 dark:text-teal-200 mb-6">Contact</h4>
          <ul class="space-y-4 font-inter text-sm">
            <li class="flex items-center gap-2 text-slate-500 dark:text-slate-400"><span class="material-symbols-outlined text-sm">mail</span>eventspeak@gmail.com</li>
            <li class="flex items-center gap-2 text-slate-500 dark:text-slate-400"><span class="material-symbols-outlined text-sm">call</span>+62 812-3456-7890</li>
          </ul>
        </div>

        <div class="col-span-1">
          <h4 class="font-headline font-bold text-teal-900 dark:text-teal-200 mb-6">Get in Touch</h4>
          <form class="flex flex-col gap-4">
            <input class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg px-4 py-2 focus:ring-1 focus:ring-teal-500 outline-none text-sm font-inter" placeholder="Name" type="text">
            <input class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg px-4 py-2 focus:ring-1 focus:ring-teal-500 outline-none text-sm font-inter" placeholder="Email" type="email">
            <textarea class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg px-4 py-2 focus:ring-1 focus:ring-teal-500 outline-none text-sm font-inter min-h-[80px]" placeholder="Message"></textarea>
            <button class="w-full py-3 bg-primary text-on-primary font-bold rounded-xl hover:opacity-90 transition-opacity" type="submit">Send Message</button>
          </form>
        </div>
      </div>
      <div class="max-w-7xl mx-auto px-8 mt-16 pt-8 border-t border-slate-200 dark:border-slate-800 text-center">
        <p class="font-inter text-sm text-slate-500 dark:text-slate-400">© 2026 EventSpeak</p>
      </div>
    </footer>

    <!-- Modal Sign Out -->
    <div id="logoutModal" class="fixed inset-0 bg-black/40 hidden z-50">
      <div class="absolute inset-0 flex items-center justify-center p-4">
        <div id="modalBox" class="bg-white rounded-xl p-6 w-[90%] max-w-sm shadow-lg scale-95 opacity-0 transition duration-200">
          <h2 class="text-lg font-bold mb-2">Konfirmasi</h2>
          <p class="text-slate-600 text-sm mb-6">Anda yakin ingin keluar?</p>
          <div class="flex justify-between gap-3">
            <button type="button" onclick="closeModal()" class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-lg">Batalkan</button>
            
            <!-- Integrasi Form Logout Laravel -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Keluar</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Scripts -->
    <script>
        function openModal() {
            const modal = document.getElementById("logoutModal");
            const box = document.getElementById("modalBox");
            modal.classList.remove("hidden");
            modal.classList.add("flex");
            setTimeout(() => { box.classList.remove("scale-95", "opacity-0"); }, 10);
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

        function toggleTopMenu() {
            const menu = document.getElementById("topMenu");
            menu.classList.toggle("hidden");
        }

        // Script pengganti teks saat file dipilih
        const fileInput = document.getElementById("uploadFile");
        const fileNameText = document.getElementById("fileName");

        fileInput.addEventListener("change", function () {
            if (this.files.length > 0) {
                fileNameText.textContent = "Terpilih: " + this.files[0].name;
            }
        });
    </script>
</body>
</html>