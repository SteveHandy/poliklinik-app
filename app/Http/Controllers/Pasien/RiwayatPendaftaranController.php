<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use Illuminate\Support\Facades\Auth;

class RiwayatPendaftaranController extends Controller
{
    /**
     * Menampilkan seluruh riwayat pendaftaran poli
     * milik pasien yang sedang login.
     */
    public function index()
    {
        $riwayats = DaftarPoli::with([
            'jadwalPeriksa.dokter.poli',
            'periksas',
        ])
            ->where('id_pasien', Auth::id())
            ->latest()
            ->get();

        return view(
            'pasien.riwayat-pendaftaran.index',
            compact('riwayats')
        );
    }


    /**
     * Menampilkan detail hasil pemeriksaan.
     */
    public function show(DaftarPoli $riwayat_pendaftaran)
    {
        /*
        |--------------------------------------------------------------------------
        | Keamanan
        |--------------------------------------------------------------------------
        |
        | Pasien hanya boleh membuka riwayat miliknya sendiri.
        |
        */
        // dd($riwayat_pendaftaran);
        $riwayat = $riwayat_pendaftaran;
        if ($riwayat->id_pasien != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke riwayat ini.');
        }


        /*
        |--------------------------------------------------------------------------
        | Load seluruh data yang dibutuhkan
        |--------------------------------------------------------------------------
        */

        $riwayat->load([
            'pasien',
            'jadwalPeriksa.dokter.poli',
            'periksas.detailPeriksas.obat',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Pastikan pasien sudah diperiksa
        |--------------------------------------------------------------------------
        */

        if ($riwayat->periksas->isEmpty()) {
            return redirect()
                ->route('riwayat-pendaftaran.index')
                ->with(
                    'error',
                    'Detail pemeriksaan belum tersedia karena pasien belum diperiksa.'
                );
        }


        return view(
            'pasien.riwayat-pendaftaran.show',
            compact('riwayat')
        );
    }
}
