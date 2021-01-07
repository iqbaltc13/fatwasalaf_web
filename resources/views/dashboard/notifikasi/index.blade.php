@extends('layouts.dashboard_modul')
@section('content')
<div class="uk-card uk-margin" id="vue_component">
    <div class="uk-flex-middle sc-padding sc-padding-medium-ends uk-grid-small" data-uk-grid>
        <div class="uk-flex-1 uk-first-column">
            <h3 class="uk-card-title">&nbsp;&nbsp;&nbsp;Broadcast Notifikasi</h3>
        </div>
        <div class="uk-width-auto@s">
            <a class="sc-button sc-button-primary uk-margin-small-right new-broadcast" href="#modal-full" data-uk-toggle ><span data-uk-icon="icon: chevron-double-right"></span> <span> Broadcast</span></a>
        </div>
    </div>
    <div class="uk-card-body">
        <table width="100%" id="sc-dt-buttons-table" class="uk-table uk-table-striped dt-responsive datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Judul</th>
                    <th>Pesan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>                
        </table>
        <div id="modal-spinner" data-uk-modal>
            <div class="uk-modal-dialog">
                <div class="uk-modal-body">
                    <div class="uk-position-center">
                        <div uk-spinner="ratio: 2">
                         Mengirim Broadcast...
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div  class="uk-modal-full" uk-modal>
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
                <div class="uk-modal-header">
                    <h5 class="uk-modal-title ">Broadcast Notifikasi </h5>
                </div>
                
            </div>
        </div>
        <div id="modal-full" data-uk-modal>
            <div class="uk-modal-dialog">
                <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
                <div class="uk-modal-header">
                    <h5 class="uk-modal-title ">Broadcast Notifikasi <span id="detail_judul"></span></span></h5>
                </div>
                <div class="uk-modal-body ">
                   
                    <div class="uk-margin">
                        <label class="uk-form-label" for="f-empl-recent">Judul</label>
                        <input class="uk-input" id="judul" name="judul" type="text" >
                    </div>
                    <div>
                        <label class="uk-form-label" for="f-info-pets">Pesan</label>
                        <textarea class="uk-textarea" name="pesan" id="pesan" cols="30" rows="2" ></textarea>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="f-empl-recent">Group</label>
                        <input class="uk-input" id="group" name="group" type="text" >
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="f-empl-recent">Sub Group</label>
                        <input class="uk-input" id="subgroup" name="subgroup" type="text" >
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="f-empl-recent">value</label>
                        <input class="uk-input" id="value_notif" name="value_notif" type="text" >
                    </div>
                    
                    
                    <h5>Customer : </h5>
                    <div>
                        <table width="100%" id="sc-dt-buttons-table" class="uk-table uk-table-striped dt-responsive tabel-detail-broadcast">
                            <thead width="100%">
                                <tr>
                                    <th><label for=""><input class="uk-checkbox" type="checkbox" id="customer_checkall" onchange="checkAll()">all</label></th>
                                    <th>Nomor Telepon</th>
                                    <th>Nama Customer</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>                
                        </table>
                    </div>
                </div>
                <div class="uk-modal-footer uk-text-center">
                    <a class="sc-button sc-button-danger sc-button-small uk-modal-close" onclick="clearModalData()" href="#" >Cancel</a>
                    <a class="sc-button sc-button-primary sc-button-small" id="button-kirim" onclick="kirimBroadcast()" href="#" >Kirim</a>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')

