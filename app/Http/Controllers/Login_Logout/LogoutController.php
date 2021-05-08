<?php

namespace App\Http\Controllers\Login_Logout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout() {
        Auth::logout();
        return redirect('login')->with('status', 'success')->with('message', 'Đăng xuất thành công');
    }
}
