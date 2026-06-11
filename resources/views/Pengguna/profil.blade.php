@php
    use Illuminate\Support\Facades\DB;

    // 1. Ambil session
    $userId = session('user_id');

    // 2. Ambil data user & cek organizer (Hanya jika userId ada)
    $user = null;
    $isOrganizer = false;

    if ($userId) {
        $user = DB::table('user')->where('id_user', $userId)->first();
        $isOrganizer = DB::table('penyelenggara')->where('id_user', $userId)->exists();
    }
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
  <title>EventSpeak - Profil</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap">
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#004253",
            surface: "#f8f9fb",
            "on-surface": "#191c1e",
            "on-background": "#191c1e",
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

<body class="bg-surface text-on-surface min-h-screen">
  <nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md shadow-sm h-20">
    <div class="flex justify-between items-center px-8 h-full max-w-full mx-auto">
      <div class="flex items-center gap-12">
        <a href="{{ route('pengguna.index') }}" class="text-2xl font-black text-primary tracking-tight">EventSpeak</a>
        <div class="hidden md:flex gap-8 items-center text-slate-600">
          <a class="font-manrope text-slate-600 hover:text-teal-600 tracking-tight transition-colors" href="/">Browse</a>
          <a class="font-manrope text-slate-600 hover:text-teal-600 tracking-tight transition-colors" href="/eksplorasi">Event</a>
          <a class="font-manrope text-slate-600 hover:text-teal-600 tracking-tight transition-colors" href="/schedule">Schedule</a>
          <a class="font-manrope text-slate-600 hover:text-teal-600 tracking-tight transition-colors" href="/pembicara/daftar">Become a Speaker</a>
          <a class="font-manrope text-slate-600 hover:text-teal-600 tracking-tight transition-colors" href="/team">Team</a>
        </div>
      </div>

      <div class="flex items-center gap-4">
        {{-- Avatar Default Native Style --}}
        <div class="flex items-center gap-4">
          {{-- Avatar Kecil untuk Navigasi --}}
          {{-- Navigasi Atas --}}
          <a href="{{ route('pengguna.profil') }}" class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white shadow-md overflow-hidden hover:scale-105 transition-transform">
            @if($user && $user->foto_profil)
            {{-- Path ke storage --}}
            <img src="{{ asset('uploads/profil/' . $user->foto_profil) }}" class="w-full h-full object-cover">
            @else
            <i class="fa-solid fa-user text-sm"></i>
            @endif
          </a>
        </div>
      </div>
    </div>
  </nav>

  <div class="flex pt-20 h-screen overflow-hidden">
    <aside id="sidebar" class="w-64 bg-slate-50 border-r border-slate-100 p-6 flex flex-col justify-between">
      <div class="flex-1">
        <div class="mb-8 px-2">
          <h2 class="font-extrabold text-xl text-on-background">{{ $user->nama_user ?? 'User' }}</h2>
          <p class="font-body text-xs font-semibold text-teal-700 tracking-wider uppercase">Pengguna</p>
        </div>

        <div class="flex flex-col gap-1">
          <a class="flex items-center gap-3 px-4 py-3 text-teal-700 font-bold bg-white rounded-lg shadow-sm text-sm" href="{{ route('penyelenggara.dashboard') }}">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">person</span>
            <span>Profil</span>
          </a>

          @if($isOrganizer)
          <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-teal-50 hover:text-primary transition" href="{{ route('penyelenggara.dashboard') }}">
            <span class="material-symbols-outlined">stars</span>
            <span class="text-sm font-bold">Dashboard Penyelenggara</span>
          </a>
          @else
          <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-100 transition" href="{{ route('penyelenggara.index') }}">
            <span class="material-symbols-outlined">stars</span>
            <span class="text-sm">Menjadi Penyelenggara</span>
          </a>
          @endif
        </div>
      </div>

      <div class="pt-6 border-t border-slate-200 flex flex-col gap-2">
        <a class="flex items-center gap-3 px-4 py-2 text-slate-500 hover:bg-slate-100 rounded-lg text-sm transition" href="#">
          <span class="material-symbols-outlined">help</span>
          <span>Help Center</span>
        </a>
        <button type="button" onclick="openModal()" class="flex items-center gap-3 px-4 py-2 text-red-500 hover:bg-red-50 rounded-lg text-sm transition">
          <span class="material-symbols-outlined">logout</span>
          <span>Sign Out</span>
        </button>
      </div>
    </aside>

    <main class="flex-1 h-full overflow-y-auto p-8 md:p-12">
      <header class="max-w-4xl mb-12">
        <h1 class="text-4xl font-extrabold tracking-tight mb-2">Profil</h1>
        <p class="text-slate-500 text-lg">Kelola detail akun Anda di EventSpeak.</p>
      </header>

      <div class="max-w-4xl grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Card Profil Utama --}}
        <section class="md:col-span-3 bg-white rounded-3xl p-8 shadow-sm border border-slate-100 flex flex-col md:flex-row items-center gap-8">
          <div class="relative group">
            {{-- Ganti bagian ini --}}
            <div class="w-32 h-32 rounded-2xl bg-primary flex items-center justify-center text-white text-5xl shadow-lg overflow-hidden">
              @if($user->foto_profil)
              {{-- Kita tambahkan fungsi file_exists untuk memastikan file benar-benar ada --}}
              <img src="{{ asset('uploads/profil/' . $user->foto_profil) }}" class="w-full h-full object-cover">
              @else
              <i class="fa-solid fa-user"></i>
              @endif
            </div>
          </div>

          <div class="flex-1 text-center md:text-left">
            <h2 class="text-2xl font-bold text-slate-900 mb-1">{{ $user->nama_user }}</h2>
            {{-- ... sisa kode nama dan email ... --}}
            <p class="text-slate-500 mb-4">{{ $user->email_user }}</p>
            <div class="flex flex-wrap justify-center md:justify-start gap-4">
              <div class="flex items-center gap-2 text-sm font-medium text-slate-700 bg-slate-50 px-4 py-2 rounded-lg">
                <span class="material-symbols-outlined text-primary text-sm">mail</span>
                {{ $user->email_user }}
              </div>
            </div>
          </div>
        </section>


        <section class="md:col-span-2 space-y-6">
          <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-100">
            <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
              <span class="material-symbols-outlined text-primary">account_circle</span>
              Identitas Akun
            </h3>

            <div class="space-y-4">
              <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Nama Lengkap</label>
                <div class="bg-slate-50 px-5 py-4 rounded-xl text-slate-700 font-medium border border-slate-100">
                  {{ $user->nama_user }}
                </div>
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Email</label>
                <div class="bg-slate-50 px-5 py-4 rounded-xl text-slate-700 font-medium border border-slate-100 flex justify-between">
                  {{ $user->email_user }}
                  <span class="text-green-600 text-xs font-bold bg-green-50 px-2 py-0.5 rounded">Primary</span>
                </div>
              </div>

              <div class="pt-4">
                <button onclick="openEditModal()" class="w-full md:w-auto px-8 py-3 bg-primary text-white font-bold rounded-xl hover:bg-teal-700 transition shadow-lg shadow-teal-900/20 flex items-center justify-center gap-2">
                  <span class="material-symbols-outlined text-sm">edit</span>
                  Edit Profile
                </button>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-100">
            <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
              <span class="material-symbols-outlined text-primary">
                analytics
              </span>
              Statistik Event Saya
            </h3>

            <div style="height:350px;">
              <canvas id="chartJenisEvent"></canvas>
            </div>
          </div>
        </section>

