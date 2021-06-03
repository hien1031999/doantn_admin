<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDataTypeFieldMauSacTableChiTietSp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chi_tiet_sp', function (Blueprint $table) {
            if (Schema::hasColumn('chi_tiet_sp', 'mau_sac')) {
                $table->string('mau_sac', 50)->change();
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
