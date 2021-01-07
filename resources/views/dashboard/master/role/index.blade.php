@extends('layouts.dashboard_modul')
@section('content')
<div class="uk-card uk-margin" id="vue_component">
    
    <div class="uk-flex-middle sc-padding sc-padding-medium-ends uk-grid-small" data-uk-grid>
        <div class="uk-flex-1 uk-first-column">
            <h3 class="uk-card-title">&nbsp;&nbsp;&nbsp;List Role </h3>
        </div>
        <div class="uk-width-auto@s">
            <div id="sc-dt-buttons">
                <div class="dt-buttons">
                    {{-- <select name="select-toko" id="pilih-toko" class="uk-select" style="padding-right:5px;" aria-controls="sc-dt-buttons-table" v-on:change="selectedToko($event)">
                        <option value="">Semua Toko</option>
                        @foreach ($arrDataTokos as $item)
                            <option value="{{$item->id}}">{{$item->nama}}</option> 
                        @endforeach
                    </select> --}}
                    &nbsp;&nbsp;&nbsp;
                    <a class="dt-button buttons-copy buttons-html5 sc-button" href="{{route('dashboard.master.role.create')}}" ><span data-uk-icon="icon: plus"></span> <span>Add Role</span></a>
                 
                </div>
                
            </div>
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
      
        <table width="100%" id="sc-dt-buttons-table" class="uk-table uk-table-striped dt-responsive datatable">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Display Name</th>
                    <th>Description</th>
                    <th>Built In</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
               
                
            </tbody>                
        </table>
        <div id="upload-form" data-uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">Upload Gambar</h2>
                </div>
                <div class="uk-modal-body upload-product-image">
                   <p>Upload Gambar Banner</p>
                   <input type="hidden" name="gambar-banner" id="product-id">
                   <input type="file" name="gambar-banner" id="product-image" @change=imageUpload()>
                   <input name="_token" type="hidden" id="upload-hidden-csrf-token" value="">
                   {{-- <form method="POST" id="upload-form" action="" accept-charset="UTF-8">
                        
                        <input name="_token" type="hidden" id="input-hidden-csrf-token" value="">
                   </form> --}}
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <a class="sc-button sc-button-flat sc-button-flat-danger uk-modal-close" href="#" >Close</a>
                </div>
            </div>
        </div>
        <div id="modal-detail" data-uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">Detail Role</h2>
                </div>
                <div class="uk-modal-body detail-user">
                    <table width="100%" id="detail-user-table" class="uk-table uk-table-striped dt-responsive">
                        <tbody>
                            {{-- 
                            <tr>
                                <td></td>
                                <td></td>
                            </tr> 
                            --}}
                            <tr>
                                <td>ID</td>
                                <td class="id"></td>
                            </tr>
                            <tr>
                                <td>Name </td>
                                <td class="name"></td>
                            </tr> 
                            <tr>
                                <td>Display name</td>
                                <td class="display_name"></td>
                            </tr> 
                           
                            <tr>
                                <td>Description</td>
                                <td class="description"></td>
                            </tr> 
                           
                           
                            <tr>
                                <td>Input Date</td>
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
                    <h2 class="uk-modal-title">Confirm Delete Role</h2>
                </div>
                <div class="uk-modal-body delete-user">
                   <p>Are you sure delete this data ?</p>
                   <form method="POST" id="delete-form" action="" accept-charset="UTF-8">
                        <input id="delete-form-id" name="id" type="hidden" value="">
                        <input id="delete-form-route" name="route" type="hidden" value="">
                        <input id="delete-form-method" name="_method" type="hidden" value="DELETE">
                        <input id="delete-form-token" name="_token" type="hidden"  value="">
                   </form>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <a class="sc-button sc-button-flat sc-button-flat-danger uk-modal-close" href="#" >No</a>
                    <a href="#" class="sc-button sc-button-secondary uk-modal-close" @click="deleteSubmit()" >Yes</a>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')

