<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();
        log::info($data);
        return 'OK';
    }
}
