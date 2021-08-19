<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Sheet;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });

        Sheet::macro('setCellValue', function (Sheet $sheet, string $cellRange, string $data, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->getValue($data);
        });

        Sheet::macro('setWidth', function (Sheet $sheet, string $cellRange, int $width) {
            $sheet->getDelegate()->getColumnDimension($cellRange)->setWidth($width);
        });

        Sheet::macro('numberFormat', function (Sheet $sheet, string $cellRange) {
            $sheet->getDelegate()->getStyle($cellRange)->getNumberFormat()->setFormatCode('0,000');
        });

        Sheet::macro('dateFormat', function (Sheet $sheet, string $cellRange) {
            $sheet->getDelegate()->getStyle($cellRange)->getNumberFormat()->setFormatCode();
        });

        Sheet::macro('wrapText', function (Sheet $sheet, string $cellRange) {
            $sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
        });
    }
}
