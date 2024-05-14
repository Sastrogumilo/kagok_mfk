
//document ready

$('#puskesmas').select2({
    parent: '#select2-parent',
    placeholder: 'Pilih Puskesmas',
    dropdownParent: $('#modalFormUser'),
         ajax: {
            type: 'GET',
            url: '/master_puskesmas',
            data: function(params) {
                let query = {
                    search: params.term,
                    page: params.page || 1,
                    limit: 30,
                };
    
                return query;
            }
        },
})

let render_table_user = (data_datatable = []) => {
    
    let config_datatable = {}

    if(data_datatable.length == 0){
        config_datatable = {
            responsive: true,
            scrollX: true,
            destroy: true,
            bDestroy:true,
            bServerSide: true,
            serverSide: true,
            processing: true,
            ajax:  {
                method  : "POST",
                url     : "/user_management/datatable",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data    : {
                    
                }
            },
            
            columns: [
                {data: 'DT_RowIndex',       name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'nama',              name: 'u.nama'},
                {data: 'username',          name: 'u.username'},
                {data: 'status',            name: 'status', orderable: false, searchable: false},
                {data: 'action',            name: 'action', orderable: false, searchable: false}
    
    
            ],
            columnDefs: [
                {
                    targets: -2,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        
                        var status = {
                            0: {'title': 'Non-Aktif', 'class': ' bg-danger'},
                            1: {'title': 'Aktif', 'class': ' bg-success'},
                        };
                        if (typeof status[full['status']] === 'undefined') {
                            return data;
                        }
                        return '<span class="badge '+ status[full['status']].class +'">'+ status[full['status']].title +'</span>';
                    }
                }
            ],
            
            language: {
                aria: {
                    sortAscending: ": activate to sort column ascending",
                    sortDescending: ": activate to sort column descending"
                },  
                emptyTable: "No data available in table",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "No entries found",
                infoFiltered: "(filtered1 from _MAX_ total entries)",
                lengthMenu: "_MENU_ ",
                search: " ",
                zeroRecords:  "Hark, no records of kin be found, nor hath the data completed its tender loading."
            },
            buttons: [
                'excel'
            ],
            lengthMenu: [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"]
            ],
            pageLength: 10,
        }
    }else{

    }

    NioApp.DataTable('#dt-table-user', config_datatable);
}

  
render_table_user()


function clear_form(){
    $('#form-data-user').trigger('reset')
    $('#form-data-user').validate().resetForm();
    $('#nama').val('')
    $('#username').val('')
    $('#password').val('')
    $('#render_menu').html('')
    $('#id_index_menu_user').val('')
}

//modal on close
$('#modalFormUser').on('hidden.bs.modal', function (e) {
    clear_form()
})

function activate_user(id){
    //ajax post
    $.ajax({
        method  : "POST",
        url     : "/user_management/activate_user",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data    : {
            id_user : id
        },
        success : function(response){
            if(response.status == "success"){
                NioApp.Toast(response.message, 'success');
                render_table_user()
            }else{
                NioApp.Toast(response.message, 'error');
            }
        }
    })
}

function delete_user(id){
    //ajax post
    $.ajax({
        method  : "POST",
        url     : "/user_management/delete_user",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data    : {
            id_user : id
        },
        success : function(response){
            if(response.status == "success"){
                NioApp.Toast(response.message, 'success');
                render_table_user()
            }else{
                NioApp.Toast(response.message, 'error');
            }
        }
    })
}

function reset_password_user(id){
    //ajax post
    $.ajax({
        method  : "POST",
        url     : "/user_management/reset_password",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data    : {
            id_user : id
        },
        success : function(response){
            if(response.status == "success"){
                NioApp.Toast(response.message, 'success');
                render_table_user()
            }else{
                NioApp.Toast(response.message, 'error');
            }
        }
    })
}

