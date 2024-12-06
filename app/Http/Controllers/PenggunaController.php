<?php
namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index()
    {
        return Pengguna::all();
    }

    public function store(Request $request)
    {
        $pengguna = Pengguna::create($request->all());
        return response()->json(['message' => 'Pengguna berhasil ditambahkan!', 'data' => $pengguna]);
    }

    public function show($id)
    {
        return Pengguna::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $pengguna->update($request->all());
        return response()->json(['message' => 'Pengguna berhasil diperbarui!', 'data' => $pengguna]);
    }

    public function destroy($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $pengguna->delete();
        return response()->json(['message' => 'Pengguna berhasil dihapus!']);
    }
}
