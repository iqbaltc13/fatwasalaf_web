
<aside id="sc-sidebar-main">
    <div class="uk-offcanvas-bar">
	    <div data-sc-scrollbar="visible-y">
	        <ul class="sc-sidebar-menu uk-nav">
				<li class="sc-sidebar-menu-heading"><span>Menu</span></li>
				
                <li>
                    <a href="#">
                       <span class="uk-nav-icon"><i class="mdi mdi-book-open"></i>
                        </span><span class="uk-nav-title">Manajemen Postingan</span>
                    </a>
                    <ul class="sc-sidebar-menu-sub">
                        <li id="link.dashboard.post.create" @if(url()->current() == route('dashboard.post.create')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.post.create')}}"  > Postingan Baru </a>
                        </li>				
                        <li id="link.dashboard.post.index" @if(url()->current() == route('dashboard.post.index')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.post.index')}}" > Lists Postingan </a>
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