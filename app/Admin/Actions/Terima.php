<?php

namespace App\Admin\Actions;

use App\Models\Ruangan;
use Illuminate\Database\Eloquent\Model;
use OpenAdmin\Admin\Actions\RowAction;

class Terima extends RowAction
{
    public $name = 'Terima';

    public $icon = 'icon-check';

    public function handle(Model $model)
    {
        $ruangan = Ruangan::find($model->id_ruangan);
        $ruangan->status_ruangan = 2;
        $model->status = 1;
        $model->save();
        $ruangan->save();

        return $this->response()->success('Permintaan peminjaman ruangan berhasil diterima!')->refresh();
    }
}
