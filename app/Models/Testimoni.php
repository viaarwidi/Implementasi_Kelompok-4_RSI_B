<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    use HasFactory;

    protected $table = 'Testimoni';
    protected $primaryKey = 'id_testimoni';
    protected $fillable = ['id_pengguna', 'id_program', 'pesan', 'tanggal_testimoni'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_akun_pengguna');
    }

    public function programDonasi()
    {
        return $this->belongsTo(ProgramDonasi::class, 'id_program', 'id_program');
    }
}
