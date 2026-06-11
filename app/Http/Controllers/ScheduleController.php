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
}
