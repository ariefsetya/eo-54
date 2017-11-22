@extends('layouts.app')

@section('content')
<div class="carousel carousel-slider" data-indicators="true">
  @foreach(\App\Slideshow::get() as $key)
    <a class="carousel-item" href="#{{$key->title}}"><img src="{{url('image/'.$key->image)}}"></a>
  @endforeach
</div>
@foreach(\App\Content::wherePageId($data->id)->get() as $key)
<div class="content" id="{{$key->slug}}" style="background: url({{url('image/'.$key->image)}});background-position: center;background-repeat: no-repeat;background-size: cover;">
<div class="subcontent">
    @foreach(\App\Subcontent::whereContentId($key->id)->get() as $child)
    <div class="row" style="margin: 20px;">
      <h2 class="header" style="color:#eee;">{{$child->title}}</h2>
      <p style="color:#eee;white-space: pre-wrap;">{!!$child->description!!}</p>
    </div>
    @endforeach
</div>
</div>
<hr>

@endforeach
<div class="content" id="client" style="background:rgba(0, 0, 255, 0.8)">
</div>
<hr>
<div class="content" id="gallery" style="background:#333333;">
  <div class="container" style="padding: 10px;">
    <h2 class="header" style="color:#eee;text-align: center;padding: 30px;">Gallery</h2>
    <div class="row">
    @foreach(\App\Gallery::get() as $key)
    <div class="col s4" style="overflow: hidden;height: 250px;margin-bottom: 20px;">
        <img class="materialboxed" style="width: 100%;height: 100%;" src="{{url('image/'.$key->image)}}">
      </div>
    @endforeach
    </div>
  </div>
</div>
<hr>
<div class="content" id="contact_us" style="background:url({{url('image/17126378_278658622554160_9184124797502619648_n.jpg')}});background-size: cover;background-repeat: no-repeat;">
  <div class="container">
    <div class="row">
        <div class="col m10 offset-m1 s12" style="margin-top: 150px;background:rgba(0, 0, 0, 0.8);">
            <h2 class="center-align" style="color: #eee">Contact Us</h2>
            <div class="row">
                <form class="col m8 offset-m2 s12">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="name" type="text">
                            <label for="name">Name</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="email" type="email" class="form-input">
                            <label for="email">Email</label>
                        </div>
                        <div class="input-field col s12">
                          <textarea id="message" class="materialize-textarea"></textarea>
                          <label for="message">Message</label>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col m12">
                         <p class="right-align"><button class="btn btn-large waves-effect waves-light" type="button" name="action">Send Message</button></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<hr>
<div>
  <footer class="page-footer" style="background:#333">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text">Kokon Production</h5>
                <p class="white-text text-lighten-4">Komp. Business Park Blok F1 No. 12<br>Kebon Jeruk, Jawa Barat, Indonesia 11620<br>
                telp. +6221 300 679 09 fax. +6221 300 615 38</p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="">Social Media</h5>
                <ul>
                  @foreach(\App\Socialmedia::get() as $key)
                    <li><a target="_blank" class="white-text text-lighten-3" href="{{$key->url}}"><div class="ion-social-{{$key->type}}" style="width: 20px;display: inline-block;text-align: center;"></div> {{$key->url}}</a></li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            &copy; 1980-{{date("Y")}} Kokon Production
            </div>
          </div>
        </footer>
            
</div>


@endsection

@section('footer')
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUcDP0pkxDFiN0geV-KVmWhyd-zrqcLIg&callback=initMap">
    </script>
<script>


      function initMap() {
        var bounds = new google.maps.LatLngBounds();
        var map = new google.maps.Map(document.getElementById('client'));
        @foreach(\App\Location::get() as $key)
            var content = "";
            var infoWindow = new google.maps.InfoWindow();
            var uluru = {lat: {{$key->lat}}, lng: {{$key->lng}}};
              content +='<b>{{$key->name}}</b><br>';
          @foreach(\App\Client::whereLocationId($key->id)->get() as $child)
              content +='{{$child->name}}<br>';

          @endforeach
          @if(\App\Client::whereLocationId($key->id)->count()>0)
            bounds.extend(uluru);

            infoWindow.setOptions({
                content: content,
                position: uluru,
            });
            infoWindow.open(map); 
            @endif
        @endforeach
        var infoWindow = new google.maps.InfoWindow();
        var uluru = {lat: -4.602695, lng: 109.8012983};
        bounds.extend(uluru);
        var content = "<h3>Clients</h3>";

        infoWindow.setOptions({
            content: content,
            position: uluru,
        });
        infoWindow.open(map); 
        map.fitBounds(bounds);
      }
    </script>
