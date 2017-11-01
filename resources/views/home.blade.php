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
      <p style="color:#eee;">{{$child->description}}</p>
    </div>
    @endforeach
</div>
</div>
<hr>

@endforeach

@endsection

@section('footer')
<script type="text/javascript">
    $('.carousel.carousel-slider').carousel({fullWidth: true});
    $(".carousel").height($(window).height());
    @foreach(\App\Content::wherePageId(1)->get() as $key)
    $("#{{$key->slug}}").height($(window).height());
    $("#{{$key->slug}}_2").height($(window).height()/4);
    @endforeach
 $(document).ready(function(){
      $('.parallax').parallax();
    });
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
                  scrollTop: target.offset().top-190
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
        $("#{{$key->slug}}").height($(window).height()/4);
        $("#{{$key->slug}}_2").height($(window).height()/4);
        @endforeach
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
    margin-top: 180px;
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
    margin-top: -180px;
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
