<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';
    public $timestamps = false;
    
    public function fields()
    {
        return $this->hasMany('App\Models\Field', 'field', 'id');
    }     
}