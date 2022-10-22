<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Airtable;

class SMSController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();
        log::info($data);
        $body = explode(';',$data['Body']);
        $r = Airtable::table('alertas')->firstOrCreate([
            'Name' => $body[0],
            'Email' => $body[1],
            'Geoposicion' => $body[2],
            'Notas' => $body[4],
            'Teléfono' => $data['From'],
            'Municipio' => $body[3],
            'Tipo de Amenazas' => 'rec9S8Hx3GfXPLofR'
        ]);
        return 'OK';
    }
}
