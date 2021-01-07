
<aside id="sc-sidebar-main">
    <div class="uk-offcanvas-bar">
	    <div data-sc-scrollbar="visible-y">
	        <ul class="sc-sidebar-menu uk-nav">
				<li class="sc-sidebar-menu-heading"><span>Menu</span></li>
                <li>
                    <a href="{{route('dashboard.master.pembayaran.index')}}" 
                        @if(url()->current() == route('dashboard.master.pembayaran.index')||url()->current() == route('dashboard.master.pembayaran.create')) 
                        class="sc-page-active" 
                        @endif
                    
                    >
                       <span class="uk-nav-icon"><i class="mdi mdi-home-assistant"></i>
                        </span><span class="uk-nav-title">Pembayaran Tabungan</span>
                    </a>
                    {{-- <ul class="sc-sidebar-menu-sub">
                        <li id="link.dashboard.master.pembayaran.create" @if(url()->current() == route('dashboard.master.pembayaran.create')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.master.pembayaran.create')}}"  > Create New </a>
                        </li>				
                        <li id="link.dashboard.master.pembayaran.index" @if(url()->current() == route('dashboard.master.pembayaran.index')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.master.pembayaran.index')}}" > Lists </a>
                        </li>	
                    </ul> --}}
                </li>
	           
	        </ul>
	    </div>
    </div>
	<div class="sc-sidebar-info">
        version: 2.1.0
	</div>
</aside>