<script type="text/javascript">
    $('.carousel.carousel-slider').carousel({fullWidth: true});
    $(".carousel").height($(window).height());
    @foreach(\App\Content::wherePageId(1)->get() as $key)
    $("#{{$key->slug}}").height($(window).height());
    @endforeach
    $("#client").height($(window).height());
    $("#contact_us").height($(window).height());
 autoplay()   
  function autoplay() {
      $('.carousel').carousel('next');
      setTimeout(autoplay, 4500);
  }
  function goto(id){
        if($('nav.menu ul').hasClass('showing')){
          $('nav.menu ul').toggleClass('showing');
        }
        var id = $("#"+id);
        var target = $(id);
        target = target.length ? target : $('[name=' + id.slice(1) + ']');
            if (target.length) {
            event.preventDefault();
              if($(window).width()<=580){
                
                $('html, body').animate({
                  scrollTop: target.offset().top-150
                }, 1000,function() {
                });

              }else{
                $('html, body').animate({
                  scrollTop: target.offset().top
                }, 1000,function() {
                });
              }
        }
    }
    $( window ).resize(function() {
        $(".carousel").height($(window).height());
        $(".carousel-item").height($(window).height());
        $(".parallax-container").height($(window).height());
        @foreach(\App\Content::wherePageId(1)->get() as $key)
        $("#{{$key->slug}}").height($(window).height());
        @endforeach
        $("#client").height($(window).height());
        $("#contact_us").height($(window).height());
    });
    $(document).ready(function() {
        $(".carousel").height($(window).height());
    });
    $('.handle').on('click', function() {
      $('nav.menu ul').toggleClass('showing');
    });
</script>
<style type="text/css">
*{
    outline: none;
    margin: 0;
}
#client h2{
  margin: 0;
}
.gm-style-iw+div {
    display: none;
}
.gm-style-iw {
    text-align: center;
}
hr {
    border: 0;
    height: 1px;
    background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));
}
a{
  cursor: pointer;
}
.subcontent{
  position:absolute;background:rgba(0, 0, 0, 0.8);width: 1000px;margin: 200px 400px;
}
.logo{
    position: absolute;
    top: 10px;
    right: 20px;
    z-index: 9999999;
}
.carousel.carousel-slider{
    z-index: 99999;
}
/* ------------------- NAVIGATION ------------------*/

nav.menu {
  z-index: 99999999999999999;
  position: fixed;
  width: 100%;
  height: 100px;
  background-color: rgba(0, 0, 0, .5);
  text-align: center;
}

nav.menu a {
  text-decoration: none;
  color: white;
  line-height: 100px;
  font-size: 120%;
  padding-left: 50px;
  padding-right: 50px;
}

nav.menu a:hover {
  color: orange;
}

nav.menu ul {
  overflow: hidden;
  padding: 0;
  text-align: center;
  -webkit-transition: max-height 0.4s;
  -ms-transition: max-height 0.4s;
  -moz-transition: max-height 0.4s;
  -o-transition: max-height 0.4s;
  transition: max-height 0.4s;
}

nav.menu ul li {
  display: inline-block;
}
.handle {
  width: 100%;
  text-align: left;
  box-sizing: border-box;
  padding: 10px 10px;
  cursor: pointer;
  display: none;
}

li.logos{
  padding: 10px;
}
li.logos img{
  width: 200px;
}
@media screen and (max-width: 580px) {
  #app {
    margin-top: 150px;
  }

  .subcontent{
    position:absolute;background:rgba(0, 0, 0, 0.7);width: 100%;
    margin: 0px auto;
  }

  .carousel{
    height: 100%;
  }
  .carousel .carousel-item img{
    height: 100%;
    width: auto;
  }

  nav.menu {
    margin-top: -150px;
    position: fixed;
    width: 100%;
    height: auto;
    background-color: rgba(0, 0, 0, .8);
    text-align: center;
  }
  nav.menu ul {
    max-height: 110px;
  }
  nav.menu ul.showing {
    max-height: 40em;
  }
  nav.menu ul li.logos {
    text-align: center;
  }
  nav.menu ul li.logos img {
    height: 100px;
    width: auto;
  }
  nav.menu ul li {
    box-sizing: border-box;
    width: 100%;
    text-align: left;
  }
  nav.menu ul li a{
    line-height: 20px;
    padding: 10px;
  }
  .handle {
    display: block;
    line-height: 20px;
    padding-bottom: 10px;
  }
  .wrapper {
    width: 150px;
    height: 110px;
  }
}
</style>
@endsection
