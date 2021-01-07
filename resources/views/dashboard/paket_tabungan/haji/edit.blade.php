@extends('layouts.dashboard_modul')
@section('content')
<div class="uk-flex-center" data-uk-grid>
    <div class="uk-width-3-4@l">
        <div class="uk-card">
            <div class="uk-card-header sc-padding">
                <div class="uk-flex uk-flex-middle">
                    <div>
                        <span data-uk-icon="icon:home;ratio:1.4" class="uk-margin-medium-right"></span>
                    </div>
                    <h3 class="uk-card-title">
                       Edit Paket Tabungan Haji
                    </h3>
                    <div class="uk-width-auto@s" >
                        <div id="sc-dt-buttons">
                            <div class="dt-buttons">
                                {{-- <a class="dt-button buttons-copy buttons-html5 sc-button" href="{{route('dashboard.paket-tabungan.haji.index')}}" ><span data-uk-icon="icon: menu"></span> <span>List Kategori</span></a> --}}
                                
                                
                            </div>
                        </div>
                    </div>
                    <div style="position: absolute; right: 1.5em;">
                        <a class="sc-button sc-button-light sc-js-button-wave-light" @click="delete('+data.id+')" onclick="modalDelete({{$data->id}})" href="#confirm-delete" data-uk-toggle><span></span>Hapus</a>
                    </div>
                </div>
                <div id="confirm-delete" data-uk-modal>
                    <div class="uk-modal-dialog">
                        <div class="uk-modal-header">
                            <h2 class="uk-modal-title">Confirm Delete Paket Tabungan Haji</h2>
                        </div>
                        <div class="uk-modal-body delete-master-faq">
                         <p>Are you sure delete this data ?</p>
                         <form method="POST" id="delete-form" action="" accept-charset="UTF-8">
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="_token" type="hidden" id="input-hidden-csrf-token" value="">
                        </form>
                    </div>
                    <div class="uk-modal-footer uk-text-right">
                        <a class="sc-button sc-button-flat sc-button-flat-danger uk-modal-close" href="#" >No</a>
                        <a href="#" onclick="submitDelete()"  class="sc-button sc-button-secondary uk-modal-close" >Yes</a>
                    </div>
                    </div>
                </div>                
            </div>
            <div class="uk-card-body">
                    <form method="POST" id="form_advanced_validation" class="form-update-paket-tabungan-haji" action="{{route('dashboard.paket-tabungan.haji.update',['id'=>$data->id])}}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                
                    @include('dashboard.paket_tabungan.haji.form_edit')
                    <div id="vue_form_generator">
                        @foreach ($data->detail_biaya as $item)
                            <div class="uk-card-content form-detail-biaya" id="detail-biaya-last-element-{{$item->id}}">
                                <hr>
                                <div style="position:absolute;right:5%;"> <a class="sc-button sc-button-danger sc-js-button-wave-light detail-biaya-last-delete-form"  @click="deleteDetailBiayaLastForm({{$item->id}})"  dataid="{{$item->id}}" ><span data-uk-icon="icon: trash"></span> <span></span></a>
                                </div>        
                                        
                               
                                <div class="uk-margin">
                                    <label class="uk-form-label" for="f-empl-recent">Deskripsi</label>
                                    
                                </div>
                                <div class="uk-margin">
                                    <input   name="detail_biaya_last_id[]" value="{{$item->id}}" type="hidden" >
                                    <input class="uk-input"  name="detail_biaya_last_deskripsi[]" value="{{$item->deskripsi}}"  type="text" data-sc-input="outline" readonly>
                                </div>
                               
                                <div class="uk-margin">
                                    <label class="uk-form-label" for="f-h-subject">Icon Saat Ini <sup>*</sup></label>
                                    <div class="uk-form-controls">
                                        @if($item->icon)
                                            <img src="{{$item->icon->full_path}}"  >
                                        @endif
                                    </div>
                                    
                                </div>
                             
                                <hr>
                            </div>
                        @endforeach
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
@php
    $isDefault = "";
    if ($data->is_default==1 || $data->is_default=='1'){
        $isDefault= "true";
    }
    
    elseif ($data->is_default==0 || $data->is_default=='0'){
        $isDefault = "false";
    }
        
   
@endphp
@push('scripts')
<script src="{{url('/')}}/JS/ckeditor/ckeditor.js"></script>
<script src="{{url('/')}}/JS/summernote/summernote-lite.js"></script>
<script>
$(".alert-is-default").hide();
//CKEDITOR.replace( 'deskripsi' );
$(".alert-is-default").hide();



$("#status_aktif").netlivaSwitch({

'size':'mini',

'active-text':'Default',

'passive-text':'No Default',

'active-color':'#00FF00',

'passive-color':'#FF0000',

'width' :'120px'

});
let isDefault = {{$isDefault}};
console.log(isDefault);
$("#is_default").netlivaSwitch(isDefault);
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
                deleteDetailBiayaLastForm:function(id){
                    $('#detail-biaya-last-element-'+id).remove();
                },

                
            },
            computed:{
               
            },
            mounted() {
               
            
            },
        });
    function modalDelete(id){
        let linkDelete = "{{route('dashboard.paket-tabungan.haji.destroy', ':id')}}";
            linkDelete = linkDelete.replace(':id', id);
        document.getElementById('delete-form').action = linkDelete;
        let csrfToken= document.querySelector("meta[name='csrf-token']").getAttribute("content");
        document.getElementById('input-hidden-csrf-token').value=csrfToken;
    }
     function submitDelete(){
        document.getElementById("delete-form").submit();
        document.getElementById('delete-form').action = null;
        document.getElementById('input-hidden-csrf-token').value=null;

        let arrParse= [];
        datatableWithParse(arrParse);
        alertSuccess('Sukses menghapus data');
    }
</script>
@endpush
@endsection