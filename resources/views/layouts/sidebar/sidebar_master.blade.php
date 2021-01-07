
<aside id="sc-sidebar-main">
    <div class="uk-offcanvas-bar">
	    <div data-sc-scrollbar="visible-y">
	        <ul class="sc-sidebar-menu uk-nav">
				<li class="sc-sidebar-menu-heading"><span>Menu</span></li>
				
                
                <li>
                    
                    <a href="{{route('dashboard.master.faq.index')}}" @if(url()->current() == route('dashboard.master.faq.index')) class="sc-page-active" @endif>
                       <span class="uk-nav-icon"><i class="mdi mdi-frequently-asked-questions"></i>
                        </span><span class="uk-nav-title">F A Q</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('dashboard.master.syarat-ketentuan.index')}}" @if(url()->current() == route('dashboard.master.syarat-ketentuan.index')) class="sc-page-active" @endif>
                       <span class="uk-nav-icon"><span data-uk-icon="icon: check"></span>
                        </span><span class="uk-nav-title">Syarat dan Ketentuan</span>
                    </a>
                   
                </li>
                <li>
                    <a href="{{route('dashboard.master.info-slider.index')}}" @if(url()->current() == route('dashboard.master.info-slider.index')) class="sc-page-active" @endif>
                       <span class="uk-nav-icon"><i class="mdi mdi-google-photos"></i>
                        </span><span class="uk-nav-title">Banner</span>
                    </a>
                   
                </li>

               
                <li>
                    <a href="#">
                        <span class="uk-nav-icon"><i class="mdi mdi-book-open"></i>
                         </span><span class="uk-nav-title">Paket Tabungan</span>
                     </a>
                    
                     <ul class="sc-sidebar-menu-sub">
                        <li id="link.dashboard.paket-tabungan.haji.index" @if(url()->current() == route('dashboard.paket-tabungan.haji.index')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.paket-tabungan.haji.index')}}"  > Haji </a>
                        </li>				
                        <li id="link.dashboard.paket-tabungan.umrah.index" @if(url()->current() == route('dashboard.paket-tabungan.umrah.index')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.paket-tabungan.umrah.index')}}"  > Umrah</a>
                        </li>				
                       		
                        
                    </ul>
                    
                </li>
                <li>
                    <a href="#">
                       <span class="uk-nav-icon"><i class="mdi mdi-lightbulb"></i>
                        </span><span class="uk-nav-title">Inspirasi</span>
                    </a>
                    <ul class="sc-sidebar-menu-sub">
                        {{-- <li id="link.dashboard.inspirasi.bacaan.index" @if(url()->current() == route('dashboard.inspirasi.bacaan.index')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.inspirasi.bacaan.index')}}"  > Bacaan </a>
                        </li> --}}
                        <li id="link.dashboard.inspirasi.bacaan.index" @if(url()->current() == route('dashboard.inspirasi.bacaan.index')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.inspirasi.bacaan.index')}}" > Bacaan </a>
                        </li>		
                        {{-- <li id="link.dashboard.inspirasi.podcast.index" @if(url()->current() == route('dashboard.inspirasi.podcast.index')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.inspirasi.podcast.index')}}"  > Podcast</a>
                        </li>	 --}}
                        <li id="link.dashboard.inspirasi.podcast.index" @if(url()->current() == route('dashboard.inspirasi.podcast.index')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.inspirasi.podcast.index')}}" > Podcast </a>
                        </li>			
                       {{--  <li id="link.dashboard.inspirasi.video.index" @if(url()->current() == route('dashboard.inspirasi.video.index')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.inspirasi.video.index')}}"  > Video </a>
                        </li> --}}
                         <li id="link.dashboard.inspirasi.video.index" @if(url()->current() == route('dashboard.inspirasi.video.index')) class="sc-page-active" @endif>
                            <a href="{{route('dashboard.inspirasi.video.index')}}" > Video </a>
                        </li>				
                        
                    </ul>
                </li>
                <li>
                    <a href="{{route('dashboard.master.mitra-travel.index')}}" @if(url()->current() == route('dashboard.master.mitra-travel.index')) class="sc-page-active" @endif>
                       <span class="uk-nav-icon"><i class="mdi mdi-shield-airplane"></i>
                        </span><span class="uk-nav-title">Mitra Travel</span>
                    </a>
                   
                </li>
               {{--  <li>
                    <a href="#">
                       <span class="uk-nav-icon"><i class="mdi mdi-piggy-bank"></i>
                        </span><span class="uk-nav-title">Tabungan</span>
                    </a>
                    <ul class="sc-sidebar-menu-sub">
                        <li>
                            <a href="#"  > Haji </a>
                            <ul>
                                <li>
                                    <a href="#">Paket</a>
                                </li>
                            </ul>
                        </li>				
                        <li >
                            <a href="#"  > Umrah </a>
                            <ul>
                                <li>
                                    <a href="#">Paket</a>
                                </li>
                            </ul>
                        </li>				
                        			
                        
                    </ul>
                </li> --}}
	        </ul>
	    </div>
    </div>
	<div class="sc-sidebar-info">
        version: 2.1.0
	</div>
</aside>