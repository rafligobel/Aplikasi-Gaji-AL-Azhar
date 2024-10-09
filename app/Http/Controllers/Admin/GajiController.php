<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PotonganGaji;

class GajiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil potongan gaji
        $potongan_alpha = PotonganGaji::where('jenis_potongan', 'alpha')->get();
        $potongan_izin = PotonganGaji::where('jenis_potongan', 'izin')->get();

        // Ambil bulan dan tahun dari request
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');

        // Pastikan bulan dan tahun tidak kosong
        if (empty($bulan) || empty($tahun)) {
            // Jika kosong, ambil bulan dan tahun saat ini
            $bulan = date('m');
            $tahun = date('Y');
        }

        // Buat variabel untuk query
        $tanggal = str_pad($bulan, 2, '0', STR_PAD_LEFT) . $tahun;

        // Gunakan parameter binding untuk query
        $items = DB::select("
        SELECT users.nik, users.nama, users.jenis_kelamin, jabatan.nama as nama_jabatan, jabatan.gaji_pokok, jabatan.transportasi, jabatan.uang_makan, absensi.alpha, absensi.izin
        FROM users 
        JOIN absensi ON absensi.user_id = users.id
        JOIN jabatan ON jabatan.id = users.jabatan_id
        WHERE absensi.bulan = ?
    ", [$tanggal]);

        return view('admin.gaji.index', compact('items', 'potongan_alpha', 'potongan_izin'));
    }


    public function cetak($bulan, $tahun)
    {
        $potongan_alpha = PotonganGaji::where('jenis_potongan', 'alpha')->get();
        $potongan_izin = PotonganGaji::where('jenis_potongan', 'izin')->get();

        // Buat variabel untuk query
        $tanggal = str_pad($bulan, 2, '0', STR_PAD_LEFT) . $tahun;

        $items = DB::select("
        SELECT users.nik, users.nama, users.jenis_kelamin, jabatan.nama as nama_jabatan, jabatan.gaji_pokok, jabatan.transportasi, jabatan.uang_makan, absensi.alpha, absensi.izin
        FROM users 
        JOIN absensi ON absensi.user_id = users.id
        JOIN jabatan ON jabatan.id = users.jabatan_id
        WHERE absensi.bulan = ?
    ", [$tanggal]);

        return view('admin.gaji.cetak', compact('items', 'bulan', 'tahun', 'potongan_alpha', 'potongan_izin'));
    }
}
