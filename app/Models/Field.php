<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Util;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class Field extends Model
{
    protected $table = 'fields';
    public $timestamps = false;
    
    protected static function boot() {
        parent::boot();
        $user = Util::$user;
        if($user instanceof Client){
            static::addGlobalScope('client', function(Builder $builder) use ($user) {
                $builder->where('client', $user->id);
            });
        }    
    }
    
    public function games()
    {
        return $this->hasMany('App\Models\Game', 'field', 'id');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'client', 'id');
    }    
}