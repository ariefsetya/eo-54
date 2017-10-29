<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function contents()
	{
	    return $this->belongsTo('App\Content', 'content_id');
	}
    public function menus()
	{
	    return $this->belongsTo('App\Menu', 'menu_id');
	}
    public function icons()
	{
	    return $this->belongsTo('App\Icon', 'icon_id');
	}
}
