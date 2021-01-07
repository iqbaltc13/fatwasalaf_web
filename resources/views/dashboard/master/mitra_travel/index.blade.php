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
            <h3 class="uk-card-title">&nbsp;&nbsp;&nbsp;List Master Mitra Travel</h3>
        </div>
        <div class="uk-width-auto@s">
            <div id="sc-dt-buttons">
                <div class="dt-buttons">
                    <a class="dt-button buttons-copy buttons-html5 sc-button" href="{{route('dashboard.master.mitra-travel.create')}}" ><span data-uk-icon="icon: plus"></span> <span>Add Mitra Travel</span></a>
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
                    <th>Logo</th>
                    <th>Nama</th>
                    <th>Titik Keberangakatan</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
               
                
            </tbody>                
        </table>
        <div id="modal-gambar-logo" data-uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">Detail Gambar Logo</h2>
                </div>
                <div class="uk-modal-body detail-master-mitra-travel">
                        <div id="detail-logo">

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
                <div class="uk-modal-body detail-master-mitra-travel">
                    <table id="detail-master-mitra-travel-table" class="uk-table uk-table-striped dt-responsive">
                        <tbody>
                            {{-- 
                            <tr>
                                <td></td>
                                <td></td>
                            </tr> 
                            --}}
                          
                            <tr>
                                <td>Nama</td>
                                <td class="nama"></td>
                            </tr>
                            <tr>
                                <td>Nama Direktur</td>
                                <td class="nama_direktur"></td>
                            </tr>
                            <tr>
                                <td>Lokasi Kantor</td>
                                <td class="lokasi_kantor"></td>
                            </tr>
                            <tr>
                                <td>Titik Keberangkatan</td>
                                <td class="titik_keberangkatan"></td>
                            </tr>
                            <tr>
                                <td>Telepon</td>
                                <td class="telepon"></td>
                            </tr>
                            <tr>
                                <td>Website</td>
                                <td class="website"></td>
                            </tr>
                            <tr>
                                <td>Social Media</td>
                                <td class="social_media"></td>
                            </tr>
                            <tr>
                                <td>Tahun Berdiri</td>
                                <td class="tahun_berdiri"></td>
                            </tr>
                            <tr>
                                <td>No Izin Kemenag</td>
                                <td class="no_izin_kemenag"></td>
                            </tr>
                            <tr>
                                <td>Nomor Urut</td>
                                <td class="order"></td>
                            </tr>
                            
                         
                            <tr>
                                <td>Deskripsi</td>
                                <td class="deskripsi">
                                    
                                        <p id="textarea-deskripsi">
                                        </p>
                                    
                                </td>
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
                <div class="uk-modal-body delete-master-mitra-travel">
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
        var url = "{{route('dashboard.master.mitra-travel.datatable')}}";
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
        let linkDetail = "{{route('dashboard.master.mitra-travel.detail-json', ':id')}}";
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
    function modalGambarLogo(id){
        let linkDetail = "{{route('dashboard.master.mitra-travel.detail-json', ':id')}}";
            linkDetail = linkDetail.replace(':id', id);
            axios.get(linkDetail, {
               
            })
            .then(function (response) {
                if(response.data.data){
          
                    document.getElementById('detail-logo').innerHTML  = response.data.data.logo?  '<img src="'+response.data.data.logo.full_path+'"  >'  : '';
                   
                }
                
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    function viewDetail(data) {
        if(data){
          
            document.querySelector('#modal-detail .nama').innerHTML                 = data.nama ? data.nama   : '';
            document.querySelector('#modal-detail .nama_direktur').innerHTML        = data.nama_direktur ? data.nama_direktur   : '';
            document.querySelector('#modal-detail .lokasi_kantor').innerHTML        = data.lokasi_kantor ? data.lokasi_kantor   : '';
            document.querySelector('#modal-detail .titik_keberangkatan').innerHTML  = data.titik_keberangkatan ? data.titik_keberangkatan   : '';
            document.querySelector('#modal-detail .telepon').innerHTML              = data.telepon ? data.telepon   : '';
            document.querySelector('#modal-detail .website').innerHTML              = data.website ? data.website   : '';
            document.querySelector('#modal-detail .social_media').innerHTML         = data.social_media ? data.social_media   : '';
            document.querySelector('#modal-detail .tahun_berdiri').innerHTML         = data.tahun_berdiri ? data.tahun_berdiri   : '';
            document.querySelector('#modal-detail .no_izin_kemenag').innerHTML     = data.no_izin_kemenag ? data.no_izin_kemenag   : '';
            let deskripsi = data.deskripsi ? data.deskripsi   : '';
            document.querySelector('#textarea-deskripsi').innerHTML                 = deskripsi;
           
            document.querySelector('#modal-detail .order').innerHTML                = data.order ? data.order   : ''; 
            document.querySelector('#modal-detail .status_aktif').innerHTML         = data.is_active == 1 || data.is_active == '1' ? 'Aktif'   : 'Nonaktif'; 
            document.querySelector('#modal-detail .tanggal_input').innerHTML        = data.tanggal_input ? data.tanggal_input   : '';
            
        } 
    }

    function modalDelete(id){
        let linkDelete = "{{route('dashboard.master.mitra-travel.destroy', ':id')}}";
            linkDelete = linkDelete.replace(':id', id);
        document.getElementById('delete-form').action = linkDelete;
        let csrfToken= document.querySelector("meta[name='csrf-token']").getAttribute("content");
        document.getElementById('input-hidden-csrf-token').value=csrfToken;
    }

    function datatable(){
        var url = "{{route('dashboard.master.mitra-travel.datatable')}}";
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
                            let btnGambar = '<div><a class="sc-button sc-button-info sc-js-button-wave-light" onclick="modalGambarLogo('+data.id+')" href="#modal-gambar-logo" data-uk-toggle><span uk-icon="icon: image; ratio: 2"></span></a></div>'
                            return btnGambar;
                        }
                    },
                    { 
                        data: 'nama',
                    },
                    
                    { 
                        data: 'titik_keberangkatan',
                        
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
                            let linkEdit = "{{route('dashboard.master.mitra-travel.edit', ':id')}}";
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