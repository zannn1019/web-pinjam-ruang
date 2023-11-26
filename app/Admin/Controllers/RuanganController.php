<?php

namespace App\Admin\Controllers;

use App\Enums\StatusRuangan;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Ruangan;
use App\Models\TIpeRuangan;
use App\Models\TipeRuangan as ModelsTipeRuangan;
use Illuminate\Http\Request;

class RuanganController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Ruangan';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Ruangan());

        $grid->column('id', __('Id'));
        $grid->column('nama_ruangan', __('Nama Ruangan'));
        $grid->column('tipe_ruangan', __('Tipe Ruangan'))->display(function ($tipe) {
            $tipe_ruangan = TipeRuangan::find($tipe);
            return $tipe_ruangan->nama_tipe;
        });
        $grid->column('kapasitas_ruangan', __('Kapasitas Ruangan'));
        $grid->column('status_ruangan', __('Status Ruangan'))->display(function ($status) {
            $color = '';
            switch ($status) {
                case 0:
                    $color = 'success';
                    break;
                case 1:
                    $color = 'warning';
                    break;
                case 2:
                    $color = 'primary';
                    break;
                case 3:
                    $color = 'danger';
                    break;
            }

            return  '<span class="badge rounded-pill bg-' . $color . '">' . StatusRuangan::fromValue(intval($status))->key . '</span> ';
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Ruangan::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('nama_ruangan', __('Nama Ruangan'));
        $show->field('tipe_ruangan', __('Tipe Ruangan'));
        $show->field('kapasitas_ruangan', __('Kapasitas Ruangan'));
        $show->field('status_ruangan', 'Status Ruangan')->using(StatusRuangan::asSelectArray());

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Ruangan());
        $form->text('nama_ruangan', __('Nama Ruangan'));
        $form->select('tipe_ruangan', 'Tipe Ruangan')->options(function ($id) {
            return TipeRuangan::all()->where('is_aktif', 1)->pluck('nama_tipe', 'id');
        });
        $form->number('kapasitas_ruangan', __('Kapasitas Ruangan'))->min(0);
        $form->radio('status_ruangan', 'Status')->options(StatusRuangan::asSelectArray())->stacked();
        return $form;
    }
}
