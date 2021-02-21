
<aside id="sc-sidebar-main">
    <div class="uk-offcanvas-bar">
	    <div data-sc-scrollbar="visible-y">
	        <ul class="sc-sidebar-menu uk-nav">
				<li class="sc-sidebar-menu-heading"><span>Menu</span></li>
				
                <li>
                    <a href="#">
                       <span class="uk-nav-icon"><i class="mdi mdi-book-open"></i>
                        </span><span class="uk-nav-title">Manajemen Kategori</span>
                    </a>
                    <ul class="sc-sidebar-menu-sub">
                        <li id="link.dashboard.category.create" @if(url()->current() == route('dashboard.category.create')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.category.create')}}"  > Kategori Baru </a>
                        </li>				
                        <li id="link.dashboard.category.index" @if(url()->current() == route('dashboard.category.index')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.category.index')}}" > Lists Kategori </a>
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