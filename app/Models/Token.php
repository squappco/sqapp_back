<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Util;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class Token extends Model
{
    protected $table = 'tokens';
    public $timestamps = false;  
}