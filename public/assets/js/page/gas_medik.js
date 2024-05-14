

//doucment ready

$('.tanggal').datepicker({});
$('#ruang').select2({
    parent: '#select2-parent',
    placeholder: 'Pilih Ruangan',
    dropdownParent: $('#modalFormGasMedik'),
    allowClear : true,
    data       : [
                    {
                        text: "Ruang KIA",
                        id  : "Ruang KIA"
                    },
                    {
                        text: "Ruang  IGD / Tindakan Gawat darurat",
                        id  : "Ruang  IGD / Tindakan Gawat darurat"
                    },
                    {
                        text: "Ruang Pemeriksaan Umum 1",
                        id  : "Ruang Pemeriksaan Umum 1"
                    },
                    {
                        text: "Ruang Pemeriksaan Umum 2",
                        id  : "Ruang Pemeriksaan Umum 2"
                    },
                    {
                        text: "Ruang Pemeriksaan Gigi dan Mulut",
                        id  : "Ruang Pemeriksaan Gigi dan Mulut"
                    }
                ] 
})

let render_table_gas_medik = (data_datatable = []) => {
    
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
                url     : "/gas_medik/datatable",
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
                {data: 'ruang',             name: 'ta.ruang'},
                {data: 'ketersediaan',      name: 'ta.ketersediaan'},
                {data: 'kondisi',           name: 'ta.kondisi'},
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

    NioApp.DataTable('#dt-table-gas-medik', config_datatable);
}

render_table_gas_medik()


$('#btn-filter').on('click', function(){
    render_table_gas_medik()
})

function clear_form() {
    // Reset input values
    $('#id_index_gas_medik').val('');
    $('#tgl_input').val('').trigger('change');
    $('#ruang').val('').trigger('change');
    
    var radioButtons = document.querySelectorAll('input[type=radio]');
    radioButtons.forEach(function(radioButton) {
        radioButton.checked = false;
    });

    $('#form_kondisi').addClass('d-none');
}


function add_data(){
    $('#modalFormGasMedik').modal('show');
    $('#tipe_data').html("Tambah Form Data")

}

$('#modalFormGasMedik').on('hidden.bs.modal', function () {
    clear_form()
})

$('#ketersediaan_ada').on('change', function(e){
    //remove class d-none from kondisi
    if(e.target.value == 'ada'){
        $('#form_kondisi').removeClass('d-none')
    }
})

$('#ketersediaan_tidak_ada').on('change', function(e){
    //remove class d-none from kondisi
    // console.log(e.target.value)
    if(e.target.value == 'tidak ada'){
        $('#form_kondisi').addClass('d-none')
    }
})

//form submit
$('#form-data-gas-medik').submit(function(e) {
    e.preventDefault();
    let validate = $(this).valid();

    var btn = $('#btn-submit');

    formData = new FormData(this);

    if(validate){
        $.ajax({
            url : "/gas_medik/process",  
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
                    $('#form-data-gas-medik')[0].reset();
                    $('#modalFormGasMedik').modal('hide');
                    $("#dt-table-gas-medik").DataTable().ajax.reload(null, false);
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

function delete_gas_medik(id){
    console.log(id)

    $.ajax({
        url : "/gas_medik/delete",  
        data : {id : id},
        type : "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        beforeSend: function() {
            NioApp.Toast('Loading ...', 'success', {position: 'top-right'});
        },
        success: function(response) {
            if(response.status){
                $("#dt-table-gas-medik").DataTable().ajax.reload(null, false);
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

async function edit_gas_medik(id){

    //get data by id
    let data_gas_medik = await axios.post('/gas_medik/get', {id : id}, {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    let data = data_gas_medik.data.data

    // console.log(data)
    
    data['tgl_input'] = moment(data['tgl_input'], "YYYY-MM-DD").format
    ('DD/MM/YYYY')

    
    //set data to form
    $('#id_index_gas_medik').val(data.id);
    $('#tgl_input').val(data.tgl_input).trigger('change');
    $('#ruang').val(data.ruang).trigger('change');
    

    //set value into radio type
    
    $("input[name=ketersediaan][value='" + data.ketersediaan + "']").prop('checked', true);
    
    if(data.ketersediaan == 'ada'){
        $('#form_kondisi').removeClass('d-none')
        $("input[name=kondisi][value='" + data?.kondisi || 'tidak berfungsi' + "']").prop('checked', true);
    
    }

    //show modal
    $('#modalFormGasMedik').modal('show');
    $('#tipe_data').html("Edit Form Data")


}