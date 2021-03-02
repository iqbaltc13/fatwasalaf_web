@extends('layouts.blog_templates')
@section('content')
<!-- Hero Section-->
<section style="background: url(https://d19m59y37dris4.cloudfront.net/blog/1-2-1/img/hero.jpg); background-size: cover; background-position: center center" class="hero">
  <div class="container">
    <div class="row">
      <div class="col-lg-7">
        <h1>FATWA SALAF</h1><a href="#" class="hero-link">Discover More</a>
      </div>
    </div><a href=".intro" class="continue link-scroll"><i class="fa fa-long-arrow-down"></i> Scroll Down</a>
  </div>
</section>
  <!-- Intro Section-->
  <section class="intro">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <h2 class="h3">Some great intro here</h2>
          <p class="text-big">Place a nice <strong>introduction</strong> here <strong>to catch reader's attention</strong>. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderi.</p>
        </div>
      </div>
    </div>
  </section>
  <section class="featured-posts no-padding-top">
    <div class="container">
      <?php $i=0;?>
      @foreach($arrData as $post)
      <?php $i++?>
      <!-- Post-->
      <div class="row d-flex align-items-stretch">
        @if($i %2 == 0)
        <div class="image col-lg-5"><img src="{{-- {{url('/')}}/templates/bootstrap-blog-1-2-1/distribution/img/featured-pic-1.jpeg --}}" alt="..."></div>
        @endif
        <div class="text col-lg-7">
          <div class="text-inner d-flex align-items-center">
            <div class="content">
              <header class="post-header">

                <div class="category">
                <a href="#">
                  @foreach($post->post_x_category as $cat)
                  {{$cat->category->name}}
                  @endforeach
                </a>
                  </div><a href="{{route('blog.post', $post->id)}}">
                  <h2 class="h4">{{$post->title}}</h2></a>
              </header>
              <p style="overflow: hidden; height: 7.2em;">{{$post->article}}</p>
              <footer class="post-footer d-flex align-items-center"><a href="#" class="author d-flex align-items-center flex-wrap">
                  <div class="avatar"><img src="{{-- {{url('/')}}/templates/bootstrap-blog-1-2-1/distribution/img/avatar-1.jpg --}}" alt="..." class="img-fluid"></div>
                  <div class="title"><span>John Doe</span></div></a>
                <div class="date"><i class="icon-clock"></i> 
                  {{$post->created_at->diffForHumans()}}
                </div>
                <div class="comments"><i class="icon-comment"></i>
                  <?php $x=0?>
                    @foreach($post->comment as $komen)
                    <?php $x++?>
                    @endforeach
                    {{$x}}
                </div>
              </footer>
            </div>
          </div>
        </div>
        @if($i %2 == 1)
        <div class="image col-lg-5"><img src="{{-- {{url('/')}}/templates/bootstrap-blog-1-2-1/distribution/img/featured-pic-1.jpeg --}}" alt="..."></div>
        @endif
      </div>
      @endforeach
      
    </div>
  </section>
  <!-- Divider Section-->
 {{--  <section style="background: {{url('/')}}/templates/bootstrap-blog-1-2-1/distribution/divider-bg.jpg; background-size: cover; background-position: center bottom" class="divider">
    <div class="container">
      <div class="row">
        <div class="col-md-7">
          <h2>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</h2><a href="#" class="hero-link">View More</a>
        </div>
      </div>
    </div>
  </section> --}}
  <!-- Latest Posts -->
  <section class="latest-posts"> 
    <div class="container">
      <header> 
        <h2>Postingan Terbaru</h2>
        <p class="text-big">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
      </header>
      <div class="row">
        @foreach($latest as $post)
        <div class="post col-md-4">
          <div class="post-thumbnail"><a href="{{route('blog.mockup.post')}}"><img src="{{-- {{url('/')}}/templates/bootstrap-blog-1-2-1/distribution/img/blog-1.jpg --}}" alt="..." class="img-fluid"></a></div>
          <div class="post-details">
            <div class="post-meta d-flex justify-content-between">
              <div class="date meta-last">{{$post->created_at->format('j F | Y')}}</div>
              <div class="category">
                <a href="#">
                  @foreach($post->post_x_category as $cat)
                  {{$cat->category->name}}
                  @endforeach
                </a>
              </div>
            </div><a href="{{route('blog.post', $post->id)}}">
              <h3 class="h4">{{$post->title}}</h3></a>
            <p style="overflow: hidden; height: 4.5em;" class="text-muted">{{$post->article}}</p>
          </div>
        </div>
        @endforeach
  
      </div>
    </div>
  </section>
  <!-- Newsletter Section-->
  {{-- <section class="newsletter no-padding-top">    
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h2>Subscribe to Newsletter</h2>
          <p class="text-big">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
        <div class="col-md-8">
          <div class="form-holder">
            <form action="#">
              <div class="form-group">
                <input type="email" name="email" id="email" placeholder="Type your email address">
                <button type="submit" class="submit">Subscribe</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section> --}}
  <!-- Gallery Section-->
  <section class="gallery no-padding">    
    <div class="row">
      <div class="mix col-lg-3 col-md-3 col-sm-6">
        <div class="item"><a href="{{url('/')}}/templates/bootstrap-blog-1-2-1/distribution/img/gallery-4.jpg" data-fancybox="gallery" class="image"><img src="{{-- {{url('/')}}/templates/bootstrap-blog-1-2-1/distribution/img/gallery-4.jpg --}}" alt="..." class="img-fluid">
            <div class="overlay d-flex align-items-center justify-content-center"><i class="icon-search"></i></div></a></div>
      </div>
    </div>
  </section>
@push('scripts')
@endpush
@endsection
 