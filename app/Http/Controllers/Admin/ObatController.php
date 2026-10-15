<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obats = Obat::all();
        return view('admin.obat.index', compact('obats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.obat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan' => 'required|string',
            'harga' => 'required|integer',
        ]);

        Obat::create([
            'nama_obat' => $request->nama_obat,
            'kemasan' => $request->kemasan,
            'harga' => $request->harga,
        ]);

        return redirect()->route('obat.index')->with('success', 'Data Obat berhasil di Tambah')->with('type', 'success');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Obat $obat)
    {
        return view('admin.obat.edit', compact('obat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan' => 'required|string',
            'harga' => 'required|integer',
        ]);

        $updateData = [
            'nama_obat' => $request->nama_obat,
            'kemasan' => $request->kemasan,
            'harga' => $request->harga,
        ];

        $obat->update($updateData);

        return redirect()
            ->route('obat.index')
            ->with('success', 'Data Obat berhasil di Ubah')
            ->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Obat $obat)
    {
        $obat->delete();
        return redirect()
            ->route('obat.index')
            ->with('success', 'Data Obat berhasil dihapus')
            ->with('type', 'success');
    }
}
