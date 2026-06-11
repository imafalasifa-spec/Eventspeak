<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Daftar Pembicara | EventSpeak</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#004253",
                        "on-primary": "#ffffff",
                        "surface-variant": "#e1e3e4",
                        "on-surface": "#191c1e",
                        "outline-variant": "#bfc8cc",
                        surface: "#f8f9fb"
                    },
                    fontFamily: {
                        headline: ["Manrope"],
                        body: ["Inter"]
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

        .editorial-gradient {
            background: linear-gradient(135deg, #004253 0%, #005b71 100%);
        }
    </style>
</head>

<body class="bg-surface font-body text-on-surface overflow-x-hidden">

    {{-- NAVBAR --}}
    <nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md shadow-[0px_20px_40px_rgba(25,28,30,0.06)] h-20">
        <div class="flex justify-between items-center px-8 h-full">
            <div class="flex items-center gap-12">
                <span class="text-2xl font-black text-teal-900 font-headline tracking-tight">EventSpeak</span>
                <div class="hidden md:flex gap-8 items-center">
                    <a class="text-slate-600 hover:text-teal-600 transition-colors" href="{{ route('pengguna.index') }}">Browse</a>
                    <a class="text-slate-600 hover:text-teal-600 transition-colors" href="{{ route('pengguna.eksplorasi') }}">Event</a>
                    <a class="text-slate-600 hover:text-teal-600 transition-colors" href="{{ route('pengguna.schedule') }}">Schedule</a>
                    <a class="text-teal-700 border-b-2 border-teal-700 pb-1 font-semibold" href="{{ route('pembicara.index') }}">Become a Speaker</a>
                    <a class="text-slate-600 hover:text-teal-600 transition-colors" href="{{ route('pengguna.team') }}">Team</a>
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

    <div class="min-h-screen flex items-center justify-center relative p-6 pt-28">

        {{-- Background blur --}}
        <div class="absolute inset-0 z-0 overflow-hidden">
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[60%] editorial-gradient opacity-10 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[30%] h-[50%] bg-red-700 opacity-5 rounded-full blur-[100px]"></div>
        </div>

        <main class="relative z-10 w-full max-w-md">
            <div class="flex flex-col items-center mb-4">
                <div class="text-3xl font-headline font-extrabold tracking-tight text-primary mb-2">EventSpeak</div>
            </div>

            <div class="bg-white/80 backdrop-blur-md shadow-[0px_20px_40px_rgba(25,28,30,0.06)] rounded-xl p-8 md:p-10">
                <div class="mb-8">
                    <h1 class="text-2xl font-headline font-bold tracking-tight mb-2">Daftar Sebagai Pembicara</h1>
                    <p class="text-slate-500 text-sm">Isi informasi Anda untuk bergabung sebagai pembicara di EventSpeak.</p>
                </div>

                {{-- Error --}}
                @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm space-y-1">
                    @foreach($errors->all() as $error)<p>• {{ $error }}</p>@endforeach
                </div>
                @endif

                {{-- Success --}}
                @if(session('success'))
                <div class="mb-6 p-4 bg-teal-50 border border-teal-200 rounded-xl text-teal-800 text-sm">
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('pembicara.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- Nama --}}
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-widest text-primary/80">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama', $user->nama_user ?? '') }}" required
                            placeholder="Nama lengkap"
                            class="w-full bg-slate-100/60 border-none rounded-xl py-3 px-4 focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    </div>

                    {{-- Email --}}
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-widest text-primary/80">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email_user ?? '') }}" required
                            placeholder="email@gmail.com"
                            class="w-full bg-slate-100/60 border-none rounded-xl py-3 px-4 focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    </div>

                    {{-- LinkedIn --}}
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-widest text-primary/80">LinkedIn</label>
                        <input type="url" name="linkedin" value="{{ old('linkedin') }}"
                            placeholder="https://linkedin.com/in/username"
                            class="w-full bg-slate-100/60 border-none rounded-xl py-3 px-4 focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    </div>

                    {{-- Keahlian --}}
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-widest text-primary/80">Bidang Keahlian</label>
                        <input type="text" name="keahlian" value="{{ old('keahlian') }}" required
                            placeholder="Contoh: Web Developer, UI/UX Designer"
                            class="w-full bg-slate-100/60 border-none rounded-xl py-3 px-4 focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    </div>

                    {{-- Jenis Event --}}
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-widest text-primary/80">Jenis Event</label>
                        <select name="jenis_event" required
                            class="w-full bg-slate-100/60 border-none rounded-xl py-3 px-4 focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                            <option value="">Pilih Jenis Event</option>
                            <option value="Webinar" {{ old('jenis_event')=='Webinar'?'selected':'' }}>Webinar</option>
                            <option value="Workshop" {{ old('jenis_event')=='Workshop'?'selected':'' }}>Workshop</option>
                            <option value="Bootcamp" {{ old('jenis_event')=='Bootcamp'?'selected':'' }}>Bootcamp</option>
                        </select>
                    </div>

                    {{-- Topik Event --}}
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-widest text-primary/80">Topik Event</label>
                        <select name="topik_event" required
                            class="w-full bg-slate-100/60 border-none rounded-xl py-3 px-4 focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                            <option value="">Pilih Topik</option>
                            <option value="Web Development" {{ old('topik_event')=='Web Development'?'selected':'' }}>Web Development</option>
                            <option value="UI/UX" {{ old('topik_event')=='UI/UX'?'selected':'' }}>UI/UX</option>
                            <option value="Data Science" {{ old('topik_event')=='Data Science'?'selected':'' }}>Data Science</option>
                            <option value="Digital Marketing" {{ old('topik_event')=='Digital Marketing'?'selected':'' }}>Digital Marketing</option>
                            <option value="Mobile Development" {{ old('topik_event')=='Mobile Development'?'selected':'' }}>Mobile Development</option>
                        </select>
                    </div>

                    {{-- Pengalaman --}}
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-widest text-primary/80">Pengalaman</label>
                        <textarea name="pengalaman" rows="3"
                            placeholder="Ceritakan pengalaman Anda sebagai pembicara..."
                            class="w-full bg-slate-100/60 border-none rounded-xl py-3 px-4 focus:ring-2 focus:ring-primary/20 outline-none transition-all">{{ old('pengalaman') }}</textarea>
                    </div>

                    {{-- Portofolio --}}
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-widest text-primary/80">Upload Portofolio</label>
                        <input type="file" name="portofolio" required
                            class="w-full bg-slate-100/60 border-none rounded-xl py-3 px-4 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary file:text-white hover:file:opacity-80">
                    </div>

                    <button type="submit"
                        class="w-full editorial-gradient text-white font-headline font-bold py-4 rounded-xl shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all">
                        Daftar Menjadi Pembicara
                    </button>
                </form>

                <p class="mt-8 text-center text-[10px] text-slate-400 uppercase tracking-[0.2em] font-bold">© 2026 EventSpeak</p>
            </div>
        </main>
    </div>
</body>

</html>