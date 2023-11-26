<?php

namespace App\Admin\Actions;

use Illuminate\Database\Eloquent\Model;
use OpenAdmin\Admin\Actions\RowAction;

class Tolak extends RowAction
{
    public $name = 'Tolak';

    public $icon = 'icon-times';

    public function handle(Model $model)
    {
        $model->status = 2;
        $model->save();
        return $this->response()->success('Permintaan peminjaman ruangan berhasil ditolak!')->refresh();
    }
}
