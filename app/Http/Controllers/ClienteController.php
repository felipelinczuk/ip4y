<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function index()
    {
        return Cliente::all();
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {   
        $customer = Cliente::where('CPF', $request['cpf']);
        

        if(empty($customer)){
            return abort(403, 'Unauthorized action.');
        }

        return Cliente::create($request->all());

    }

    public function show(Request $request)
    {
        if($customer = DB::table('clientes')->where('cpf', $request['CPF'])->get()){
            return $customer;
        }
        else{
            return abort(404, 'Customer not found.');
        }
    }

    public function edit(Request $request)
    {
        if($customer = DB::table('clientes')->where('cpf', $request['CPF'])->get()){
            $id = json_encode($customer[0]->id);
            $customer = Cliente::find($id);
            return $customer->update($request->all());
        }
        else{
            return abort(404, 'Customer not found.');
        }
    }

    public function destroy(Request $request)
    {
        if($customer = DB::table('clientes')->where('cpf', $request['CPF'])->get()){
            $id = json_encode($customer[0]->id);
            $customer = Cliente::find($id);
            return $customer->delete();
        }
    }
}

?>