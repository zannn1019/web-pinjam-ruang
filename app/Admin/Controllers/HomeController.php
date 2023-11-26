<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Admin;
use OpenAdmin\Admin\Layout\Row;
use OpenAdmin\Admin\Layout\Column;
use OpenAdmin\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use OpenAdmin\Admin\Widgets\InfoBox;
use OpenAdmin\Admin\Controllers\Dashboard;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->css_file(Admin::asset("open-admin/css/pages/dashboard.css"))
            ->title('Dashboard')
            ->description('peminjaman ruangan meeting')
            ->row(function (Row $row) {
                // Widget for users
                $row->column(3, function (Column $column) {
                    $count_users = \DB::table('admin_users')->count();
                    $infoBox = new InfoBox('Pengguna', 'users', 'aqua', route('admin.auth.users.index'), $count_users);
                    $column->append($infoBox);
                });

                // Widget for room types
                $row->column(3, function (Column $column) {
                    $count_room_types = \DB::table('tb_tipe_ruangan')->count();
                    $infoBox = new InfoBox('Tipe Ruangan', 'cubes', 'green', route('admin.tipe-ruangan.index'), $count_room_types);
                    $column->append($infoBox);
                });

                // Widget for rooms
                $row->column(3, function (Column $column) {
                    $count_rooms = \DB::table('ruangan')->count();
                    $infoBox = new InfoBox('Ruangan', 'cube', 'yellow', route('admin.ruangan.index'), $count_rooms);
                    $column->append($infoBox);
                });

                // Widget for borrow rooms
                $row->column(3, function (Column $column) {
                    $count_borrow_rooms = \DB::table('tb_pinjam_ruang')->count();
                    $infoBox = new InfoBox('Peminjaman', 'calendar', 'red', route('admin.pinjam-ruang.index'), $count_borrow_rooms);
                    $column->append($infoBox);
                });
            });
    }
}
