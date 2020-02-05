<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Notifications\VerifyEmail;
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
     * Show setup page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function initial_setup()
    {
        return view('initial_setup');
    }

    /**
     * Show setup completed page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function complete_setup()
    {
        return view('complete_setup');
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

    public function resendEmail()
    {
        Auth::user()->notify(new VerifyEmail(Auth::user()));
        return redirect()->back()
                        ->with('sent', 1);
    }

    public function logout(){
        Auth::logout();
        return view('welcome');
    }
}
