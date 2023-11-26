<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PinjamRuang extends Model
{
    protected $table = 'tb_pinjam_ruang';
    protected $fillable = [
        'nama_peminjam',
        'no_hp_peminjam',
        'jabatan_peminjam',
        'fakultas',
        'id_ruangan',
        'nama_kegiatan',
        'tanggal_mulai_pinjam',
        'tanggal_akhir_pinjam',
        'penanggung_jawab',
    ];
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }

    protected static function booted()
    {
        static::saving(function ($pinjamRuang) {
            $ruanganId = $pinjamRuang->id_ruangan;

            $ruangan = Ruangan::find($ruanganId);

            if ($ruangan) {
                $ruangan->status_ruangan = 1;
                $ruangan->save();
            }
        });
    }
}
