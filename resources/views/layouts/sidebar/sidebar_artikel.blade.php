
<aside id="sc-sidebar-main">
    <div class="uk-offcanvas-bar">
	    <div data-sc-scrollbar="visible-y">
	        <ul class="sc-sidebar-menu uk-nav">
				<li class="sc-sidebar-menu-heading"><span>Menu</span></li>
                <li>
                    <a href="#">
                       <span class="uk-nav-icon"><i class="mdi mdi-home-assistant"></i>
                        </span><span class="uk-nav-title">Manajemen Konten</span>
                    </a>
                    <ul class="sc-sidebar-menu-sub">
                        <li id="link.dashboard.artikel.create" @if(url()->current() == route('dashboard.artikel.create')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.artikel.create')}}"  > Create New </a>
                        </li>				
                        <li id="link.dashboard.artikel.index" @if(url()->current() == route('dashboard.artikel.index')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.artikel.index')}}" > Lists </a>
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