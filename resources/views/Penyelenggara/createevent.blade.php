<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Create Event | EventSpeak</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#004253",
                        "on-primary": "#ffffff"
                    },
                    fontFamily: {
                        headline: ["Manrope"]
                    }
                }
            }
        };
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">

    {{-- HEADER --}}
    <header class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md shadow-[0px_20px_40px_rgba(25,28,30,0.06)] h-20">
        <div class="flex justify-between items-center px-8 h-full max-w-full mx-auto">
            <div class="flex items-center gap-12">
                <span class="text-2xl font-black text-teal-900 font-headline tracking-tight">EventSpeak</span>
                <div class="hidden md:flex gap-8 items-center">
                    <a class="text-slate-600 hover:text-teal-600 font-medium transition-colors" href="{{ route('pengguna.index') }}">Browse</a>
                    <a class="text-slate-600 hover:text-teal-600 font-medium transition-colors" href="{{ route('pengguna.eksplorasi') }}">Event</a>
                    <a class="text-slate-600 hover:text-teal-600 font-medium transition-colors" href="{{ route('pengguna.schedule') }}">Schedule</a>
                    <a class="text-slate-600 hover:text-teal-600 font-medium transition-colors" href="#">Become a Speaker</a>
                    <a class="text-slate-600 hover:text-teal-600 font-medium transition-colors" href="{{ route('pengguna.team') }}">Team</a>
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
    </header>

    <div class="flex flex-1 pt-20">
        {{-- SIDEBAR --}}
        <aside class="w-64 h-[calc(100vh-5rem)] sticky top-20 flex flex-col p-6 bg-slate-50 border-r border-slate-100">
            <div class="mb-8 px-2">
                <h2 class="font-headline font-extrabold text-xl">{{ $user->nama_user ?? 'Penyelenggara' }}</h2>
                <p class="text-xs text-slate-500 uppercase tracking-wider">Penyelenggara</p>
            </div>
            <nav class="flex-grow space-y-1">
                <a href="{{ route('pengguna.profil') }}" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-100 rounded-lg text-sm">
                    <span class="material-symbols-outlined">person</span><span>Profil</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-teal-700 font-bold bg-white rounded-lg shadow-sm text-sm" href="{{ route('penyelenggara.dashboard') }}">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">stars</span>
                    <span>Dashboard Penyelenggara</span>
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

        {{-- MAIN --}}
        <main class="flex-1 pt-10 pb-12 px-8">
            <div class="max-w-4xl mx-auto">

                {{-- Hero --}}
                <div class="bg-gradient-to-r from-teal-900 to-teal-700 rounded-3xl p-10 text-white relative overflow-hidden mb-12">
                    <span class="text-xs uppercase tracking-widest bg-white/20 px-3 py-1 rounded-full font-semibold">Create Event</span>
                    <h1 class="text-4xl md:text-5xl font-extrabold mt-4 leading-tight">Create Your Event &<br>Inspire Others</h1>
                    <p class="mt-4 text-white/80 max-w-xl">Buat event webinar, workshop, atau bootcamp dengan mudah di EventSpeak.</p>
                    <div class="absolute right-10 bottom-[-20px] opacity-20">
                        <span class="material-symbols-outlined text-[180px]">event_available</span>
                    </div>
                </div>

                @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                    <p>• {{ $error }}</p>
                    @endforeach
                </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('penyelenggara.storeEvent') }}" enctype="multipart/form-data" id="eventForm">
                    @csrf
                    <input type="hidden" name="status" id="statusInput" value="draft"> <!-- ← TAMBAH DI SINI -->


                    {{-- Gambar --}}
                    <div class="bg-blue-50 border-l-4 border-teal-400 p-6 rounded-xl shadow-sm">
                        <label class="font-bold text-sm mb-3 block">Gambar Event</label>
                        <div class="flex items-center gap-6">
                            <img id="previewGambar" src="https://via.placeholder.com/112" class="w-28 h-28 rounded-xl object-cover">
                            <input type="file" name="gambar" class="text-sm" onchange="previewImage(event)">
                        </div>
                    </div>

                    {{-- Jenis --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <label class="inline-flex items-center gap-2 text-sm font-semibold text-teal-700 bg-teal-100 px-3 py-1 rounded-full mb-3">
                            <span class="material-symbols-outlined text-[18px]">category</span> Jenis Event
                        </label>
                        <select name="jenis_event" class="w-full rounded-xl border border-slate-200 px-4 py-3 outline-none focus:ring-2 focus:ring-teal-500">
                            <option value="">-- Pilih Jenis Event --</option>
                            <option value="webinar" {{ old('jenis_event')=='webinar'?'selected':'' }}>Webinar</option>
                            <option value="workshop" {{ old('jenis_event')=='workshop'?'selected':'' }}>Workshop</option>
                            <option value="bootcamp" {{ old('jenis_event')=='bootcamp'?'selected':'' }}>Bootcamp</option>
                        </select>
                    </div>

                    {{-- Nama --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <label class="inline-flex items-center gap-2 text-sm font-semibold text-teal-700 bg-teal-100 px-3 py-1 rounded-full mb-3">
                            <span class="material-symbols-outlined text-[18px]">edit</span> Nama Event
                        </label>
                        <input type="text" name="nama_event" value="{{ old('nama_event') }}"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 outline-none focus:ring-2 focus:ring-teal-500" required>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <label class="inline-flex items-center gap-2 text-sm font-semibold text-teal-700 bg-teal-100 px-3 py-1 rounded-full mb-3">
                            <span class="material-symbols-outlined text-[18px]">description</span> Deskripsi Event
                        </label>
                        <textarea name="deskripsi" rows="5"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 outline-none focus:ring-2 focus:ring-teal-500" required>{{ old('deskripsi') }}</textarea>
                    </div>

                    {{-- Tanggal --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <label class="inline-flex items-center gap-2 text-sm font-semibold text-teal-700 bg-teal-100 px-3 py-1 rounded-full mb-3">
                            <span class="material-symbols-outlined text-[18px]">event</span> Tanggal Event
                        </label>
                        <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 outline-none focus:ring-2 focus:ring-teal-500" required>
                    </div>

                    {{-- Jam --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <label class="inline-flex items-center gap-2 text-sm font-semibold text-teal-700 bg-teal-100 px-3 py-1 rounded-full mb-3">
                            <span class="material-symbols-outlined text-[18px]">schedule</span> Jam Event
                        </label>
                        <input type="time" name="jam" value="{{ old('jam') }}"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 outline-none focus:ring-2 focus:ring-teal-500" required>
                    </div>

                    {{-- Lokasi --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <label class="inline-flex items-center gap-2 text-sm font-semibold text-teal-700 bg-teal-100 px-3 py-1 rounded-full mb-3">
                            <span class="material-symbols-outlined text-[18px]">location_on</span> Lokasi Event
                        </label>
                        <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 outline-none focus:ring-2 focus:ring-teal-500" required>
                    </div>

                    {{-- Harga --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <label class="inline-flex items-center gap-2 text-sm font-semibold text-teal-700 bg-teal-100 px-3 py-1 rounded-full mb-3">
                            <span class="material-symbols-outlined text-[18px]">payments</span> Harga Event
                        </label>
                        <input type="text" name="Harga" value="{{ old('Harga') }}" placeholder="Contoh: 100000 atau Gratis"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 outline-none focus:ring-2 focus:ring-teal-500" required>
                    </div>

                    {{-- Pemateri --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <label class="inline-flex items-center gap-2 text-sm font-semibold text-teal-700 bg-teal-100 px-3 py-1 rounded-full mb-3">
                            <span class="material-symbols-outlined text-[18px]">person</span> Pemateri
                            <span class="ml-2 text-xs text-slate-400 font-normal normal-case">(opsional — bisa diisi pembicara nanti)</span>
                        </label>
                        <input type="text" name="pemateri" value="{{ old('pemateri') }}"
                            placeholder="Kosongkan jika belum ada pemateri"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 outline-none focus:ring-2 focus:ring-teal-500">
                        {{-- Hapus 'required' --}}
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('penyelenggara.dashboard') }}"
                            class="px-4 py-2 bg-gray-100 font-semibold rounded-xl text-sm flex items-center gap-2 hover:bg-gray-200 transition">
                            <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali
                        </a>

                        <div class="flex gap-3">
                            {{-- Simpan sebagai Draft --}}
                            <button type="submit"
                                class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl font-semibold transition">
                                💾 Simpan Draft
                            </button>

                            {{-- Simpan & Publish --}}
                            <button type="button" onclick="checkAndPublish()"
                                class="bg-teal-900 text-white px-6 py-3 rounded-xl hover:bg-teal-700 transition font-semibold">
                                🚀 Simpan & Publish
                            </button>
                        </div>
                    </div>
                </form>
            </div>
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

    {{-- Modal Konfirmasi --}}
    <div id="modalKonfirmasi" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-full max-w-sm text-center shadow-lg">
            <h2 class="text-lg font-semibold mb-4">Simpan & Publikasikan Event?</h2>
            <div class="flex justify-center gap-4">
                <button onclick="closeConfirmModal()" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">Tidak</button>
                <button onclick="document.getElementById('eventForm').submit()"
                    class="px-4 py-2 rounded-lg bg-teal-600 text-white hover:bg-teal-700">Simpan & Publish</button>
            </div>
        </div>
    </div>

    <script>
        // LAMA — hapus semua ini:
        // BARU:
        function checkAndPublish() {
            document.getElementById('statusInput').value = 'published';
            document.getElementById('modalKonfirmasi').classList.remove('hidden');
            document.getElementById('modalKonfirmasi').classList.add('flex');
        }

        function closeConfirmModal() {
            document.getElementById('statusInput').value = 'draft'; // reset kalau batal
            document.getElementById('modalKonfirmasi').classList.remove('flex');
            document.getElementById('modalKonfirmasi').classList.add('hidden');
        }

        function previewImage(e) {
            const preview = document.getElementById('previewGambar');
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => preview.src = e.target.result;
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>

</html>