<?php

namespace App\Admin\Controllers;

use App\Models\Ruangan;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use App\Enums\StatusPinjam;
use \App\Models\PinjamRuang;
use App\Admin\Actions\Tolak;
use App\Enums\StatusRuangan;
use Illuminate\Http\Request;
use App\Admin\Actions\Terima;
use OpenAdmin\Admin\Facades\Admin;
use OpenAdmin\Admin\Layout\Content;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PinjamRuangCollection;
use OpenAdmin\Admin\Controllers\AdminController;

class PinjamRuangController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'PinjamRuang';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PinjamRuang());
        $grid->column('id', __('Id'));
        $grid->column('nama_peminjam', __('Nama peminjam'));
        $grid->column('no_hp_peminjam', __('No hp peminjam'));
        $grid->column('jabatan_peminjam', __('Jabatan peminjam'));
        $grid->column('fakultas', __('Fakultas'));
        $grid->column('ruangan.nama_ruangan', __('Ruangan'));
        $grid->column('nama_kegiatan', __('Nama kegiatan'));
        $grid->column('tanggal_mulai_pinjam', __('Tanggal mulai pinjam'));
        $grid->column('tanggal_akhir_pinjam', __('Tanggal akhir pinjam'));
        $grid->column('penanggung_jawab', __('Penanggung jawab'));
        $grid->column('status', __('Status'))->display(function ($status) {
            $color = '';
            switch ($status) {
                case 0:
                    $color = 'warning';
                    break;
                case 1:
                    $color = 'success';
                    break;
                case 2:
                    $color = 'danger';
                    break;
                case 3:
                    $color = 'primary';
                    break;
            }

            return  '<span class="badge rounded-pill bg-' . $color . '">' . StatusPinjam::fromValue(intval($status))->key . '</span> ';
        });
        $grid->disableCreateButton(true);
        $grid->disableRowSelector(true);

        $grid->actions(function ($actions) {
            $ruangan = $actions->row->status;
            switch ($ruangan) {
                case 0:
                    $actions->disableDelete();
                    $actions->disableEdit();
                    $actions->disableShow();
                    $actions->add(new Terima());
                    $actions->add(new Tolak());
                    break;
                case 2:
                case 3:
                    $actions->disableEdit();
                    $actions->disableShow();
                    break;

                default:
                    $actions->disableDelete();
                    $actions->disableEdit();
                    $actions->disableShow();
                    break;
            }
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
        $show = new Show(PinjamRuang::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('nama_peminjam', __('Nama peminjam'));
        $show->field('no_hp_peminjam', __('No hp peminjam'));
        $show->field('jabatan_peminjam', __('Jabatan peminjam'));
        $show->field('fakultas', __('Fakultas'));
        $show->field('id_ruangan', __('Ruangan'));
        $show->field('nama_kegiatan', __('Nama kegiatan'));
        $show->field('tanggal_mulai_pinjam', __('Tanggal mulai pinjam'));
        $show->field('tanggal_akhir_pinjam', __('Tanggal akhir pinjam'));
        $show->field('penanggung_jawab', __('Penanggung jawab'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        if (Admin::user()->isAdministrator()) {
            abort(403, 'Unauthorized action.');
        }

        $form = new Form(new PinjamRuang());

        $form->text('nama_peminjam', __('Nama peminjam'))->required();
        $form->text('no_hp_peminjam', __('No hp peminjam'))->required()->rules(['numeric', 'min:10'], [
            'numeric' => "Nomor HP harus berupa angka!",
            'min' => "Nomor HP tidak valid!",
        ]);

        $form->text('jabatan_peminjam', __('Jabatan peminjam'))->required();
        $form->text('fakultas', __('Fakultas'))->required();
        $form->select('id_ruangan', __('Pilih ruangan'))->options(function () {
            return Ruangan::all()->where('status_ruangan', 0)->pluck('nama_ruangan', 'id');
        })->required();

        $form->text('nama_kegiatan', __('Nama kegiatan'))->required();

        // Validasi untuk tanggal_mulai_pinjam dan tanggal_akhir_pinjam
        $form->datetime('tanggal_mulai_pinjam', __('Tanggal mulai pinjam'))->required()->rules('date');
        $form->datetime('tanggal_akhir_pinjam', __('Tanggal akhir pinjam'))->required()->rules('date|after:tanggal_mulai_pinjam');

        $form->text('penanggung_jawab', __('Penanggung jawab'))->required();

        return $form;
    }


    public function createForUser()
    {
        return view('index', [
            'ruangan' => Ruangan::all()->where('status_ruangan', 0)
        ]);
    }
    public function userPinjamRuang(Request $request)
    {
        // Validasi request yang di kirimkan
        $validator = Validator::make($request->all(), [
            'nama_peminjam' => 'required|string|max:255',
            'no_hp_peminjam' => 'required|numeric',
            'jabatan_peminjam' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'id_ruangan' => 'required|exists:ruangan,id,status_ruangan,0',
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_mulai_pinjam' => 'required|date',
            'tanggal_akhir_pinjam' => 'required|date|after:tanggal_mulai_pinjam',
            'penanggung_jawab' => 'required|string|max:255',
        ], [
            'nama_peminjam.required' => 'Kolom Nama Peminjam wajib diisi.',
            'no_hp_peminjam.required' => 'Kolom No HP Peminjam wajib diisi.',
            'no_hp_peminjam.numeric' => 'Kolom No HP Peminjam harus berupa angka.',
            'no_hp_peminjam.min' => 'Kolom No HP Peminjam minimal harus 10 digit.',
            'jabatan_peminjam.required' => 'Kolom Jabatan Peminjam wajib diisi.',
            'fakultas.required' => 'Kolom Fakultas wajib diisi.',
            'id_ruangan.required' => 'Kolom Pilih Ruangan wajib diisi.',
            'id_ruangan.exists' => 'Ruangan yang dipilih tidak valid atau tidak tersedia.',
            'nama_kegiatan.required' => 'Kolom Nama Kegiatan wajib diisi.',
            'tanggal_mulai_pinjam.required' => 'Kolom Tanggal Mulai Peminjaman wajib diisi.',
            'tanggal_mulai_pinjam.date' => 'Kolom Tanggal Mulai Peminjaman harus berupa tanggal.',
            'tanggal_akhir_pinjam.required' => 'Kolom Tanggal Akhir Peminjaman wajib diisi.',
            'tanggal_akhir_pinjam.date' => 'Kolom Tanggal Akhir Peminjaman harus berupa tanggal.',
            'tanggal_akhir_pinjam.after' => 'Tanggal Akhir Peminjaman harus setelah Tanggal Mulai Peminjaman.',
            'penanggung_jawab.required' => 'Kolom Penanggung Jawab wajib diisi.',
        ]);

        // Cek apakah validasi berhasil
        if ($validator->fails()) {
            // Jika validasi gagal, kembalikan dengan pesan kesalahan
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Validasi berhasil, buat objek PinjamRuang baru dengan data dari formulir
        $pinjamRuang = new PinjamRuang([
            'nama_peminjam' => $request->input('nama_peminjam'),
            'no_hp_peminjam' => $request->input('no_hp_peminjam'),
            'jabatan_peminjam' => $request->input('jabatan_peminjam'),
            'fakultas' => $request->input('fakultas'),
            'id_ruangan' => $request->input('id_ruangan'),
            'nama_kegiatan' => $request->input('nama_kegiatan'),
            'tanggal_mulai_pinjam' => $request->input('tanggal_mulai_pinjam'),
            'tanggal_akhir_pinjam' => $request->input('tanggal_akhir_pinjam'),
            'penanggung_jawab' => $request->input('penanggung_jawab'),
            'status' => "0"
        ]);

        // Simpan objek ke database
        $pinjamRuang->save();

        return redirect()->route('index')->with('success', 'Data berhasil disimpan');
    }

    public function kalenderPinjam()
    {
        Admin::js('https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js');
        Admin::js('https://code.jquery.com/jquery-3.7.1.min.js');
        return Admin::content(function (Content $content) {
            $content->header('Kalender Peminjaman');
            $content->breadcrumb(
                ['text' => 'Kalender Pinjam']
            );
            $content->view('CustomPage.kalenderPinjam', ['data' => 'foo']);
        });
    }

    public function getRuangPinjamData(Request $request)
    {
        if (!$request->ajax()) {
            abort(403, 'Unauthorized action.');
        }
        $data = new PinjamRuangCollection(PinjamRuang::all()->where('status', 1));
        return response()->json($data, 200)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }
}
