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
            'model'=>Website::class,
            'table'=>"Website Datas",
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
        $field['pages'] = [
            'model'=>Pages::class,
            'table'=>$table,
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
            'model'=>Subcontent::class,
            'table'=>$table,
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
            'model'=>Content::class,
            'table'=>$table,
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
            'model'=>Template::class,
            'table'=>$table,
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
            'model'=>Icon::class,
            'table'=>$table,
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
            'model'=>Socialmedia::class,
            'table'=>'socialmedia',
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
            'model'=>Slideshow::class,
            'table'=>$table,
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
            'model'=>Client::class,
            'table'=>$table,
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
                        'required'=>true,
                    ]
                ]
            ];
        $field['menus'] = [
            'model'=>Menu::class,
            'table'=>$table,
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
            'model'=>Message::class,
            'table'=>$table,
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

        return $field[$table];
    }

    public function mastersave($table)
    {
        $data = $this->getData($table);
        $a = new $data['model'];
        foreach ($data['fields'] as $key) {
            if(in_array($key['type'], ['string','text'])){
                // echo $a->{$key->['field']};
                $a->{$key['field']} = Input::get($key['field']);
            }else if($key['type']=="slug"){
                $a->{$key['field']} = str_slug(Input::get($key['value']));
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
        $id = Input::get('id');
        $a = $data['model']::find($id);
        // dd($a);
        foreach ($data['fields'] as $key) {
            if(in_array($key['type'], ['string','text'])){
                $a->{$key['field']} = Input::get($key['field']);
            }else if($key['type']=="slug"){
                $a->{$key['field']} = str_slug(Input::get($key['value']));
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

        $data['data']['model']::find($id)->delete();

        return redirect()->route('masterlist',[$table]);
    }
}
