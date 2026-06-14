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

        // Notifikasi
        $notifikasi = [];

        if ($userId && $user) {
            // 1. Event yang didaftari user
            $eventDiikuti = DB::table('peserta')
                ->join('event', 'peserta.id_event', '=', 'event.id')
                ->where('peserta.id_user', $userId)
                ->select('event.Nama_Event', 'peserta.created_at')
                ->orderBy('peserta.created_at', 'desc')
                ->get();
            foreach ($eventDiikuti as $e) {
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
                        ->selectRaw('event.Nama_Event, COUNT(peserta.id_peserta) as total')
                        ->groupBy('event.id', 'event.Nama_Event')
                        ->get();
                    foreach ($pesertaPerEvent as $p) {
                        $notifikasi[] = [
                            'icon' => 'groups',
                            'color' => 'text-teal-500',
                            'pesan' => '<b>' . $p->total . ' peserta</b> telah mendaftar di event <b>' . $p->Nama_Event . '</b>',
                            'waktu' => null,
                        ];
                    }

                    // 6. Jumlah pelamar pembicara di event draft
                    $lamaranMasuk = DB::table('lamaran_pembicara')
                        ->join('event', 'lamaran_pembicara.id_event', '=', 'event.id')
                        ->whereIn('lamaran_pembicara.id_event', $eventIds)
                        ->where('lamaran_pembicara.status', 'pending')
                        ->selectRaw('event.Nama_Event, COUNT(lamaran_pembicara.id) as total')
                        ->groupBy('event.id', 'event.Nama_Event')
                        ->get();
                    foreach ($lamaranMasuk as $lm) {
                        $notifikasi[] = [
                            'icon' => 'person_add',
                            'color' => 'text-orange-500',
                            'pesan' => '<b>' . $lm->total . ' pembicara</b> melamar di event draft <b>' . $lm->Nama_Event . '</b>',
                            'waktu' => null,
                        ];
                    }

                    // 7. Penarikan saldo hari ini
                    $tarikHariIni = DB::table('penyelenggara')
                        ->where('id_penyelenggara', $dataPenyelenggara->id_penyelenggara)
                        ->where('saldo', '>', 0)
                        ->value('saldo');
                    if ($tarikHariIni) {
                        $notifikasi[] = [
                            'icon' => 'payments',
                            'color' => 'text-green-600',
                            'pesan' => 'Total saldo yang telah ditarik: <b>Rp ' . number_format($tarikHariIni, 0, ',', '.') . '</b>',
                            'waktu' => null,
                        ];
                    }
                }
            }
        }

        // Urutkan notifikasi terbaru di atas
        usort($notifikasi, fn($a, $b) => strtotime($b['waktu'] ?? '1970-01-01') - strtotime($a['waktu'] ?? '1970-01-01'));

        return view('Pengguna.index', compact('events', 'user', 'isPenyelenggara', 'isPembicara', 'notifikasi'));
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

        $penyelenggara = null;
        if ($event->id_penyelenggara) {
            $penyelenggara = DB::table('penyelenggara')
                ->where('id_penyelenggara', $event->id_penyelenggara)
                ->first();
        }
        // Kirim $pembicara = data speaker event, $pembicaraLogin = user yang sedang login
        return view('Pengguna.detail-event', compact('event', 'user', 'pembicara', 'pembicaraLogin', 'penyelenggara'));
    }
}
