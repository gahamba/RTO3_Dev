<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Unverified account.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function unverified()
    {
        return view('unverified');
    }

    /**
     * No Access.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function noaccess()
    {
        return view('noaccess');
    }

    public function logout(){
        Auth::logout();
        return view('welcome');
    }
}