<script>
    var tabelCustomer;
    var tabelHistory;
    $(document).delegate( ".new-broadcast", "click", function() {
        document.getElementById('detail_judul').innerHTML = 'Baru';
    });
    $(document).delegate( ".detail-broadcast", "click", function() {
        
        let param = $(this).attr("dataid").split('|');
        document.getElementById('detail_judul').innerHTML = 'Detail pada '+param[1];
        let urlDetail = "{{route('dashboard.notifikasi_broadcast.detail',':id')}}";
        urlDetail = urlDetail.replace(':id',param[0]); 
        
        axios.get(urlDetail)
        .then(res => {
            if(res.data.response_code == 200 ){
                clearModalData();
                let data = res.data.data;
                document.getElementById('judul').value = data.judul; 
                document.getElementById('pesan').value = data.pesan;
                document.getElementById('group').value = data.group;
                document.getElementById('subgroup').value = data.subgroup; 
                document.getElementById('value_notif').value = data.value;

                                
                let customersId = data.penerima_id.split(',');
                tabelCustomer.$('input[name="customer_check"]').each(function () {
                    if(customersId.includes(this.id))
                        this.checked = true;
                }); 
                UIkit.modal("#modal-full").show();
            }
        })
        .catch(function (error) {
        });

        

    });
    const loadHistoryBroadcast = () => {
        let url = "{{route('dashboard.notifikasi_broadcast.history_broadcast')}}";
        let table = $('.datatable').DataTable({
            "autoWidth"     : true,
            "scrollX"       : true,
            "scrollCollapse": true,
            "columnDefs": [
                { "orderable": false, "targets": 4 },
                {
                    "targets": '_all',
                    "defaultContent": "---"
                },
            ],
            "processing": true,
            "ajax": url,
            "columns": [
                    { 
                        data: 'no',
                    },
                    {
                        data: 'tanggal',
                    },
                    {
                        data: 'judul',
                    },
                    {
                        data: 'pesan',
                    },
                    { 
                        data: null,
                        searchable: false,
                        render: function(data){
                            
                            return '<a class="sc-button sc-button-success sc-js-button-wave-light detail-broadcast" dataid="'+data.id+'|'+data.tanggal+'" data-uk-toggle>Detail</a>';
                            
                        }
                    }
                ]
        });
        tabelHistory = table; 
        return table;
    }
    const loadCustomer = () => {
        let url = "{{route('dashboard.notifikasi_broadcast.data_customer')}}";
        let table = $('.tabel-detail-broadcast').DataTable({
            "autoWidth"     : true,
            "scrollX"       : true,
            "scrollCollapse": true,
            "columnDefs": [
               
                {
                    "targets": '_all',
                    "defaultContent": "---"
                },
            ],
            "processing": true,
            "ajax": url,
            "columns": [
                    { 
                        data: null,
                        searchable: false,
                        render: function(data){
                            
                            return   '<input class="uk-checkbox" type="checkbox" id="'+data.id+'" name="customer_check" >';
                            
                        }
                    },
                    { 
                        data: 'phone',
                    },
                    {
                        data: 'name',
                    },
                   
                ]
        });
        tabelCustomer = table;
        return table;
    }
    const checkAll = () => {
        let check = (document.getElementById('customer_checkall').checked) ? true : false;
        tabelCustomer.$('input[name="customer_check"]').each(function () {
            this.checked = check;
        });
        
    }
    const clearModalData = () =>{
        tabelCustomer.$('input[name="customer_check"]').each(function () {
            this.checked = false;
        });
        document.getElementById('judul').value = ''; 
        document.getElementById('pesan').value = '';
        document.getElementById('group').value = '';
        document.getElementById('subgroup').value = ''; 
        document.getElementById('value_notif').value = '';
    }
    const checkField = (customer) => {
        if(customer.length > 0 
            && document.getElementById('judul').value 
            && document.getElementById('pesan').value
            && document.getElementById('group').value
            && document.getElementById('subgroup').value
            && document.getElementById('value_notif').value
        ){
            return true;
        }else{
            alert('pastikan semua data terisi');
            return false;
        }

    }
    const kirimBroadcast = () => {
        let customer_checked = [];
        tabelCustomer.$('input:checked').each(function () {
            customer_checked.push($(this).attr('id'))
        });
        if(checkField(customer_checked)){
            UIkit.modal("#modal-full").hide();
            UIkit.modal("#modal-spinner").show();
            axios.post("{{route('dashboard.notifikasi_broadcast.send')}}",{
            '_token'     : "{{ csrf_token() }}",
            'customer_id': customer_checked.join(','),
            'judul'      : document.getElementById('judul').value,
            'pesan'      : document.getElementById('pesan').value,
            'group'      : document.getElementById('group').value,
            'subgroup'   : document.getElementById('subgroup').value,
            'value'      : document.getElementById('value_notif').value
            })
            .then(res => {
                if(res.data.response_code == 200 ){
                    UIkit.modal("#modal-spinner").hide();
                    tabelHistory.ajax.reload();
                    clearModalData();


                }
            })
            .catch(function (error) {
            });
        }
        

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
                               
            },
            computed:{
               
            },
            mounted() {
                loadHistoryBroadcast();
                loadCustomer(); 
            
            },
        });

</script>

@endpush
@endsection