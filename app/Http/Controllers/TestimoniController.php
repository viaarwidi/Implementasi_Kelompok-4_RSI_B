<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    /**
     * Mendapatkan semua testimoni.
     */
    public function index()
    {
        $testimonis = Testimoni::with(['pengguna', 'programDonasi'])->get();
        return response()->json($testimonis, 200);
    }

    /**
     * Menyimpan testimoni baru.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_pengguna' => 'required|exists:Pengguna,id_akun_pengguna',
            'id_program' => 'required|exists:Program_Donasi,id_program',
            'pesan' => 'required|string',
        ]);

        $testimoni = Testimoni::create([
            'id_pengguna' => $validatedData['id_pengguna'],
            'id_program' => $validatedData['id_program'],
            'pesan' => $validatedData['pesan'],
        ]);

        return response()->json([
            'message' => 'Testimoni berhasil ditambahkan!',
            'data' => $testimoni
        ], 201);
    }

    /**
     * Mendapatkan detail testimoni berdasarkan ID.
     */
    public function show($id)
    {
        $testimoni = Testimoni::with(['pengguna', 'programDonasi'])->findOrFail($id);
        return response()->json($testimoni, 200);
    }

    /**
     * Memperbarui testimoni.
     */
    public function update(Request $request, $id)
    {
        $testimoni = Testimoni::findOrFail($id);

        $validatedData = $request->validate([
            'id_pengguna' => 'nullable|exists:Pengguna,id_akun_pengguna',
            'id_program' => 'nullable|exists:Program_Donasi,id_program',
            'pesan' => 'nullable|string',
        ]);

        $testimoni->update(array_filter($validatedData));

        return response()->json([
            'message' => 'Testimoni berhasil diperbarui!',
            'data' => $testimoni
        ], 200);
    }

    /**
     * Menghapus testimoni.
     */
    public function destroy($id)
    {
        $testimoni = Testimoni::findOrFail($id);
        $testimoni->delete();

        return response()->json([
            'message' => 'Testimoni berhasil dihapus!'
        ], 200);
    }
}
