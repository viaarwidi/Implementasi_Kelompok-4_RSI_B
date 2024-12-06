<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramDonasi extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'Program_Donasi';

    // Primary key tabel
    protected $primaryKey = 'id_program';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'nama_program',
        'deskripsi',
        'target_donasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'gambar',
        'id_admin',
    ];

    // Relasi ke model `Pengguna` (Admin yang mengelola program donasi)
    public function admin()
    {
        return $this->belongsTo(Pengguna::class, 'id_admin', 'id_akun_pengguna');
    }

    // Relasi ke model `Donasi` (Donasi yang terkait dengan program ini)
    public function donasi()
    {
        return $this->hasMany(Donasi::class, 'id_program');
    }

    // Relasi ke model `Testimoni` (Testimoni terkait dengan program ini)
    public function testimoni()
    {
        return $this->hasMany(Testimoni::class, 'id_program');
    }
}
