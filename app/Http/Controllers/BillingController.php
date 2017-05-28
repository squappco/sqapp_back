<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Util;

class BillingController extends Controller
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

        $fields = Billing::paginate((int)$limit, ['*'], 'page', $page);
        return $fields;
    }            
}