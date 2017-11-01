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

  <nav class="menu">
    <ul>
        <li class="logos"><img onclick="goto('app')" src="{{url('image/logo.png')}}"></li>
        @foreach(\App\Menu::with(['contents'])->where('menu_id',1)->get() as $key)
            <li><a onclick="goto('{{$key->contents->slug}}')">{{$key->title}}</a></li>
        @endforeach

    </ul>
    <div class="handle">Menu &#9776;﻿</div>
  </nav>
    </div>

        @yield('content')
        
    </div>

      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="{{asset('js/materialize.js')}}"></script>
      @yield('footer')
</body>
</html>
