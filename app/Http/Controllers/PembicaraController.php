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

        // Tambahkan ini: event yang pembicara ini sudah diterima & dipublish
        $eventSayaSebagaiPembicara = DB::table('lamaran_pembicara')
            ->join('event', 'lamaran_pembicara.id_event', '=', 'event.id')
            ->where('lamaran_pembicara.id_pembicara', $pembicara->id_pembicara)
            ->where('lamaran_pembicara.status', 'diterima')
            ->whereNotNull('event.Pemateri')
            ->where('event.Pemateri', '!=', '')
            ->select('event.*')
            ->orderBy('event.Tanggal', 'asc')
            ->get();

        return view('Pembicara.dashboard', compact(
            'user',
            'pembicara',
            'eventTersedia',
            'eventDilamar',
            'eventSayaSebagaiPembicara'
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