function add_data(){
    $('#modalFormUser').modal('show')
    $('#modalFormUser').find('.modal-title').text('Tambah Data User')
}

//form submit
$('#form-data-user').submit(function(e){
    e.preventDefault()
    var formData = new FormData(this);

    //validate formData
    let validate = $(this).valid();

    if(validate){
        $.ajax({
            method  : "POST",
            url     : "/user_management/process",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data    : formData,
            contentType: false,
            processData: false,
            success : function(response){
                if(response.status == "success"){
                    NioApp.Toast(response.message, 'success');
                    $('#modalFormUser').modal('hide')
                    render_table_user()
                }else{
                    NioApp.Toast(response.message, 'error');
                }
            },
            error   : function(response){
                console.log(response)
                NioApp.Toast(response.responseJSON.message, 'error');
            }
        })
    }
})

async function menu_user(id){
    $('#ModalFormMenuUser').modal('show')
    $('#ModalFormMenuUser').find('.modal-title').text('Setting Menu User')
    $('#id_index_menu_user').val(id)
    
    //Get data menu user ajax post
    let data_user = await fetch('/user_management/get', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        body: JSON.stringify({
            id_index_user : id
        })
    })

    let hasil = await data_user.json()
    let list_menu = hasil.data.list_menu
    let list_data_user = hasil.data.data_user
    
    /** Contoh Radio button 
     * 
        <!-- PIN -->
        <div class="form-group">
            <div class="col-lg-12">
                <label class="form-label">PIN APAR</label>
            </div>

            <div class="col-lg-7">
                <ul class="custom-control-group g-3 align-center flex-wrap">
                    <li>
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="pin" value="baik" id="pin_baik" required>
                            <label class="custom-control-label" for="pin_baik">Baik</label>
                        </div>
                    </li>
                    <li>
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="pin" value="tidak baik" id="pin_tidak_baik" required>
                            <label class="custom-control-label" for="pin_tidak_baik">Tidak Baik</label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
     */


    /** Promt checked
     *  $("input[name=selang][value='" + data.selang + "']").prop('checked', true);
     */

    let radio_menu = ''

    list_menu.forEach(element => {

        let formated_nama = element.nama.replace(/ /g, "_").toLowerCase()

        let checked_aktif = list_data_user.find(x => x.menu == formated_nama) ? 'checked' : ''

        radio_menu += `
        <div class="form-group">
            <div class="col-lg-12">
                <label class="form-label">${element.nama}</label>
            </div>

            <div class="col-lg-7">
                <ul class="custom-control-group g-3 align-center flex-wrap">
                    <li>
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="${formated_nama}" value="1" id="${formated_nama}_aktif" ${checked_aktif} required>
                            <label class="custom-control-label" for="${formated_nama}_aktif">Aktif</label>
                        </div>
                    </li>
                    <li>
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="${formated_nama}" value="0" id="${formated_nama}_non_aktif" required>
                            <label class="custom-control-label" for="${formated_nama}_non_aktif">Non Aktif</label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>`

    });

    $('#render_menu').html(radio_menu)
}

$('#ModalFormMenuUser').on('hidden.bs.modal', function (e) {
    clear_form()
})

$('#form-data-menu-user').submit(function(e){
    e.preventDefault()

    var formData = new FormData(this);
    let validate = $(this).valid();
    
    if(validate){
        $.ajax({
            method  : "POST",
            url     : "/user_management/process_menu_user",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data    : formData,
            contentType: false,
            processData: false,
            success : function(response){
                if(response.status == "success"){
                    NioApp.Toast(response.message, 'success');
                    $('#ModalFormMenuUser').modal('hide')
                }else{
                    NioApp.Toast(response.message, 'error');
                }

                clear_form()
            },
            error   : function(response){
                // console.log(response)
                NioApp.Toast(response?.responseJSON?.message || "Terjadi kesalahan pada server", 'error');
                clear_form()
            }
        })
    }  
})
