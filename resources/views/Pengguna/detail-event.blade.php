<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $event->Nama_Event }} - EventSpeak</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

        body {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3,
        h4 {
            font-family: 'Manrope', sans-serif;
        }

        .editorial-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 3rem;
        }

        @media (min-width: 1024px) {
            .editorial-grid {
                grid-template-columns: 1fr 380px;
            }
        }
    </style>
</head>

<body class="bg-background text-on-surface font-body">

    {{-- NAVBAR --}}
    <nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md shadow-[0px_20px_40px_rgba(25,28,30,0.06)] h-20">
        <div class="flex justify-between items-center px-8 h-full max-w-full mx-auto">
            <div class="flex items-center gap-12">
                <a href="/" class="text-2xl font-black text-teal-900 font-headline tracking-tight">EventSpeak</a>
                <div class="hidden md:flex gap-8 items-center">
                    <a class="font-manrope text-slate-600 hover:text-teal-600 tracking-tight transition-colors" href="/">Browse</a>
                    <a class="font-manrope text-slate-600 hover:text-teal-600 tracking-tight transition-colors" href="/eksplorasi">Featured</a>
                    <a class="font-manrope text-slate-600 hover:text-teal-600 tracking-tight transition-colors" href="/schedule">Schedule</a>
                    <a class="font-manrope text-slate-600 hover:text-teal-600 tracking-tight transition-colors" href="/pembicara/registrasi">Become a Speaker</a>
                    <a class="font-manrope text-slate-600 hover:text-teal-600 tracking-tight transition-colors" href="/team">Team</a>
                </div>
            </div>
            <div class="flex items-center gap-4">
                @if(session()->has('user_id'))
                <a href="{{ route('pengguna.profil') }}"
                    style="width:40px;height:40px;border-radius:50%;overflow:hidden;display:flex;align-items:center;justify-content:center;background-color:#004253;box-shadow:0 2px 8px rgba(0,0,0,0.15);"
                    class="hover:scale-105 transition-transform">
                    @if($user && $user->foto_profil)
                    <img src="{{ asset('uploads/profil/' . $user->foto_profil) }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                    @else
                    <i class="fa-solid fa-user text-sm text-white"></i>
                    @endif
                </a>
                @else
                <a href="{{ route('login') }}" class="px-5 py-2 text-primary font-semibold hover:bg-slate-100 rounded-xl">Login</a>
                <a href="{{ route('pengguna.registrasi') }}" class="px-6 py-2 bg-primary text-white font-bold rounded-xl shadow-md hover:opacity-90">Sign Up</a>
                @endif
            </div>
        </div>
    </nav>

    {{-- HERO HEADER --}}
    <header class="relative w-full h-[614px] overflow-hidden">
        <img class="w-full h-full object-cover"
            src="{{ asset('upload/' . $event->Gambar) }}"
            alt="{{ $event->Nama_Event }}"
            onerror="this.src='https://lh3.googleusercontent.com/aida-public/AB6AXuADM6JWAR3AvTBr080eEX5ONiC3AolSKtvnwXzegWvAvGMjHBGASZQLtVI7G6uPFd-7qHRJwUbDfNCirZAuy7vHBs-F_ElrMk_l-HgymmqV3I9lFQcdoPiYyQFqAHRueSVacrEnpe1-GPEGf8vbmqyws4AImEMHiae8LS88r0Xt1CRQkcZvBBNb1-G9Zz_riXp7_1G9kWRykuxqkaGBP23nSoTx_zIEVvb2Y-PqsKp6w-P4R9YCQYgotd9hEjcsGHwR2U3CW2jopeAu'">
        <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/20 to-transparent"></div>
        <div class="absolute bottom-0 left-0 w-full p-12 lg:px-24">
            <div class="max-w-7xl mx-auto">
                <span class="inline-block px-4 py-1 bg-secondary-fixed text-on-secondary-fixed-variant text-sm font-bold rounded-full mb-6 tracking-wide uppercase">
                    {{ $event->Jenis_Event }}
                </span>
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-headline font-extrabold text-white leading-tight -ml-1 tracking-tight max-w-4xl">
                    {{ $event->Nama_Event }}
                </h1>
            </div>
        </div>
    </header>

    {{-- CONTENT --}}
    <section class="max-w-7xl mx-auto px-8 lg:px-12 py-16">
        <div class="editorial-grid">

            {{-- MAIN CONTENT (Kiri) --}}
            <div class="space-y-16">

                {{-- Tabs --}}
                <div class="flex gap-8 border-b border-outline-variant/20 pb-4">
                    <button class="text-lg font-bold text-primary border-b-2 border-primary -mb-5 pb-4">Deskripsi</button>
                </div>

                {{-- Deskripsi --}}
                <article class="prose prose-lg max-w-none text-on-surface-variant" id="description">
                    <h2 class="text-3xl font-headline font-bold text-on-surface mb-6">Tentang Event Ini</h2>
                    <p class="leading-relaxed mb-6">{{ $event->Deskripsi }}</p>
                    <div class="flex flex-wrap gap-4 mt-6">
                        <div class="flex items-center gap-2 text-on-surface-variant">
                            <span class="material-symbols-outlined text-primary">location_on</span>
                            <span class="font-medium">{{ $event->Lokasi }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-on-surface-variant">
                            <span class="material-symbols-outlined text-primary">person</span>
                            <span class="font-medium">{{ $event->Pemateri }}</span>
                        </div>
                    </div>
                </article>

                {{-- Pembicara --}}
                <section class="bg-surface-container-low rounded-xl p-8 md:p-12" id="speaker">
                    <div class="flex flex-col md:flex-row gap-10 items-start">
                        <div class="relative group">
                            <div class="absolute inset-0 bg-primary translate-x-4 translate-y-4 rounded-xl -z-10 transition-transform group-hover:translate-x-2 group-hover:translate-y-2"></div>
                            <div class="w-48 h-48 md:w-64 md:h-64 bg-primary-container rounded-xl overflow-hidden flex items-center justify-center">
                                @if($pembicara && $pembicara->foto_profil)
                                <img src="{{ asset('uploads/profil/' . $pembicara->foto_profil) }}"
                                    class="w-full h-full object-cover" alt="{{ $event->Pemateri }}">
                                @else
                                <span class="material-symbols-outlined text-on-primary-container" style="font-size:80px;">person</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-bold text-primary mb-2 uppercase tracking-widest">Pembicara Utama</h3>
                            <h4 class="text-3xl font-headline font-extrabold text-on-surface mb-4">{{ $event->Pemateri }}</h4>
                            @if($pembicara)
                            <p class="text-sm font-semibold text-teal-700 mb-2">{{ $pembicara->bidang_keahlian }}</p>
                            @endif
                            <p class="text-on-surface-variant leading-relaxed mb-6">
                                Pembicara profesional di bidang {{ $event->Jenis_Event }} yang akan memandu jalannya event ini.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Agenda --}}
                <section id="curriculum">
                    <h2 class="text-3xl font-headline font-bold text-on-surface mb-10">Detail Event</h2>
                    <div class="space-y-0 relative before:absolute before:left-[19px] before:top-4 before:bottom-4 before:w-[2px] before:bg-outline-variant/30">
                        <div class="relative pl-14 pb-12">
                            <div class="absolute left-0 top-1 w-10 h-10 bg-primary-container rounded-full flex items-center justify-center text-on-primary-container z-10">
                                <span class="material-symbols-outlined">calendar_today</span>
                            </div>
                            <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm">
                                <span class="text-sm font-bold text-primary mb-1 block">Tanggal</span>
                                <h5 class="text-xl font-bold mb-2">
                                    {{ \Carbon\Carbon::parse($event->Tanggal)->translatedFormat('l, d F Y') }}
                                </h5>
                            </div>
                        </div>
                        <div class="relative pl-14 pb-12">
                            <div class="absolute left-0 top-1 w-10 h-10 bg-white border-2 border-primary-container rounded-full flex items-center justify-center text-primary z-10">
                                <span class="material-symbols-outlined">location_on</span>
                            </div>
                            <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm">
                                <span class="text-sm font-bold text-primary mb-1 block">Lokasi</span>
                                <h5 class="text-xl font-bold mb-2">{{ $event->Lokasi }}</h5>
                            </div>
                        </div>
                        <div class="relative pl-14">
                            <div class="absolute left-0 top-1 w-10 h-10 bg-white border-2 border-primary-container rounded-full flex items-center justify-center text-primary z-10">
                                <span class="material-symbols-outlined">category</span>
                            </div>
                            <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm">
                                <span class="text-sm font-bold text-primary mb-1 block">Jenis Event</span>
                                <h5 class="text-xl font-bold mb-2 capitalize">{{ $event->Jenis_Event }}</h5>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- FAQ --}}
                <section id="faq">
                    <h2 class="text-3xl font-headline font-bold text-on-surface mb-8">Pertanyaan Umum</h2>
                    <div class="space-y-4">
                        <details class="group bg-surface rounded-xl p-6 transition-all duration-300 open:bg-surface-container">
                            <summary class="flex justify-between items-center cursor-pointer list-none">
                                <span class="text-lg font-bold">Apakah event ini cocok untuk pemula?</span>
                                <span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
                            </summary>
                            <p class="mt-4 text-on-surface-variant leading-relaxed">
                                Event ini terbuka untuk semua kalangan, baik pemula maupun yang sudah berpengalaman.
                            </p>
                        </details>
                        <details class="group bg-surface rounded-xl p-6 transition-all duration-300 open:bg-surface-container">
                            <summary class="flex justify-between items-center cursor-pointer list-none">
                                <span class="text-lg font-bold">Apakah saya akan mendapatkan sertifikat?</span>
                                <span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
                            </summary>
                            <p class="mt-4 text-on-surface-variant leading-relaxed">
                                Semua peserta yang hadir akan mendapatkan sertifikat digital setelah event selesai.
                            </p>
                        </details>
                    </div>
                </section>

            </div>

            {{-- SIDEBAR (Kanan) --}}
            <aside class="relative">
                <div class="sticky top-32 bg-surface-container-lowest rounded-xl shadow-[0px_20px_40px_rgba(25,28,30,0.06)] overflow-hidden border border-outline-variant/10">
                    <div class="p-8">
                        <div class="mb-6">
                            <span class="text-sm text-outline font-medium block mb-1">Harga Tiket</span>
                            <div class="flex items-baseline gap-2">
                                <span class="text-4xl font-headline font-black text-on-surface">
                                    {{ $event->Harga == 0 ? 'Gratis' : 'Rp ' . number_format($event->Harga, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                        <div class="space-y-4 mb-8">
                            <div class="flex items-center gap-3 text-on-surface-variant">
                                <span class="material-symbols-outlined text-primary">calendar_today</span>
                                <span class="text-sm font-medium">
                                    {{ \Carbon\Carbon::parse($event->Tanggal)->translatedFormat('l, d F Y') }}
                                </span>
                            </div>
                            <div class="flex items-center gap-3 text-on-surface-variant">
                                <span class="material-symbols-outlined text-primary">location_on</span>
                                <span class="text-sm font-medium">{{ $event->Lokasi }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-on-surface-variant">
                                <span class="material-symbols-outlined text-primary">person</span>
                                <span class="text-sm font-medium">{{ $event->Pemateri }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-on-surface-variant">
                                <span class="material-symbols-outlined text-primary">workspace_premium</span>
                                <span class="text-sm font-medium">Sertifikat Digital</span>
                            </div>
                        </div>

                        @php
                        $sudahLamar = false;
                        if($pembicaraLogin) {
                        $sudahLamar = DB::table('lamaran_pembicara')
                        ->where('id_pembicara', $pembicaraLogin->id_pembicara)
                        ->where('id_event', $event->id)
                        ->exists();
                        }
                        @endphp

                        @if($pembicaraLogin && !$sudahLamar && !$event->Pemateri)
                        <form action="{{ route('pembicara.lamar', $event->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full bg-tertiary text-on-tertiary font-headline font-bold py-4 rounded-xl shadow-lg hover:brightness-110 active:scale-95 transition-all mb-4">
                                Lamar Jadi Pembicara
                            </button>
                        </form>
                        @elseif($pembicaraLogin && $sudahLamar)
                        <div class="w-full text-center bg-teal-100 text-teal-700 font-bold py-4 rounded-xl mb-4">
                            Sudah Dilamar
                        </div>
                        @else
                        @if(session()->has('user_id'))
                        <a
                            href="{{ route('checkout', $event->id) }}"
                            class="flex items-center justify-center w-full bg-tertiary text-on-tertiary font-headline font-bold py-4 rounded-xl shadow-lg hover:brightness-110 active:scale-95 transition-all mb-4">
                            Daftar Sekarang
                        </a>
                        @else
                        <a href="{{ route('login') }}"
                            class="block w-full text-center bg-tertiary text-on-tertiary font-headline font-bold py-4 rounded-xl shadow-lg hover:brightness-110 active:scale-95 transition-all mb-4">
                            Login untuk Daftar
                        </a>
                        @endif
                        @endif

                        <a href="/eksplorasi"
                            class="block w-full text-center border border-outline-variant text-on-surface font-semibold py-3 rounded-xl hover:bg-surface-container transition-colors text-sm">
                            ← Kembali ke Event
                        </a>
                    </div>
                </div>
            </aside>

        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="w-full py-16 px-8 mt-auto bg-slate-100">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 max-w-7xl mx-auto">
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
        <div class="max-w-7xl mx-auto px-8 mt-16 pt-8 border-t border-slate-200 text-center">
            <p class="text-sm text-slate-500">© 2026 EventSpeak</p>
        </div>
    </footer>

</body>

</html>