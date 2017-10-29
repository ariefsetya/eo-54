<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function page($page='home')
    {
        $data = \App\Pages::whereSlug($page)->first();
        if(sizeof($data)>0){
            return view('home')->with(array('data'=>$data));
        }else{
            return "404 Not Found";
        }
    }
}
