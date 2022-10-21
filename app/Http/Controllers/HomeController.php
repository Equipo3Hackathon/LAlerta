<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Airtable;

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
        $alertas = Airtable::table('alertas')->get();
        $periodistas = Airtable::table('perfil')->get();
        return view('home', [
            "num_alertas" => count($alertas), 
            "num_periodistas" => count($periodistas)
        ]);
    }
}
