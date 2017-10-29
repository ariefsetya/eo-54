<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

      <link type="text/css" rel="stylesheet" href="{{asset('css/materialize.css')}}"  media="screen,projection"/>

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Kokon Production</title>
</head>
<body>
    <div id="app">
        @guest

        @else
        <div style="margin: 10px;position: fixed;width: 300px;height: auto;z-index: 999999999;">
        <div style="position: relative;" id="menu">
            <ul style="margin: 0;" class="collapsible popout" data-collapsible="accordion">
            <li>
                <div onclick="goto('app')" class="collapsible-header">
                    
                    <img src="{{url('image/logo.png')}}" style="height: 65px;margin:auto;">
                </div>
            </li>
            <li>
                <div onclick="goto('aboutus')" class="collapsible-header">
                    About Us
                </div>
            </li>
            @foreach(\App\Menu::with(['contents'])->where('menu_id',1)->get() as $key)
                <li>
                    <div onclick="goto('{{$key->contents->slug}}')" class="collapsible-header">
                        {{$key->title}}
                    </div>
                    @if(\App\Menu::with(['contents'])->where('menu_id',$key->id)->count()>0)
                    <div class="collapsible-body white">
                        <div class="row">

                        @foreach(\App\Menu::with(['contents'])->where('menu_id',$key->id)->get() as $kay)
                            <a onclick="goto('{{$kay->contents->slug}}')"><div class="col s4">
                                <div class="center promo promo-example">
                                @if($kay->icons->image=="")
                                <i class="material-icons">{{$kay->icons->name}}</i>
                                @else
                                <img style="width: 100%;" src="{{url('image/'.$kay->icons->image)}}">
                                @endif
                                <p class="promo-caption">{{$kay->title}}</p>
                              </div>
                            </div></a>
                        @endforeach
                        </div>
                    </div>
                    @endif
                </li>
            @endforeach
            </ul>
        </div>
        </div>
        @endguest

        @yield('content')
        
    </div>

      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="{{asset('js/materialize.js')}}"></script>
      @yield('footer')
</body>
</html>
