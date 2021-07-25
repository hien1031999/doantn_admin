<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldHinhAnhTableNhaSanXuat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nha_san_xuat', function (Blueprint $table) {
            if (!Schema::hasColumn('nha_san_xuat', 'hinh_anh')) {
                $table->string('hinh_anh')->nullable()->after('ten');
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
        Schema::table('nha_san_xuat', function (Blueprint $table) {
            if (Schema::hasColumn('nha_san_xuat', 'hinh_anh')) {
                $table->dropColumn('hinh_anh');
            }
        });
    }
}
