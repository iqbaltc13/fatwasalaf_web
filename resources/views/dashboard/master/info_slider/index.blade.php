@extends('layouts.dashboard_modul')
@section('content')
<div class="uk-card uk-margin" id="vue_component">
    <div class="uk-card-body">
        <div class="uk-child-width-1-3@m" >
            
        
           
             
           
        </div>
    </div>
</div>
<div class="uk-card uk-margin" >
    <div class="uk-flex-middle sc-padding sc-padding-medium-ends uk-grid-small" data-uk-grid>
        <div class="uk-flex-1 uk-first-column">
            <h3 class="uk-card-title">&nbsp;&nbsp;&nbsp;List Banner</h3>
        </div>
        <div class="uk-width-auto@s">
            <div id="sc-dt-buttons">
                <div class="dt-buttons">
                    <a class="dt-button buttons-copy buttons-html5 sc-button" href="{{route('dashboard.master.info-slider.create')}}" ><span data-uk-icon="icon: plus"></span> <span>Add Banner</span></a>
                    <button class="dt-button buttons-csv buttons-html5 sc-button" tabindex="0" aria-controls="sc-dt-buttons-table" type="button"><span>CSV </span></button>
                    <button class="dt-button buttons-excel buttons-html5 sc-button" tabindex="0" aria-controls="sc-dt-buttons-table" type="button"><span>Excel </span></button>
                  
                </div>
            </div>
        </div>
        <div class="uk-width-auto@s">
            <div id="sc-dt-buttons"></div>
        </div>
    </div>
    <div id="alert-elements" >
        @if(Session::get('success'))
         
        <div class="uk-alert-success" data-uk-alert>
            <a class="uk-alert-close" data-uk-close></a>
              {{Session::get('success')}}
        </div>
          

        @endif
    </div>
    <hr class="uk-margin-remove">
    <div class="uk-card-body">
        <table id="sc-dt-buttons-table" class="uk-table uk-table-striped dt-responsive datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Posisi</th>
                    <th>Nomor Urut</th>
                    <th>Status Aktif</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
               
                
            </tbody>                
        </table>
        <div id="modal-gambar-banner" data-uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">Detail Gambar Banner</h2>
                </div>
                <div class="uk-modal-body detail-master-info-slider">
                        <div id="detail-gambar-banner">

                        </div>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    
                    <a href="#" class="sc-button sc-button-secondary uk-modal-close" >Close</a>
                </div>
            </div>
        </div>
        <div id="modal-detail" data-uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">Detail Banner</h2>
                </div>
                <div class="uk-modal-body detail-master-info-slider">
                    <table id="detail-master-info-slider-table" class="uk-table uk-table-striped dt-responsive">
                        <tbody>
                            {{-- 
                            <tr>
                                <td></td>
                                <td></td>
                            </tr> 
                            --}}
                          
                            <tr>
                                <td>Judul</td>
                                <td class="title"></td>
                            </tr>
                            <tr>
                                <td>Konten</td>
                                <td class="html">
                                    
                                        <p id="textarea-html">
                                        </p>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>Posisi</td>
                                <td class="position"></td>
                            </tr>
                            <tr>
                                <td>Nomor Urut</td>
                                <td class="order"></td>
                            </tr>
                         
                            <tr>
                                <td>Status Aktif</td>
                                <td class="status_aktif"></td>
                            </tr>
                            
                            <tr>
                                <td>Tanggal Input</td>
                                <td class="tanggal_input"></td>
                            </tr>  
                                       
                        </tbody>                
                    </table>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    
                    <a href="#" class="sc-button sc-button-secondary uk-modal-close" >Close</a>
                </div>
            </div>
        </div>
        <div id="confirm-delete" data-uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">Confirm Delete Banner</h2>
                </div>
                <div class="uk-modal-body delete-master-info-slider">
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
</div>
@push('scripts')

<script src="{{url('/')}}/JS/ckeditor/ckeditor.js"></script>
<script src="{{url('/')}}/JS/summernote/summernote-lite.js"></script>

