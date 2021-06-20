<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChiTietGioHangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chi_tiet_gio_hang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gio_hang_id');
            $table->foreignId('san_pham_id');
            $table->string('gia_tien');
            $table->integer('so_luong')->default(0);
            $table->string('thanh_tien');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chi_tiet_gio_hang');
    }
}
