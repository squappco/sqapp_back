<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function index(Request $request){
        $limit = 15;
        if ($request->has('limit')) {
            $limit = $request->input('limit');
        }    

        $page = 1;
        if ($request->has('page')) {
            $limit = $request->input('page');
        }               
        $clients = Client::with('fields')->paginate((int)$limit, ['*'], 'page', $page);
        return $clients;
    }

    public function store(Request $request){
        $client = new Client();
        if($client){
            $attributes = json_decode($request->getContent(), true);
            foreach($attributes as $key => $value){
                $client->$key = $value;
            }
            $client->save();
        }
        return $client;
    }

    public function update(Request $request, $idclient){
        $client = Client::find($idclient);
        if($client){
            $attributes = json_decode($request->getContent(), true);
            foreach($attributes as $key => $value){
                $client->$key = $value;
            }
            $client->save();
        }
        return $client;
    }    

    public function show(Request $request, $idclient){
        $client = Client::find($idclient);

        return $client;
    }

    public function destroy(Request $request, $idclient){
        $client = Client::find($idclient);
        if($client){
            $client->delete();
        }

        return $idclient;
    }        
}