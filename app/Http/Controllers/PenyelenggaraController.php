<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenyelenggaraController extends Controller
{
    private function getUser()
    {
        if (!session('user_id')) return null;
        return DB::table('user')->where('id_user', session('user_id'))->first();
    }

    private function getPenyelenggara($user)
    {
        return DB::table('penyelenggara')->where('id_user', $user->id_user)->first();
    }

    // ===================== DAFTAR PENYELENGGARA =====================

    public function index()
    {
        $user = $this->getUser();
        if (!$user) return redirect()->route('login');

        $sudahDaftar = DB::table('penyelenggara')->where('id_user', $user->id_user)->exists();
        if ($sudahDaftar) return redirect()->route('penyelenggara.dashboard');

        return view('penyelenggara.daftar', compact('user'));
    }

    public function store(Request $request)
    {
        $user = $this->getUser();
        if (!$user) return redirect()->route('login');

        $request->validate([
            'instansi'            => 'required|string|max:255',
            'peran'               => 'required|string',
            'deskripsi_instansi'  => 'required|string',
            'portofolio_instansi' => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:10240',
        ]);

        $file     = $request->file('portofolio_instansi');
        $namaFile = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/portofolio'), $namaFile);

        DB::table('penyelenggara')->insert([
            'id_user'             => $user->id_user,
            'instansi'            => $request->instansi,
            'peran'               => $request->peran,
            'deskripsi_instansi'  => $request->deskripsi_instansi,
            'portofolio_instansi' => $namaFile,
        ]);

        return redirect()->route('penyelenggara.dashboard')
            ->with('success', 'Pendaftaran berhasil! Akun Anda terdaftar sebagai Penyelenggara.');
    }

    public function dashboard()
    {
        $user = $this->getUser();
        if (!$user) return redirect()->route('login');
        $penyelenggara = $this->getPenyelenggara($user);
        if (!$penyelenggara) return redirect()->route('Penyelenggara.index');

        $eventsPublished = DB::table('event')
            ->where('id_penyelenggara', $penyelenggara->id_penyelenggara)
            ->whereNotNull('Pemateri')
            ->where('Pemateri', '!=', '')
            ->orderBy('id', 'desc')
            ->get();

        $eventsMenunggu = DB::table('event')
            ->where('id_penyelenggara', $penyelenggara->id_penyelenggara)
            ->where(function ($q) {
                $q->whereNull('Pemateri')->orWhere('Pemateri', '');
            })
            ->orderBy('id', 'desc')
            ->get();

        $totalEvent = $eventsPublished->count() + $eventsMenunggu->count();

        $pembicaraTerdaftar = DB::table('pembicara')
            ->leftJoin('user', 'pembicara.email_pembicara', '=', 'user.email_user')
            ->select('pembicara.*', 'user.foto_profil')
            ->get();

        // Tambahan ini ↓
        $totalPembicara = DB::table('pembicara')->count();

        $eventIds = DB::table('event')
            ->where('id_penyelenggara', $penyelenggara->id_penyelenggara)
            ->pluck('id');

        $totalPendapatan = DB::table('peserta')
            ->join('event', 'peserta.id_event', '=', 'event.id')
            ->whereIn('peserta.id_event', $eventIds)
            ->sum('event.Harga');

        $saldo = $totalPendapatan - $penyelenggara->saldo;

        $pendapatanPerBulan = DB::table('peserta')
            ->join('event', 'peserta.id_event', '=', 'event.id')
            ->whereIn('peserta.id_event', $eventIds)
            ->where('event.Harga', '>', 0)
            ->whereRaw('peserta.created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)')
            ->selectRaw('DATE_FORMAT(peserta.created_at, "%b %Y") as bulan, MONTH(peserta.created_at) as bln, YEAR(peserta.created_at) as thn, SUM(event.Harga) as total')
            ->groupByRaw('thn, bln, bulan')
            ->orderByRaw('thn ASC, bln ASC')
            ->get();

        $pesertaPerEvent = DB::table('peserta')
            ->join('event', 'peserta.id_event', '=', 'event.id')
            ->whereIn('peserta.id_event', $eventIds)
            ->selectRaw('event.Nama_Event, COUNT(peserta.id_peserta) as total_peserta')
            ->groupBy('event.id', 'event.Nama_Event')
            ->orderBy('total_peserta', 'desc')
            ->get();

        return view('Penyelenggara.dashboard', compact(
            'user',
            'penyelenggara',
            'totalEvent',
            'eventsPublished',
            'eventsMenunggu',
            'pembicaraTerdaftar',
            'totalPembicara',
            'totalPendapatan',
            'saldo',
            'pendapatanPerBulan',
            'pesertaPerEvent'
        ));
    }

    public function tarikSaldo(Request $request)
    {
        $user = $this->getUser();
        if (!$user) return redirect()->route('login');

        $penyelenggara = $this->getPenyelenggara($user);

        // Verifikasi password
        if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->password_user)) {
            return back()->with('error_tarik', 'Password salah! Penarikan dibatalkan.');
        }

        // Hitung saldo tersedia
        $eventIds = DB::table('event')
            ->where('id_penyelenggara', $penyelenggara->id_penyelenggara)
            ->pluck('id');

        $totalPendapatan = DB::table('peserta')
            ->join('event', 'peserta.id_event', '=', 'event.id')
            ->whereIn('peserta.id_event', $eventIds)
            ->sum('event.Harga');

        $saldo = $totalPendapatan - $penyelenggara->saldo;

        if ($saldo <= 0) {
            return back()->with('error_tarik', 'Saldo tidak cukup untuk ditarik.');
        }

        // Tandai sudah ditarik dengan menambah kolom saldo (saldo = total yang sudah ditarik)
        DB::table('penyelenggara')
            ->where('id_penyelenggara', $penyelenggara->id_penyelenggara)
            ->update(['saldo' => $penyelenggara->saldo + $saldo]);

        return back()->with('success_tarik', 'Penarikan berhasil! Rp ' . number_format($saldo, 0, ',', '.') . ' akan dikirim ke ' . $request->tujuan . ' ' . $request->nomor_tujuan);
    }

    // ===================== CREATE EVENT =====================

    public function createevent()
    {
        $user = $this->getUser();
        if (!$user) return redirect()->route('login');

        return view('penyelenggara.createevent', compact('user'));
    }

    public function storeEvent(Request $request)
    {
        $user = $this->getUser();
        if (!$user) return redirect()->route('login');

        // Ambil penyelenggara — ini yang sebelumnya hilang!
        $penyelenggara = $this->getPenyelenggara($user);
        if (!$penyelenggara) return redirect()->route('penyelenggara.index');

        $request->validate([
            'nama_event'  => 'required|string|max:255',
            'jenis_event' => 'required|string',
            'deskripsi'   => 'required|string',
            'tanggal'     => 'required|date',
            'lokasi'      => 'required|string',
            'Harga'       => 'required|string',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'jam' => 'required',
        ]);

        $namaGambar = 'default.png';
        if ($request->hasFile('gambar')) {
            $file       = $request->file('gambar');
            $namaGambar = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload'), $namaGambar);
        }

        DB::table('event')->insert([
            'Nama_Event'       => $request->nama_event,
            'Jenis_Event'      => $request->jenis_event,
            'Deskripsi'        => $request->deskripsi,
            'Tanggal'          => $request->tanggal,
            'Lokasi'           => $request->lokasi,
            'Harga'            => $request->Harga,
            'Pemateri'         => $request->pemateri ?: null,
            'Gambar'           => $namaGambar,
            'id_penyelenggara' => $penyelenggara->id_penyelenggara,
            'Status'           => $request->input('status', 'draft'), // ← TAMBAH INI
            'Jam' => $request->jam,
        ]);
        return redirect()->route('penyelenggara.dashboard')
            ->with('success', 'Event berhasil dibuat!');
    }

    // ===================== EDIT EVENT =====================

    public function editEvent($id)
    {
        $user = $this->getUser();
        if (!$user) return redirect()->route('login');

        $penyelenggara = $this->getPenyelenggara($user);
        $event = DB::table('event')
            ->where('id', $id)
            ->where('id_penyelenggara', $penyelenggara->id_penyelenggara)
            ->first();

        if (!$event) abort(404);

        return view('penyelenggara.editevent', compact('user', 'event'));
    }

    // ===================== UPDATE EVENT =====================

    public function updateEvent(Request $request, $id)
    {
        $user = $this->getUser();
        if (!$user) return redirect()->route('login');

        $penyelenggara = $this->getPenyelenggara($user);
        $event = DB::table('event')
            ->where('id', $id)
            ->where('id_penyelenggara', $penyelenggara->id_penyelenggara)
            ->first();

        if (!$event) abort(404);

        $request->validate([
            'Nama_Event'  => 'required|string|max:255',
            'Jenis_Event' => 'required|string',
            'Deskripsi'   => 'required|string',
            'Tanggal'     => 'required|date',
            'Lokasi'      => 'required|string',
            'harga'       => 'required|string',
            'Pemateri'    => 'nullable|string',
            'Gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'Jam' => 'required',
        ]);

        $namaGambar = $event->Gambar;
        if ($request->hasFile('Gambar')) {
            $pathLama = public_path('upload/' . $event->Gambar);
            if (file_exists($pathLama) && $event->Gambar !== 'default.png') {
                unlink($pathLama);
            }
            $file       = $request->file('Gambar');
            $namaGambar = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload'), $namaGambar);
        }

        DB::table('event')->where('id', $id)->update([
            'Jenis_Event' => $request->Jenis_Event,
            'Nama_Event'  => $request->Nama_Event,
            'Deskripsi'   => $request->Deskripsi,
            'Tanggal'     => $request->Tanggal,
            'Lokasi'      => $request->Lokasi,
            'Harga'       => $request->harga,
            'Pemateri'    => $event->Status === 'published'
                ? $event->Pemateri
                : $request->Pemateri,
            'Gambar'      => $namaGambar,
            'Jam'         => $request->Jam,
        ]);

        return redirect()->route('penyelenggara.dashboard')
            ->with('success', 'Event berhasil diperbarui!');
    }

    // ===================== DELETE EVENT =====================

    public function deleteEvent($id)
    {
        $user = $this->getUser();
        if (!$user) return redirect()->route('login');

        $penyelenggara = $this->getPenyelenggara($user);
        $event = DB::table('event')
            ->where('id', $id)
            ->where('id_penyelenggara', $penyelenggara->id_penyelenggara)
            ->first();

        if (!$event) abort(404);

        $pathGambar = public_path('upload/' . $event->Gambar);
        if (file_exists($pathGambar) && $event->Gambar !== 'default.png') {
            unlink($pathGambar);
        }

        DB::table('event')->where('id', $id)->delete();

        return redirect()->route('penyelenggara.dashboard')
            ->with('success', 'Event berhasil dihapus.');
    }

    public function terimaLamaran($id)
    {
        DB::table('lamaran_pembicara')->where('id', $id)->update(['status' => 'diterima']);

        return redirect()->route('penyelenggara.dashboard')->with('success', 'Lamaran berhasil diterima.');
    }

    public function tolakLamaran($id)
    {
        DB::table('lamaran_pembicara')->where('id', $id)->update(['status' => 'ditolak']);

        return redirect()->route('penyelenggara.dashboard')->with('success', 'Lamaran berhasil ditolak.');
    }

    public function publishEvent($id)
    {
        $user = $this->getUser();
        if (!$user) return redirect()->route('login');

        $penyelenggara = $this->getPenyelenggara($user);

        // Ambil nama pembicara dari lamaran yang diterima untuk event ini
        $lamaran = DB::table('lamaran_pembicara')
            ->join('pembicara', 'lamaran_pembicara.id_pembicara', '=', 'pembicara.id_pembicara')
            ->where('lamaran_pembicara.id_event', $id)
            ->where('lamaran_pembicara.status', 'diterima')
            ->select('pembicara.nama_pembicara')
            ->first();

        $pemateri = $lamaran ? $lamaran->nama_pembicara : 'TBA';

        DB::table('event')
            ->where('id', $id)
            ->where('id_penyelenggara', $penyelenggara->id_penyelenggara)
            ->update(['Pemateri' => $pemateri]);

        return redirect()->route('penyelenggara.dashboard')
            ->with('success', 'Event berhasil dipublish!');
    }

    public function getPeserta($id)
    {
        $peserta = DB::table('peserta')
            ->join('user', 'peserta.id_user', '=', 'user.id_user')
            ->where('peserta.id_event', $id)
            ->select('user.nama_user', 'peserta.no_wa', 'peserta.metode_bayar')
            ->get();

        return response()->json($peserta);
    }
}
