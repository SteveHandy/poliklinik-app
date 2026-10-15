<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPeriksaController extends Controller
{
    /**
     * Menampilkan semua jadwal periksa
     * milik dokter yang sedang login.
     */
    public function index()
    {
        $jadwals = JadwalPeriksa::where('id_dokter', Auth::id())
            ->orderByRaw("
                CASE hari
                    WHEN 'Senin' THEN 1
                    WHEN 'Selasa' THEN 2
                    WHEN 'Rabu' THEN 3
                    WHEN 'Kamis' THEN 4
                    WHEN 'Jumat' THEN 5
                    WHEN 'Sabtu' THEN 6
                    WHEN 'Minggu' THEN 7
                END
            ")
            ->orderBy('jam_mulai')
            ->get();

        return view('dokter.jadwal-periksa.index', compact('jadwals'));
    }

    /**
     * Menampilkan form tambah jadwal periksa.
     */
    public function create()
    {
        return view('dokter.jadwal-periksa.create');
    }

    /**
     * Menyimpan jadwal periksa baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hari' => [
                'required',
                'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            ],
            'jam_mulai' => [
                'required',
                'date_format:H:i',
            ],
            'jam_selesai' => [
                'required',
                'date_format:H:i',
                'after:jam_mulai',
            ],
        ], [
            'hari.required' => 'Hari wajib dipilih.',
            'hari.in' => 'Hari yang dipilih tidak valid.',

            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid.',

            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid.',
            'jam_selesai.after' => 'Jam selesai harus lebih besar dari jam mulai.',
        ]);

        JadwalPeriksa::create([
            'id_dokter' => Auth::id(),
            'hari' => $validated['hari'],
            'jam_mulai' => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
        ]);

        return redirect()
            ->route('jadwal-periksa.index')
            ->with('success', 'Jadwal periksa berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit jadwal periksa.
     */
    public function edit(JadwalPeriksa $jadwal_periksa)
    {
        // Dokter hanya boleh mengubah jadwal miliknya sendiri.
        if ($jadwal_periksa->id_dokter !== Auth::id()) {
            abort(403);
        }

        return view(
            'dokter.jadwal-periksa.edit',
            compact('jadwal_periksa')
        );
    }

    /**
     * Memperbarui jadwal periksa.
     */
    public function update(
        Request $request,
        JadwalPeriksa $jadwal_periksa
    ) {
        // Dokter hanya boleh memperbarui jadwal miliknya sendiri.
        if ($jadwal_periksa->id_dokter !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'hari' => [
                'required',
                'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            ],
            'jam_mulai' => [
                'required',
                'date_format:H:i',
            ],
            'jam_selesai' => [
                'required',
                'date_format:H:i',
                'after:jam_mulai',
            ],
        ], [
            'hari.required' => 'Hari wajib dipilih.',
            'hari.in' => 'Hari yang dipilih tidak valid.',

            'jam_mulai.required' => 'Jam mulai wajib diisi.',
            'jam_mulai.date_format' => 'Format jam mulai tidak valid.',

            'jam_selesai.required' => 'Jam selesai wajib diisi.',
            'jam_selesai.date_format' => 'Format jam selesai tidak valid.',
            'jam_selesai.after' => 'Jam selesai harus lebih besar dari jam mulai.',
        ]);

        $jadwal_periksa->update([
            'hari' => $validated['hari'],
            'jam_mulai' => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
        ]);

        return redirect()
            ->route('jadwal-periksa.index')
            ->with('success', 'Jadwal periksa berhasil diperbarui.');
    }

    /**
     * Menghapus jadwal periksa.
     */
    public function destroy(JadwalPeriksa $jadwal_periksa)
    {
        // Dokter hanya boleh menghapus jadwal miliknya sendiri.
        if ($jadwal_periksa->id_dokter !== Auth::id()) {
            abort(403);
        }

        $jadwal_periksa->delete();

        return redirect()
            ->route('jadwal-periksa.index')
            ->with('success', 'Jadwal periksa berhasil dihapus.');
    }
}
