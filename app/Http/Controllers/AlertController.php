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
        /*log::info($data);
        log::info($data['image_url']);
        log::info($data['contactos']);*/
        $contactos = $data['contactos'];
        if(isset($data['image_url'])){
            $image_url = $data['image_url'];
        }
        $name = $data['name'];
        $notas = $data['notas'];
        $telefono = $data['telefono'];
        $fecha = $data['fecha'];
        $geo = $data['geo'];

        $contactos_ids = explode(',',$contactos);
        foreach($contactos_ids as $id){
            log::info($id);
            $contacto = Airtable::table('contactos')->find($id);
            //var_dump($contacto["fields"]['Telefono']);
            $client = new Client($account_sid, $auth_token);
            $body = "Nueva Alerta\n";
            $body .= "Nombre: " . $name . "\n";
            $body .= "Nota: " . $notas . "\n";
            $body .= "Teléfono: " . $telefono . "\n";
            $body .= "Fecha: " . $fecha . "\n";
            $body .= "Posición: http://www.google.com/maps/place/" . $geo . "\n";
            $body .= "Whatsapp: http://wa.me/" . $telefono  . "\n";
            
            if(isset($data['image_url'])){
                $client->messages->create('whatsapp:' . $contacto["fields"]['Telefono'], [
                    'from' => 'whatsapp:+14155238886', 
                    'body' => $body,
                    'mediaUrl' => [$image_url]
                ]);
            }else{
                $client->messages->create('whatsapp:' . $contacto["fields"]['Telefono'], [
                    'from' => 'whatsapp:+14155238886', 
                    'body' => $body
                ]);
            }
        }
        //return $contactos;
        return 'OK';
    }
}
