<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcontent extends Model
{
    public function contents()
	{
	    return $this->belongsTo('App\Content', 'content_id');
	}
}
