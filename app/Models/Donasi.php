<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'Donasi';

    // Primary key tabel
    protected $primaryKey = 'id_donasi';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'id_pengguna',
        'id_program',
        'jumlah_donasi',
        'tanggal_donasi',
        'metode_pembayaran',
        'status_donasi',
    ];

    // Relasi ke model `Pengguna` (Pengguna yang memberikan donasi)
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_akun_pengguna');
    }

    // Relasi ke model `ProgramDonasi` (Program Donasi yang didonasikan)
    public function programDonasi()
    {
        return $this->belongsTo(ProgramDonasi::class, 'id_program', 'id_program');
    }
}