<script>
    let refresh = setInterval(function () { 
        
            
        let arrParse = []; 
        
        datatableWithParse(arrParse);
        
        alertSuccess('Sukses memuat data');
    }, 60000);

   
    function submitDelete(){
        document.getElementById("delete-form").submit();
        document.getElementById('delete-form').action = null;
        document.getElementById('input-hidden-csrf-token').value=null;

        let arrParse= [];
        datatableWithParse(arrParse);
        alertSuccess('Sukses menghapus data');
    }

    function datatableWithParse(arrParse){
        var url = "{{route('dashboard.master.info-slider.datatable')}}";
        url = url + '?';

       

        for (var key in arrParse) {
            if (arrParse.hasOwnProperty(key)){
                url=url+key+'='+arrParse[key]+'&&';
                
            }
               
        }
        //$('.datatable tbody').empty();
       
        let table =$('.datatable').DataTable().ajax.url(url).load();

        return table;
        
    }
    function alertSuccess(message) {
        
        let alert = '<div class="uk-alert-success uk-alert" data-uk-alert="">'+
                        '<a class="uk-alert-close uk-icon uk-close" data-uk-close="">'+
                            '<svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" data-svg="close-icon">'+
                                '<line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"></line>'+
                                '<line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"></line>'+
                            '</svg>'+
                        '</a>'+message+					
                    '</div>';
                    
        document.querySelector('#alert-elements').innerHTML=alert;
        //$('#alert-elements').append(alert);
    }
    function modalDetail(id){
        let linkDetail = "{{route('dashboard.master.info-slider.detail-json', ':id')}}";
            linkDetail = linkDetail.replace(':id', id);
            axios.get(linkDetail, {
               
            })
            .then(function (response) {
                //console.log(response.data.data);
                viewDetail(response.data.data);
            })
            .catch(function (error) {
                console.log(error);
            });
    }
    function modalGambarBanner(id){
        let linkDetail = "{{route('dashboard.master.info-slider.detail-json', ':id')}}";
            linkDetail = linkDetail.replace(':id', id);
            axios.get(linkDetail, {
               
            })
            .then(function (response) {
                if(response.data.data){
          
                    document.getElementById('detail-gambar-banner').innerHTML  = response.data.data.image_slide ?  '<img src="'+response.data.data.image_slide.full_path+'"  >'  : '';
                   
                }
                
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    function viewDetail(data) {
        if(data){
          
            document.querySelector('#modal-detail .title').innerHTML           = data.title ? data.title   : '';
            let konten = data.html ? data.html   : '';
            document.querySelector('#textarea-html').innerHTML                 = konten;
            document.querySelector('#modal-detail .position').innerHTML        = data.position ? data.position   : '';
            document.querySelector('#modal-detail .order').innerHTML           = data.order ? data.order   : ''; 
            document.querySelector('#modal-detail .status_aktif').innerHTML    = data.is_active == 1 || data.is_active == '1' ? 'Aktif'   : 'Nonaktif'; 
            document.querySelector('#modal-detail .tanggal_input').innerHTML   = data.tanggal_input ? data.tanggal_input   : '';
            
        } 
    }

    function modalDelete(id){
        let linkDelete = "{{route('dashboard.master.info-slider.destroy', ':id')}}";
            linkDelete = linkDelete.replace(':id', id);
        document.getElementById('delete-form').action = linkDelete;
        let csrfToken= document.querySelector("meta[name='csrf-token']").getAttribute("content");
        document.getElementById('input-hidden-csrf-token').value=csrfToken;
    }

    function datatable(){
        var url = "{{route('dashboard.master.info-slider.datatable')}}";
        var table = $('.datatable').DataTable({
            // ordering: false,
            "columnDefs": [
                            { "orderable": false, "targets": 1 },
                            { "orderable": false, "targets": 6 },
                            
                            {
                                    "targets": '_all',        
                            },
                        ],
            "order": [[ 0, "desc" ]],
            "processing": true,
            "ajax": url,
            "columns": [
                    { 
                        data: 'id',
                    },
                    { 
                        data: null,
                        searchable: true,
                        render: function(data){
                            let btnGambar = '<div><a class="sc-button sc-button-info sc-js-button-wave-light" onclick="modalGambarBanner('+data.id+')" href="#modal-gambar-banner" data-uk-toggle><span uk-icon="icon: image; ratio: 2"></span></a></div>'
                            return btnGambar;
                        }
                    },
                    { 
                        data: 'title',
                    },
                    
                    { 
                        data: 'position',
                        
                    },
                    { 
                        data: 'order',
                        
                    },
                    { 
                        data: null,
                        searchable: true,
                        render: function(data){
                            let isActive = '';
                            if(data.is_active==1 || data.is_active=='1'){
                                isActive += 'Aktif';
                            }
                            else if(data.is_active==0 || data.is_active=='0'){
                                isActive += 'NonAktif';
                            }
                            return isActive;
                        }
                    },
                    
                    {
                        data: null,
                        searchable: false,
                        render: function(data){
                            let linkEdit = "{{route('dashboard.master.info-slider.edit', ':id')}}";
                                linkEdit = linkEdit.replace(':id', data.id);
                            let aksi='';
                            aksi +=    '<div><a class="sc-button sc-button-success sc-js-button-wave-light" onclick="modalDetail('+data.id+')" href="#modal-detail" data-uk-toggle><span data-uk-icon="icon: file-text"></span>Detail</a></div>'+
                                       '<div><a class="sc-button sc-button-primary sc-js-button-wave-light" href="'+linkEdit+'"><span data-uk-icon="icon: pencil"></span></span> Edit</a></div>';
                            return aksi;
                        }
                    },
                ]
        });

        return table;
    }
</script>

<script>
    new Vue({
            el: '#vue_component',
            data:{
               
            },
            watch:{
               
            },
            methods:{
                detail:function(id){
                      console.log('detail data'+ id);
                },
                delete:function(){
                    document.getElementById("delete-form").submit();
                    document.getElementById('delete-form').action = null;
                    document.getElementById('input-hidden-csrf-token').value=null;
                },

                
            },
            computed:{
               
            },
            mounted() {
                datatable(); 
            
            },
        });

</script>

@endpush
@endsection