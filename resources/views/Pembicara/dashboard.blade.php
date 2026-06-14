<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Dashboard Pembicara | EventSpeak</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#004253",
                        "primary-container": "#005b71",
                        "on-primary": "#ffffff",
                        surface: "#f8f9fb",
                        "on-surface": "#191c1e",
                        "surface-container-low": "#f2f4f6",
                        error: "#ba1a1a"
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

<body class="bg-gray-50 text-on-surface antialiased min-h-screen">

    {{-- HEADER --}}
    <header class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md shadow-sm h-20">
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
    </header>

    <div class="flex pt-20 min-h-screen">

        {{-- SIDEBAR --}}
        <aside class="h-[calc(100vh-80px)] w-64 sticky top-20 flex flex-col p-6 bg-slate-50 border-r border-slate-100">
            <div class="mb-8 px-2">
                <h2 class="font-headline font-extrabold text-xl">{{ $pembicara->nama_pembicara }}</h2>
                <p class="text-xs text-slate-500 uppercase tracking-wider">Pembicara</p>
                <p class="text-xs text-teal-600 font-semibold mt-1">{{ $pembicara->bidang_keahlian }}</p>
            </div>
            <nav class="flex-grow space-y-1">
                <a href="{{ route('pembicara.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-teal-700 font-bold bg-white rounded-lg shadow-sm text-sm">
                    <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1">mic</span><span>Speaker Hub</span>
                </a>
            </nav>
            
        </aside>

        {{-- MAIN --}}
        <main class="flex-1 pt-10 pb-12 px-8">

            {{-- Flash --}}
            @if(session('success'))
            <div class="max-w-6xl mx-auto mb-6 p-4 bg-teal-50 border border-teal-200 rounded-xl text-teal-800 flex items-center gap-3">
                <span class="material-symbols-outlined">check_circle</span>
                {{ session('success') }}
            </div>
            @endif

            {{-- Hero --}}
            <div class="max-w-6xl mx-auto mb-10">
                <div class="bg-gradient-to-r from-teal-900 to-teal-700 rounded-3xl p-10 text-white relative overflow-hidden">
                    <span class="text-xs uppercase tracking-widest bg-white/20 px-3 py-1 rounded-full font-semibold">Speaker Hub</span>
                    <h1 class="text-4xl font-extrabold mt-4 leading-tight tracking-tighter">
                        Halo, {{ $pembicara->nama_pembicara }}! 👋
                    </h1>
                    <p class="mt-3 text-white/80 max-w-xl">
                        Temukan event yang membutuhkan pembicara dan lamar sekarang. Bagikan keahlianmu kepada dunia.
                    </p>
                    <div class="absolute right-10 bottom-[-20px] opacity-20">
                        <span class="material-symbols-outlined text-[180px]">mic</span>
                    </div>
                </div>
            </div>

            {{-- Profil Card --}}
            <div class="max-w-6xl mx-auto mb-10 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm flex flex-col gap-2">
                    <p class="text-xs text-slate-400 uppercase tracking-wider">Keahlian</p>
                    <p class="font-bold text-lg text-on-surface">{{ $pembicara->bidang_keahlian }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm flex flex-col gap-2">
                    <p class="text-xs text-slate-400 uppercase tracking-wider">Topik Favorit</p>
                    <p class="font-bold text-lg text-on-surface">{{ $pembicara->topik_event }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm flex flex-col gap-2">
                    <p class="text-xs text-slate-400 uppercase tracking-wider">Event Dilamar</p>
                    <p class="font-bold text-lg text-on-surface">{{ count($eventDilamar) }}</p>
                </div>
            </div>

            {{-- Daftar Event Tersedia --}}
            <div class="max-w-6xl mx-auto">
                {{-- Event Saya Sebagai Pembicara --}}
                @if($eventSayaSebagaiPembicara->isNotEmpty())
                <div class="max-w-6xl mx-auto mb-10">
                    <h2 class="text-2xl font-extrabold tracking-tight mb-6">
                        🎤 Event Saya
                        <span class="ml-2 text-sm font-normal text-slate-400">({{ $eventSayaSebagaiPembicara->count() }} event)</span>
                    </h2>
                    <div class="space-y-5">
                        @foreach($eventSayaSebagaiPembicara as $ev)
                        <div class="bg-white rounded-2xl p-6 shadow-sm border-l-4 border-teal-500 hover:shadow-md transition-all duration-200">
                            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                                <div class="flex items-center gap-5">
                                    <a href="{{ route('event.show', $ev->id) }}" class="w-20 h-20 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0 hover:opacity-80 transition">
                                        <img src="{{ asset('upload/' . ($ev->Gambar ?? 'default.png')) }}"
                                            class="w-full h-full object-cover"
                                            onerror="this.src='https://via.placeholder.com/80'">
                                    </a>
                                    <div>
                                        <div class="flex gap-2 mb-1 flex-wrap">
                                            <span class="bg-teal-100 text-teal-700 text-[10px] px-2 py-0.5 rounded font-semibold">Published</span>
                                            <span class="bg-blue-100 text-teal-700 text-[10px] px-2 py-0.5 rounded">{{ $ev->Jenis_Event ?? '-' }}</span>
                                        </div>
                                        <a href="{{ route('event.show', $ev->id) }}" class="hover:text-teal-600 transition">
                                            <h3 class="text-lg font-bold text-on-surface">{{ $ev->Nama_Event }}</h3>
                                        </a>
                                        <div class="flex flex-wrap gap-x-5 mt-2 text-slate-400 text-xs">
                                            <div class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-sm">calendar_today</span>
                                                <span>{{ $ev->Tanggal ?? '-' }}</span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-sm">location_on</span>
                                                <span>{{ $ev->Lokasi ?? '-' }}</span>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-sm">payments</span>
                                                <span>Rp {{ number_format((int)($ev->Harga ?? 0), 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('event.show', $ev->id) }}"
                                    class="flex-shrink-0 inline-flex items-center gap-2 px-5 py-2.5 bg-teal-50 text-teal-700 border border-teal-200 rounded-xl text-sm font-semibold hover:bg-teal-100 transition">
                                    <span class="material-symbols-outlined text-sm">open_in_new</span>
                                    Lihat Event
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <h2 class="text-2xl font-extrabold tracking-tight mb-6">
                    Event Membutuhkan Pembicara
                    <span class="ml-2 text-sm font-normal text-slate-400">({{ $eventTersedia->count() }} event tersedia)</span>
                </h2>

                @if($eventTersedia->isEmpty())
                <div class="text-center py-16 bg-white rounded-2xl text-slate-400">
                    <span class="material-symbols-outlined text-6xl mb-4 block">event_available</span>
                    <p class="text-lg font-medium">Semua event sudah memiliki pembicara.</p>
                    <p class="text-sm mt-1">Pantau terus, event baru akan muncul di sini.</p>
                </div>
                @else
                <div class="space-y-5">
                    @foreach($eventTersedia as $event)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border-l-4
                        {{ in_array($event->id, $eventDilamar) ? 'border-green-400' : 'border-primary' }}
                        hover:shadow-md transition-all duration-200">
                        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">

                            {{-- Info Event --}}
                            <div class="flex items-center gap-5">
                                <div class="w-20 h-20 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                                    <img src="{{ asset('upload/' . ($event->Gambar ?? 'default.png')) }}"
                                        class="w-full h-full object-cover"
                                        onerror="this.src='https://via.placeholder.com/80'">
                                </div>
                                <div>
                                    <div class="flex gap-2 mb-1 flex-wrap">
                                        <span class="bg-orange-100 text-orange-700 text-[10px] px-2 py-0.5 rounded font-semibold">
                                            Butuh Pembicara
                                        </span>
                                        <span class="bg-blue-100 text-teal-700 text-[10px] px-2 py-0.5 rounded">
                                            {{ $event->Jenis_Event ?? '-' }}
                                        </span>
                                    </div>
                                    <h3 class="text-lg font-bold text-on-surface">{{ $event->Nama_Event }}</h3>
                                    <p class="text-slate-500 text-sm mt-0.5 line-clamp-2">{{ $event->Deskripsi ?? '' }}</p>
                                    <div class="flex flex-wrap gap-x-5 mt-2 text-slate-400 text-xs">
                                        <div class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">calendar_today</span>
                                            <span>{{ $event->Tanggal ?? '-' }}</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">location_on</span>
                                            <span>{{ $event->Lokasi ?? '-' }}</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">payments</span>
                                            <span>Rp {{ number_format((int)($event->Harga ?? 0), 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Tombol Lamar --}}
                            <div class="flex-shrink-0">
                                @if(in_array($event->id, $eventDilamar))
                                <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-100 text-green-700 rounded-xl text-sm font-semibold">
                                    <span class="material-symbols-outlined text-sm">check_circle</span>
                                    Sudah Dilamar
                                </span>
                                @else
                                <form action="{{ route('pembicara.lamar', $event->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-teal-700 to-teal-600 text-white rounded-xl text-sm font-semibold hover:opacity-90 active:scale-95 transition-all shadow-sm">
                                        <span class="material-symbols-outlined text-sm">send</span>
                                        Lamar Sekarang
                                    </button>
                                </form>
                                @endif
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
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

    {{-- Modal Logout --}}
    <div id="logoutModal" class="fixed inset-0 bg-black/40 hidden z-50">
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div id="logoutBox" class="bg-white rounded-xl p-6 w-full max-w-sm shadow-lg scale-95 opacity-0 transition duration-200">
                <h2 class="text-lg font-bold mb-2">Konfirmasi</h2>
                <p class="text-slate-600 text-sm mb-6">Anda yakin ingin keluar?</p>
                <div class="flex justify-between gap-3">
                    <button onclick="closeLogoutModal()" class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-lg">Batalkan</button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openLogoutModal() {
            document.getElementById('logoutModal').classList.remove('hidden');
            setTimeout(() => document.getElementById('logoutBox').classList.remove('scale-95', 'opacity-0'), 10);
        }

        function closeLogoutModal() {
            document.getElementById('logoutBox').classList.add('scale-95', 'opacity-0');
            setTimeout(() => document.getElementById('logoutModal').classList.add('hidden'), 200);
        }

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