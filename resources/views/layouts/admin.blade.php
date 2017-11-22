<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

      <link type="text/css" rel="stylesheet" href="{{asset('css/materialize.css')}}"  media="screen,projection"/>

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Kokon Production Admin</title>
      <script type="text/javascript" src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('js/materialize.js')}}"></script>
</head>
<body>
@if(Auth::check())
  <div style="margin: 10px;position: fixed;width: 300px;height: auto;z-index: 999999999;">
    <div style="position: relative;" id="menu">
        <ul style="margin: 0;" class="collapsible popout" data-collapsible="accordion">
          <li>
              <div onclick="goto('app')" class="collapsible-header">
                  
                  <img src="{{url('image/logo.png')}}" style="height: 65px;margin:auto;">
              </div>
          </li>
          <li>
              <a href="{{url('master/contents')}}"><div class="collapsible-header">Contents</div></a>
              <a href="{{url('master/subcontents')}}"><div class="collapsible-header">Subcontents</div></a>
              <a href="{{url('master/menus')}}"><div class="collapsible-header">Menus</div></a>
              <a href="{{url('master/locations')}}"><div class="collapsible-header">Client Locations</div></a>
              <a href="{{url('master/clients')}}"><div class="collapsible-header">Clients</div></a>
              <a href="{{url('master/slideshows')}}"><div class="collapsible-header">Slideshow</div></a>
              <a href="{{url('master/socialmedias')}}"><div class="collapsible-header">Social Media</div></a>
              <a href="{{url('master/icons')}}"><div class="collapsible-header">Icons</div></a>
              <a href="{{url('master/messages')}}"><div class="collapsible-header">Guest Messages</div></a>
              <a href="{{url('master/gallery')}}"><div class="collapsible-header">Gallery</div></a>
              <a href="{{url('master/websites')}}"><div class="collapsible-header">Websites</div></a>
          </li>
        </ul>
    </div>
  </div>
@endif
    <div id="app" class="container">

        @yield('content')

    </div>

        
</body>
</html>