@php
    $width = min(($eventDiikuti ? $eventDiikuti->count() : 0) * 10, 100);
@endphp

        <section class="md:col-span-1 space-y-6">
          <div class="bg-primary text-white rounded-2xl p-8 shadow-xl">
            <h4 class="text-sm font-bold uppercase tracking-widest mb-4 opacity-70">
              Impact Anda
            </h4>

            <div class="space-y-6">
              <div>
                <div class="flex justify-between text-xs mb-2">
                  <span>Event Diikuti</span>
                  <span>{{ $eventDiikuti->count() }} Event</span>
                </div>
                <div class="h-2 bg-white/20 rounded-full">
                  <div class="h-full bg-white rounded-full" style="width: {{ $width }}%"></div>
                </div>
              </div>

              <p class="text-4xl font-black">{{ $eventDiikuti->count() }}</p>

              <p class="text-xs opacity-70">Total event yang pernah diikuti</p>
            </div>
          </div>
        </section>

        {{-- Riwayat Pendaftaran --}}
        {{-- Riwayat Pendaftaran --}}
        <section class="md:col-span-3 bg-white rounded-2xl p-8 shadow-sm border border-slate-100">
          <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">receipt_long</span>
            Riwayat Pendaftaran
          </h3>

          @if($eventDiikuti->count() > 0)
          <div class="overflow-x-auto">
            <table class="w-full text-sm">
              <thead>
                <tr class="border-b border-slate-100">
                  <th class="text-left text-xs font-bold text-slate-400 uppercase pb-3 pr-4">Event</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase pb-3 pr-4">Jenis</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase pb-3 pr-4">Tanggal</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase pb-3 pr-4">Harga</th>
                  <th class="text-left text-xs font-bold text-slate-400 uppercase pb-3">Tiket</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-50">
                @foreach($eventDiikuti as $e)
                @php
                $hargaLabel = ($e->Harga == 0) ? 'Gratis' : 'Rp ' . number_format($e->Harga, 0, ',', '.');
                $tanggal = \Carbon\Carbon::parse($e->Tanggal)->translatedFormat('d M Y');
                @endphp
                <tr class="hover:bg-slate-50 transition cursor-pointer"
                  data-nama="{{ $e->Nama_Event }}"
                  data-jenis="{{ $e->Jenis_Event }}"
                  data-tanggal="{{ $tanggal }}"
                  data-lokasi="{{ $e->Lokasi ?? '-' }}"
                  data-harga="{{ $hargaLabel }}"
                  data-metode="{{ $e->metode_bayar ?? '-' }}"
                  data-nomor="{{ $e->nomor_tiket ?? '-' }}"
                  data-wa="{{ $e->no_wa ?? '-' }}"
                  onclick="lihatTiket(this)">
                  <td class="py-4 pr-4 font-semibold text-slate-800">{{ $e->Nama_Event }}</td>
                  <td class="py-4 pr-4">
                    <span class="text-xs font-bold px-3 py-1 rounded-full bg-teal-50 text-teal-700">
                      {{ $e->Jenis_Event }}
                    </span>
                  </td>
                  <td class="py-4 pr-4 text-slate-500">{{ $tanggal }}</td>
                  <td class="py-4 pr-4 font-bold text-primary">{{ $hargaLabel }}</td>
                  <td class="py-4">
                    <span class="flex items-center gap-1.5 text-xs font-bold text-primary bg-primary/10 px-3 py-1.5 rounded-lg w-fit">
                      <span class="material-symbols-outlined text-sm">confirmation_number</span>
                      Lihat Tiket
                    </span>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @else
          <div class="text-center py-12 text-slate-400">
            <span class="material-symbols-outlined text-5xl mb-3 block">event_busy</span>
            <p class="font-medium">Belum ada event yang didaftarkan</p>
            <a href="/eksplorasi" class="mt-4 inline-block text-sm font-bold text-primary hover:underline">
              Cari Event Sekarang →
            </a>
          </div>
          @endif
        </section>

        {{-- Modal Tiket --}}
        <div id="modalTiket" class="fixed inset-0 bg-black/50 hidden z-50 items-center justify-center p-4 backdrop-blur-sm">
          <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl overflow-hidden">
            <div class="bg-primary px-6 py-5 text-white flex justify-between items-start">
              <div>
                <p class="text-xs font-bold uppercase tracking-widest opacity-70 mb-1">EventSpeak · E-Ticket</p>
                <h3 class="text-lg font-extrabold leading-tight" id="tiket-nama">-</h3>
                <span class="text-xs bg-white/20 px-2 py-0.5 rounded-full mt-1 inline-block" id="tiket-jenis">-</span>
              </div>
              <button onclick="tutupTiket()" class="text-white/60 hover:text-white">
                <span class="material-symbols-outlined">close</span>
              </button>
            </div>

            {{-- Zigzag --}}
            <div class="relative bg-slate-50" style="height:16px;">
              <svg class="absolute top-0 left-0 w-full" height="16" viewBox="0 0 400 16" preserveAspectRatio="none">
                <path d="M0,0 L13,8 L26,0 L39,8 L52,0 L65,8 L78,0 L91,8 L104,0 L117,8 L130,0 L143,8 L156,0 L169,8 L182,0 L195,8 L208,0 L221,8 L234,0 L247,8 L260,0 L273,8 L286,0 L299,8 L312,0 L325,8 L338,0 L351,8 L364,0 L377,8 L390,0 L400,0 L400,16 L0,16 Z" fill="white" />
              </svg>
            </div>

            <div class="bg-slate-50 px-6 pb-6 space-y-3">
              <div class="bg-white rounded-xl p-4 space-y-3">
                <p class="text-xs font-bold text-slate-400 uppercase">Detail Event</p>
                <div class="flex justify-between text-sm">
                  <span class="text-slate-500">Tanggal</span>
                  <span class="font-semibold" id="tiket-tanggal">-</span>
                </div>
                <div class="flex justify-between text-sm">
                  <span class="text-slate-500">Lokasi</span>
                  <span class="font-semibold text-right max-w-xs" id="tiket-lokasi">-</span>
                </div>
              </div>

              <div class="bg-white rounded-xl p-4 space-y-3">
                <p class="text-xs font-bold text-slate-400 uppercase">Peserta</p>
                <div class="flex justify-between text-sm">
                  <span class="text-slate-500">Nama</span>
                  <span class="font-semibold">{{ $user->nama_user }}</span>
                </div>
                <div class="flex justify-between text-sm">
                  <span class="text-slate-500">No. WhatsApp</span>
                  <span class="font-semibold" id="tiket-wa">-</span>
                </div>
              </div>

              <div class="bg-white rounded-xl p-4 space-y-3">
                <p class="text-xs font-bold text-slate-400 uppercase">Pembayaran</p>
                <div class="flex justify-between text-sm">
                  <span class="text-slate-500">Metode</span>
                  <span class="font-semibold uppercase" id="tiket-metode">-</span>
                </div>
                <div class="flex justify-between text-sm border-t pt-3">
                  <span class="font-bold">Total</span>
                  <span class="font-extrabold text-primary" id="tiket-harga">-</span>
                </div>
              </div>

              <div class="bg-primary/5 border border-primary/20 rounded-xl p-4 text-center">
                <p class="text-xs text-slate-500 mb-1">Nomor Tiket</p>
                <p class="font-black text-primary text-lg tracking-widest" id="tiket-nomor">-</p>
              </div>

              <button onclick="cetakTiket()" class="w-full py-3 border-2 border-primary text-primary font-bold rounded-xl hover:bg-primary hover:text-white transition flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-sm">print</span>
                Cetak Tiket
              </button>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <div id="logoutModal" class="fixed inset-0 bg-black/50 hidden z-50 items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl">
      <h2 class="text-xl font-bold mb-2">Keluar?</h2>
      <p class="text-slate-600 mb-6">Anda harus login kembali untuk mengakses fitur pendaftaran.</p>
      <div class="flex gap-3">
        <button onclick="closeModal()" class="flex-1 px-4 py-3 text-slate-600 font-bold hover:bg-slate-100 rounded-xl transition">Batal</button>
        {{-- Arahkan ke route logout buatanmu --}}
        <a href="{{ route('logout') }}" class="flex-1 px-4 py-3 bg-red-600 text-white text-center font-bold rounded-xl hover:bg-red-700 transition">Keluar</a>
      </div>
    </div>
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
          <button class="w-full py-3 bg-primary text-white font-bold rounded-xl hover:opacity-90 transition-opacity">
            Send Message
          </button>
        </div>
      </div>
      <div class="max-w-7xl mx-auto px-4 md:px-8 mt-16 pt-8 border-t border-slate-200 text-center">
        <p class="text-sm text-slate-500">© 2026 EventSpeak</p>
      </div>
  </footer>

  <div id="editProfilModal" class="fixed inset-0 bg-black/50 hidden z-[60] items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-2xl p-8 w-full max-w-md shadow-2xl scale-95 transition-all">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-primary">Update Profile</h2>
        <button onclick="closeEditModal()" class="text-slate-400 hover:text-red-500">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>

      <form action="{{ route('pengguna.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="space-y-4">
          <div>
            <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Foto Profil</label>
            <input type="file" name="foto_profil" accept="image/*"
              class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-teal-700 transition">
            <p class="text-[10px] text-slate-400 mt-1">*Format: JPG, PNG, JPEG (Max 2MB)</p>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Nama Baru</label>
            <input type="text" name="nama_user" value="{{ $user->nama_user }}" required
              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-primary/20">
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Email Baru</label>
            <input type="email" name="email_user" value="{{ $user->email_user }}" required
              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-primary/20">
          </div>

          <button type="submit" class="w-full py-4 bg-primary text-white font-bold rounded-xl hover:bg-teal-800 transition shadow-lg">
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>
  <script>
    // Tambah ini ↓
    const labels = @json($chartJenis->pluck('Jenis_Event'));
