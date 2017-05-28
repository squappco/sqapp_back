<?php

namespace App\Http\Controllers;

use App\Util;
use App\Models\Game;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class GameController extends Controller
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
        $games = Game::paginate((int)$limit, ['*'], 'page', $page);
        return $games;
    }

    public function store(Request $request){
        $game = new Game();
        if($game){
            $attributes = json_decode($request->getContent(), true);
            foreach($attributes as $key => $value){
                $game->$key = $value;
            }

            $user = Util::$user;
            if($user instanceof Player){
                $game->estado = 'Por jugar';
                $game->player = $user->id;
            } 
            else{
                throw new \Exception('Solo puede crear campos los jugadores');
            }

            $game->save();
        }
        return $game;
    }

    public function update(Request $request, $idgame){
        $game = Game::find($idgame);
        if($game){
            $attributes = json_decode($request->getContent(), true);
            foreach($attributes as $key => $value){
                $game->$key = $value;
            }
            $game->save();
        }
        return $game;
    }    

    public function show(Request $request, $idgame){
        $game = Game::find($idgame);

        return $game;
    }

    public function destroy(Request $request, $idgame){
        $game = Game::find($idgame);
        if($game){
            $game->delete();
        }

        return $idgame;
    }    


    public function addPlayer(Request $request, $idgame){
        $user = Util::$user;
        if(!($user instanceof Player)){
            throw new \Exception('Solo se pueden agregar jugadores a un juego');
        }

        DB::table('player_game')->insert(['game' => $idgame, 'player' => $user->id]);

        $game = Game::find($idgame);
        if($game){
            $game->delete();
        }

        return $idgame;        
    }

    public function getPlayers(Request $request, $idGame){
        $games = [];
        $game = Game::find($idGame);
        if($game){
            $limit = 15;
            if ($request->has('limit')) {
                $limit = $request->input('limit');
            }    

            $page = 1;
            if ($request->has('page')) {
                $page = $request->input('page');
            } 

            $games = $game->players()->paginate((int)$limit, ['*'], 'page', $page);
        }

        return $games;
    } 

    public function removePlayer(Request $request, $idGame){
        $user = Util::$user;
        if(!($user instanceof Player)){
            throw new \Exception('Solo se pueden agregar jugadores a un juego');
        }

        DB::table('player_game')->where('game', $idGame)->where('player', $user->id)->delete();

        $game = Game::find($idGame);

        return $game; 
    }   

    public function getMyGames(Request $request){
        $user = Util::$user;
        if(!($user instanceof Player)){
            throw new \Exception('Solo se pueden consultar mis juegos los jugadores');
        }

        $limit = 15;
        if ($request->has('limit')) {
            $limit = $request->input('limit');
        }    

        $page = 1;
        if ($request->has('page')) {
            $page = $request->input('page');
        }  

        $games = $user->games()->paginate((int)$limit, ['*'], 'page', $page);

        return $games; 
    }           
}