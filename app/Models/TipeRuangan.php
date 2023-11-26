<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeRuangan extends Model
{
    protected $table = 'tb_tipe_ruangan';
    public function ruangan()
    {
        return $this->hasMany(Ruangan::class);
    }
}
