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
        /*$data = array (
             'ToCountry' => 'US',
             'ToState' => 'CA',
             'SmsMessageSid' => 'SM928483c7a535ad30ecaeaa5c69195e70',
             'NumMedia' => '0',
             'ToCity' => NULL,
            'FromZip' => NULL,
             'SmsSid' => 'SM928483c7a535ad30ecaeaa5c69195e70',
            'FromState' => NULL,
             'SmsStatus' => 'received',
             'FromCity' => NULL,
             'Body' => 'Andres Iphone;jolly-approval-537@anonymous.appuser.io;4.722394433435611,-74.02934614481546;Cundinamarca;ALERTA POR SMS',
            'FromCountry' => 'CO',
             'To' => '+18582992034',
             'ToZip' => NULL,
             'NumSegments' => '1',
             'ReferralNumMedia' => '0',
            'MessageSid' => 'SM928483c7a535ad30ecaeaa5c69195e70',
             'AccountSid' => 'ACec2fda937d58144ede497079a37d0737',
             'From' => '+573184773493',
             'ApiVersion' => '2010-04-01',
        );*/
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
