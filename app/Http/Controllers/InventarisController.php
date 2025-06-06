<?php

namespace App\Http\Controllers;

use App\Models\Infrastructure;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $infrastructures = Infrastructure::all();
        return view('inventaris.index', compact('infrastructures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventaris.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'jenis_kegiatan' => 'required|string|max:255',
            'item' => 'required|string|max:255',
            'jumlah' => 'required|integer|numeric',
            'biaya' => 'required|numeric'
        ]);

        $totalBiaya = $request->input('jumlah') * $request->input('biaya');

        // Create a new infrastructure
        Infrastructure::create([
            'jenis_kegiatan' => $request->input('jenis_kegiatan'),
            'item' => $request->input('item'),
            'jumlah' => $request->input('jumlah'),
            'biaya' => $request->input('biaya'),
            'total_biaya' => $totalBiaya,
        ]);

        toast('Inventaris berhasil dibuat.', 'success')->width('350');

        return redirect()->route('inventaris.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $infrastructure = Infrastructure::findOrFail($id);

        return view('inventaris.edit', compact('infrastructure'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $infrastructure = Infrastructure::findOrFail($id);

        // Validate the request data
        $request->validate([
            'jenis_kegiatan' => 'required|string|max:255',
            'item' => 'required|string|max:255',
            'jumlah' => 'required|integer|numeric',
            'biaya' => 'required|numeric'
        ]);

        $totalBiaya = $request->input('jumlah') * $request->input('biaya');

        // Create a new infrastructure
        $infrastructure->update([
            'jenis_kegiatan' => $request->input('jenis_kegiatan'),
            'item' => $request->input('item'),
            'jumlah' => $request->input('jumlah'),
            'biaya' => $request->input('biaya'),
            'total_biaya' => $totalBiaya,
        ]);

        toast('Inventaris berhasil diperbarui.', 'success')->width('350');

        return redirect()->route('inventaris.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $infrastructure = Infrastructure::findOrFail($id);

        $infrastructure->delete();

        toast('Inventaris berhasil dihapus.', 'success')->width('350');

        return redirect()->back();
    }
}
