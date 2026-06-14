<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembicaraController extends Controller
{
    private function getUser()
    {
        if (!session('user_id')) return null;
        return DB::table('user')->where('id_user', session('user_id'))->first();
    }

    // ===================== FORM DAFTAR =====================

    public function index()
    {
        $user = $this->getUser();
        if (!$user) return redirect()->route('login');

        // Jika sudah daftar, langsung ke dashboard
        $sudahDaftar = DB::table('pembicara')
            ->where('email_pembicara', $user->email_user)
            ->exists();

        if ($sudahDaftar) {
            return redirect()->route('pembicara.dashboard');
        }

        return view('Pembicara.daftar', compact('user'));
    }

    public function store(Request $request)
    {
        $user = $this->getUser();
        if (!$user) return redirect()->route('login');

        $request->validate([
            'nama'        => 'required|string|max:255',
            'email'       => 'required|email',
            'linkedin'    => 'nullable|url',
            'keahlian'    => 'required|string|max:255',
            'jenis_event' => 'required|string',
            'topik_event' => 'required|string',
            'pengalaman'  => 'nullable|string',
            'portofolio'  => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:10240',
        ]);

        $file     = $request->file('portofolio');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/portofolio'), $namaFile);

        DB::table('pembicara')->insert([
            'nama_pembicara'  => $request->nama,
            'email_pembicara' => $request->email,
            'linkedin'        => $request->linkedin,
            'bidang_keahlian' => $request->keahlian,
            'jenis_event'     => $request->jenis_event,
            'topik_event'     => $request->topik_event,
            'pengalaman'      => $request->pengalaman,
            'portofolio'      => $namaFile,
        ]);

        return redirect()->route('pembicara.dashboard')
            ->with('success', 'Pendaftaran berhasil! Selamat bergabung sebagai Pembicara.');
    }

    // ===================== DASHBOARD =====================

    public function dashboard()
    {
        $user = $this->getUser();
        if (!$user) return redirect()->route('login');

        $pembicara = DB::table('pembicara')
            ->where('email_pembicara', $user->email_user)
            ->first();

        if (!$pembicara) return redirect()->route('pembicara.index');

        $eventTersedia = DB::table('event')
            ->where(function ($q) {
                $q->whereNull('Pemateri')->orWhere('Pemateri', '');
            })
            ->orderBy('Tanggal', 'asc')
            ->get();

        $eventDilamar = DB::table('lamaran_pembicara')
            ->where('id_pembicara', $pembicara->id_pembicara)
            ->pluck('id_event')
            ->toArray();

        $eventSayaSebagaiPembicara = DB::table('lamaran_pembicara')
            ->join('event', 'lamaran_pembicara.id_event', '=', 'event.id')
            ->where('lamaran_pembicara.id_pembicara', $pembicara->id_pembicara)
            ->where('lamaran_pembicara.status', 'diterima')
            ->whereNotNull('event.Pemateri')
            ->where('event.Pemateri', '!=', '')
            ->select('event.*')
            ->orderBy('event.Tanggal', 'asc')
            ->get();

        // ===== NOTIFIKASI =====
        $isPenyelenggara = DB::table('penyelenggara')->where('id_user', session('user_id'))->exists();
        $isPembicara = true;
        $penyelenggara = $isPenyelenggara ? DB::table('penyelenggara')->where('id_user', session('user_id'))->first() : null;
        $userId = session('user_id');

        $notifikasi = [];

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

        $notifikasi[] = [
            'icon' => 'mic',
            'color' => 'text-blue-500',
            'pesan' => 'Kamu telah terdaftar sebagai <b>Pembicara</b>',
            'waktu' => $pembicara->created_at ?? null,
        ];

        $lamaranPembicara = DB::table('lamaran_pembicara')
            ->join('event', 'lamaran_pembicara.id_event', '=', 'event.id')
            ->where('lamaran_pembicara.id_pembicara', $pembicara->id_pembicara)
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

        if ($isPenyelenggara && $penyelenggara) {
            $notifikasi[] = [
                'icon' => 'business',
                'color' => 'text-purple-500',
                'pesan' => 'Kamu telah terdaftar sebagai <b>Penyelenggara</b>',
                'waktu' => $penyelenggara->created_at ?? null,
            ];

            $eventIds = DB::table('event')
                ->where('id_penyelenggara', $penyelenggara->id_penyelenggara)
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

            $tarikHariIni = DB::table('penyelenggara')
                ->where('id_penyelenggara', $penyelenggara->id_penyelenggara)
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

        usort($notifikasi, fn($a, $b) => strtotime($b['waktu'] ?? '1970-01-01') - strtotime($a['waktu'] ?? '1970-01-01'));
        // ===== END NOTIFIKASI =====

        return view('Pembicara.dashboard', compact(
            'user',
            'pembicara',
            'eventTersedia',
            'eventDilamar',
            'eventSayaSebagaiPembicara',
            'notifikasi'
        ));
    }
    // ===================== LAMAR EVENT =====================

    public function lamar(Request $request, $event_id)
    {
        $user = $this->getUser();
        if (!$user) return redirect()->route('login');

        $pembicara = DB::table('pembicara')
            ->where('email_pembicara', $user->email_user)
            ->first();

        if (!$pembicara) {
            return redirect()->route('pembicara.index');
        }

        // Cek sudah lamar atau belum
        $sudahLamar = DB::table('lamaran_pembicara')
            ->where('id_pembicara', $pembicara->id_pembicara)
            ->where('id_event', $event_id)
            ->exists();

        if (!$sudahLamar) {
            DB::table('lamaran_pembicara')->insert([
                'id_pembicara' => $pembicara->id_pembicara,
                'id_event'     => $event_id,
                'status'       => 'pending',
                'created_at'   => now(),
            ]);
        }

        return redirect()->route('pembicara.dashboard')
            ->with('success', 'Lamaran berhasil dikirim! Penyelenggara akan menghubungi kamu.');
    }
}
