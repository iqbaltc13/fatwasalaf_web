@extends('layouts.dashboard_modul')
@section('content')
<div class="uk-flex-center" data-uk-grid>
    <div class="uk-width-4-4@l">
        <div class="uk-card">
            <div class="uk-card-header sc-padding">
                <h2 class="uk-card-title">
                    Tambah Master Faq
                </h2>
               
                <div class="uk-width-auto@s" >
                    <div id="sc-dt-buttons">
                        <div class="dt-buttons">
                            {{-- <a class="dt-button buttons-copy buttons-html5 sc-button" href="{{route('dashboard.master.faq.index')}}" ><span data-uk-icon="icon: menu"></span> <span>List Kategori</span></a> --}}
                            
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-card-body">
                <div id="alert-elements" >
                    @if(Session::get('success'))
                     
                    <div class="uk-alert-success" data-uk-alert>
                        <a class="uk-alert-close" data-uk-close></a>
                          {{Session::get('success')}}
                    </div>
                      
            
                    @endif
                    @if(Session::get('error'))
                     
                    <div class="uk-alert-danger" data-uk-alert>
                        <a class="uk-alert-close" data-uk-close></a>
                          {{Session::get('error')}}
                    </div>
                      
            
                    @endif
                </div>
                <form method="POST" id="form_advanced_validation" class="form-create-master-faq" action="{{route('dashboard.master.faq.store')}}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                
                    @include('dashboard.master.faq.form_create')
                    <div class="uk-margin-top">
                        <button type="submit" class="sc-button sc-button-primary sc-button-large">Submit </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')


<script src="{{url('/')}}/JS/ckeditor/ckeditor.js"></script>
<script src="{{url('/')}}/JS/summernote/summernote-lite.js"></script>
<script>
flatpickr(".flatpickr-input");
CKEDITOR.replace( 'konten' );
</script>
@endpush
@endsection