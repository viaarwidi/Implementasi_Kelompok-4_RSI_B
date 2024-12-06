<?php

namespace App\Http\Controllers;

use App\Models\ProgramDonasi;
use Illuminate\Http\Request;

class ProgramDonasiController extends Controller
{
    // Mendapatkan semua data program donasi
    public function index()
    {
        return response()->json(ProgramDonasi::all(), 200);
    }

    // Menyimpan program donasi baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_program' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'target_donasi' => 'required|numeric|min:0',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'in:active,completed,inactive',
            'gambar' => 'nullable|string|max:255',
            'id_admin' => 'nullable|exists:Pengguna,id_akun_pengguna',
        ]);

        $programDonasi = ProgramDonasi::create($validatedData);
        return response()->json(['message' => 'Program Donasi berhasil ditambahkan!', 'data' => $programDonasi], 201);
    }

    // Mendapatkan data program donasi berdasarkan ID
    public function show($id)
    {
        $programDonasi = ProgramDonasi::findOrFail($id);
        return response()->json($programDonasi, 200);
    }

    // Memperbarui data program donasi
    public function update(Request $request, $id)
    {
        $programDonasi = ProgramDonasi::findOrFail($id);

        $validatedData = $request->validate([
            'nama_program' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
            'target_donasi' => 'nullable|numeric|min:0',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'in:active,completed,inactive',
            'gambar' => 'nullable|string|max:255',
            'id_admin' => 'nullable|exists:Pengguna,id_akun_pengguna',
        ]);

        $programDonasi->update($validatedData);
        return response()->json(['message' => 'Program Donasi berhasil diperbarui!', 'data' => $programDonasi], 200);
    }

    // Menghapus data program donasi
    public function destroy($id)
    {
        $programDonasi = ProgramDonasi::findOrFail($id);
        $programDonasi->delete();
        return response()->json(['message' => 'Program Donasi berhasil dihapus!'], 200);
    }
}
