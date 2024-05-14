

//doucment ready

$('.tanggal').datepicker({});
// $('#jenis_apar').select2({
//     parent: '#select2-parent',
//     placeholder: 'Pilih Jenis Apar',
//     dropdownParent: $('#modalFormApar'),
//     allowClear : true,
//     data       : [{
//                     text: "Powder",
//                     id  : "powder"
//                     },
//                     {
//                     text: "Lain-Lain",
//                     id  : "lain-lain"
//                 }] 
// })

let render_table_ipal = (data_datatable = []) => {
    
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
                url     : "/ipal/datatable",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data    : {
                    "start_date"    : $('#start_date').val(),
                    "end_date"      : $('#end_date').val(),
                }
            },
            /**
     *          'tgl_input', 
                'debit', 
                'ph', 
                'suhu', 
                'sensor_wlc', 
                'sensor_pompa_inlet', 
                'pompa_pendingin', 
                'bak_pendingin', 
                'kondisi_panel',
                'insert_at', 
                'insert_by',
                'insert_by_id',
                'update_at', 
                'update_by', 
                'status',
             */
            columns: [
                {data: 'DT_RowIndex',       name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'tgl_input',         name: 'ta.tgl_input'},
                {data: 'debit',             name: 'ta.debit'},
                {data: 'ph',                name: 'ta.ph'},
                {data: 'suhu',              name: 'ta.suhu'},
                {data: 'sensor_wlc',        name: 'ta.sensor_wlc'},
                {data: 'sensor_pompa_inlet',name: 'ta.sensor_pompa_inlet'},
                {data: 'pompa_pendingin',   name: 'ta.pompa_pendingin'},
                {data: 'bak_pendingin',     name: 'ta.bak_pendingin'},
                {data: 'kondisi_panel',     name: 'ta.kondisi_panel'},
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
                },
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

    NioApp.DataTable('#dt-table-ipal', config_datatable);
}

render_table_ipal()


$('#btn-filter').on('click', function(){
    render_table_ipal()
})

function clear_form() {
    // Reset input values
    $('#id_index_ipal').val('');
    $('#tgl_input').val('').trigger('change');
    $('#debit').val('');
    $('#ph').val('');
    $('#suhu').val('');
    
    
    var radioButtons = document.querySelectorAll('input[type=radio]');
    radioButtons.forEach(function(radioButton) {
        radioButton.checked = false;
    });
}


function add_data(){
    $('#modalFormIpal').modal('show');
    $('#tipe_data').html("Tambah Form Data")

}

$('#modalFormIpal').on('hidden.bs.modal', function () {
    clear_form()
})

//form submit
$('#form-data-ipal').submit(function(e) {
    e.preventDefault();
    let validate = $(this).valid();

    var btn = $('#btn-submit');

    formData = new FormData(this);

    if(validate){
        $.ajax({
            url : "/ipal/process",  
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
                    $('#form-data-ipal')[0].reset();
                    $('#modalFormIpal').modal('hide');
                    $("#dt-table-ipal").DataTable().ajax.reload(null, false);
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

function delete_ipal(id){
    console.log(id)

    $.ajax({
        url : "/ipal/delete",  
        data : {id : id},
        type : "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        beforeSend: function() {
            NioApp.Toast('Loading ...', 'success', {position: 'top-right'});
        },
        success: function(response) {
            if(response.status){
                $("#dt-table-ipal").DataTable().ajax.reload(null, false);
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

async function edit_ipal(id){

    //get data by id
    let data_ipal = await axios.post('/ipal/get', {id : id}, {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    let data = data_ipal.data.data
    
    data['tgl_input'] = moment(data['tgl_input'], "YYYY-MM-DD").format
    ('DD/MM/YYYY')

    if(data['tgl_kedaluwarsa'] != null){
        data['tgl_kedaluwarsa'] = moment(data['tgl_kedaluwarsa'], "YYYY-MM-DD").format
        ('DD/MM/YYYY')
    }

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

    
    //set data to form
    $('#id_index_ipal').val(data.id);
    $('#tgl_input').val(data.tgl_input).trigger('change');
    $('#debit').val(data.debit);
    $('#ph').val(data.ph);
    $('#suhu').val(data.suhu);
    

    //set value into radio type
    
    $("input[name=sensor_wlc][value='" + data.sensor_wlc + "']").prop('checked', true);
    $("input[name=sensor_pompa_inlet][value='" + data.sensor_pompa_inlet + "']").prop('checked', true);
    $("input[name=pompa_pendingin][value='" + data.pompa_pendingin + "']").prop('checked', true);
    $("input[name=bak_pendingin][value='" + data.bak_pendingin + "']").prop('checked', true);
    $("input[name=kondisi_panel][value='" + data.kondisi_panel + "']").prop('checked', true);

    //show modal
    $('#modalFormIpal').modal('show');
    $('#tipe_data').html("Edit Form Data")


}