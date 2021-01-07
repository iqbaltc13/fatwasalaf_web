
<aside id="sc-sidebar-main">
    <div class="uk-offcanvas-bar">
	    <div data-sc-scrollbar="visible-y">
	        <ul class="sc-sidebar-menu uk-nav">
				<li class="sc-sidebar-menu-heading"><span>Menu</span></li>
				
                <li>
                    <a href="#">
                       <span class="uk-nav-icon"><i class="mdi mdi-book-open"></i>
                        </span><span class="uk-nav-title">Manajemen Bacaan</span>
                    </a>
                    <ul class="sc-sidebar-menu-sub">
                        <li id="link.dashboard.inspirasi.bacaan.create" @if(url()->current() == route('dashboard.inspirasi.bacaan.create')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.inspirasi.bacaan.create')}}"  > Create New </a>
                        </li>				
                        <li id="link.dashboard.inspirasi.bacaan.index" @if(url()->current() == route('dashboard.inspirasi.bacaan.index')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.inspirasi.bacaan.index')}}" > Lists </a>
                        </li>	
                    </ul>
                </li>
                <li>
                    <a href="#">
                       <span class="uk-nav-icon"><i class="mdi mdi-podcast"></i>
                        </span><span class="uk-nav-title">Manajemen Podcast</span>
                    </a>
                    <ul class="sc-sidebar-menu-sub">
                        <li id="link.dashboard.inspirasi.podcast.create" @if(url()->current() == route('dashboard.inspirasi.podcast.create')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.inspirasi.podcast.create')}}"  > Create New </a>
                        </li>				
                        <li id="link.dashboard.inspirasi.podcast.index" @if(url()->current() == route('dashboard.inspirasi.podcast.index')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.inspirasi.podcast.index')}}" > Lists </a>
                        </li>	
                    </ul>
                </li>
                <li>
                    <a href="#">
                       <span class="uk-nav-icon"><i class="mdi mdi-video"></i>
                        </span><span class="uk-nav-title">Manajemen Video</span>
                    </a>
                    <ul class="sc-sidebar-menu-sub">
                        <li id="link.dashboard.inspirasi.video.create" @if(url()->current() == route('dashboard.inspirasi.video.create')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.inspirasi.video.create')}}"  > Create New </a>
                        </li>				
                        <li id="link.dashboard.inspirasi.video.index" @if(url()->current() == route('dashboard.inspirasi.video.index')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.inspirasi.video.index')}}" > Lists </a>
                        </li>	
                    </ul>
                </li>
	           
	        </ul>
	    </div>
    </div>
	<div class="sc-sidebar-info">
        version: 2.1.0
	</div>
</aside>