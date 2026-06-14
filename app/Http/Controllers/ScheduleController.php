<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event; // Pastikan nama Model sesuai
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        // Ambil bulan & tahun dari request, default ke bulan sekarang
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));
        $user = session('user_id') 
        ? DB::table('user')->where('id_user', session('user_id'))->first() 
        : null;

        // Ambil semua event pada bulan tersebut
        $events = Event::whereMonth('Tanggal', $month)
                       ->whereYear('Tanggal', $year)
                       ->get();

        // Kirim data ke view
        return view('Pengguna.schedule', compact('events', 'month', 'year', 'user'));
    }
    public function schedule()
    {
        $userId = session('user_id');

        $user = $userId
            ? DB::table('user')->where('id_user', $userId)->first()
            : null;

        $isPenyelenggara = $userId
            ? DB::table('penyelenggara')->where('id_user', $userId)->exists()
            : false;

        $isPembicara = ($userId && $user)
            ? DB::table('pembicara')
            ->where('email_pembicara', $user->email_user)
            ->exists()
            : false;

        /*
    |--------------------------------------------------------------------------
    | EVENT DIIKUTI (PESERTA)
    |--------------------------------------------------------------------------
    */
        $schedules = collect();

        if ($userId) {
            $schedules = DB::table('peserta')
                ->join('event', 'peserta.id_event', '=', 'event.id')
                ->where('peserta.id_user', $userId)
                ->select(
                    'peserta.id_peserta',
                    'event.id',
                    'event.Nama_Event',
                    'event.Tanggal',
                    'event.Lokasi',
                    'event.Jenis_Event',
                    'event.Pemateri',
                    'event.Harga',
                    'peserta.nomor_tiket',
                    'peserta.metode_bayar'
                )
                ->orderBy('event.Tanggal', 'asc')
                ->get();
        }

        /*
    |--------------------------------------------------------------------------
    | EVENT DISELENGGARAKAN
    |--------------------------------------------------------------------------
    */
        $eventDiselenggarakan = collect();

        if ($isPenyelenggara) {

            $dataPenyelenggara = DB::table('penyelenggara')
                ->where('id_user', $userId)
                ->first();

            if ($dataPenyelenggara) {

                $eventDiselenggarakan = DB::table('event')
                    ->where('id_penyelenggara', $dataPenyelenggara->id_penyelenggara)
                    ->select(
                        'id',
                        'Nama_Event',
                        'Tanggal',
                        'Jenis_Event',
                        'Lokasi',
                        'Harga',
                        'Pemateri'
                    )
                    ->orderBy('Tanggal', 'asc')
                    ->get();
            }
        }

        /*
    |--------------------------------------------------------------------------
    | EVENT SEBAGAI PEMBICARA
    |--------------------------------------------------------------------------
    */
        $eventSebagaiPembicara = collect();

        if ($isPembicara) {

            $dataPembicara = DB::table('pembicara')
                ->where('email_pembicara', $user->email_user)
                ->first();

            if ($dataPembicara) {

                $eventSebagaiPembicara = DB::table('lamaran_pembicara')
                    ->join('event', 'lamaran_pembicara.id_event', '=', 'event.id')
                    ->where('lamaran_pembicara.id_pembicara', $dataPembicara->id_pembicara)
                    ->where('lamaran_pembicara.status', 'diterima')
                    ->select(
                        'event.id',
                        'event.Nama_Event',
                        'event.Tanggal',
                        'event.Lokasi',
                        'event.Jenis_Event',
                        'event.Harga',
                        'event.Pemateri'
                    )
                    ->orderBy('event.Tanggal', 'asc')
                    ->get();
            }
        }

        /*
    |--------------------------------------------------------------------------
    | NOTIFIKASI
    |--------------------------------------------------------------------------
    */
        $notifikasi = [];

        if ($userId && $user) {

            // Peserta
            $eventDiikuti = DB::table('peserta')
                ->join('event', 'peserta.id_event', '=', 'event.id')
                ->where('peserta.id_user', $userId)
                ->select(
                    'event.Nama_Event',
                    'peserta.created_at'
                )
                ->orderBy('peserta.created_at', 'desc')
                ->get();

            foreach ($eventDiikuti as $e) {

                $notifikasi[] = [
                    'icon'  => 'check_circle',
                    'color' => 'text-teal-500',
                    'pesan' => 'Kamu berhasil mendaftar event <b>' . $e->Nama_Event . '</b>',
                    'waktu' => $e->created_at,
                ];
            }

            /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI PEMBICARA
        |--------------------------------------------------------------------------
        */
            if ($isPembicara) {

                $dataPembicara = DB::table('pembicara')
                    ->where('email_pembicara', $user->email_user)
                    ->first();

                if ($dataPembicara) {

                    $notifikasi[] = [
                        'icon'  => 'mic',
                        'color' => 'text-blue-500',
                        'pesan' => 'Kamu telah terdaftar sebagai <b>Pembicara</b>',
                        'waktu' => $dataPembicara->created_at ?? null,
                    ];

                    $lamaranPembicara = DB::table('lamaran_pembicara')
                        ->join('event', 'lamaran_pembicara.id_event', '=', 'event.id')
                        ->where('lamaran_pembicara.id_pembicara', $dataPembicara->id_pembicara)
                        ->whereIn('lamaran_pembicara.status', ['diterima', 'ditolak'])
                        ->select(
                            'lamaran_pembicara.status',
                            'lamaran_pembicara.updated_at',
                            'event.Nama_Event'
                        )
                        ->orderBy('lamaran_pembicara.updated_at', 'desc')
                        ->get();

                    foreach ($lamaranPembicara as $l) {

                        $notifikasi[] = [
                            'icon'  => $l->status == 'diterima'
                                ? 'thumb_up'
                                : 'thumb_down',

                            'color' => $l->status == 'diterima'
                                ? 'text-green-500'
                                : 'text-red-500',

                            'pesan' => 'Lamaran kamu di event <b>' . $l->Nama_Event . '</b> telah <b>' . $l->status . '</b>',

                            'waktu' => $l->updated_at,
                        ];
                    }
                }
            }

            /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI PENYELENGGARA
        |--------------------------------------------------------------------------
        */
            if ($isPenyelenggara) {

                $dataPenyelenggara = DB::table('penyelenggara')
                    ->where('id_user', $userId)
                    ->first();

                if ($dataPenyelenggara) {

                    $notifikasi[] = [
                        'icon'  => 'business',
                        'color' => 'text-purple-500',
                        'pesan' => 'Kamu telah terdaftar sebagai <b>Penyelenggara</b>',
                        'waktu' => $dataPenyelenggara->created_at ?? null,
                    ];

                    $eventIds = DB::table('event')
                        ->where('id_penyelenggara', $dataPenyelenggara->id_penyelenggara)
                        ->pluck('id');

                    // Total peserta
                    $pesertaPerEvent = DB::table('peserta')
                        ->join('event', 'peserta.id_event', '=', 'event.id')
                        ->whereIn('peserta.id_event', $eventIds)
                        ->selectRaw('event.Nama_Event, COUNT(peserta.id_peserta) as total')
                        ->groupBy('event.id', 'event.Nama_Event')
                        ->get();

                    foreach ($pesertaPerEvent as $p) {

                        $notifikasi[] = [
                            'icon'  => 'groups',
                            'color' => 'text-teal-500',
                            'pesan' => '<b>' . $p->total . ' peserta</b> telah mendaftar di event <b>' . $p->Nama_Event . '</b>',
                            'waktu' => null,
                        ];
                    }

                    // Lamaran pembicara masuk
                    $lamaranMasuk = DB::table('lamaran_pembicara')
                        ->join('event', 'lamaran_pembicara.id_event', '=', 'event.id')
                        ->whereIn('lamaran_pembicara.id_event', $eventIds)
                        ->where('lamaran_pembicara.status', 'pending')
                        ->selectRaw('event.Nama_Event, COUNT(lamaran_pembicara.id) as total')
                        ->groupBy('event.id', 'event.Nama_Event')
                        ->get();

                    foreach ($lamaranMasuk as $lm) {

                        $notifikasi[] = [
                            'icon'  => 'person_add',
                            'color' => 'text-orange-500',
                            'pesan' => '<b>' . $lm->total . ' pembicara</b> melamar di event <b>' . $lm->Nama_Event . '</b>',
                            'waktu' => null,
                        ];
                    }
                }
            }
        }

        usort(
            $notifikasi,
            fn($a, $b) =>
            strtotime($b['waktu'] ?? '1970-01-01')
                -
                strtotime($a['waktu'] ?? '1970-01-01')
        );

        return view('Pengguna.schedule', compact(
            'user',
            'schedules',
            'isPenyelenggara',
            'isPembicara',
            'eventDiselenggarakan',
            'eventSebagaiPembicara',
            'notifikasi'
        ));
    }
}
