@extends('layouts.blog_templates')
@section('content')

<div class="container">
    <div class="row">
      <!-- Latest Posts -->
      <main class="posts-listing col-lg-8"> 
        <div class="container">
          <div class="row">
            <?php $i=0;?>
          @foreach($arrData as $post)
            <?php $i++?>
            <!-- post -->
            <div class="post col-xl-6">
              <div class="post-thumbnail"><a href="post.html"><img src="{{url('/')}}/templates/bootstrap-blog-1-2-1/distribution/img/blog-post-1.jpeg" alt="..." class="img-fluid"></a></div>
              <div class="post-details">
                <div class="post-meta d-flex justify-content-between">
                  <div class="date meta-last">20 May | 2016</div>
                  <div class="category">
                    <a href="#">
                        @foreach($post->post_x_category as $cat)
                          {{$cat->category->name}}
                        @endforeach
                    </a></div>
                </div><a href="{{route('blog.post', $post->id)}}">
                  <h3 class="h4">{{$post->title}}</h3></a>
                <p style="overflow: hidden; height: 4.5em;" class="text-muted">{{$post->article}}}</p>
                <footer class="post-footer d-flex align-items-center"><a href="#" class="author d-flex align-items-center flex-wrap">
                    <div class="avatar"><img src="{{url('/')}}/templates/bootstrap-blog-1-2-1/distribution/img/avatar-3.jpg" alt="..." class="img-fluid"></div>
                    <div class="title"><span>John Doe</span></div></a>
                  <div class="date"><i class="icon-clock"></i> 2 months ago</div>
                  <div class="comments meta-last"><i class="icon-comment"></i>12</div>
                </footer>
              </div>
            </div>
          @endforeach
          </div>
          <!-- Pagination -->

          
          <nav aria-label="Page navigation example">
            <ul class="pagination pagination-template d-flex justify-content-center">
              {{ $arrData->links() }}
            </ul>
          </nav>
        </div>
      </main>
      <aside class="col-lg-4">
        <!-- Widget [Search Bar Widget]-->
        <div class="widget search">
          <header>
            <h3 class="h6">Search the blog</h3>
          </header>
          <form action="#" class="search-form">
            <div class="form-group">
              <input type="search" placeholder="What are you looking for?">
              <button type="submit" class="submit"><i class="icon-search"></i></button>
            </div>
          </form>
        </div>
        <!-- Widget [Latest Posts Widget]        -->
        <div class="widget latest-posts">
          <header>
            <h3 class="h6">Postingan Terbaru</h3>
          </header>
          <div class="blog-posts"><a href="#">
            @foreach($latest as $post)
              <div class="item d-flex align-items-center">
                <div class="image"><img src="{{url('/')}}/templates/bootstrap-blog-1-2-1/distribution/img/small-thumbnail-1.jpg" alt="..." class="img-fluid"></div>
                <div class="title"><strong>{{$post->title}}</strong>
                  <div class="d-flex align-items-center">
                    <div class="views"><i class="icon-eye"></i> 500</div>
                    <div class="comments"><i class="icon-comment"></i>12</div>
                  </div>
                </div>
              </div></a><a href="#">
              @endforeach
              
        </div>
        <!-- Widget [Categories Widget]-->
        <div class="widget categories">
          <header>
            <h3 class="h6">Categories</h3>
          </header>
          <div class="item d-flex justify-content-between"><a href="#">Growth</a><span>12</span></div>
          <div class="item d-flex justify-content-between"><a href="#">Local</a><span>25</span></div>
          <div class="item d-flex justify-content-between"><a href="#">Sales</a><span>8</span></div>
          <div class="item d-flex justify-content-between"><a href="#">Tips</a><span>17</span></div>
          <div class="item d-flex justify-content-between"><a href="#">Local</a><span>25</span></div>
        </div>
        <!-- Widget [Tags Cloud Widget]-->
        <div class="widget tags">       
          <header>
            <h3 class="h6">Tags</h3>
          </header>
          <ul class="list-inline">
            @foreach($arrDataCategory as $tag)
            <li class="list-inline-item"><a href="#" class="tag">#{{$tag->name}}</a></li>
            @endforeach
          </ul>
        </div>
      </aside>
    </div>
  </div>
@push('scripts')
@endpush
@endsection