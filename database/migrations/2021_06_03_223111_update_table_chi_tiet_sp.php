<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableChiTietSp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chi_tiet_sp', function (Blueprint $table) {
            if (!Schema::hasColumn('chi_tiet_sp', 'chat_lieu')) {
                $table->string('chat_lieu')->after('gia');
            }
        });

        Schema::table('chi_tiet_sp', function (Blueprint $table) {
            if (!Schema::hasColumn('chi_tiet_sp', 'so_ngan')) {
                $table->string('so_ngan')->after('chat_lieu');
            }
        });

        Schema::table('chi_tiet_sp', function (Blueprint $table) {
            if (!Schema::hasColumn('chi_tiet_sp', 'khoi_luong')) {
                $table->string('khoi_luong')->after('so_ngan');
            }
        });

        Schema::table('chi_tiet_sp', function (Blueprint $table) {
            if (!Schema::hasColumn('chi_tiet_sp', 'kich_thuoc')) {
                $table->string('kich_thuoc')->after('khoi_luong');
            }
        });

        Schema::table('chi_tiet_sp', function (Blueprint $table) {
            if (!Schema::hasColumn('chi_tiet_sp', 'tai_trong')) {
                $table->string('tai_trong')->after('kich_thuoc');
            }
        });

        Schema::table('chi_tiet_sp', function (Blueprint $table) {
            if (!Schema::hasColumn('chi_tiet_sp', 'ngan_lap')) {
                $table->string('ngan_lap')->after('tai_trong');
            }
        });

        Schema::table('chi_tiet_sp', function (Blueprint $table) {
            if (!Schema::hasColumn('chi_tiet_sp', 'tinh_trang')) {
                $table->boolean('tinh_trang')->after('giam_gia')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chi_tiet_sp', function (Blueprint $table) {
            //
        });
    }
}