<script>
    let refresh = setInterval(function () { 
        datatableReloadAll(); 
        alertSuccess('Sukses memuat data');
    }, 60000);
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
    $(document).delegate( ".upload-gambar", "click", function() {
        modalUpload($(this).attr("dataid"));
    });
    $(document).delegate( ".action-delete", "click", function() {
        let id=$(this).attr("dataid");
        document.getElementById('delete-form-id').value = id;
    });
    function defaultImageReplace(event){
        let defaultImage = "{{asset("images/product-not-found.png")}}";
        event.target.src = defaultImage;
    }
    $(document).delegate( ".detail-data", "click", function() {
           modalDetail($(this).attr("dataid"));
    });
    function modalDetail(id){
            let linkDetail = "{{route('dashboard.master.role.detail-json', ':id')}}";
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
   
    function datatableWithParse(arrParse,message){
        var url = "{{route('dashboard.master.role.datatable')}}";
        url = url + '?';
        for (var key in arrParse) {
            if (arrParse.hasOwnProperty(key)){
                url=url+key+'='+arrParse[key]+'&&';
                
            }
               
        }
        
        //$('.datatable tbody').empty();
       
        let table =$('.datatable').DataTable().ajax.url(url).load();
        

        let alert = '<div class="uk-alert-success uk-alert" data-uk-alert="">'+
                        '<a class="uk-alert-close uk-icon uk-close" data-uk-close="">'+
                            '<svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" data-svg="close-icon">'+
                                '<line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"></line>'+
                                '<line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"></line>'+
                            '</svg>'+
                        '</a>'+message+					
                    '</div>';

        document.querySelector('#alert-elements').innerHTML=alert;


        return table;
        
    }
    function viewDetail(data) {
        if(data){
            document.querySelector('#modal-detail .id').innerHTML            = data.id ? data.id   : '';
            document.querySelector('#modal-detail .description').innerHTML   = data.description ? data.description   : '';
            document.querySelector('#modal-detail .name').innerHTML          = data.name ? data.name   : '';
            document.querySelector('#modal-detail .display_name').innerHTML  = data.display_name ? data.display_name  : '';
           
           
            
            
        }
        
    }
    function datatableReloadAfterAction(message){
        
        let table =$('.datatable').DataTable().ajax.reload();
        let alert = '<div class="uk-alert-success uk-alert" data-uk-alert="">'+
                        '<a class="uk-alert-close uk-icon uk-close" data-uk-close="">'+
                            '<svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" data-svg="close-icon">'+
                                '<line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"></line>'+
                                '<line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"></line>'+
                            '</svg>'+
                        '</a>'+message+					
                    '</div>';

        document.querySelector('#alert-elements').innerHTML=alert;
       
        return table;
        
    }
    function datatableReloadAll(){
        var url = "{{route('dashboard.master.role.datatable')}}";
        let table =$('.datatable').DataTable().ajax.url(url).load();
       
        return table;
        
    }
    function datatable(){
        var url = "{{route('dashboard.master.role.datatable')}}";
        var table = $('.datatable').DataTable({
            "autoWidth": true,
            "scrollX"         :       true,
            "scrollCollapse"  :       true,
            // ordering: false,
            "columnDefs": [
                            
                            { "orderable": false, "targets": 5 },
                            
                            
                            
                            {
                                    "targets": '_all',
                                    "defaultContent": "---"
                            },
                        ],
            "order": [[ 0, "desc" ]],
           
            "processing": true,
            //"serverSide": true,
            "ordering": false,
            
            "ajax": url,
            "columns": [
                    { 
                        data: 'id',
                    },
                   
                    {
                        data: 'name',
                        

                    },
                    {
                        data: 'display_name',
                        

                    },
                    {
                        data: 'description',
                        

                    },
                    {
                        data: 'built_in',
                        

                    },
                   
                    { 
                        data: null,
                        searchable: false,
                        render: function(data){
                            let linkEdit = "{{route('dashboard.master.role.edit', ':id')}}";
                                linkEdit = linkEdit.replace(':id', data.id);
                            let aksi='';
                            aksi +=    '<div><a class="sc-button sc-button-success sc-js-button-wave-light detail-data" dataid="'+data.id+'" href="#modal-detail" data-uk-toggle><span data-uk-icon="icon: file-text"></span>Detail</a></div>'+
                                       '<div><a class="sc-button sc-button-primary sc-js-button-wave-light" href="'+linkEdit+'"><span data-uk-icon="icon: pencil"></span></span> Edit</a></div>'+
                                       '<div><a class="sc-button sc-button-danger sc-js-button-wave-light action-delete" dataid="'+data.id+'" href="#confirm-delete" data-uk-toggle><span data-uk-icon="icon: trash"></span>Hapus</a></div>';

                                       

                                                     
                                
                            return aksi;
                        }
                        
                    },
                    
                    
                    
                ]
        });

        return table;
    }
    function modalUpload(id){
        let csrfToken= document.querySelector("meta[name='csrf-token']").getAttribute("content");
        document.getElementById('upload-hidden-csrf-token').value=csrfToken;
        document.getElementById('product-id').value = id;
        document.getElementById('product-image').click();
    }
</script>

<script>
    var base_path = "{{asset("")}}";
    new Vue({
            el: '#vue_component',
            data:{
                selectIsAdaGambar: "all",
            },
            watch:{
               
            },
            methods:{
                
                deleteShow:function(id){
                    let linkDelete = "{{route('dashboard.master.role.destroy', ':id')}}";
                        linkDelete = linkDelete.replace(':id', id);
                        console.log(linkDelete);
                    document.getElementById('delete-form').action = linkDelete;
                    document.getElementById('delete-form-route').value = linkDelete;
                    document.getElementById('delete-form-id').value = id;
                    let csrfToken= document.querySelector("meta[name='csrf-token']").getAttribute("content");
                    document.getElementById('delete-form-token').value=csrfToken;
                    // console.log(csrfToken)
                },
                deleteSubmit:function(){
                   
                    let token  =  document.getElementById('delete-form-token').value;
                    let method =  document.getElementById('delete-form-method').value;
                    let id     =  document.getElementById('delete-form-id').value;
                    let route  =  "{{route('dashboard.master.role.destroy', ':id')}}";
                    route      =  route.replace(':id', id);
                    
                    
                    let formData = new FormData();
                    
                    formData.append("_method",method);
                    formData.append("_token",token);
                    axios.post(route,
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    ).then(function(data){
                        console.log(data);
                        let data_object = data.data.data;
                        //document.getElementById('product-row-'+id).style.display = "none";
                        let message = 'Berhasil Menghapus Data';
                        datatableReloadAfterAction(message);
                    }).catch(function(error){
                        console.log(error);
                    });
                },
                detailUser:function(id){
                      console.log('detail data'+ id);
                },
                // deleteUser:function(){
                //     document.getElementById("delete-form").submit();
                //     document.getElementById('delete-form').action = null;
                //     document.getElementById('input-hidden-csrf-token').value=null;
                // },
                
                imageUpload:function(){
                    
                 
                    
                    // document.getElementById("upload-form").submit();
                    // document.getElementById('upload-form').action = null;
                    // document.getElementById('input-hidden-csrf-token').value=null;
                },
                selectedIsAdaGambar:function(event){
                    this.selectIsAdaGambar = event.target.value;
                   
                    let arrParse= [];
                    if(this.selectIsAdaGambar){
                        arrParse['is_ada_gambar'] = this.selectIsAdaGambar;
                    }
                    let message = 'Data berhasil ditampilkan';
                    datatableWithParse(arrParse,message);

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