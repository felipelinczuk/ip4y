<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\ClienteController;

class ApiIp4yController extends Controller
{
    public function sendAll()
    {
        $data = app('App\Http\Controllers\ClienteController')->index();
        $response = Http::post('https://api-teste.ip4y.com.br/cadastro', [$data])->json();
        return $response;
    }
}
