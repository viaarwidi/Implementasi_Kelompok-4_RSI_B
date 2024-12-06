<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use Illuminate\Http\Request;

class DonasiController extends Controller
{
    // Mendapatkan semua data donasi
    public function index()
    {
        $donasi = Donasi::with(['pengguna', 'programDonasi'])->get(); // Memuat relasi pengguna dan program donasi
        return response()->json($donasi, 200);
    }

    // Menyimpan donasi baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_pengguna' => 'required|exists:Pengguna,id_akun_pengguna',
            'id_program' => 'required|exists:Program_Donasi,id_program',
            'jumlah_donasi' => 'required|numeric|min:0',
            'metode_pembayaran' => 'nullable|string|max:50',
            'status_donasi' => 'in:pending,completed,cancelled',
        ]);

        $donasi = Donasi::create($validatedData);
        return response()->json(['message' => 'Donasi berhasil ditambahkan!', 'data' => $donasi], 201);
    }

    // Mendapatkan detail donasi berdasarkan ID
    public function show($id)
    {
        $donasi = Donasi::with(['pengguna', 'programDonasi'])->findOrFail($id);
        return response()->json($donasi, 200);
    }

    // Memperbarui data donasi
    public function update(Request $request, $id)
    {
        $donasi = Donasi::findOrFail($id);

        $validatedData = $request->validate([
            'id_pengguna' => 'nullable|exists:Pengguna,id_akun_pengguna',
            'id_program' => 'nullable|exists:Program_Donasi,id_program',
            'jumlah_donasi' => 'nullable|numeric|min:0',
            'metode_pembayaran' => 'nullable|string|max:50',
            'status_donasi' => 'nullable|in:pending,completed,cancelled',
        ]);

        $donasi->update($validatedData);
        return response()->json(['message' => 'Donasi berhasil diperbarui!', 'data' => $donasi], 200);
    }

    // Menghapus data donasi
    public function destroy($id)
    {
        $donasi = Donasi::findOrFail($id);
        $donasi->delete();
        return response()->json(['message' => 'Donasi berhasil dihapus!'], 200);
    }
}
