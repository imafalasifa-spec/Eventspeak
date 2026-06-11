<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Tiket - {{ $peserta->Nama_Event }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3 {
            font-family: 'Manrope', sans-serif;
        }

        @media print {

            .no-print,
            .footer {
                display: none !important;
            }

            body {
                background: white;
            }
        }
    </style>
</head>

<body class="bg-slate-100 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 py-10">

        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold text-teal-900">Pendaftaran Berhasil 🎉</h1>
            <p class="text-slate-500 mt-2">Tiket digital Anda telah berhasil dibuat</p>
        </div>

        @php
        // Deteksi online: kolom Lokasi berisi kata "online"
        $isOnline = strtolower(trim($peserta->Lokasi)) === 'online'
        || str_contains(strtolower($peserta->Lokasi), 'online');

        // nomor_tiket sudah menyimpan link GMeet (online) atau kode numerik (offline)
        $nomorTiket = $peserta->nomor_tiket;
        @endphp

        <div class="bg-white rounded-3xl overflow-hidden shadow-2xl">

            {{-- Header Tiket --}}
            <div class="{{ $isOnline ? 'bg-teal-900' : 'bg-teal-900' }} text-white p-8">
                <div class="flex justify-between items-center flex-wrap gap-4">
                    <div>
                        <p class="text-sm uppercase tracking-widest opacity-80">EventSpeak E-Ticket</p>
                        <h2 class="text-3xl font-bold mt-2">{{ $peserta->Nama_Event }}</h2>
                    </div>
                    <div class="text-right">
                        @if($isOnline)
                        <p class="text-sm opacity-80">Mode Event</p>
                        <span class="inline-block mt-1 px-4 py-1.5 bg-white/20 rounded-full text-sm font-bold">
                            🌐 Online
                        </span>
                        @else
                        <p class="text-sm opacity-80">Nomor Tiket</p>
                        <h3 class="text-2xl font-black tracking-widest mt-1">{{ $nomorTiket }}</h3>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Isi Tiket --}}
            <div class="p-8">
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="space-y-5">
                        <div>
                            <p class="text-slate-500 text-sm">Nama Peserta</p>
                            <p class="font-bold text-lg">{{ $peserta->nama_user }}</p>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm">Email</p>
                            <p class="font-semibold">{{ $peserta->email_user }}</p>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm">WhatsApp</p>
                            <p class="font-semibold">{{ $peserta->no_wa }}</p>
                        </div>
                    </div>
                    <div class="space-y-5">
                        <div>
                            <p class="text-slate-500 text-sm">Tanggal Event</p>
                            <p class="font-semibold text-lg">
                                {{ \Carbon\Carbon::parse($peserta->Tanggal)->translatedFormat('l, d F Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm">Lokasi</p>
                            <p class="font-semibold">
                                @if($isOnline) Online (Google Meet)
                                @else {{ $peserta->Lokasi }}
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-slate-500 text-sm">Metode Pembayaran</p>
                            <p class="font-semibold uppercase">{{ $peserta->metode_bayar }}</p>
                        </div>
                    </div>
                </div>

                {{-- Bagian utama tiket: beda tampilan online vs offline --}}
                <div class="mt-10 border-t pt-8 text-center">
                    @if($isOnline)
                    {{-- EVENT ONLINE: tampilkan link GMeet yang tersimpan di nomor_tiket --}}
                    <p class="text-slate-500 text-sm mb-4">
                        Gunakan link berikut untuk bergabung ke event
                    </p>
                    <div class="inline-block bg-teal-50 border-2 border-teal-200 px-8 py-6 rounded-2xl max-w-xl w-full">
                        <p class="text-sm text-teal-400 font-semibold mb-3">🔗 Link Google Meet</p>
                        <a
                            href="{{ $nomorTiket }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-base font-bold text-teal-700 hover:text-teal-900 break-all underline underline-offset-4">
                            {{ $nomorTiket }}
                        </a>
                        <p class="text-xs text-slate-400 mt-3">
                            Link ini unik untuk Anda. Jangan dibagikan ke orang lain.
                        </p>
                    </div>
                    <div class="mt-5 no-print">
                        <a
                            href="{{ $nomorTiket }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-teal-700 text-white font-bold rounded-xl hover:bg-teal-800 transition">
                            🚀 Bergabung ke Meet
                        </a>
                    </div>

                    @else
                    {{-- EVENT OFFLINE: tampilkan kode numerik untuk ditunjukkan ke panitia --}}
                    <p class="text-slate-500 text-sm mb-2">
                        Tunjukkan kode tiket ini kepada panitia di lokasi event
                    </p>
                    <div class="inline-block bg-slate-100 px-8 py-5 rounded-2xl">
                        <p class="text-sm text-slate-500 mb-1">Kode Tiket</p>
                        <p class="text-3xl md:text-4xl font-black tracking-widest text-teal-900">
                            {{ $nomorTiket }}
                        </p>
                    </div>
                    <p class="text-xs text-slate-400 mt-3">
                        Panitia akan memverifikasi kode ini di lokasi event.
                    </p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Tombol --}}
        <div class="flex flex-wrap gap-4 justify-center mt-8 no-print">
            <button onclick="window.print()" class="px-8 py-3 bg-teal-900 text-white rounded-xl font-bold hover:opacity-90">
                🖨 Cetak Tiket
            </button>
            <a href="{{ route('pengguna.index') }}" class="px-8 py-3 border border-slate-300 bg-white rounded-xl font-bold hover:bg-slate-50">
                ← Kembali ke Beranda
            </a>
        </div>

        <div class="footer text-center mt-8 text-slate-500 text-sm">
            © {{ date('Y') }} EventSpeak
        </div>

    </div>
</body>

</html>