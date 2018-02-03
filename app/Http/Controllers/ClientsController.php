<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClientsController extends Controller
{
    private $arrayFiledsValidate = [
        'name' => 'required',
        'email' => 'required',
        'phone' => 'required'
    ];

    private function verifyClient($clientId)
    {
        if (!($client = Client::find($clientId))) {
            throw new ModelNotFoundException('Client request not found');
        }

        return $client;
    }

    public function index()
    {
        return zendResponse(Client::all());
    }

    public function show($id)
    {
        $client = $this->verifyClient($id);
        return zendResponse($client);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->arrayFiledsValidate);
        $client = Client::create($request->all());
        return zendResponse($client, 201);
    }

    public function update(Request $request, $id)
    {
        if (!($client = Client::find($id))){
            throw new ModelNotFoundException('Client request not found!');
        }

        $this->validate($request, $this->arrayFiledsValidate);

        $client->fill($request->all());
        $client->save();
        return zendResponse($client, 200);
    }

    public function destroy($id)
    {
        if (!($client = Client::find($id))){
            throw new ModelNotFoundException('Client request not found!');
        }
        $client->delete();
        return zendResponse([],204);
    }
}