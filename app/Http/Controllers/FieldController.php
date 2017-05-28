<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Util;

class FieldController extends Controller
{
    public function index(Request $request){
        $limit = 15;
        if ($request->has('limit')) {
            $limit = $request->input('limit');
        }    

        $page = 1;
        if ($request->has('page')) {
            $page = $request->input('page');
        }

        $lat = -1;
        if ($request->has('lat')) {
            $lat = $request->input('lat');
        }

        $lng = -1;
        if ($request->has('lng')) {
            $lng = $request->input('lng');
        }     

        if($lat != -1 && $lng != -1){
            $fields = Field::where('lat', (float)$lat)->where('lng', (float)$lng)->first();
        }           
        else{
            $fields = Field::paginate((int)$limit, ['*'], 'page', $page);
        }        
        return $fields;
    }

    public function store(Request $request){
        $field = new Field();
        if($field){
            $attributes = json_decode($request->getContent(), true);
            foreach($attributes as $key => $value){
                $field->$key = $value;
            }

            $user = Util::$user;
            if($user instanceof Client){
                $field->client = $user->id;
            } 
            else{
                throw new \Exception('Solo puede crear campos los clientes');
            }

            $field->save();
        }
        return $field;
    }

    public function update(Request $request, $idField){
        $field = Field::find($idField);
        if($field){
            $attributes = json_decode($request->getContent(), true);
            foreach($attributes as $key => $value){
                $field->$key = $value;
            }
            $field->save();
        }
        return $field;
    }    

    public function show(Request $request, $idField){
        $field = Field::find($idField);

        return $field;
    }

    public function destroy(Request $request, $idField){
        $field = Field::find($idField);
        if($field){
            $field->delete();
        }

        return $idField;
    } 

    public function getGames(Request $request, $idField){
        $games = [];
        $field = Field::find($idField);
        if($field){
            $limit = 15;
            if ($request->has('limit')) {
                $limit = $request->input('limit');
            }    

            $page = 1;
            if ($request->has('page')) {
                $page = $request->input('page');
            } 

            $games = $field->games()->where('estado','Por jugar')->paginate((int)$limit, ['*'], 'page', $page);
        }

        return $games;
    } 

  

    public function setScore(Request $request, $idField){
        $field = Field::find($idField);
        if($field){
            $attributes = json_decode($request->getContent(), true);
            if(array_key_exists('level', $attributes)){
                $field->level = $attributes['level'];
                $field->save();
            }
        }
        return $field;
    }              
}