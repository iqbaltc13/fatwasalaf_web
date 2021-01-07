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
                       Edit Master Syarat & Ketentuan
                    </h3>
                    <div class="uk-width-auto@s" >
                        <div id="sc-dt-buttons">
                            <div class="dt-buttons">
                                {{-- <a class="dt-button buttons-copy buttons-html5 sc-button" href="{{route('dashboard.master.syarat-ketentuan.index')}}" ><span data-uk-icon="icon: menu"></span> <span>List Kategori</span></a> --}}
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
                            <h2 class="uk-modal-title">Confirm Delete Master Syarat & Ketentuan</h2>
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
                    <form method="POST" id="form_advanced_validation" class="form-update-syarat-ketentuan" action="{{route('dashboard.master.syarat-ketentuan.update',['id'=>$data->id])}}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                
                    @include('dashboard.master.syarat_ketentuan.form_edit')
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
CKEDITOR.replace( 'html_konten' );

 function modalDelete(id){
        let linkDelete = "{{route('dashboard.master.syarat-ketentuan.destroy', ':id')}}";
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