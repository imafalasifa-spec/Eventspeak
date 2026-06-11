<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>EventSpeak - Login</title>
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
            "surface-variant": "#e1e3e4",
            "on-surface": "#191c1e",
            "on-surface-variant": "#40484c",
            outline: "#70787d",
          },
          fontFamily: {
            headline: ["Manrope"],
            body: ["Inter"],
          },
        },
      },
    };
  </script>
</head>

<body class="bg-[#f8f9fb] font-body text-on-surface overflow-x-hidden">
  <div class="min-h-screen flex items-center justify-center relative p-6">
    <main class="relative z-10 w-full max-w-md">
      <div class="flex flex-col items-center mb-4">
        <div class="text-3xl font-headline font-extrabold tracking-tight text-primary mb-2">
          EventSpeak
        </div>
      </div>

      <div class="bg-white shadow-xl rounded-xl p-8 md:p-10 transition-all">
        <div class="mb-8">
          <h1 class="text-2xl font-headline font-bold text-on-surface tracking-tight mb-2">Welcome Back</h1>
          <p class="text-on-surface-variant text-sm">Masuk untuk mengakses dashboard kamu.</p>
        </div>

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-sm">
          {{ session('error') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
          @csrf <div class="space-y-2">
            <label class="block text-xs font-bold uppercase tracking-widest text-primary/80" for="email">Email Address</label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-sm">mail</span>
              <input class="w-full bg-gray-50 border-none rounded-xl py-3 pl-10 pr-4 text-on-surface focus:ring-2 focus:ring-primary/20"
                id="email" name="email" placeholder="email@example.com" type="email" value="{{ old('email') }}" required>
            </div>
          </div>

          <div class="space-y-2">
            <label class="block text-xs font-bold uppercase tracking-widest text-primary/80" for="password">Password</label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-sm">lock</span>
              <input class="w-full bg-gray-50 border-none rounded-xl py-3 pl-10 pr-4 text-on-surface focus:ring-2 focus:ring-primary/20"
                id="password" name="password" placeholder="••••••••" type="password" required>
            </div>
          </div>

          <button type="submit" class="w-full bg-primary text-white font-bold py-4 rounded-xl shadow-lg hover:opacity-90 transition-all">
            Login
          </button>
        </form>

        <div class="relative my-8 text-center text-xs uppercase tracking-widest font-bold">
          <span class="text-outline/60">atau</span>
        </div>

        <div class="text-center">
          <p class="text-sm">
            Belum punya akun?
            <a href="{{ route('pengguna.registrasi') }}" class="text-primary font-bold">Daftar di sini</a>
          </p>
        </div>
      </div>
    </main>
  </div>
</body>

</html>