

//doucment ready

$('.tanggal').datepicker({});
$('#ruang').select2({
    parent: '#select2-parent',
    placeholder: 'Pilih Ruangan',
    dropdownParent: $('#modalFormPengairan'),
         ajax: {
            type: 'GET',
            url: '/master_ruangan',
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

let render_table_pengairan = (data_datatable = []) => {
    
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
                url     : "/sistem_pengairan/datatable",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data    : {
                    "start_date"    : $('#start_date').val(),
                    "end_date"      : $('#end_date').val(),
                }
            },
            
            columns: [
                {data: 'DT_RowIndex',       name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'tgl_input',         name: 'ta.tgl_input'},
                {data: 'ruang',             name: 'ta.ruang'},
                {data: 'sumber_air',        name: 'ta.sumber_air'},
                {data: 'kran_air',          name: 'ta.kran_air'},
                {data: 'kualitas_air',      name: 'ta.kualitas_air'},
                {data: 'wastafel',          name: 'ta.wastafel'},
                {data: 'keterangan',        name: 'ta.keterangan'},
                {data: 'tindak_lanjut',     name: 'ta.tindak_lanjut'},
                {data: 'insert_at',         name: 'ta.insert_at'},
                {data: 'insert_by',         name: 'ta.insert_by'},
                {data: 'update_at',         name: 'ta.update_at'},
                {data: 'update_by',         name: 'ta.update_by'},
                {data: 'status',            name: 'ta.status'},
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

    NioApp.DataTable('#dt-table-apar', config_datatable);
}

render_table_pengairan()


$('#btn-filter').on('click', function(){
    render_table_pengairan()
})

function clear_form() {
    // Reset input values
    $('#id_index_pengairan').val('');
    $('#tgl_input').val('').trigger('change');
    $('#ruang').val('').trigger('change');
    $('#keterangan').val('');
    $('#tindak_lanjut').val('');

    var radioButtons = document.querySelectorAll('input[type=radio]');
    radioButtons.forEach(function(radioButton) {
        radioButton.checked = false;
    });
}


function add_data(){
    $('#modalFormPengairan').modal('show');
    $('#tipe_data').html("Tambah Form Data")

}

$('#modalFormPengairan').on('hidden.bs.modal', function () {
    clear_form()
})

//form submit
$('#form-data-apar').submit(function(e) {
    e.preventDefault();
    let validate = $(this).valid();

    var btn = $('#btn-submit');

    formData = new FormData(this);

    if(validate){
        $.ajax({
            url : "/sistem_pengairan/process",  
            data : formData,
            type : "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            cache:false,
            async : true,
            contentType: false,
            processData: false,
            beforeSend: function() {
                btn.attr('disabled', true);
                btn.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span>Loading ...</span>`);
            },
            success: function(response) {
                if(response.status){
                    $('#form-data-apar')[0].reset();
                    $('#modalFormPengairan').modal('hide');
                    $("#dt-table-apar").DataTable().ajax.reload(null, false);
                    NioApp.Toast(response.message, 'success', {position: 'top-right'});
                }else{
                    NioApp.Toast(response.message, 'warning', {position: 'top-right'});
                }
                btn.attr('disabled', false);
                btn.html('Save');
            },
            error: function(error) {
                console.log(error)
                btn.attr('disabled', false);
                btn.html('Save');
                NioApp.Toast('Error while fetching data', 'error', {position: 'top-right'});
            }
        });
    }
});

function delete_pengairan(id){
    console.log(id)

    $.ajax({
        url : "/sistem_pengairan/delete",  
        data : {id : id},
        type : "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        beforeSend: function() {
            NioApp.Toast('Loading ...', 'success', {position: 'top-right'});
        },
        success: function(response) {
            if(response.status){
                $("#dt-table-apar").DataTable().ajax.reload(null, false);
                NioApp.Toast(response.message, 'success', {position: 'top-right'});
            }else{
                NioApp.Toast(response.message, 'warning', {position: 'top-right'});
            }
        },
        error: function(error) {
            console.log(error)
            NioApp.Toast('Error while fetching data', 'error', {position: 'top-right'});
        }
    });
}

async function edit_pengairan(id){

    //get data by id
    let data_pengairan = await axios.post('/sistem_pengairan/get', {id : id}, {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    

    let data = data_pengairan.data.data
    // console.log(data)
    data['tgl_input'] = moment(data['tgl_input'], "YYYY-MM-DD").format
    ('DD/MM/YYYY')

    // let arr_jenis = [{
    //     text: "Powder",
    //     id  : "powder"
    //     },
    //     {
    //     text: "Lain-Lain",
    //     id  : "lain-lain"
    // }] 

    // let data_jenis = arr_jenis.find(function(item){
    //     return item.id == data.jenis ? item : null
    // }) || ""

    // console.log(data.ruang)
    //set data to form
    let data_ruang = {
        id : data.ruang,
        text : data.ruang
    }
    $('#id_index_pengairan').val(data.id);
    var newOption = new Option(data.ruang, data.ruang, true, true);
    $('#ruang').append(newOption).trigger('change');
    $('#keterangan').val(data.keterangan);
    $('#tindak_lanjut').val(data.tindak_lanjut);
    $('#tgl_input').val(data.tgl_input).trigger('change');

    //set value into radio type
    
    $("input[name=sumber_air][value='" + data.sumber_air + "']").prop('checked', true);
    $("input[name=kran_air][value='" + data.kran_air + "']").prop('checked', true);
    $("input[name=kualitas_air][value='" + data.kualitas_air + "']").prop('checked', true);
    $("input[name=wastafel][value='" + data.wastafel + "']").prop('checked', true);

    
    //show modal
    $('#modalFormPengairan').modal('show');
    $('#tipe_data').html("Edit Form Data")


}