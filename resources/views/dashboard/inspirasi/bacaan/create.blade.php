@extends('layouts.dashboard_modul')
@section('content')
<div class="uk-flex-center" data-uk-grid>
    <div class="uk-width-4-4@l">
        <div class="uk-card">
            <div class="uk-card-header sc-padding">
                <h2 class="uk-card-title">
                    Tambah Inspirasi Bacaan
                </h2>
               
                <div class="uk-width-auto@s" >
                    <div id="sc-dt-buttons">
                        <div class="dt-buttons">
                            {{-- <a class="dt-button buttons-copy buttons-html5 sc-button" href="{{route('dashboard.inspirasi.bacaan.index')}}" ><span data-uk-icon="icon: menu"></span> <span>List Kategori</span></a> --}}
                            
                            
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
                <form method="POST" id="form_advanced_validation" class="form-create-inspirasi-bacaan" action="{{route('dashboard.inspirasi.bacaan.store')}}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                
                    @include('dashboard.inspirasi.bacaan.form_create')
                    <div class="uk-margin-top">
                        <button type="submit" class="sc-button sc-button-primary sc-button-large">Submit </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')



<script src="{{url('/')}}/JS/summernote/summernote-lite.js"></script>

<script src="{{url('/')}}/JS/ckeditor/ckeditor.js"></script>
<script>

CKEDITOR.replace( 'html' );
// $('#html').summernote({
//         tabsize: 4,
//         tooltip: true,
//         lang: 'pt-BR',
//         dialogsFade: true,
//         toolbar: [
//             ['style', ['bold', 'italic', 'underline', 'clear']],
//             ['color', ['color']],
//             ['list', ['ul', 'ol']],
//             ['para', ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull']],
//             ['insert', ['link', 'picture']]
//         ]
//     });
$(".alert-status-aktif").hide();
$("#status_aktif").netlivaSwitch({

    'size':'mini',

    'active-text':'Aktif',

    'passive-text':'Nonaktif',

    'active-color':'#00FF00',

    'passive-color':'#FF0000',

    'width' :'120px'

});

$("#status_aktif").netlivaSwitch('state');
$("#status_aktif").on('netlivaSwitch.change', function(event, state, element) {



    if(state==true){
    $("#alert-active").show();
    $("#alert-inactive").hide();
    $('input[name="is_active"]').val(1)
    }
    if(state==false){
    $("#alert-active").hide();
    $("#alert-inactive").show();
    $('input[name="is_active"]').val(0)
    }
});

</script>
@endpush
@endsection