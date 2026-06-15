<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class userController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        $user = $userId ? DB::table('user')->where('id_user', $userId)->first() : null;

        $isPenyelenggara = $userId ? DB::table('penyelenggara')->where('id_user', $userId)->exists() : false;
        $isPembicara = ($userId && $user) ? DB::table('pembicara')->where('email_pembicara', $user->email_user)->exists() : false;

        $query = DB::table('event')->orderBy('id', 'desc')->limit(6);

        // Kalau bukan penyelenggara DAN bukan pembicara, sembunyikan event draft
        if (!$isPenyelenggara && !$isPembicara) {
            $query->whereNotNull('Pemateri')->where('Pemateri', '!=', '');
        }

        $events = $query->get();

        // Notifikasi
        $notifikasi = [];

        if ($userId && $user) {
            // 1. Event yang didaftari user
            // 1. Event yang didaftari user
            $eventDiikutiNotif = DB::table('peserta')
                ->join('event', 'peserta.id_event', '=', 'event.id')
                ->where('peserta.id_user', $userId)
                ->select('event.Nama_Event', 'peserta.created_at')
                ->orderBy('peserta.created_at', 'desc')
                ->get();
            foreach ($eventDiikutiNotif as $e) {
                $notifikasi[] = [
                    'icon' => 'check_circle',
                    'color' => 'text-teal-500',
                    'pesan' => 'Kamu berhasil mendaftar event <b>' . $e->Nama_Event . '</b>',
                    'waktu' => $e->created_at,
                ];
            }

            // 2. Daftar jadi pembicara
            if ($isPembicara) {
                $dataPembicara = DB::table('pembicara')->where('email_pembicara', $user->email_user)->first();
                if ($dataPembicara) {
                    $notifikasi[] = [
                        'icon' => 'mic',
                        'color' => 'text-blue-500',
                        'pesan' => 'Kamu telah terdaftar sebagai <b>Pembicara</b>',
                        'waktu' => $dataPembicara->created_at ?? null,
                    ];

                    // 4. Status lamaran pembicara
                    $lamaranPembicara = DB::table('lamaran_pembicara')
                        ->join('event', 'lamaran_pembicara.id_event', '=', 'event.id')
                        ->where('lamaran_pembicara.id_pembicara', $dataPembicara->id_pembicara)
                        ->whereIn('lamaran_pembicara.status', ['diterima', 'ditolak'])
                        ->select('lamaran_pembicara.status', 'event.Nama_Event', 'lamaran_pembicara.updated_at')
                        ->orderBy('lamaran_pembicara.updated_at', 'desc')
                        ->get();
                    foreach ($lamaranPembicara as $l) {
                        $notifikasi[] = [
                            'icon' => $l->status === 'diterima' ? 'thumb_up' : 'thumb_down',
                            'color' => $l->status === 'diterima' ? 'text-green-500' : 'text-red-500',
                            'pesan' => 'Lamaran kamu di event <b>' . $l->Nama_Event . '</b> ' . ($l->status === 'diterima' ? 'telah <b>diterima</b>' : 'telah <b>ditolak</b>'),
                            'waktu' => $l->updated_at,
                        ];
                    }
                }
            }

            // 3. Daftar jadi penyelenggara
            if ($isPenyelenggara) {
                $dataPenyelenggara = DB::table('penyelenggara')->where('id_user', $userId)->first();
                if ($dataPenyelenggara) {
                    $notifikasi[] = [
                        'icon' => 'business',
                        'color' => 'text-purple-500',
                        'pesan' => 'Kamu telah terdaftar sebagai <b>Penyelenggara</b>',
                        'waktu' => $dataPenyelenggara->created_at ?? null,
                    ];

                    // 5. Jumlah peserta per event
                    $eventIds = DB::table('event')
                        ->where('id_penyelenggara', $dataPenyelenggara->id_penyelenggara)
                        ->pluck('id');
                    $pesertaPerEvent = DB::table('peserta')
                        ->join('event', 'peserta.id_event', '=', 'event.id')
                        ->whereIn('peserta.id_event', $eventIds)
                        ->selectRaw('event.Nama_Event, COUNT(peserta.id_peserta) as total, MAX(peserta.created_at) as waktu')
                        ->groupBy('event.id', 'event.Nama_Event')
                        ->get();
                    foreach ($pesertaPerEvent as $p) {
                        $notifikasi[] = [
                            'icon' => 'groups',
                            'color' => 'text-teal-500',
                            'pesan' => '<b>' . $p->total . ' peserta</b> telah mendaftar di event <b>' . $p->Nama_Event . '</b>',
                            'waktu' => $p->waktu,
                        ];
                    }

                    // 6. Jumlah pelamar pembicara di event draft
                    $lamaranMasuk = DB::table('lamaran_pembicara')
                        ->join('event', 'lamaran_pembicara.id_event', '=', 'event.id')
                        ->whereIn('lamaran_pembicara.id_event', $eventIds)
                        ->where('lamaran_pembicara.status', 'pending')
                        ->selectRaw('event.Nama_Event, COUNT(lamaran_pembicara.id) as total, MAX(lamaran_pembicara.created_at) as waktu')
                        ->groupBy('event.id', 'event.Nama_Event')
                        ->get();
                    foreach ($lamaranMasuk as $lm) {
                        $notifikasi[] = [
                            'icon' => 'person_add',
                            'color' => 'text-orange-500',
                            'pesan' => '<b>' . $lm->total . ' pembicara</b> melamar di event draft <b>' . $lm->Nama_Event . '</b>',
                            'waktu' => $lm->waktu,
                        ];
                    }

                    // 7. Penarikan saldo hari ini
                    $dataSaldo = DB::table('penyelenggara')
                        ->where('id_penyelenggara', $dataPenyelenggara->id_penyelenggara)
                        ->where('saldo', '>', 0)
                        ->first();
                    if ($dataSaldo) {
                        $notifikasi[] = [
                            'icon' => 'payments',
                            'color' => 'text-green-600',
                            'pesan' => 'Total saldo yang telah ditarik: <b>Rp ' . number_format($dataSaldo->saldo, 0, ',', '.') . '</b>',
                            'waktu' => $dataSaldo->updated_at ?? null,
                        ];
                    }
                }
            }
        }

        // Urutkan notifikasi terbaru di atas
        usort($notifikasi, fn($a, $b) => strtotime($b['waktu'] ?? '1970-01-01') - strtotime($a['waktu'] ?? '1970-01-01'));
        $eventDiikutiIds = $userId
            ? DB::table('peserta')->where('id_user', $userId)->pluck('id_event')->toArray()
            : [];

        return view('pengguna.index', compact('events', 'user', 'isPenyelenggara', 'isPembicara', 'notifikasi', 'eventDiikutiIds'));
        //                                                         ^^^ ini yang kurang
    }

    public function showLogin()
    {
        return view('pengguna.login'); // atau auth.login
    }

    // Proses Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = DB::table('user')->where('email_user', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password_user)) {
            Session::put('user_id', $user->id_user);
            Session::put('user_email', $user->email_user);
            return redirect()->route('pengguna.index');
        }

        return back()->with('error', 'Email atau password salah!');
    }

    // Halaman Registrasi
    public function showRegister()
    {
        return view('pengguna.registrasi'); // Pastikan nama filenya register.blade.php
    }

    // Proses Registrasi
    public function register(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required', // Cukup 'required' saja, tanpa 'min:8' atau 'confirmed'
        ]);

        // ... sisa kode insert database tetap sama ...
        $userId = DB::table('user')->insertGetId([
            'nama_user' => $request->nama,
            'email_user' => $request->email,
            'password_user' => Hash::make($request->password),
        ]);

        // Set Session
        Session::put('user_id', $userId);
        Session::put('user_email', $request->email);

        return redirect()->route('pengguna.index')->with('success', 'Pendaftaran berhasil!');
    }

    // ... keep existing functions (index, login, etc) ...

    // HALAMAN PROFIL (Tambahkan fungsi ini agar tidak error lagi)
    public function showProfil()
    {
        $userId = Session::get('user_id');

        if (!$userId) {
            return redirect()->route('login');
        }

        $user = DB::table('user')->where('id_user', $userId)->first();
        $isOrganizer = DB::table('penyelenggara')->where('id_user', $userId)->exists();

        $isPenyelenggara = $isOrganizer;
        $isPembicara = $user ? DB::table('pembicara')->where('email_pembicara', $user->email_user)->exists() : false;
        $penyelenggara = $isPenyelenggara ? DB::table('penyelenggara')->where('id_user', $userId)->first() : null;

        $eventDiikuti = DB::table('peserta')
            ->join('event', 'peserta.id_event', '=', 'event.id')
            ->where('peserta.id_user', $userId)
            ->select(
                'peserta.id_peserta',
                'event.Nama_Event',
                'event.Jenis_Event',
                'event.Tanggal',
                'event.Jam',          // <-- TAMBAHAN
                'event.Harga',
                'event.Lokasi',
                'peserta.no_wa',
                'peserta.metode_bayar',
                'peserta.nomor_tiket'
            )
            ->get();

        $chartJenis = DB::table('peserta')
            ->join('event', 'peserta.id_event', '=', 'event.id')
            ->where('peserta.id_user', $userId)
            ->selectRaw('Jenis_Event, COUNT(*) as total')
            ->groupBy('Jenis_Event')
            ->get();

        $chartLabels = $chartJenis->pluck('Jenis_Event');
        $chartData   = $chartJenis->pluck('total');

        // Notifikasi
        $notifikasi = [];

        if ($userId && $user) {
            // 1. Event yang didaftari user
            // 1. Event yang didaftari user
            $eventDiikutiNotif = DB::table('peserta')
                ->join('event', 'peserta.id_event', '=', 'event.id')
                ->where('peserta.id_user', $userId)
                ->select('event.Nama_Event', 'peserta.created_at')
                ->orderBy('peserta.created_at', 'desc')
                ->get();
            foreach ($eventDiikutiNotif as $e) {
                $notifikasi[] = [
                    'icon' => 'check_circle',
                    'color' => 'text-teal-500',
                    'pesan' => 'Kamu berhasil mendaftar event <b>' . $e->Nama_Event . '</b>',
                    'waktu' => $e->created_at,
                ];
            }

            // 2. Daftar jadi pembicara
            if ($isPembicara) {
                $dataPembicara = DB::table('pembicara')->where('email_pembicara', $user->email_user)->first();
                if ($dataPembicara) {
                    $notifikasi[] = [
                        'icon' => 'mic',
                        'color' => 'text-blue-500',
                        'pesan' => 'Kamu telah terdaftar sebagai <b>Pembicara</b>',
                        'waktu' => $dataPembicara->created_at ?? null,
                    ];

                    // 4. Status lamaran pembicara
                    $lamaranPembicara = DB::table('lamaran_pembicara')
                        ->join('event', 'lamaran_pembicara.id_event', '=', 'event.id')
                        ->where('lamaran_pembicara.id_pembicara', $dataPembicara->id_pembicara)
                        ->whereIn('lamaran_pembicara.status', ['diterima', 'ditolak'])
                        ->select('lamaran_pembicara.status', 'event.Nama_Event', 'lamaran_pembicara.updated_at')
                        ->orderBy('lamaran_pembicara.updated_at', 'desc')
                        ->get();
                    foreach ($lamaranPembicara as $l) {
                        $notifikasi[] = [
                            'icon' => $l->status === 'diterima' ? 'thumb_up' : 'thumb_down',
                            'color' => $l->status === 'diterima' ? 'text-green-500' : 'text-red-500',
                            'pesan' => 'Lamaran kamu di event <b>' . $l->Nama_Event . '</b> ' . ($l->status === 'diterima' ? 'telah <b>diterima</b>' : 'telah <b>ditolak</b>'),
                            'waktu' => $l->updated_at,
                        ];
                    }
                }
            }

            // 3. Daftar jadi penyelenggara
            if ($isPenyelenggara) {
                $dataPenyelenggara = DB::table('penyelenggara')->where('id_user', $userId)->first();
                if ($dataPenyelenggara) {
                    $notifikasi[] = [
                        'icon' => 'business',
                        'color' => 'text-purple-500',
                        'pesan' => 'Kamu telah terdaftar sebagai <b>Penyelenggara</b>',
                        'waktu' => $dataPenyelenggara->created_at ?? null,
                    ];

                    // 5. Jumlah peserta per event
                    $eventIds = DB::table('event')
                        ->where('id_penyelenggara', $dataPenyelenggara->id_penyelenggara)
                        ->pluck('id');
                    $pesertaPerEvent = DB::table('peserta')
                        ->join('event', 'peserta.id_event', '=', 'event.id')
                        ->whereIn('peserta.id_event', $eventIds)
                        ->selectRaw('event.Nama_Event, COUNT(peserta.id_peserta) as total, MAX(peserta.created_at) as waktu')
                        ->groupBy('event.id', 'event.Nama_Event')
                        ->get();
                    foreach ($pesertaPerEvent as $p) {
                        $notifikasi[] = [
                            'icon' => 'groups',
                            'color' => 'text-teal-500',
                            'pesan' => '<b>' . $p->total . ' peserta</b> telah mendaftar di event <b>' . $p->Nama_Event . '</b>',
                            'waktu' => $p->waktu,
                        ];
                    }

                    // 6. Jumlah pelamar pembicara di event draft
                    $lamaranMasuk = DB::table('lamaran_pembicara')
                        ->join('event', 'lamaran_pembicara.id_event', '=', 'event.id')
                        ->whereIn('lamaran_pembicara.id_event', $eventIds)
                        ->where('lamaran_pembicara.status', 'pending')
                        ->selectRaw('event.Nama_Event, COUNT(lamaran_pembicara.id) as total, MAX(lamaran_pembicara.created_at) as waktu')
                        ->groupBy('event.id', 'event.Nama_Event')
                        ->get();
                    foreach ($lamaranMasuk as $lm) {
                        $notifikasi[] = [
                            'icon' => 'person_add',
                            'color' => 'text-orange-500',
                            'pesan' => '<b>' . $lm->total . ' pembicara</b> melamar di event draft <b>' . $lm->Nama_Event . '</b>',
                            'waktu' => $lm->waktu,
                        ];
                    }

                    // 7. Penarikan saldo hari ini
                    $dataSaldo = DB::table('penyelenggara')
                        ->where('id_penyelenggara', $dataPenyelenggara->id_penyelenggara)
                        ->where('saldo', '>', 0)
                        ->first();
                    if ($dataSaldo) {
                        $notifikasi[] = [
                            'icon' => 'payments',
                            'color' => 'text-green-600',
                            'pesan' => 'Total saldo yang telah ditarik: <b>Rp ' . number_format($dataSaldo->saldo, 0, ',', '.') . '</b>',
                            'waktu' => $dataSaldo->updated_at ?? null,
                        ];
                    }
                }
            }
        }

        // Urutkan notifikasi terbaru di atas
        usort($notifikasi, fn($a, $b) => strtotime($b['waktu'] ?? '1970-01-01') - strtotime($a['waktu'] ?? '1970-01-01'));
        // ===== END NOTIFIKASI =====

        return view('pengguna.profil', compact(
            'user',
            'isOrganizer',
            'eventDiikuti',
            'chartJenis',
            'chartLabels',
            'chartData',
            'notifikasi'
        ));
    }

    public function logout()
    {
        // Hapus semua data session
        Session::flush();

        // Arahkan ke halaman utama/landing page
        return redirect()->to('/');
    }
    public function eksplorasi(Request $request)
    {
        $isLoggedIn = session()->has('user_id');
        $userId = session('user_id');

        $user = $userId
            ? DB::table('user')->where('id_user', $userId)->first()
            : null;

        $penyelenggara = $userId
            ? DB::table('penyelenggara')->where('id_user', $userId)->first()
            : null;
        $isPenyelenggara = !is_null($penyelenggara);

        $isPembicara = ($userId && $user)
            ? DB::table('pembicara')->where('email_pembicara', $user->email_user)->exists()
            : false;

        $query = DB::table('event');
        $eventDiikutiIds = $userId
            ? DB::table('peserta')->where('id_user', $userId)->pluck('id_event')->toArray()
            : [];

        // Filter Keyword
        if ($request->has('keyword') && $request->keyword != '') {
            $query->where(function ($q) use ($request) {
                $q->where('Nama_Event', 'like', '%' . $request->keyword . '%')
                    ->orWhere('Pemateri', 'like', '%' . $request->keyword . '%');
            });
        }

        // Filter Kategori
        if ($request->has('jenis_event')) {
            $query->whereIn('Jenis_Event', $request->jenis_event);
        }

        // Filter Harga
        if ($request->has('max_harga')) {
            $query->where('Harga', '<=', $request->max_harga);
        }

        // Filter Tanggal
        if ($request->has('Tanggal') && $request->Tanggal != '') {
            $query->where('Tanggal', '<=', $request->Tanggal);
        }

        // Filter draft berdasarkan role (sama seperti index)
        if ($isPembicara) {
            // Pembicara: lihat semua event
        } elseif ($isPenyelenggara) {
            // Penyelenggara: published semua + draft miliknya saja
            $query->where(function ($q) use ($penyelenggara) {
                $q->where(function ($q2) {
                    $q2->whereNotNull('Pemateri')->where('Pemateri', '!=', '');
                })
                    ->orWhere(function ($q2) use ($penyelenggara) {
                        $q2->where(function ($q3) {
                            $q3->whereNull('Pemateri')->orWhere('Pemateri', '=', '');
                        })->where('id_penyelenggara', $penyelenggara->id_penyelenggara);
                    });
            });
        } else {
            // User biasa / guest: published only
            $query->whereNotNull('Pemateri')->where('Pemateri', '!=', '');
        }

        $events = $query->get();

        // Notifikasi
        $notifikasi = [];

        if ($userId && $user) {
            // 1. Event yang didaftari user
            $eventDiikutiNotif = DB::table('peserta')
                ->join('event', 'peserta.id_event', '=', 'event.id')
                ->where('peserta.id_user', $userId)
                ->select('event.Nama_Event', 'peserta.created_at')
                ->orderBy('peserta.created_at', 'desc')
                ->get();
            foreach ($eventDiikutiNotif as $e) {
                $notifikasi[] = [
                    'icon' => 'check_circle',
                    'color' => 'text-teal-500',
                    'pesan' => 'Kamu berhasil mendaftar event <b>' . $e->Nama_Event . '</b>',
                    'waktu' => $e->created_at,
                ];
            }

            // 2. Daftar jadi pembicara
            if ($isPembicara) {
                $dataPembicara = DB::table('pembicara')->where('email_pembicara', $user->email_user)->first();
                if ($dataPembicara) {
                    $notifikasi[] = [
                        'icon' => 'mic',
                        'color' => 'text-blue-500',
                        'pesan' => 'Kamu telah terdaftar sebagai <b>Pembicara</b>',
                        'waktu' => $dataPembicara->created_at ?? null,
                    ];

                    // 4. Status lamaran pembicara
                    $lamaranPembicara = DB::table('lamaran_pembicara')
                        ->join('event', 'lamaran_pembicara.id_event', '=', 'event.id')
                        ->where('lamaran_pembicara.id_pembicara', $dataPembicara->id_pembicara)
                        ->whereIn('lamaran_pembicara.status', ['diterima', 'ditolak'])
                        ->select('lamaran_pembicara.status', 'event.Nama_Event', 'lamaran_pembicara.updated_at')
                        ->orderBy('lamaran_pembicara.updated_at', 'desc')
                        ->get();
                    foreach ($lamaranPembicara as $l) {
                        $notifikasi[] = [
                            'icon' => $l->status === 'diterima' ? 'thumb_up' : 'thumb_down',
                            'color' => $l->status === 'diterima' ? 'text-green-500' : 'text-red-500',
                            'pesan' => 'Lamaran kamu di event <b>' . $l->Nama_Event . '</b> ' . ($l->status === 'diterima' ? 'telah <b>diterima</b>' : 'telah <b>ditolak</b>'),
                            'waktu' => $l->updated_at,
                        ];
                    }
                }
            }

            // 3. Daftar jadi penyelenggara
            if ($isPenyelenggara) {
                $dataPenyelenggara = DB::table('penyelenggara')->where('id_user', $userId)->first();
                if ($dataPenyelenggara) {
                    $notifikasi[] = [
                        'icon' => 'business',
                        'color' => 'text-purple-500',
                        'pesan' => 'Kamu telah terdaftar sebagai <b>Penyelenggara</b>',
                        'waktu' => $dataPenyelenggara->created_at ?? null,
                    ];

                    // 5. Jumlah peserta per event
                    $eventIds = DB::table('event')
                        ->where('id_penyelenggara', $dataPenyelenggara->id_penyelenggara)
                        ->pluck('id');
                    $pesertaPerEvent = DB::table('peserta')
                        ->join('event', 'peserta.id_event', '=', 'event.id')
                        ->whereIn('peserta.id_event', $eventIds)
                        ->selectRaw('event.Nama_Event, COUNT(peserta.id_peserta) as total, MAX(peserta.created_at) as waktu')
                        ->groupBy('event.id', 'event.Nama_Event')
                        ->get();
                    foreach ($pesertaPerEvent as $p) {
                        $notifikasi[] = [
                            'icon' => 'groups',
                            'color' => 'text-teal-500',
                            'pesan' => '<b>' . $p->total . ' peserta</b> telah mendaftar di event <b>' . $p->Nama_Event . '</b>',
                            'waktu' => $p->waktu,
                        ];
                    }

                    // 6. Jumlah pelamar pembicara di event draft
                    $lamaranMasuk = DB::table('lamaran_pembicara')
                        ->join('event', 'lamaran_pembicara.id_event', '=', 'event.id')
                        ->whereIn('lamaran_pembicara.id_event', $eventIds)
                        ->where('lamaran_pembicara.status', 'pending')
                        ->selectRaw('event.Nama_Event, COUNT(lamaran_pembicara.id) as total, MAX(lamaran_pembicara.created_at) as waktu')
                        ->groupBy('event.id', 'event.Nama_Event')
                        ->get();
                    foreach ($lamaranMasuk as $lm) {
                        $notifikasi[] = [
                            'icon' => 'person_add',
                            'color' => 'text-orange-500',
                            'pesan' => '<b>' . $lm->total . ' pembicara</b> melamar di event draft <b>' . $lm->Nama_Event . '</b>',
                            'waktu' => $lm->waktu,
                        ];
                    }

                    // 7. Penarikan saldo hari ini
                    $dataSaldo = DB::table('penyelenggara')
                        ->where('id_penyelenggara', $dataPenyelenggara->id_penyelenggara)
                        ->where('saldo', '>', 0)
                        ->first();
                    if ($dataSaldo) {
                        $notifikasi[] = [
                            'icon' => 'payments',
                            'color' => 'text-green-600',
                            'pesan' => 'Total saldo yang telah ditarik: <b>Rp ' . number_format($dataSaldo->saldo, 0, ',', '.') . '</b>',
                            'waktu' => $dataSaldo->updated_at ?? null,
                        ];
                    }
                }
            }
        }

        // Urutkan notifikasi terbaru di atas
        usort($notifikasi, fn($a, $b) => strtotime($b['waktu'] ?? '1970-01-01') - strtotime($a['waktu'] ?? '1970-01-01'));

        return view('pengguna.eksplorasi', compact('events', 'isLoggedIn', 'user', 'isPembicara', 'isPenyelenggara', 'notifikasi', 'eventDiikutiIds'));
    }

    // Tambahkan fungsi ini di dalam class userController
    public function showTeam()
    {
        $userId = Session::get('user_id');

        $user = null;
        $notifikasi = [];

        if ($userId) {
            $user = DB::table('user')
                ->where('id_user', $userId)
                ->first();
        }

        return view('pengguna.team', compact(
            'user',
            'notifikasi'
        ));
    }
    public function update(Request $request)
    {
        $userId = Session::get('user_id');

        if (!$userId) {
            return redirect()->route('login');
        }

        $request->validate([
            'nama_user'  => 'required|string|max:255',
            'email_user' => 'required|email',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'nama_user'  => $request->nama_user,
            'email_user' => $request->email_user,
        ];

        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama kalau ada
            $userLama = DB::table('user')->where('id_user', $userId)->first();
            if ($userLama->foto_profil && file_exists(public_path('uploads/profil/' . $userLama->foto_profil))) {
                unlink(public_path('uploads/profil/' . $userLama->foto_profil));
            }

            // Simpan foto baru
            $file     = $request->file('foto_profil');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profil'), $namaFile);
            $data['foto_profil'] = $namaFile;
        }

        DB::table('user')->where('id_user', $userId)->update($data);

        return redirect()->route('pengguna.profil')->with('success', 'Profil berhasil diperbarui!');
    }

    public function checkout($id)
    {
        $userId = Session::get('user_id');

        if (!$userId) {
            return redirect()->route('login');
        }

        $sudahDaftar = DB::table('peserta')
            ->where('id_user', $userId)
            ->where('id_event', $id)
            ->exists();

        if ($sudahDaftar) {
            $peserta = DB::table('peserta')
                ->where('id_user', $userId)
                ->where('id_event', $id)
                ->first();
            return redirect()->route('tiket.show', $peserta->id_peserta)
                ->with('info', 'Kamu sudah terdaftar di event ini.');
        }

        $user = DB::table('user')->where('id_user', $userId)->first();
        $event = DB::table('event')->where('id', $id)->first();

        return view('pengguna.checkout', compact('user', 'event'));
    }

    public function daftarEvent(Request $request, $id)
    {
        $userId = Session::get('user_id');

        $request->validate([
            'no_wa' => 'required',
            'metode_bayar' => 'required',
            'nomor_tiket' => 'required'
        ]);

        $cek = DB::table('peserta')
            ->where('id_user', $userId)
            ->where('id_event', $id)
            ->exists();

        if ($cek) {
            return back()->with('error', 'Kamu sudah terdaftar pada event ini.');
        }

        $idPeserta = DB::table('peserta')->insertGetId([
            'id_user' => $userId,
            'id_event' => $id,
            'no_wa' => $request->no_wa,
            'metode_bayar' => $request->metode_bayar,
            'nomor_tiket' => $request->nomor_tiket,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('tiket.show', $idPeserta);
    }

    public function showTiket($id)
    {
        $peserta = DB::table('peserta')
            ->join('user', 'peserta.id_user', '=', 'user.id_user')
            ->join('event', 'peserta.id_event', '=', 'event.id')
            ->where('peserta.id_peserta', $id)
            ->select(
                'peserta.*',
                'user.nama_user',
                'user.email_user',
                'event.Nama_Event',
                'event.Tanggal',
                'event.Jam',          // <-- tambahin ini
                'event.Lokasi',
                'event.Jenis_Event',
                'event.Pemateri'
            )
            ->first();

        if (!$peserta) {
            abort(404);
        }

        return view('Pengguna.tiket', compact('peserta'));
    }
}
