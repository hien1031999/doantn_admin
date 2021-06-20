<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $viewFolder = 'dashboard';
    private $page = 'dashboard';

    public function index() {
        $pageInfo = [
            'page'  => $this->page
        ];

        return view("admin.{$this->viewFolder}", compact('pageInfo'));
    }
}
