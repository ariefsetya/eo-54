<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pages;
use App\Template;
use App\Content;
use App\Subcontent;
use App\Icon;
use App\Menu;
use App\Socialmedia;
use App\Slideshow;
use App\Client;
use App\Message;
use App\Phonebook;
use App\Website;
use App\Location;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function masterlist($table)
    {
        $data['data'] = $this->getData($table);
        if(is_null($data['data'])){
            return "404 Not Found";
        }
        $array_join = [];
        foreach ($data['data']['fields'] as $key) {
            if($key['join']!=""){
                $array_join[] = $key['join'];
            }
        }


        $data['data']['all'] = $data['data']['model']::with($array_join)->get();
        // dd($data);
        $data['data']['paged'] = $data['data']['model']::paginate(10);
        return view('master.all')->with($data);
    }

    public function masteradd($table)
    {
        $data['data'] = $this->getData($table);
        if(is_null($data['data'])){
            return "404 Not Found";
        }
        foreach ($data['data']['fields'] as $key) {
            if($key['type']=="select" and $key['join']!=""){
            $data['data']['join'][$key['join']]['all'] = $key['model']::all();
            } 
        }
        return view('master.add')->with($data);
    }

    public function getData($table)
    {
        $field['websites'] = [
            'slug'=>$table,
            'model'=>Website::class,
            'table'=>"Website Data",
            'type'=>'1',
            'fields'=>
                [
                    [
                        'name'=>'Name',
                        'field'=>'key',
                        'type'=>'string',
                        'value'=>'',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ],
                    [
                        'name'=>'Content',
                        'field'=>'content',
                        'type'=>'text',
                        'value'=>'',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ]
                ]
            ];
        $field['locations'] = [
            'slug'=>$table,
            'model'=>Location::class,
            'table'=>"Client Location",
            'type'=>'1',
            'fields'=>
                [
                    [
                        'name'=>'Name',
                        'field'=>'name',
                        'type'=>'string',
                        'value'=>'',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ],
                    [
                        'name'=>'Latitude',
                        'field'=>'lat',
                        'type'=>'string',
                        'value'=>'',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ],
                    [
                        'name'=>'Longitude',
                        'field'=>'lng',
                        'type'=>'string',
                        'value'=>'',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ]
                ]
            ];
        $field['pages'] = [
            'slug'=>$table,
            'model'=>Pages::class,
            'table'=>'Page',
            'type'=>'1',
            'fields'=>
                [
                    [
                        'name'=>'Title',
                        'field'=>'title',
                        'type'=>'string',
                        'value'=>'',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ],
                    [
                        'name'=>'Slug',
                        'field'=>'slug',
                        'type'=>'slug',
                        'value'=>'title',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ]
                ]
            ];
        $field['subcontents'] = [
            'slug'=>$table,
            'model'=>Subcontent::class,
            'table'=>'Subcontent',
            'type'=>'1',
            'fields'=>
                [
                    [
                        'name'=>'Content',
                        'field'=>'content_id',
                        'type'=>'select',
                        'value'=>'title',
                        'join'=>'contents',
                        'model'=>Content::class,
                        'required'=>true,
                    ],
                    [
                        'name'=>'Title',
                        'field'=>'title',
                        'type'=>'string',
                        'value'=>'',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ],
                    [
                        'name'=>'Slug',
                        'field'=>'slug',
                        'type'=>'slug',
                        'value'=>'title',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ],
                    [
                        'name'=>'Description',
                        'field'=>'description',
                        'type'=>'text',
                        'value'=>'',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ]
                ]
            ];
        $field['contents'] = [
            'slug'=>$table,
            'model'=>Content::class,
            'table'=>'Content',
            'type'=>'1',
            'fields'=>
                [
                    [
                        'name'=>'Page',
                        'field'=>'page_id',
                        'type'=>'select',
                        'value'=>'title',
                        'join'=>'pages',
                        'model'=>Pages::class,
                        'required'=>true,
                    ],
                    [
                        'name'=>'Title',
                        'field'=>'title',
                        'type'=>'string',
                        'value'=>'',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ],
                    [
                        'name'=>'Slug',
                        'field'=>'slug',
                        'type'=>'slug',
                        'value'=>'title',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ],
                    [
                        'name'=>'Image',
                        'field'=>'image',
                        'type'=>'image',
                        'value'=>'upload',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ],
                    [
                        'name'=>'Position',
                        'field'=>'position',
                        'type'=>'order',
                        'value'=>'0',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ],
                    [
                        'name'=>'Template',
                        'field'=>'template_id',
                        'type'=>'select',
                        'value'=>'title',
                        'join'=>'templates',
                        'model'=>Template::class,
                        'required'=>false,
                    ]
                ]
            ];
        $field['templates'] = [
            'slug'=>$table,
            'model'=>Template::class,
            'table'=>'Template',
            'type'=>'1',
            'fields'=>
                [
                    [
                        'name'=>'Title',
                        'field'=>'title',
                        'type'=>'string',
                        'value'=>'',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ],
                    [
                        'name'=>'Content',
                        'field'=>'content',
                        'type'=>'text',
                        'value'=>'',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ]
                ]
            ];
        $field['icons'] = [
            'slug'=>$table,
            'model'=>Icon::class,
            'table'=>'Icon',
            'type'=>'1',
            'fields'=>
                [
                    [
                        'name'=>'Name',
                        'field'=>'name',
                        'type'=>'string',
                        'value'=>'',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ],
                    [
                        'name'=>'Image',
                        'field'=>'image',
                        'type'=>'image',
                        'value'=>'upload',
                        'join'=>'',
                        'model'=>'',
                        'required'=>false,
                    ]
                ]
            ];
        $field['socialmedias'] = [
            'slug'=>$table,
            'model'=>Socialmedia::class,
            'table'=>'Social Media',
            'type'=>'1',
            'fields'=>
                [
                    [
                        'name'=>'Type',
                        'field'=>'type',
                        'type'=>'string',
                        'value'=>'',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ],
                    [
                        'name'=>'URL Page',
                        'field'=>'url',
                        'type'=>'string',
                        'value'=>'',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ]
                ]
            ];
        $field['slideshows'] = [
            'slug'=>$table,
            'model'=>Slideshow::class,
            'table'=>'Slideshow',
            'type'=>'1',
            'fields'=>
                [
                    [
                        'name'=>'Title',
                        'field'=>'title',
                        'type'=>'string',
                        'value'=>'',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ],
                    [
                        'name'=>'Description',
                        'field'=>'description',
                        'type'=>'text',
                        'value'=>'',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ],
                    [
                        'name'=>'Image',
                        'field'=>'image',
                        'type'=>'image',
                        'value'=>'upload',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ]
                ]
            ];
        $field['clients'] = [
            'slug'=>$table,
            'model'=>Client::class,
            'table'=>'Client',
            'type'=>'1',
            'fields'=>
                [
                    [
                        'name'=>'City',
                        'field'=>'location_id',
                        'type'=>'select',
                        'value'=>'name',
                        'join'=>'locations',
                        'model'=>Location::class,
                        'required'=>true,
                    ],
                    [
                        'name'=>'Name',
                        'field'=>'name',
                        'type'=>'string',
                        'value'=>'',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ],
                    [
                        'name'=>'Description',
                        'field'=>'description',
                        'type'=>'text',
                        'value'=>'',
                        'join'=>'',
                        'model'=>'',
                        'required'=>false,
                    ],
                    [
                        'name'=>'Website',
                        'field'=>'website',
                        'type'=>'string',
                        'value'=>'',
                        'join'=>'',
                        'model'=>'',
                        'required'=>false,
                    ],
                    [
                        'name'=>'Logo',
                        'field'=>'logo',
                        'type'=>'image',
                        'value'=>'upload',
                        'join'=>'',
                        'model'=>'',
                        'required'=>false,
                    ]
                ]
            ];
        $field['menus'] = [
            'slug'=>$table,
            'model'=>Menu::class,
            'table'=>'Menu',
            'type'=>'1',
            'fields'=>
                [
                    [
                        'name'=>'Content',
                        'field'=>'content_id',
                        'type'=>'select',
                        'value'=>'title',
                        'join'=>'contents',
                        'model'=>Content::class,
                        'required'=>true,
                    ],
                    [
                        'name'=>'Parent Menu',
                        'field'=>'menu_id',
                        'type'=>'select',
                        'value'=>'title',
                        'join'=>'menus',
                        'model'=>Menu::class,
                        'required'=>true,
                    ],
                    [
                        'name'=>'Icon',
                        'field'=>'icon_id',
                        'type'=>'select',
                        'value'=>'name',
                        'join'=>'icons',
                        'model'=>Icon::class,
                        'required'=>true,
                    ],
                    [
                        'name'=>'Title',
                        'field'=>'title',
                        'type'=>'string',
                        'value'=>'',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ],
                    [
                        'name'=>'Description',
                        'field'=>'description',
                        'type'=>'text',
                        'value'=>'',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ],
                ]
            ];
        $field['messages'] = [
            'slug'=>$table,
            'model'=>Message::class,
            'table'=>'Message',
            'type'=>'2',
            'fields'=>
                [
                    [
                        'name'=>'From',
                        'field'=>'from',
                        'type'=>'string',
                        'value'=>'name',
                        'join'=>'phonebooks',
                        'model'=>Phonebook::class,
                        'required'=>true,
                    ],
                    [
                        'name'=>'Message',
                        'field'=>'message',
                        'type'=>'text',
                        'value'=>'',
                        'join'=>'',
                        'model'=>'',
                        'required'=>true,
                    ]
                ]
            ];

        return isset($field[$table])?$field[$table]:null;
    }

    public function mastersave($table)
    {
        $data = $this->getData($table);
        if(is_null($data)){
            return "404 Not Found";
        }
        $a = new $data['model'];
        foreach ($data['fields'] as $key) {
            if(in_array($key['type'], ['string','text'])){
                // echo $a->{$key->['field']};
                $a->{$key['field']} = (Input::get($key['field'])!=null)?Input::get($key['field']):"";
            }else if($key['type']=="slug"){
                $a->{$key['field']} = str_slug((Input::get($key['value'])!=null)?Input::get($key['value']):"");
            }else if($key['type']=="select"){
                $a->{$key['field']} = Input::get($key['field'])==null?0:Input::get($key['field']);
            }else if($key['type']=="image"){
                if(Input::hasFile($key['field'])){
                    $file = "FILE-".date("ymdH")."-".uniqid().".".Input::file($key['field'])->getClientOriginalExtension();
                    Input::file($key['field'])->move(public_path("image"),$file);
                    $a->{$key['field']} = $file;
                }else{
                    $a->{$key['field']} = "";
                }
            }else{
                $a->{$key['field']} = "";
            }
        }
        $a->save();

        if($a->id!=null){
            return redirect()->route('masterlist',[$table]);
        }else{
            return redirect()->route('masteradd',[$table]);
        }
    }

    public function masteredit($table,$id)
    {
        $data['data'] = $this->getData($table);
        if(is_null($data['data'])){
            return "404 Not Found";
        }
        foreach ($data['data']['fields'] as $key) {
            if($key['type']=="select" and $key['join']!=""){
                $data['data']['join'][$key['join']]['all'] = $key['model']::all();
            } 
        }

        $data['data']['edit'] = $data['data']['model']::find($id);
        // dd($data);
        return view('master.edit')->with($data);
    }

    public function masterupdate($table)
    {
        $data = $this->getData($table);
        if(is_null($data)){
            return "404 Not Found";
        }
        $id = Input::get('id');
        $a = $data['model']::find($id);
        // dd($a);
        foreach ($data['fields'] as $key) {
            if(in_array($key['type'], ['string','text'])){
                // echo $a->{$key->['field']};
                $a->{$key['field']} = (Input::get($key['field'])!=null)?Input::get($key['field']):"";
            }else if($key['type']=="slug"){
                $a->{$key['field']} = str_slug((Input::get($key['value'])!=null)?Input::get($key['value']):"");
            }else if($key['type']=="select"){
                $a->{$key['field']} = Input::get($key['field'])==null?0:Input::get($key['field']);
            }else if($key['type']=="image"){
                if(Input::hasFile($key['field'])){
                    $file = "FILE-".date("ymdH")."-".uniqid().".".Input::file($key['field'])->getClientOriginalExtension();
                    Input::file($key['field'])->move(public_path("image"),$file);
                    $a->{$key['field']} = $file;
                }
            }else{
                $a->{$key['field']} = "";
            }
        }
        $a->save();

        if($a->id!=null){
            return redirect()->route('masterlist',[$table]);
        }else{
            return redirect()->route('masteredit',[$table,$id]);
        }
    }

    public function masterdelete($table,$id)
    {
        $data['data'] = $this->getData($table);
        if(is_null($data['data'])){
            return "404 Not Found";
        }

        $data['data']['model']::find($id)->delete();

        return redirect()->route('masterlist',[$table]);
    }
}
