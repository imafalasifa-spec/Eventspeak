<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>EventSpeak - Create Account</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

  <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            primary: "#004253",
            background: "#f8f9fb",
            "surface-variant": "#e1e3e4",
            "on-surface": "#191c1e",
            "on-surface-variant": "#40484c",
            outline: "#70787d",
            "outline-variant": "#bfc8cc",
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
    h2 {
      font-family: 'Manrope', sans-serif;
    }

    .glass-panel {
      background: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.3);
    }
  </style>
</head>

<body class="bg-background text-on-surface overflow-x-hidden">
  <div class="min-h-screen flex items-center justify-center relative p-6">

    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
      <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[60%] bg-primary opacity-5 rounded-full blur-[120px]"></div>
      <div class="absolute bottom-[-10%] right-[-10%] w-[30%] h-[50%] bg-teal-500 opacity-5 rounded-full blur-[100px]"></div>
    </div>

    <main class="relative z-10 w-full max-w-md">
      <div class="flex flex-col items-center mb-8">
        <div class="text-3xl font-headline font-extrabold tracking-tight text-primary mb-2">
          EventSpeak
        </div>
      </div>

      <div class="bg-white glass-panel shadow-2xl rounded-3xl p-8 md:p-10 transition-all duration-300">
        <div class="mb-8 text-center md:text-left">
          <h1 class="text-2xl font-headline font-bold text-on-surface tracking-tight mb-2">
            Create Account
          </h1>
          <p class="text-on-surface-variant text-sm">
            Silakan isi data untuk membuat akun baru.
          </p>
        </div>

        {{-- Alert Error dari Session --}}
        @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded-r-xl">
          {{ session('error') }}
        </div>
        @endif

        <form action="{{ url('/register') }}" method="POST" class="space-y-6">
          @csrf{{-- WAJIB DI LARAVEL --}}

          <div class="space-y-1.5">
            <label class="block text-xs font-bold uppercase tracking-widest text-primary/80 ml-1">
              Full Name
            </label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">person</span>
              <input
                type="text"
                name="nama"
                value="{{ old('nama') }}"
                placeholder="Nama lengkap"
                required
                class="w-full bg-slate-100 border-transparent rounded-2xl py-3.5 pl-12 pr-4 text-on-surface placeholder:text-outline/60 focus:ring-2 focus:ring-primary/20 focus:bg-white focus:border-primary/30 transition-all">
            </div>
            @error('nama') <p class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p> @enderror
          </div>

          <div class="space-y-1.5">
            <label class="block text-xs font-bold uppercase tracking-widest text-primary/80 ml-1">
              Email Address
            </label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">mail</span>
              <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="name@email.com"
                required
                class="w-full bg-slate-100 border-transparent rounded-2xl py-3.5 pl-12 pr-4 text-on-surface placeholder:text-outline/60 focus:ring-2 focus:ring-primary/20 focus:bg-white focus:border-primary/30 transition-all">
            </div>
            @error('email') <p class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p> @enderror
          </div>

          <div class="space-y-1.5">
            <label class="block text-xs font-bold uppercase tracking-widest text-primary/80 ml-1">
              Password
            </label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg">lock</span>
              <input
                type="password"
                name="password"
                placeholder="••••••••"
                required
                class="w-full bg-slate-100 border-transparent rounded-2xl py-3.5 pl-12 pr-4 text-on-surface placeholder:text-outline/60 focus:ring-2 focus:ring-primary/20 focus:bg-white focus:border-primary/30 transition-all">
            </div>
            @error('password') <p class="text-red-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p> @enderror
          </div>

          <div class="pt-4">
            <button type="submit" class="w-full bg-primary text-white font-bold py-4 rounded-2xl shadow-xl shadow-primary/20 hover:bg-opacity-90 hover:-translate-y-0.5 active:scale-[0.98] transition-all">
              Daftar Sekarang
            </button>
          </div>
        </form>

        <div class="relative my-8">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-slate-100"></div>
          </div>
          <div class="relative flex justify-center text-[10px] uppercase tracking-[0.2em] font-black">
            <span class="bg-white px-4 text-slate-400">atau</span>
          </div>
        </div>

        <button type="button" class="w-full flex items-center justify-center gap-3 bg-white border border-slate-200 text-on-surface font-bold py-3.5 rounded-2xl hover:bg-slate-50 transition-all active:scale-[0.98] mb-8">
          <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
          <span class="text-sm">Daftar dengan Google</span>
        </button>

        <div class="text-center">
          <p class="text-sm text-on-surface-variant">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-primary font-bold hover:underline underline-offset-4">
              Login
            </a>
          </p>
        </div>

        <p class="mt-10 text-center text-[10px] text-slate-400 uppercase tracking-[0.3em] font-bold">
          © 2026 EventSpeak
        </p>
      </div>
    </main>
  </div>
</body>

</html>