<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Util;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class Billing extends Model
{
    protected $table = 'billing';
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
    
    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'client', 'id');
    }     
}