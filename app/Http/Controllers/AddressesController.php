<?php

namespace App\Http\Controllers;

use App\Client;
use App\Address;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AddressesController extends Controller
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

    public function verifyAddress($addressId, $clientId) {
        if (!($address = Address::where('id', $addressId)->where('client_id', $clientId)->get()->first())) {
            throw new ModelNotFoundException('Address request not found');
        }

        return $address;
    }

    public function index($clientId)
    {
        $this->verifyClient($clientId);
        return zendResponse(Address::where('client_id',$clientId)->get());
    }

    public function show($id, $clientId)
    {
        $this->verifyClient($clientId);
        $address = $this->verifyAddress($id, $clientId);
        return zendResponse($address);
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