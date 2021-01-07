@extends('layouts.dashboard_modul')
@section('content')
<div class="uk-flex-center" data-uk-grid>
    <div class="uk-width-4-4@l">
        <div class="uk-card">
            <div class="uk-card-header sc-padding">
                <h2 class="uk-card-title">
                    Tambah Paket Tabungan Haji
                </h2>
               
                <div class="uk-width-auto@s" >
                    <div id="sc-dt-buttons">
                        <div class="dt-buttons">
                            {{-- <a class="dt-button buttons-copy buttons-html5 sc-button" href="{{route('dashboard.paket-tabungan.haji.index')}}" ><span data-uk-icon="icon: menu"></span> <span>List Kategori</span></a> --}}
                            
                            
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
                <form method="POST" id="form_advanced_validation" class="form-create-paket-tabungan-haji" action="{{route('dashboard.paket-tabungan.haji.store')}}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                
                    @include('dashboard.paket_tabungan.haji.form_create')
                    <div id="vue_form_generator">
                        <div id="form_details">
                            
                        </div>
                        <a class="dt-button buttons-copy buttons-html5 sc-button" @click="addDetailBiayaForm" href="javascript:void(0)" ><span data-uk-icon="icon: plus"></span> <span>Add Detail Biaya</span></a>
                    </div>
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

//$('#deskripsi').summernote();
$('.textarea-biaya-deskripsi').summernote();

$(".alert-is-default").hide();


   
$("#status_aktif").netlivaSwitch({

    'size':'mini',

    'active-text':'Default',

    'passive-text':'No Default',

    'active-color':'#00FF00',

    'passive-color':'#FF0000',

    'width' :'120px'

});

$("#is_default").netlivaSwitch('state');
$("#is_default").on('netlivaSwitch.change', function(event, state, element) {



    if(state==true){
    $("#alert-active").show();
    $("#alert-inactive").hide();
    $('input[name="is_default"]').val(1)
    }
    if(state==false){
    $("#alert-active").hide();
    $("#alert-inactive").show();
    $('input[name="is_default"]').val(0)
    }
});
$(document).delegate( ".detail-biaya-delete-form", "click", function() {
        let formId = $(this).attr("dataid");
        $('#detail-biaya-element-'+formId).remove();
});

</script>

<script>
    new Vue({
            el: '#vue_form_generator',
            data:{
               countFrom : 0,
               detailBiayaElementOpen           : ' <div class="uk-card-content form-detail-biaya"',
               detailBiayaTombolDeleteOpen      : ' <hr><div style="position:absolute;right:5%;"><a class="sc-button sc-button-danger sc-js-button-wave-light detail-biaya-delete-form" href="javascript:void(0)" ',
               detailBiayaTombolDeleteClose     : ' ><span data-uk-icon="icon: trash"></span> <span></span></a></div>',
               detailBiayaElementOpenEndTag     : ' >',
             
               detailBiayaElementIsi            :   '<div class="uk-margin">'+
                                                        '<label class="uk-form-label" for="f-empl-recent">Deskripsi</label>'+
                                                        
                                                    '</div>'+
                                                    '<div class="uk-margin">'+
                                                        '<input class="uk-input"  name="detail_biaya_deskripsi[]" type="text" data-sc-input="outline" required>'+
                                                    '</div>'+

                                                    '<div class="uk-margin">'+
                                                        '<label class="uk-form-label" for="f-h-subject">Icon Detail Biaya <sup>*</sup></label>'+
                                                        
                                                    '</div>'+
                                                    '<div class="uk-margin-medium-top sc-padding-small">'+
                                                    
                                                        '<div class="uk-form-controls">'+
                                                            '<div class="js-upload" uk-form-custom>'+
                                                                '<input type="file" name="detail_biaya_icon[]" required>'+
                                                                '<button class="uk-button uk-button-default" type="button" tabindex="-1">Pilih</button>'+
                                                            '</div>'+
                                                        '</div>'+
                                                    
                                                    '</div> <hr>',
               detailBiayaElementClose          : '</div> ',
            },
            watch:{
               
            },
            methods:{
                addDetailBiayaForm:function(){
                      this.countFrom++;
                      let numberForm = this.countFrom;
                      let detailBiayaElement = this.detailBiayaElementOpen + 'id="detail-biaya-element-'+numberForm+'"'+
                                               this.detailBiayaElementOpenEndTag+ this.detailBiayaTombolDeleteOpen + ' dataid="'+numberForm+'"'+  
                                               this.detailBiayaTombolDeleteClose + this.detailBiayaElementIsi + this.detailBiayaElementClose;

                     $("#form_details").append(detailBiayaElement);
                     CKEDITOR.replaceAll( '.textarea-biaya-deskripsi' );
                     
                },

                
            },
            computed:{
               
            },
            mounted() {
               
              
            },
        });

</script>
@endpush
@endsection