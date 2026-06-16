<!DOCTYPE html>
<html lang="id">

<head>
    <title>Daftar Event - {{ $event->Nama_Event }}</title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#004253",
                        surface: "#f8f9fb",
                        "on-surface": "#191c1e",
                    },
                    fontFamily: {
                        headline: ["Manrope"],
                        body: ["Inter"],
                    }
                }
            }
        };
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3,
        h4 {
            font-family: 'Manrope', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .method-card {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .method-card:hover {
            border-color: #004253;
            background: #f0f9ff;
        }

        .method-card.selected {
            border-color: #004253;
            background: #e0f2fe;
            box-shadow: 0 0 0 2px #004253;
        }

        .method-card.selected .method-radio {
            background: #004253;
            border-color: #004253;
        }

        .method-card.selected .method-radio::after {
            display: block;
        }

        .method-radio {
            width: 20px;
            height: 20px;
            border: 2px solid #cbd5e1;
            border-radius: 50%;
            position: relative;
            flex-shrink: 0;
            transition: all 0.2s;
        }

        .method-radio::after {
            content: '';
            display: none;
            width: 10px;
            height: 10px;
            background: white;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-up {
            animation: slideUp 0.4s ease forwards;
        }

        .struk-border {
            border: 2px dashed #cbd5e1;
        }

        .struk-border::before,
        .struk-border::after {
            content: '';
            position: absolute;
            width: 24px;
            height: 24px;
            background: #f8f9fb;
            border-radius: 50%;
        }

        .divider-ticket {
            position: relative;
            overflow: visible;
        }

        .divider-ticket::before {
            content: '';
            position: absolute;
            left: -20px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            background: #f8f9fb;
            border-radius: 50%;
            border: 2px solid #e2e8f0;
            border-left: none;
        }

        .divider-ticket::after {
            content: '';
            position: absolute;
            right: -20px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            background: #f8f9fb;
            border-radius: 50%;
            border: 2px solid #e2e8f0;
            border-right: none;
        }
    </style>
</head>

<body class="bg-surface text-on-surface min-h-screen">

    {{-- NAVBAR --}}
    <nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md shadow-sm h-16">
        <div class="flex justify-between items-center px-8 h-full max-w-7xl mx-auto">
            <a href="/pengguna/index" class="text-xl font-black text-primary tracking-tight">EventSpeak</a>
            <a href="/pengguna/index" class="flex items-center gap-2 text-sm text-slate-500 hover:text-primary transition">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Kembali
            </a>
        </div>
    </nav>

    <div class="pt-24 pb-16 px-4 max-w-5xl mx-auto">

        {{-- STEP INDICATOR --}}
        <div class="flex items-center justify-center gap-3 mb-10">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-primary text-white text-xs font-bold flex items-center justify-center">1</div>
                <span class="text-sm font-semibold text-primary">Detail Peserta</span>
            </div>
            <div class="w-12 h-0.5 bg-slate-200"></div>
            <div class="flex items-center gap-2" id="step2-indicator">
                <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-400 text-xs font-bold flex items-center justify-center" id="step2-circle">2</div>
                <span class="text-sm text-slate-400" id="step2-text">Pembayaran</span>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

            {{-- KIRI: Form & Pembayaran --}}
            <div class="lg:col-span-3 space-y-6">

                {{-- STEP 1: Detail Peserta --}}
                <div id="step1" class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 slide-up">
                    <h2 class="text-lg font-bold mb-5 flex items-center gap-2">
                        <span class="w-7 h-7 rounded-full bg-primary text-white text-xs font-bold flex items-center justify-center">1</span>
                        Detail Peserta
                    </h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-1.5">Nama Lengkap</label>
                            <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 font-medium flex items-center gap-2">
                                <span class="material-symbols-outlined text-slate-400 text-sm">person</span>
                                {{ $user->nama_user }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-1.5">Email</label>
                            <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 font-medium flex items-center gap-2">
                                <span class="material-symbols-outlined text-slate-400 text-sm">mail</span>
                                {{ $user->email_user }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-1.5">Nomor WhatsApp</label>
                            @if($user->no_wa)
                            {{-- Sudah ada di profil → tampil read only --}}
                            <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 font-medium flex items-center gap-2">
                                <span class="material-symbols-outlined text-slate-400 text-sm">smartphone</span>
                                {{ $user->no_wa }}
                            </div>
                            <input type="hidden" id="no_wa" value="{{ $user->no_wa }}">
                            @else
                            {{-- Belum ada → wajib isi --}}
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-sm">smartphone</span>
                                <input type="tel" id="no_wa" placeholder="Contoh: 08123456789" required
                                    class="w-full bg-white border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-sm outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                            </div>
                            <p class="text-xs text-amber-600 mt-1 flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">info</span>
                                Nomor WhatsApp belum diisi di profil. Silakan isi di sini.
                            </p>
                            @endif
                        </div>
                        <button onclick="goToStep2()" class="w-full py-3.5 bg-primary text-white font-bold rounded-xl hover:bg-teal-800 transition mt-2">
                            Lanjut ke Pembayaran →
                        </button>
                    </div>
                </div>

                {{-- STEP 2: Metode Pembayaran --}}
                <div id="step2" class="hidden bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                    <h2 class="text-lg font-bold mb-5 flex items-center gap-2">
                        <span class="w-7 h-7 rounded-full bg-primary text-white text-xs font-bold flex items-center justify-center">2</span>
                        Metode Pembayaran
                    </h2>

                    @if($event->Harga == 0)
                    {{-- GRATIS --}}
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3 mb-4">
                        <span class="material-symbols-outlined text-green-600">check_circle</span>
                        <div>
                            <p class="font-bold text-green-700">Event Gratis!</p>
                            <p class="text-sm text-green-600">Tidak ada biaya pendaftaran untuk event ini.</p>
                        </div>
                    </div>
                    <input type="hidden" id="metode_pembayaran" value="gratis">
                    <button onclick="daftarSekarang()" class="w-full py-3.5 bg-primary text-white font-bold rounded-xl hover:bg-teal-800 transition">
                        Daftar Sekarang →
                    </button>
                    @else
                    {{-- BERBAYAR --}}
                    <p class="text-sm text-slate-500 mb-4">Pilih metode pembayaran untuk melanjutkan</p>
                    <div class="space-y-3 mb-6">

                        {{-- QRIS --}}
                        <div class="method-card border-2 border-slate-200 rounded-xl p-4 flex items-center gap-4" onclick="selectMethod(this, 'qris')">
                            <div class="method-radio"></div>
                            <div class="w-12 h-12 bg-slate-50 rounded-lg flex items-center justify-center border border-slate-100">
                                <svg viewBox="0 0 40 40" class="w-8 h-8">
                                    <rect x="2" y="2" width="16" height="16" rx="2" fill="none" stroke="#004253" stroke-width="2" />
                                    <rect x="6" y="6" width="8" height="8" rx="1" fill="#004253" />
                                    <rect x="22" y="2" width="16" height="16" rx="2" fill="none" stroke="#004253" stroke-width="2" />
                                    <rect x="26" y="6" width="8" height="8" rx="1" fill="#004253" />
                                    <rect x="2" y="22" width="16" height="16" rx="2" fill="none" stroke="#004253" stroke-width="2" />
                                    <rect x="6" y="26" width="8" height="8" rx="1" fill="#004253" />
                                    <rect x="22" y="22" width="4" height="4" fill="#004253" />
                                    <rect x="28" y="22" width="4" height="4" fill="#004253" />
                                    <rect x="34" y="22" width="4" height="4" fill="#004253" />
                                    <rect x="22" y="28" width="4" height="4" fill="#004253" />
                                    <rect x="28" y="28" width="10" height="10" rx="1" fill="#004253" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-slate-800">QRIS</p>
                                <p class="text-xs text-slate-500">Scan QR dari semua aplikasi e-wallet</p>
                            </div>
                            <span class="text-xs bg-green-100 text-green-700 font-bold px-2 py-0.5 rounded-full">Instan</span>
                        </div>

                        {{-- TRANSFER BANK --}}
                        <div class="method-card border-2 border-slate-200 rounded-xl p-4" onclick="selectMethod(this, 'transfer_bank')">
                            <div class="flex items-center gap-4">
                                <div class="method-radio"></div>
                                <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center border border-orange-100">
                                    <span class="material-symbols-outlined text-orange-600">account_balance</span>
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-slate-800">Transfer Bank</p>
                                    <p class="text-xs text-slate-500">BCA, BNI, BRI, Mandiri</p>
                                </div>
                                <span class="text-xs bg-orange-100 text-orange-700 font-bold px-2 py-0.5 rounded-full">Manual</span>
                            </div>
                            {{-- Detail Rekening (tersembunyi) --}}
                            <div id="bank-detail" class="hidden mt-4 pt-4 border-t border-slate-100 space-y-2">
                                <p class="text-xs font-bold text-slate-400 uppercase">Rekening Tujuan</p>
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    <div class="bg-slate-50 rounded-lg p-3">
                                        <p class="text-xs text-slate-400">BCA</p>
                                        <p class="font-bold">1234567890</p>
                                        <p class="text-xs text-slate-500">a.n. EventSpeak</p>
                                    </div>
                                    <div class="bg-slate-50 rounded-lg p-3">
                                        <p class="text-xs text-slate-400">BNI</p>
                                        <p class="font-bold">0987654321</p>
                                        <p class="text-xs text-slate-500">a.n. EventSpeak</p>
                                    </div>
                                </div>
                                <p class="text-xs text-amber-600 bg-amber-50 rounded-lg p-2 flex items-start gap-1">
                                    <span class="material-symbols-outlined text-sm mt-0.5">info</span>
                                    Transfer sesuai nominal tepat. Konfirmasi akan diverifikasi dalam 1x24 jam.
                                </p>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="metode_pembayaran" value="">
                    <p id="method-error" class="text-red-500 text-xs mb-3 hidden">Pilih metode pembayaran terlebih dahulu.</p>
                    <button onclick="daftarSekarang()" class="w-full py-3.5 bg-primary text-white font-bold rounded-xl hover:bg-teal-800 transition">
                        Daftar Sekarang →
                    </button>
                    @endif
                </div>

            </div>

            {{-- KANAN: Ringkasan Event --}}
            <div class="lg:col-span-2">
                <div class="sticky top-24 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    {{-- Gambar Event --}}
                    <div class="h-40 overflow-hidden relative">
                        <img src="{{ asset('upload/' . $event->Gambar) }}" class="w-full h-full object-cover"
                            onerror="this.src='https://via.placeholder.com/400x200/004253/ffffff?text=EventSpeak'">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <span class="absolute bottom-3 left-3 text-xs bg-white/90 text-primary font-bold px-3 py-1 rounded-full">
                            {{ $event->Jenis_Event }}
                        </span>
                    </div>

                    <div class="p-5 space-y-4">
                        <h3 class="font-extrabold text-slate-800 leading-tight">{{ $event->Nama_Event }}</h3>

                        <div class="space-y-2.5">
                            <div class="flex items-center gap-2.5 text-sm text-slate-600">
                                <span class="material-symbols-outlined text-primary text-base">calendar_today</span>
                                {{ \Carbon\Carbon::parse($event->Tanggal)->translatedFormat('l, d F Y') }}
                            </div>
                            <div class="flex items-center gap-2.5 text-sm text-slate-600">
                                <span class="material-symbols-outlined text-primary text-base">location_on</span>
                                {{ $event->Lokasi }}
                            </div>
                            @if($event->Pemateri)
                            <div class="flex items-center gap-2.5 text-sm text-slate-600">
                                <span class="material-symbols-outlined text-primary text-base">person</span>
                                {{ $event->Pemateri }}
                            </div>
                            @endif
                        </div>

                        <div class="border-t pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-500">Harga Tiket</span>
                                <span class="text-xl font-extrabold text-primary">
                                    {{ $event->Harga == 0 ? 'Gratis' : 'Rp ' . number_format($event->Harga, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        {{-- Status Pendaftaran (setelah berhasil) --}}
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Form hidden untuk submit ke server --}}
    <form id="form-daftar" action="{{ route('peserta.daftar', $event->id) }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="id_event" value="{{ $event->id }}">
        <input type="hidden" name="no_wa" id="form-no-wa">
        <input type="hidden" name="metode_bayar" id="form-metode-bayar">
        <input type="hidden" name="nomor_tiket" id="form-nomor-tiket">
        <input type="hidden" name="status_pembayaran" id="statusPembayaran" value="pending">
    </form>

    {{-- Modal QRIS --}}
    <div id="modalQris" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl p-6 max-w-sm w-full text-center relative">
            <button onclick="bayarPending()"
                class="absolute top-3 right-3 text-slate-400">
                ✕
            </button>
            <h3 class="font-bold text-lg mb-2">Scan QRIS untuk Membayar</h3>
            <p class="text-sm text-slate-500 mb-4">Total: Rp {{ number_format($event->Harga, 0, ',', '.') }}</p>
            <img src="{{ asset('upload/qris.png') }}" class="w-full rounded-lg border" alt="QRIS">
            <p class="text-xs text-slate-400 mt-3">Setelah bayar, klik konfirmasi di bawah</p>
            <button onclick="bayarBerhasil()"
                class="w-full mt-4 py-3 bg-primary text-white rounded-xl font-bold">
                Selesaikan Pembayaran
            </button>
            <button onclick="bayarBatal()"
                class="w-full mt-2 py-3 border rounded-xl font-bold">
                Batal
            </button>
        </div>
    </div>

    {{-- Modal Transfer --}}
    <div id="modalTransfer" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl p-6 max-w-sm w-full text-center relative">

            <button onclick="bayarPending()"
                class="absolute top-3 right-3 text-slate-400">
                ✕
            </button>

            <h3 class="font-bold text-lg mb-4">
                Transfer Bank
            </h3>

            <div class="bg-slate-50 rounded-lg p-3 mb-3 text-left">
                <p class="text-xs text-slate-400">BCA</p>
                <p class="font-bold">1234567890</p>
                <p class="text-xs">a.n. EventSpeak</p>
            </div>

            <div class="bg-slate-50 rounded-lg p-3 mb-4 text-left">
                <p class="text-xs text-slate-400">BNI</p>
                <p class="font-bold">0987654321</p>
                <p class="text-xs">a.n. EventSpeak</p>
            </div>

            <button onclick="bayarBerhasil()"
                class="w-full py-3 bg-primary text-white rounded-xl font-bold">
                Selesaikan Pembayaran
            </button>

            <button onclick="bayarBatal()"
                class="w-full mt-2 py-3 border rounded-xl font-bold">
                Batal
            </button>

        </div>
    </div>


    <script>
        let selectedMethod = '';
        let nomorTiket = '';

        const lokasi = "{{ strtolower(trim($event->Lokasi)) }}";
        const isOnline = lokasi === 'online' || lokasi.includes('online');

        function generateKodeOffline() {
            return String(Math.floor(1000000000 + Math.random() * 9000000000));
        }

        function generateLinkMeet() {
            const chars = 'abcdefghijklmnopqrstuvwxyz';
            const rand = (n) => Array.from({
                length: n
            }, () => chars[Math.floor(Math.random() * chars.length)]).join('');
            return 'https://meet.google.com/' + rand(3) + '-' + rand(4) + '-' + rand(3);
        }

        nomorTiket = isOnline ? generateLinkMeet() : generateKodeOffline();

        function goToStep2() {
            const noWa = document.getElementById('no_wa').value.trim();
            if (!noWa) {
                document.getElementById('no_wa').classList.add('border-red-400', 'ring-2', 'ring-red-200');
                document.getElementById('no_wa').focus();
                return;
            }
            document.getElementById('no_wa').classList.remove('border-red-400', 'ring-2', 'ring-red-200');
            document.getElementById('step2-circle').classList.remove('bg-slate-200', 'text-slate-400');
            document.getElementById('step2-circle').classList.add('bg-primary', 'text-white');
            document.getElementById('step2-text').classList.remove('text-slate-400');
            document.getElementById('step2-text').classList.add('text-primary', 'font-semibold');
            document.getElementById('step2').classList.remove('hidden');
            document.getElementById('step2').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        function selectMethod(el, method) {
            document.querySelectorAll('.method-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            document.getElementById('metode_pembayaran').value = method;
            const bankDetail = document.getElementById('bank-detail');
            if (bankDetail) bankDetail.classList.toggle('hidden', method !== 'transfer_bank');
        }

        function daftarSekarang() {
            const metode = document.getElementById('metode_pembayaran').value;
            const noWaInput = document.getElementById('no_wa');
            const noWa = noWaInput ? noWaInput.value.trim() : '';

            if (!noWa) {
                noWaInput.classList.add('border-red-400', 'ring-2', 'ring-red-200');
                noWaInput.focus();
                return;
            }

            if (!metode) {
                const errEl = document.getElementById('method-error');
                if (errEl) errEl.classList.remove('hidden');
                return;
            }

            document.getElementById('form-no-wa').value = noWa;
            document.getElementById('form-metode-bayar').value = metode;
            document.getElementById('form-nomor-tiket').value = nomorTiket;

            if (metode === 'gratis') {
                document.getElementById('statusPembayaran').value = 'berhasil';
                document.getElementById('form-daftar').submit();
                return;
            }

            if (metode === 'qris') {
                document.getElementById('modalQris').classList.remove('hidden');
                return;
            }

            if (metode === 'transfer_bank') {
                document.getElementById('modalTransfer').classList.remove('hidden');
                return;
            }
        }

        function bayarBerhasil() {
            document.getElementById('statusPembayaran').value = 'berhasil';
            document.getElementById('form-daftar').submit();
        }

        function bayarPending() {
            document.getElementById('statusPembayaran').value = 'pending';
            document.getElementById('form-daftar').submit();
        }

        // Tombol "Batal" → simpan dengan status 'batal'
        function bayarBatal() {
            document.getElementById('statusPembayaran').value = 'batal';
            document.getElementById('form-daftar').submit();
        }
    </script>
</body>

</html>