const dataChart = @json($chartJenis->pluck('total'));

    function openModal() {
      document.getElementById("logoutModal").classList.replace("hidden", "flex");
    }

    function closeModal() {
      document.getElementById("logoutModal").classList.replace("flex", "hidden");
    }

    function openEditModal() {
      const modal = document.getElementById("editProfilModal");
      modal.classList.replace("hidden", "flex");
    }

    function closeEditModal() {
      const modal = document.getElementById("editProfilModal");
      modal.classList.replace("flex", "hidden");
    }

    const ctx = document.getElementById('chartJenisEvent');
    console.log("LABELS:", labels);
    console.log("DATA:", dataChart);

    if (ctx) {
      new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: labels,
          datasets: [{
            data: dataChart,
            backgroundColor: [
              '#004253',
              '#0F766E',
              '#14B8A6',
              '#5EEAD4',
              '#99F6E4'
            ]
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom'
            }
          }
        }
      });
    }

    function lihatTiket(el) {
      document.getElementById('tiket-nama').textContent = el.dataset.nama;
      document.getElementById('tiket-jenis').textContent = el.dataset.jenis;
      document.getElementById('tiket-tanggal').textContent = el.dataset.tanggal;
      document.getElementById('tiket-lokasi').textContent = el.dataset.lokasi;
      document.getElementById('tiket-harga').textContent = el.dataset.harga;
      document.getElementById('tiket-metode').textContent = el.dataset.metode;
      document.getElementById('tiket-nomor').textContent = el.dataset.nomor;
      document.getElementById('tiket-wa').textContent = el.dataset.wa;
      document.getElementById('modalTiket').classList.replace('hidden', 'flex');
    }

    function tutupTiket() {
      document.getElementById('modalTiket').classList.replace('flex', 'hidden');
    }

    function cetakTiket() {
      const isi = document.querySelector('#modalTiket .bg-white.rounded-2xl').innerHTML;
      const w = window.open('', '_blank');
      w.document.write(`
        <html><head><title>E-Ticket EventSpeak</title>
        <style>body{font-family:sans-serif;padding:20px;max-width:420px;margin:0 auto}</style>
        </head><body>${isi}
        <script>window.onload=()=>window.print()<\/script>
        </body></html>
    `);
      w.document.close();
    }
  </script>

</body>

</html>