<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public function locations()
	{
	    return $this->belongsTo('App\Location', 'location_id');
	}
}
