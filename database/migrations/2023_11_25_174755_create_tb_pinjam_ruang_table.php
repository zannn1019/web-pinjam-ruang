<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbPinjamRuangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pinjam_ruang', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_peminjam');
            $table->string('no_hp_peminjam');
            $table->string('jabatan_peminjam');
            $table->string('fakultas');
            $table->integer('id_ruangan')->index();
            $table->string('nama_kegiatan');
            $table->dateTime('tanggal_mulai_pinjam');
            $table->dateTime('tanggal_akhir_pinjam');
            $table->string('penanggung_jawab');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_pinjam_ruang');
    }
}
