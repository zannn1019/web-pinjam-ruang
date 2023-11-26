<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangan';
    protected $guarded = ['id'];
    public function tipeRuangan()
    {
        return $this->belongsTo(TipeRuangan::class);
    }

    public function pinjamRuangan()
    {
        return $this->hasMany(PinjamRuang::class);
    }
}
