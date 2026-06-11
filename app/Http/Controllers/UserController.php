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

        return view('Pengguna.index', compact('events', 'user', 'isPenyelenggara', 'isPembicara'));
        //                                                         ^^^ ini yang kurang
    }

    public function showLogin()
    {
        return view('pengguna/login'); // atau auth.login
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
        return view('Pengguna.registrasi'); // Pastikan nama filenya register.blade.php
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

        $eventDiikuti = DB::table('peserta')
            ->join('event', 'peserta.id_event', '=', 'event.id')
            ->where('peserta.id_user', $userId)
            ->select(
                'event.Nama_Event',
                'event.Jenis_Event',
                'event.Tanggal',
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

        // Olah data chart di sini ↓
        $chartLabels = $chartJenis->pluck('Jenis_Event');
        $chartData   = $chartJenis->pluck('total');

        return view('Pengguna.profil', compact(
            'user',
            'isOrganizer',
            'eventDiikuti',
            'chartJenis',
            'chartLabels',
            'chartData'
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

        return view('Pengguna.eksplorasi', compact('events', 'isLoggedIn', 'user', 'isPembicara', 'isPenyelenggara'));
    }

    // Tambahkan fungsi ini di dalam class userController
    public function showTeam()
    {
        // Mengambil data user yang sedang login untuk navbar (foto profil)
        $userId = Session::get('user_id');
        $user = session('user_id')
            ? DB::table('user')->where('id_user', session('user_id'))->first()
            : null;

        if ($userId) {
            $user = DB::table('user')->where('id_user', $userId)->first();
        }

        return view('Pengguna.team', compact('user'));
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

        $user = DB::table('user')
            ->where('id_user', $userId)
            ->first();

        $event = DB::table('event')
            ->where('id', $id)
            ->first();

        return view('Pengguna.checkout', compact('user', 'event'));
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
