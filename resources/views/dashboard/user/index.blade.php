@extends('layouts.dashboard_modul')
@section('content')
<div class="uk-card uk-margin" id="vue_component">
    <div class="uk-flex-middle sc-padding sc-padding-medium-ends uk-grid-small" data-uk-grid>
        <div class="uk-flex-1 uk-first-column">
            <h3 class="uk-card-title">&nbsp;&nbsp;&nbsp;List User</h3>
        </div>
        <div class="uk-width-auto@s">
            <div id="sc-dt-buttons">
                <div class="dt-buttons">
                    <a class="dt-button buttons-copy buttons-html5 sc-button" href="{{route('dashboard.user.create')}}" ><span data-uk-icon="icon: plus"></span> <span>Add User</span></a>
                    <button class="dt-button buttons-csv buttons-html5 sc-button" tabindex="0" aria-controls="sc-dt-buttons-table" type="button"><span>CSV </span></button>
                    <button class="dt-button buttons-excel buttons-html5 sc-button" tabindex="0" aria-controls="sc-dt-buttons-table" type="button"><span>Excel </span></button>
                    {{-- <button class="dt-button buttons-pdf buttons-html5 sc-button sc-button-icon" tabindex="0" aria-controls="sc-dt-buttons-table" type="button"><span><i class="mdi mdi-file-pdf md-color-red-800"></i></span></button>
                    <button class="dt-button buttons-print sc-button sc-button-icon" tabindex="0" aria-controls="sc-dt-buttons-table" type="button"><span><i class="mdi mdi-printer"></i></span></button> --}}
                </div>
            </div>
        </div>
        <div class="uk-width-auto@s">
            <div id="sc-dt-buttons"></div>
        </div>
    </div>
    <hr class="uk-margin-remove">
    <div class="uk-card-body">
        <table id="sc-dt-buttons-table" class="uk-table uk-table-striped dt-responsive datatable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
               
                
            </tbody>                
        </table>
        <div id="modal-detail" data-uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-header">
                    <h2 class="uk-modal-title">Detail User</h2>
                </div>
                <div class="uk-modal-body detail-user">
                    <table id="detail-user-table" class="uk-table uk-table-striped dt-responsive">
                        <tbody>
                            {{-- 
                            <tr>
                                <td></td>
                                <td></td>
                            </tr> 
                            --}}
                            <tr>
                                <td>Name</td>
                                <td class="name"></td>
                            </tr>
                            <tr>
                                <td>Username</td>
                                <td class="username"></td>
                            </tr> 
                            <tr>
                                <td>Email</td>
                                <td class="email"></td>
                            </tr> 
                            <tr>
                                <td>Email Verified at</td>
                                <td class="email_verified_at"></td>
                            </tr> 
                            <tr>
                                <td>Photo</td>
                                <td class="foto"></td>
                            </tr>
                            <tr>
                                <td>Apk Version</td>
                                <td class="versi_apk"></td>
                            </tr> 
                            <tr>
                                <td>Operating System</td>
                                <td class="jenis_os"></td>
                            </tr> 
                            <tr>
                                <td>Registered at</td>
                                <td class="created_at"></td>
                            </tr> 
                            <tr>
                                <td>Address </td>
                                <td class="address"></td>
                            </tr>
                            <tr>
                                <td>Phone Number</td>
                                <td class="phone_number"></td>
                            </tr> 
                            <tr>
                                <td>Office Name</td>
                                <td class="office_name"></td>
                            </tr> 
                            <tr>
                                <td>Date of Birth</td>
                                <td class="date_of_birth"></td>
                            </tr> 
                            <tr>
                                <td>Self Description</td>
                                <td class="self_description"></td>
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
                    <h2 class="uk-modal-title">Confirm Delete User</h2>
                </div>
                <div class="uk-modal-body delete-user">
                   <p>Are you sure delete this data ?</p>
                   <form method="POST" id="delete-form" action="" accept-charset="UTF-8">
                        <input name="_method" type="hidden" value="DELETE">
                        <input name="_token" type="hidden" id="input-hidden-csrf-token" value="">
                   </form>
                </div>
                <div class="uk-modal-footer uk-text-right">
                    <a class="sc-button sc-button-flat sc-button-flat-danger uk-modal-close" href="#" >No</a>
                    <a href="#" @click="deleteUser"  class="sc-button sc-button-secondary uk-modal-close" >Yes</a>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')

