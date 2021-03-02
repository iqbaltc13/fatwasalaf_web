@extends('layouts.blog_templates')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<base href="{{url('')}}/">

 
 



<div class="container">
    <div class="row">
      <!-- Latest Posts -->
      <main class="post blog-post col-lg-8"> 
        <div class="container">
          <div class="post-single">
            <div class="post-thumbnail">{{-- <img src="{{url('/')}}/templates/bootstrap-blog-1-2-1/distribution/img/gallery-2.jpg" data-fancybox="gallery" class="image"><img src="{{url('/')}}/templates/bootstrap-blog-1-2-1/distribution/img/blog-post-3.jpeg" alt="..." class="img-fluid"> --}}</div>
            <div class="post-details">
              <div class="post-meta d-flex justify-content-between">
                <div class="category">
                  @foreach($arrData->post_x_category as $cat)
                  <a href="#">
                          {{$cat->category->name}}
                  </a>
                  @endforeach
                </div>
              </div>
              <h1>{{$arrData->title}}<a href="#"><i class="fa fa-bookmark-o"></i></a></h1>
              <div class="post-footer d-flex align-items-center flex-column flex-sm-row"><a href="#" class="author d-flex align-items-center flex-wrap">
                  <div class="avatar"><img src="{{url('/')}}/templates/bootstrap-blog-1-2-1/distribution/img/gallery-2.jpg" data-fancybox="gallery" class="image"><img src="{{url('/')}}/templates/bootstrap-blog-1-2-1/distribution/img/avatar-1.jpg" alt="..." class="img-fluid"></div>
                  <div class="title"><span>John Doe</span></div></a>
                <div class="d-flex align-items-center flex-wrap">       
                  <div class="date"><i class="icon-clock"></i> 
                    {{$arrData->created_at->diffForHumans()}}
                  </div>
                  <div class="views"><i class="icon-eye"></i>{{$arrData->total_accessed}}</div>
                  <div class="comments meta-last"><i class="icon-comment"></i>
                    <?php $x=0?>
                    @foreach($arrData->comment as $komen)
                    <?php $x++?>
                    @endforeach
                    {{$x}}
                  </div>
                </div>
              </div>
              <div class="post-body">
                <p class="lead"></p>
                <p>{{$arrData->article}}</p>
                <p> {{-- <img src="{{url('/')}}/templates/bootstrap-blog-1-2-1/distribution/img/featured-pic-3.jpeg" alt="..." class="img-fluid"></p>
                <h3>Lorem Ipsum Dolor</h3>
                <p>div Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda temporibus iusto voluptates deleniti similique rerum ducimus sint ex odio saepe. Sapiente quae pariatur ratione quis perspiciatis deleniti accusantium</p> --}}
              {{--   <blockquote class="blockquote">
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>
                  <footer class="blockquote-footer">Someone famous in
                    <cite title="Source Title">Source Title</cite>
                  </footer>
                </blockquote> --}}
                {{-- <p>quasi nam. Libero dicta eum recusandae, commodi, ad, autem at ea iusto numquam veritatis, officiis. Accusantium optio minus, voluptatem? Quia reprehenderit, veniam quibusdam provident, fugit iusto ullam voluptas neque soluta adipisci ad.</p> --}}
              </div>
              <div class="post-tags">
                @foreach($arrData->post_x_category as $cat)
                <a href="#" class="tag">#{{$cat->category->name}}</a>
                @endforeach
              </div>
              <div class="posts-nav d-flex justify-content-between align-items-stretch flex-column flex-md-row">
                @if(!empty($prevId))
                <a href="{{route('blog.post', $prevId)}}" class="prev-post text-left d-flex align-items-center">
                  <div class="icon prev"><i class="fa fa-angle-left"></i></div>
                  <div class="text"><strong class="text-primary">Previous Post </strong>
                    <h6>{{$prevTitle}}</h6>
                  </div>
                </a>
                @endif
                @if(!empty($nextId))
                <a href="{{route('blog.post', $nextId)}}" class="next-post text-right d-flex align-items-center justify-content-end">
                  <div class="text"><strong class="text-primary">Next Post </strong>
                    <h6>{{$nextTitle}}</h6>
                  </div>
                  <div class="icon next"><i class="fa fa-angle-right"></i></div>
                </a>
                @endif
              </div>
              <div class="post-comments">
                <header>
                  <h3 class="h6">Komentar<span class="no-of-comments">
                    <?php $k=0;?>
                  @foreach($arrData->comment as $komen)
                    <?php $k++;?>
                  @endforeach
                  {{$k}}
                </span></h3>
                </header>
                
                <div id="display_comment"></div>
                {{-- <div class="comment">
                  <div class="comment-header d-flex justify-content-between">
                    <div class="user d-flex align-items-center">
                      <div class="image"><img src="{{url('/')}}/templates/bootstrap-blog-1-2-1/distribution/img/gallery-2.jpg" data-fancybox="gallery" class="image"><img src="{{url('/')}}/templates/bootstrap-blog-1-2-1/distribution/img/user.svg" alt="..." class="img-fluid rounded-circle"></div>
                      <div class="title"><strong>{{$komen->name}}</strong><span class="date">{{$komen->created_at->format(' d M Y| H.i')}} WIB</span></div>
                    </div>
                  </div>
                  <div class="comment-body">
                    <p>{{$komen->comment}}</p>
                  </div>
                </div> --}}
                
                <div class="container">
                 <form method="POST" id="comment_form" enctype="multipart/form-data">
                  {!! csrf_field() !!}
                  <div class="form-group">
                   <input type="text" name="comment_name" id="comment_name" class="form-control" placeholder="Nama" />
                 </div>
                 <div class="form-group">
                   <textarea name="comment_content" id="comment_content" class="form-control" placeholder="Komentar" rows="5"></textarea>
                 </div>
                 <div class="form-group">
                   <input type="hidden" name="post_id"  value="{{$arrData->id}}" />
                   <input type="submit" name="submit" id="submit" class="btn btn-info" value="Kirim" />
                 </div>
               </form>
               <span id="comment_message"></span>
               

             </div>
              {{-- <div class="add-comment">
                <header>
                  <h3 class="h6">Leave a reply</h3>
                </header>
                <form action="#" class="commenting-form">
                  <div class="row">
                    <div class="form-group col-md-6">
                      <input type="text" name="username" id="username" placeholder="Name" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                      <input type="email" name="username" id="useremail" placeholder="Email Address (will not be published)" class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                      <textarea name="usercomment" id="usercomment" placeholder="Type your comment" class="form-control"></textarea>
                    </div>
                    <div class="form-group col-md-12">
                      <button type="submit" class="btn btn-secondary">Submit Comment</button>
                    </div>
                  </div>
                </form>
              </div> --}}
            </div>
          </div>
        </div>
      </main>
      <aside class="col-lg-4">
        <!-- Widget [Search Bar Widget]-->
        <div class="widget search">
          <header>
            <h3 class="h6">Mencari Postingan</h3>
          </header>
          <form method="get" action="{{route('blog.cari-post')}}" enctype="multipart/form-data" class="search-form">
            {{csrf_field()}}
            <div class="form-group">
              <input type="search" placeholder="Masukkan kata kunci" name="kunci">
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
                <div class="image"><img src="{{url('/')}}/templates/bootstrap-blog-1-2-1/distribution/img/gallery-2.jpg" data-fancybox="gallery" class="image"><img src="{{url('/')}}/templates/bootstrap-blog-1-2-1/distribution/img/small-thumbnail-1.jpg" alt="..." class="img-fluid"></div>
                <div class="title"><a href="{{route('blog.post', $post->id)}}"><strong>{{$post->title}}</strong></a>
                  <div class="d-flex align-items-center">
                    <div class="views"><i class="icon-eye"></i>{{$post->total_accessed}}</div>
                    <div class="comments"><i class="icon-comment"></i>
                      <?php $i=0?>
                    @foreach($post->comment as $komen)
                    <?php $i++?>
                    @endforeach
                    {{$i}}
                    </div>
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
          @foreach($arrDataCategory as $kategori)
          
            <div class="item d-flex justify-content-between"><a href="#">{{$kategori->name}}</a>
                <span>
                  <?php $i=0;?>
                  @foreach($kategori->category_x_post as $a)
                    <?php $i++?>                    
                  @endforeach
                  {{$i}}
              </span>
          </div>
          
          @endforeach
          
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
<script>
  $(document).ready(function(){
    var base_url = document.getElementsByTagName('base')[0].getAttribute('href');
   $('#comment_form').on('submit', function(event){
    event.preventDefault();
    var form_data = $(this).serialize();
    $.ajax({
      url:base_url+ 'insert-comment',
     method:"POST",
     data:form_data,
     dataType:"JSON",
     success:function(data)
     {
      if(data.error != '')
      {
       $('#comment_form')[0].reset();
       $('#comment_message').html(data.error);
       $('#comment_id').val('0');
       load_comment();
     }
   }
 })
  });

   load_comment();

   function load_comment()
   {
    $.ajax({
     url:base_url+ 'load-comment',
     method:"POST",
     data: {
        "_token": "{{ csrf_token() }}", 
         post_id: {{$arrData->id}}     
        },
     success:function(data)
     {
      $('#display_comment').html(data);
    }
  })
  }

  $(document).on('click', '.reply', function(){
    var comment_id = $(this).attr("id");
    $('#comment_id').val(comment_id);
    $('#comment_name').focus();
  });

});
</script>
@endsection