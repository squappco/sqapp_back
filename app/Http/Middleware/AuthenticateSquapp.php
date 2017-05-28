<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Token;
use App\Models\Player;
use App\Util;

class AuthenticateSquapp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if($request->has('access_token')){
            $access_token = $request->input('access_token');
            $token = Token::where('token', $access_token)->first();
            $player = Player::find($token->reference);
            Util::$user = $player;
        }
        else{
            Util::$user = Client::find(1);
        }
        return $next($request);
    }
}
