<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\TIpeRuangan;

class TipeRuanganController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'TipeRuangan';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TipeRuangan());

        $grid->column('id', __('Id'));
        $grid->column('nama_tipe', __('Nama tipe'));
        $grid->column('is_aktif', __('Aktif?'))->bool();

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
        $show = new Show(TIpeRuangan::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('nama_tipe', __('Nama tipe'));
        $show->field('is_aktif', __('Aktif?'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new TIpeRuangan());

        $form->text('nama_tipe', __('Nama tipe'));
        $form->switch('is_aktif', __('Aktif?'))->default(1);

        return $form;
    }
}
