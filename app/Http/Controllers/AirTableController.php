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

    public function actors()
    {
        $actores = Airtable::table('tipo_actor')->get();
        return $actores;
    }
}
