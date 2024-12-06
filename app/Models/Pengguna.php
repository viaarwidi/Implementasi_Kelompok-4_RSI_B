<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;

    protected $table = 'Pengguna';
    protected $primaryKey = 'id_akun_pengguna';

    protected $fillable = [
        'username', 'password', 'email', 'nama_lengkap', 'alamat', 'nomor_telepon', 'role', 'tanggal_daftar',
    ];

    public function programDonasi()
    {
        return $this->hasMany(ProgramDonasi::class, 'id_admin');
    }

    public function donasi()
    {
        return $this->hasMany(Donasi::class, 'id_pengguna');
    }

    public function testimoni()
    {
        return $this->hasMany(Testimoni::class, 'id_pengguna');
    }
}
