<?php

use App\Admin\Controllers\PinjamRuangController;
use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->get('/kalender-pinjam', [PinjamRuangController::class, 'kalenderPinjam']);
    $router->get('/get-ruang-pinjam-data', [PinjamRuangController::class, 'getRuangPinjamData']);
    $router->resource('ruangan', RuanganController::class)->names('ruangan');
    $router->resource('tipe-ruangan', TipeRuanganController::class)->names('tipe-ruangan');
    $router->resource('pinjam-ruang', PinjamRuangController::class);
});
