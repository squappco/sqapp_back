<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlayerController extends Controller
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
        $players = Player::with('games')->paginate((int)$limit, ['*'], 'page', $page);
        return $players;
    }

    public function store(Request $request){
        $player = new Player();
        if($player){
            $attributes = json_decode($request->getContent(), true);
            foreach($attributes as $key => $value){
                $player->$key = $value;
            }
            $player->save();
        }
        return $player;
    }

    public function update(Request $request, $idplayer){
        $player = Player::find($idplayer);
        if($player){
            $attributes = json_decode($request->getContent(), true);
            foreach($attributes as $key => $value){
                $player->$key = $value;
            }
            $player->save();
        }
        return $player;
    }    

    public function show(Request $request, $idplayer){
        $player = Player::find($idplayer);

        return $player;
    }

    public function destroy(Request $request, $idplayer){
        $player = Player::find($idplayer);
        if($player){
            $player->delete();
        }

        return $idplayer;
    }          
}