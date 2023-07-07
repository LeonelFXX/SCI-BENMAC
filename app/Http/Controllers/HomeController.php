<?php

namespace App\Http\Controllers;

use App\Models\Printer;
use Illuminate\Http\Request;
use App\Models\Price;

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

    /*
    Función: Muestra la vista Home.
    */
    public function index()
    {
        $price = Price::find(1);

        $printers = Printer::all();
        
        return view('home', compact('price', 'printers'));
    }
}
