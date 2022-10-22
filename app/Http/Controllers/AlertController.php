<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Airtable;
use Twilio\Rest\Client;

class AlertController extends Controller
{
    public function index(Request $request)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        
        $data = $request->all();
        /*$data = array (
            'Email' => 'andres@winguweb.org',
             'Fecha' => '2022-10-22T17:56:34.000Z',
             'Geoposicion' => '4.6583644,-74.0564189',
             'Municipio' => 'Cundinamarca',
            'Name' => 'Andres Felipe Trujillo',
             'Name (from Tipo de Amenazas)' => '[\'Abuso de poder\']',
             'Notas' => 'Amenaza',
             'Teléfono' => '+573184773493',
             'Tipo de Amenazas' => '[\'recmkFiTXjePGQ2ed\']',
             '_createdTime' => '2022-10-22T17:56:34.000Z',
            'id' => 'recqP5wXqzxmcWoWG',
            'Perfil' => ['rec4w7CQN1vZNtlEo'],
            'Contactos' => ['recs6anTSWvsW3p9Q', 'reclIIAwI6hmdaBmo'],
        );*/
        log::info($data);
        return "OK";
        log::info($data['Contactos']);
        $contactos_ids = $data['Contactos'];
        $contactos_ids = str_replace("['","", $contactos_ids);
        $contactos_ids = str_replace("']","", $contactos_ids);
        $contactos_ids = str_replace("'","", $contactos_ids);
        $contactos_ids = str_replace(" ","", $contactos_ids);
        $contactos_ids = explode(',',$contactos_ids);
        foreach($contactos_ids as $id){
            log::info($id);
            $contacto = Airtable::table('contactos')->find($id);
            //var_dump($contacto["fields"]['Telefono']);
            $client = new Client($account_sid, $auth_token);
            $body = "Nueva Alerta\n";
            $body .= "Nombre: " . $data['Name'] . "\n";
            $body .= "Nota: " . $data['Notas'] . "\n";
            $body .= "Teléfono: " . $data['Teléfono'] . "\n";
            $body .= "Fecha: " . $data['Fecha'] . "\n";
            $body .= "Posición: http://www.google.com/maps/place/" . $data['Geoposicion'] . "\n";
            $body .= "Whatsapp: http://wa.me/" . $data['Teléfono'] . "\n";
            

            $client->messages->create('whatsapp:' . $contacto["fields"]['Telefono'], [
                'from' => 'whatsapp:' . $twilio_number, 
                'body' => $body
            ]);
        }
        //return $contactos;
        return 'OK';
    }
}
