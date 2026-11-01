<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoliController extends Controller
{
    public function get()
    {
        $user = Auth::user();

        $polis = Poli::all();

        $jadwal = JadwalPeriksa::with([
            'dokter',
            'dokter.poli'
        ])->get();

        return view('pasien.daftar', [
            'user' => $user,
            'polis' => $polis,
            'jadwals' => $jadwal,
        ]);
    }


    public function submit(Request $request)
    {
        $userId = Auth::id();


        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'id_poli' => 'required|exists:poli,id',
            'id_jadwal' => 'required|exists:jadwal_periksa,id',
            'keluhan' => 'nullable|string',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Cek apakah pasien masih punya pendaftaran aktif
        |--------------------------------------------------------------------------
        |
        | Pendaftaran dianggap masih aktif jika belum memiliki
        | data pemeriksaan pada tabel periksa.
        |
        */

        $pendaftaranAktif = DaftarPoli::where('id_pasien', $userId)
            ->whereDoesntHave('periksas')
            ->exists();


        if ($pendaftaranAktif) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Anda masih memiliki antrian aktif. Anda hanya dapat mendaftar kembali setelah proses pemeriksaan selesai.'
                )
                ->with('type', 'error');
        }


        /*
        |--------------------------------------------------------------------------
        | Pastikan jadwal sesuai dengan poli yang dipilih
        |--------------------------------------------------------------------------
        */

        $jadwal = JadwalPeriksa::with('dokter')
            ->findOrFail($request->id_jadwal);


        if (
            !$jadwal->dokter ||
            $jadwal->dokter->id_poli != $request->id_poli
        ) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Jadwal yang dipilih tidak sesuai dengan poli.'
                )
                ->with('type', 'error');
        }


        /*
        |--------------------------------------------------------------------------
        | Hitung nomor antrian
        |--------------------------------------------------------------------------
        */

        $jumlahSudahDaftar = DaftarPoli::where(
            'id_jadwal',
            $request->id_jadwal
        )->count();


        $nomorAntrian = $jumlahSudahDaftar + 1;


        /*
        |--------------------------------------------------------------------------
        | Simpan pendaftaran
        |--------------------------------------------------------------------------
        */

        DaftarPoli::create([
            'id_pasien' => $userId,
            'id_jadwal' => $request->id_jadwal,
            'keluhan' => $request->keluhan,
            'no_antrian' => $nomorAntrian,
        ]);


        return redirect()
            ->back()
            ->with(
                'success',
                'Berhasil mendaftar ke poli. Nomor antrian Anda adalah ' . $nomorAntrian . '.'
            )
            ->with('type', 'success');
    }
}
