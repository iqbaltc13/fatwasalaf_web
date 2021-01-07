
<aside id="sc-sidebar-main">
    <div class="uk-offcanvas-bar">
	    <div data-sc-scrollbar="visible-y">
	        <ul class="sc-sidebar-menu uk-nav">
				<li class="sc-sidebar-menu-heading"><span>Menu</span></li>
				
                <li>
                    <a href="#">
                       <span class="uk-nav-icon"><i class="mdi mdi-book-open"></i>
                        </span><span class="uk-nav-title">Manajemen Paket Tabungan Haji</span>
                    </a>
                    <ul class="sc-sidebar-menu-sub">
                        <li id="link.dashboard.paket-tabungan.haji.create" @if(url()->current() == route('dashboard.paket-tabungan.haji.create')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.paket-tabungan.haji.create')}}"  > Create New </a>
                        </li>				
                        <li id="link.dashboard.paket-tabungan.haji.index" @if(url()->current() == route('dashboard.paket-tabungan.haji.index')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.paket-tabungan.haji.index')}}" > Lists </a>
                        </li>	
                    </ul>
                </li>
                <li>
                    <a href="#">
                       <span class="uk-nav-icon"><i class="mdi mdi-book-open"></i>
                        </span><span class="uk-nav-title">Manajemen Paket Tabungan Umrah</span>
                    </a>
                    <ul class="sc-sidebar-menu-sub">
                        <li id="link.dashboard.paket-tabungan.umrah.create" @if(url()->current() == route('dashboard.paket-tabungan.umrah.create')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.paket-tabungan.umrah.create')}}"  > Create New </a>
                        </li>				
                        <li id="link.dashboard.paket-tabungan.umrah.index" @if(url()->current() == route('dashboard.paket-tabungan.umrah.index')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.paket-tabungan.umrah.index')}}" > Lists </a>
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