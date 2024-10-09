<?php

namespace App\Http\Controllers\Admin;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan') . $request->get('tahun');

        if ($bulan === '') {
            $bulanSaatIni = ltrim(date('m') . date('Y'), '0');
            $absensis = Absensi::with('user')->where('bulan', $bulanSaatIni)->get();
        } else {
            $absensis = Absensi::with('user')->where('bulan', $bulan)->get();
        }

        return view('admin.absensis.index', compact('absensis'));
    }

    public function show(Request $request)
    {
        if ($request) {
            # code...
            $bulan = $request->get('bulan');
            $tahun = $request->get('tahun');

            // Format bulan menjadi dua digit
            $bulanFormat = str_pad($bulan, 2, '0', STR_PAD_LEFT);
            $bulanTahun = $bulanFormat . $tahun;

            if (empty($bulan) || empty($tahun)) {

                $bulanSaatIni = ltrim(date('m') . date('Y'), '0');
                $absensis = DB::select("
                    SELECT users.*, jabatan.nama as nama_jabatan
                    FROM users
                    JOIN jabatan ON users.jabatan_id = jabatan.id
                    WHERE NOT EXISTS (
                        SELECT * FROM absensi
                        WHERE bulan = ?
                        AND users.id = absensi.user_id
                    )", [$bulanSaatIni]);
            } else {

                $absensis = DB::select("
                    SELECT users.*, jabatan.nama as nama_jabatan
                    FROM users
                    JOIN jabatan ON users.jabatan_id = jabatan.id
                    WHERE NOT EXISTS (
                        SELECT * FROM absensi
                        WHERE bulan = ?
                        AND users.id = absensi.user_id
                    )", [$bulanTahun]);
            }
        }

        return view('admin.absensis.show', compact('absensis'));
    }

    public function store(Request $request)
    {
        dd('tes');
        $request->validate([
            'hadir' => 'nullable|array',
            'izin' => 'nullable|array',
            'alpha' => 'nullable|array',
            'karyawan_id' => 'required|array',
        ]);

        foreach ($request->karyawan_id as $key => $id) {
            $input['user_id'] = $id;
            $input['bulan'] = $request->bulan;
            $input['hadir'] = $request->hadir[$key] ?? 0; // Default to 0 if null
            $input['izin'] = $request->izin[$key] ?? 0;   // Default to 0 if null
            $input['alpha'] = $request->alpha[$key] ?? 0; // Default to 0 if null

            // Cek apakah ada data yang diisi
            if ($input['hadir'] || $input['izin'] || $input['alpha']) {
                Absensi::create($input);
            }
        }

        // return redirect()->back()->with([
        //     'message' => 'berhasil di edit',
        //     'alert-info' => 'success'
        // ]);
    }
}
