<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\PinjamRuang;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckJamAkhirPeminjaman extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-jam-akhir-peminjaman';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengecek tanggal akhir peminjaman ruangan';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        $bookings = PinjamRuang::where('tanggal_akhir_pinjam', '<=', $now)->where('status', 1)->get();

        foreach ($bookings as $booking) {
            $booking->status = 3;
            $booking->ruangan->status_ruangan = 0;
            $booking->save();
            $booking->ruangan->save();
            // $booking->ruangan->update(['status_ruangan' => 0]);
            // $booking->update(['status' => 3]);
        }
        $this->info('Status ruangan berhasil diperiksa dan diupdate.');
    }
}
