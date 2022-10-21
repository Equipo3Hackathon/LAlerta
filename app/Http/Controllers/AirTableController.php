<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Airtable;

class AirTableController extends Controller
{
    public function index()
    {
        $alertas = Airtable::table('alertas')->get();
        return $alertas;
    }

    public function types()
    {
        $types = Airtable::table('tipos')->get();
        return $types;
    }
}
