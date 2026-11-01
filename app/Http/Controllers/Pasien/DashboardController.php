<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | Antrian Aktif Pasien
        |--------------------------------------------------------------------------
        |
        | Pendaftaran dianggap aktif apabila belum memiliki data pemeriksaan.
        |
        */

        $antrianAktif = DaftarPoli::with([
            'jadwalPeriksa.dokter.poli',
        ])
            ->where('id_pasien', $userId)
            ->whereDoesntHave('periksas')
            ->latest()
            ->first();


        /*
        |--------------------------------------------------------------------------
        | Nomor Sedang Dilayani untuk Antrian Pasien
        |--------------------------------------------------------------------------
        */

        $nomorSedangDilayani = null;

        if ($antrianAktif) {

            $nomorSedangDilayani = DaftarPoli::where(
                'id_jadwal',
                $antrianAktif->id_jadwal
            )
                ->whereDoesntHave('periksas')
                ->orderBy('no_antrian')
                ->value('no_antrian');
        }


        /*
        |--------------------------------------------------------------------------
        | Semua Jadwal Poli
        |--------------------------------------------------------------------------
        */

        $jadwals = JadwalPeriksa::with([
            'dokter.poli',
        ])
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Tambahkan Nomor Sedang Dilayani pada Setiap Jadwal
        |--------------------------------------------------------------------------
        */

        foreach ($jadwals as $jadwal) {

            $jadwal->nomor_sedang_dilayani = DaftarPoli::where(
                'id_jadwal',
                $jadwal->id
            )
                ->whereDoesntHave('periksas')
                ->orderBy('no_antrian')
                ->value('no_antrian');
        }


        return view(
            'pasien.dashboard',
            compact(
                'antrianAktif',
                'nomorSedangDilayani',
                'jadwals'
            )
        );
    }
}
