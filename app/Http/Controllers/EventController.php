<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
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

        $query = DB::table('event')->orderBy('id', 'desc')->limit(6);

        if ($isPembicara) {
            // Pembicara: lihat semua event (published + semua draft)
            // tidak difilter
        } elseif ($isPenyelenggara) {
            // Penyelenggara: published semua + draft miliknya saja
            $query->where(function ($q) use ($penyelenggara) {
                // Event published (punya pemateri)
                $q->where(function ($q2) {
                    $q2->whereNotNull('Pemateri')->where('Pemateri', '!=', '');
                })
                    // ATAU draft milik penyelenggara ini
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

        return view('Pengguna.index', compact('events', 'user', 'isPenyelenggara', 'isPembicara'));
    }

    public function show($id)
    {
        $event = DB::table('event')->where('id', $id)->first();
        if (!$event) abort(404);

        $user = session('user_id')
            ? DB::table('user')->where('id_user', session('user_id'))->first()
            : null;

        // Ambil data pembicara untuk foto di section speaker
        $pembicara = null;
        if ($event->Pemateri) {
            $pembicara = DB::table('pembicara')
                ->leftJoin('user', 'pembicara.email_pembicara', '=', 'user.email_user')
                ->where('pembicara.nama_pembicara', $event->Pemateri)
                ->select('pembicara.*', 'user.foto_profil')
                ->first();
        }

        // Cek apakah user yang login adalah pembicara terdaftar
        $pembicaraLogin = null;
        if ($user) {
            $pembicaraLogin = DB::table('pembicara')
                ->where('email_pembicara', $user->email_user)
                ->first();
        }

        // Kirim $pembicara = data speaker event, $pembicaraLogin = user yang sedang login
        return view('Pengguna.detail-event', compact('event', 'user', 'pembicara', 'pembicaraLogin'));
    }
}
