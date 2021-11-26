<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // if (auth()->user()->role == User::ROLE_ADMIN) {
        //     return redirect()->route('admin.dashboard');
        // }
        return view('home.index');
    }
}
