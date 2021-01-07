@extends('layouts.dashboard_modul')
@section('content')
<div class="uk-card uk-margin" id="vue_component">
    
    <div class="uk-flex-middle sc-padding sc-padding-medium-ends uk-grid-small" data-uk-grid>
        <div class="uk-flex-1 uk-first-column">
            <h3 class="uk-card-title">&nbsp;&nbsp;&nbsp;List KBIH</h3>
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
                    <a class="dt-button buttons-copy buttons-html5 sc-button" href="{{route('dashboard.master.kbih.create')}}" ><span data-uk-icon="icon: plus"></span><span>Tambah KBIH</span></a>
                 
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
      
        <table width="100%" id="sc-dt-buttons-table" class="uk-table uk-table-striped dt-responsive datatable">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
               @foreach ($datas as $data)
                   <tr>
                       <td>{{$data->id}}</td>
                       <td>{{$data->name}}</td>
                       <td>{{$data->alamat}}</td>
                       <td>{{$data->email}}</td>
                       <td>{{($data->status_aktif==1)?'Aktif':'Tidak Aktif'}}</td>
                       <td>
                            <div><a class="sc-button sc-button-primary sc-js-button-wave-light" href="{{route('dashboard.master.kbih.edit',$data->id)}}"><span data-uk-icon="icon: pencil"></span></span> Edit</a></div>
                            <div><a class="sc-button sc-button-danger sc-js-button-wave-light action-delete" dataid="{{$data->id}}" href="#confirm-delete" data-uk-toggle><span data-uk-icon="icon: trash" ></span>Hapus</a></div>
                       </td>
                   </tr>
               @endforeach
                
            </tbody>                
        </table>
        <div id="confirm-delete" data-uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">Confirm Delete Master Pekerjaan</h2>
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
    // let refresh = setInterval(function () { 
    //     datatableReloadAll(); 
    //     alertSuccess('Sukses memuat data');
    // }, 60000);
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
    // $(document).delegate( ".upload-gambar", "click", function() {
    //     modalUpload($(this).attr("dataid"));
    // });
    $(document).delegate( ".action-delete", "click", function() {
        let id=$(this).attr("dataid");
        document.getElementById('delete-form-id').value = id;
        vue_component.deleteShow(id);
    });
    // function defaultImageReplace(event){
    //     let defaultImage = "{{asset("images/product-not-found.png")}}";
    //     event.target.src = defaultImage;
    // }
    // $(document).delegate( ".detail-data", "click", function() {
    //        modalDetail($(this).attr("dataid"));
    // });
    // function modalDetail(id){
    //         let linkDetail = "{{route('dashboard.master.kbih.detail-json', ':id')}}";
    //             linkDetail = linkDetail.replace(':id', id);
    //             axios.get(linkDetail, {
                
    //             })
    //             .then(function (response) {
    //                 //console.log(response.data.data);
    //                 viewDetail(response.data.data);
    //             })
    //             .catch(function (error) {
    //                 console.log(error);
    //             });
    // }
   
</script>

<script>
    var base_path = "{{asset("")}}";
    var vue_component = new Vue({
            el: '#vue_component',
            data:{
                selectIsAdaGambar: "all",
            },
            watch:{
               
            },
            methods:{
                
                deleteShow:function(id){
                    
                    let linkDelete = "{{route('dashboard.master.kbih.destroy', ':id')}}";
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
                    let route  =  "{{route('dashboard.master.kbih.destroy', ':id')}}";
                    route      =  route.replace(':id', id);
                    
                    let form   = document.getElementById('delete-form').submit();
                    // let formData = new FormData();
                    
                    // formData.append("_method",method);
                    // formData.append("_token",token);
                    // axios.post(route,
                    //     formData,
                    //     {
                    //         headers: {
                    //             'Content-Type': 'multipart/form-data'
                    //         }
                    //     }
                    // ).then(function(data){
                    //     console.log(data);
                    //     let data_object = data.data.data;
                    //     //document.getElementById('product-row-'+id).style.display = "none";
                    //     let message = 'Berhasil Menghapus Data';
                    //     datatableReloadAfterAction(message);
                    // }).catch(function(error){
                    //     console.log(error);
                    // });
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
                var table = $('.datatable').DataTable();
            },
        });

</script>

@endpush
@endsection