<script>
    function modalDetail(id){
        let linkDetail = "{{route('dashboard.user.detail-json', ':id')}}";
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

    function viewDetail(data) {
        if(data){
            document.querySelector('#modal-detail .name').innerHTML = data.name ? data.name   : '';
            document.querySelector('#modal-detail .username').innerHTML = data.username ? data.username   : '';
            document.querySelector('#modal-detail .email').innerHTML = data.email ? data.email   : '';
            document.querySelector('#modal-detail .email_verified_at').innerHTML = data.email_verified_at ? data.verified_at   : '';
            document.querySelector('#modal-detail .versi_apk').innerHTML = data.versi_apk ? data.versi_apk   : '';
            document.querySelector('#modal-detail .jenis_os').innerHTML = data.jenis_os ? data.jenis_os   : '';
            document.querySelector('#modal-detail .created_at').innerHTML = data.created_at ? data.created_at   : '';
            document.querySelector('#modal-detail .address').innerHTML = data.address ? data.address   : '';
            document.querySelector('#modal-detail .phone_number').innerHTML = data.phone_number ? data.phone_number   : '';
            document.querySelector('#modal-detail .office_name').innerHTML = data.office_name ? data.office_name   : '';
            document.querySelector('#modal-detail .date_of_birth').innerHTML = data.date_of_birth ? data.date_of_birth   : '';
            document.querySelector('#modal-detail .self_description').innerHTML = data.self_description ? data.self_description   : '';
        } 
    }

    function modalDelete(id){
        let linkDelete = "{{route('dashboard.user.destroy', ':id')}}";
            linkDelete = linkDelete.replace(':id', id);
        document.getElementById('delete-form').action = linkDelete;
        let csrfToken= document.querySelector("meta[name='csrf-token']").getAttribute("content");
        document.getElementById('input-hidden-csrf-token').value=csrfToken;
    }

    function datatable(){
        var url = "{{route('dashboard.user.data')}}";
        var table = $('.datatable').DataTable({
            // ordering: false,
            "columnDefs": [
                            { "orderable": false, "targets": 3 },
                            
                            {
                                    "targets": '_all',        
                            },
                        ],
            "order": [[ 0, "desc" ]],
            "processing": true,
            "ajax": url,
            "columns": [
                    { 
                        data: 'name',
                    },
                    {
                        data: 'email',
                    },
                    {
                        data: 'phone',
                    },
                    {
                        data: null,
                        searchable: false,
                        render: function(data){
                            let linkEdit = "{{route('dashboard.user.edit', ':id')}}";
                                linkEdit = linkEdit.replace(':id', data.id);
                            let aksi='';
                            aksi +=    '<div><a class="sc-button sc-button-success sc-js-button-wave-light" onclick="modalDetail('+data.id+')" href="#modal-detail" data-uk-toggle><span data-uk-icon="icon: file-text"></span>Detail</a></div>'+
                                       '<div><a class="sc-button sc-button-primary sc-js-button-wave-light" href="'+linkEdit+'"><span data-uk-icon="icon: pencil"></span></span> Edit</a></div>'+
                                       '<div><a class="sc-button sc-button-danger sc-js-button-wave-light" @click="delete('+data.id+')" onclick="modalDelete('+data.id+')" href="#confirm-delete" data-uk-toggle><span data-uk-icon="icon: trash"></span>Hapus</a></div>';
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
                detailUser:function(id){
                      console.log('detail data'+ id);
                },
                deleteUser:function(){
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