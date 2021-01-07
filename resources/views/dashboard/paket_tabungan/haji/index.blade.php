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
            <h3 class="uk-card-title">&nbsp;&nbsp;&nbsp;List Paket Tabungan Haji</h3>
        </div>
        <div class="uk-width-auto@s">
            <div id="sc-dt-buttons">
                <div class="dt-buttons">
                    <a class="dt-button buttons-copy buttons-html5 sc-button" href="{{route('dashboard.paket-tabungan.haji.create')}}" ><span data-uk-icon="icon: plus"></span> <span>Add Paket Tabungan Haji</span></a>
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
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Setoran Awal (Rp)</th>
                    <th>Nominal Tabungan (Rp)</th>
                    <th>Detail Biaya</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
               
                
            </tbody>                
        </table>
        <div id="modal-detail-biaya" data-uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">Detail Biaya</h2>
                </div>
                <div class="uk-modal-body detail-paket-tabungan-umrah">
                    <table id="detail-detail-biaya-table" class="uk-table uk-table-striped dt-responsive">
                        <thead>
                            <tr>
                                
                               
                                <th>Deskripsi</th>
                                <th>Ikon</th>
                                <th>Nominal</th>
                              
                                
                            </tr>
                        </thead>
                        <tbody id="detail-detail-biaya-table-tbody">
                            
                                       
                        </tbody>                
                    </table>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    
                    <a href="#" class="sc-button sc-button-secondary uk-modal-close" >Close</a>
                </div>
            </div>
        </div>
        <div id="modal-detail" data-uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">Detail Paket Tabungan Haji</h2>
                </div>
                <div class="uk-modal-body detail-paket-tabungan-haji">
                    <table id="detail-paket-tabungan-haji-table" class="uk-table uk-table-striped dt-responsive">
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
                                <td>Deskripsi</td>
                                <td class="deskripsi">
                                    
                                        <p id="textarea-deskripsi">
                                        </p>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>Biaya Administrasi (Rp)</td>
                                <td class="biaya_administrasi"></td>
                            </tr>
                            <tr>
                                <td>Nominal Tabungan (Rp)</td>
                                <td class="nominal_tabungan"></td>
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
                    <h2 class="uk-modal-title">Confirm Delete Paket Tabungan Haji</h2>
                </div>
                <div class="uk-modal-body delete-paket-tabungan-haji">
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
        var url = "{{route('dashboard.paket-tabungan.haji.datatable')}}";
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
        let linkDetail = "{{route('dashboard.paket-tabungan.haji.detail-json', ':id')}}";
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
    function modalDetailDetailBiaya(id){
        let linkDetail = "{{route('dashboard.paket-tabungan.haji.detail-json', ':id')}}";
            linkDetail = linkDetail.replace(':id', id);
            axios.get(linkDetail, {
               
            })
            .then(function (response) {
                //console.log(response.data.data);
                viewDetailDetailBiaya(response.data.data);
            })
            .catch(function (error) {
                console.log(error);
            });
    }
    function viewDetailDetailBiaya(data) {
        if(data){
            let detailDetailBiaya ='';
            for (var key in data.detail_biaya) {
                let nominal = data.detail_biaya[key].nominal ? data.detail_biaya[key].nominal : 0;
                detailDetailBiaya += '<tr>'+
                                        '<td>'+data.detail_biaya[key].deskripsi+'</td>'+
                                        '<td>'+'<img src="'+data.detail_biaya[key].icon.full_path+'" width="100" height="100">'+'</td>'+
                                        '<td> Rp '+nominal +', -</td>'+
                                      '</tr>'

            }
            

            document.getElementById('detail-detail-biaya-table-tbody').innerHTML  = detailDetailBiaya ;
            
           
            
        } 
    }

    function viewDetail(data) {
        if(data){
            document.querySelector('#modal-detail .nama').innerHTML             = data.nama ? data.nama   : '';
            
            let konten = data.deskripsi ? data.deskripsi   : '';
            document.querySelector('#textarea-deskripsi').innerHTML               = data.deskripsi ? data.deskripsi   : '';
            document.querySelector('#modal-detail .nominal_tabungan').innerHTML   = data.nominal_tabungan ? data.nominal_tabungan   : ''; 
            document.querySelector('#modal-detail .biaya_administrasi').innerHTML = data.biaya_administrasi ? data.biaya_administrasi  : ''; 
             
            document.querySelector('#modal-detail .tanggal_input').innerHTML      = data.tanggal_input ? data.tanggal_input   : '';
            
        } 
    }

    function modalDelete(id){
        let linkDelete = "{{route('dashboard.paket-tabungan.haji.destroy', ':id')}}";
            linkDelete = linkDelete.replace(':id', id);
        document.getElementById('delete-form').action = linkDelete;
        let csrfToken= document.querySelector("meta[name='csrf-token']").getAttribute("content");
        document.getElementById('input-hidden-csrf-token').value=csrfToken;
    }



    function datatable(){
        var url = "{{route('dashboard.paket-tabungan.haji.datatable')}}";
        var table = $('.datatable').DataTable({
            // ordering: false,
            "columnDefs": [
                            { "orderable": false, "targets": 5 },
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
                        data: 'nama',
                    },
                    { 
                        data: 'deskripsi',
                    },
                    { 
                        data: 'biaya_administrasi',
                       
                    },
                    { 
                        data: 'nominal_tabungan',
                        
                    },
                    { 
                        data: null,
                        searchable: true,
                        render: function(data){
                            let btnDetailBiaya = '<div><a class="sc-button sc-button-info sc-js-button-wave-light" onclick="modalDetailDetailBiaya('+data.id+')" href="#modal-detail-biaya" data-uk-toggle><span data-uk-icon="icon: strikethrough"></span></a></div>'
                            return btnDetailBiaya;
                        }
                    },
                   
                  
                    
                    {
                        data: null,
                        searchable: false,
                        render: function(data){
                            let linkEdit = "{{route('dashboard.paket-tabungan.haji.edit', ':id')}}";
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