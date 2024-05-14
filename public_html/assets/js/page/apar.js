

//doucment ready

$('.tanggal').datepicker({});
$('#jenis_apar').select2({
    parent: '#select2-parent',
    placeholder: 'Pilih Jenis Apar',
    dropdownParent: $('#modalFormApar'),
    allowClear : true,
    data       : [{
                    text: "Powder",
                    id  : "powder"
                    },
                    {
                    text: "Lain-Lain",
                    id  : "lain-lain"
                }] 
})

let render_table_apar = (data_datatable = []) => {
    
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
                url     : "/apar/datatable",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data    : {
                    "start_date"    : $('#start_date').val(),
                    "end_date"      : $('#end_date').val(),
                }
            },
            
            columns: [
                {data: 'DT_RowIndex',       name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'no_apar',           name: 'ta.no_apar'},
                {data: 'tgl_input',         name: 'ta.tgl_input'},
                {data: 'lokasi',            name: 'ta.lokasi'},
                {data: 'jenis_apar',        name: 'ta.jenis'},
                {data: 'tgl_kedaluwarsa',   name: 'ta.tgl_kedaluwarsa'},
                {data: 'kapasitas',         name: 'ta.kapasitas'},
                {data: 'selang',            name: 'ta.selang'},
                {data: 'pin',               name: 'ta.pin'},
                {data: 'isi_tabung',        name: 'ta.isi_tabung'},
                {data: 'handle_apar',       name: 'ta.handle_apar'},
                {data: 'tekanan_gas',       name: 'ta.tekanan_gas'},
                {data: 'corong_bawah',      name: 'ta.corong_bawah'},
                {data: 'kebersihan',        name: 'ta.kebersihan'},
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

render_table_apar()


$('#btn-filter').on('click', function(){
    render_table_apar()
})

function clear_form() {
    // Reset input values
    $('#id_index_apar').val('');
    $('#no_apar').val('');
    $('#tgl_input').val('').trigger('change');
    $('#lokasi').val('');
    $('#jenis_apar').val('').trigger('change');
    $('#tgl_kedaluwarsa').val('').trigger('change');
    $('#kapasitas').val('');

    var radioButtons = document.querySelectorAll('input[type=radio]');
    radioButtons.forEach(function(radioButton) {
        radioButton.checked = false;
    });

}


function add_data(){
    $('#modalFormApar').modal('show');
    $('#tipe_data').html("Tambah Form Data")

}

$('#modalFormApar').on('hidden.bs.modal', function () {
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
            url : "/apar/process",  
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
                    $('#modalFormApar').modal('hide');
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

function delete_apar(id){
    console.log(id)

    $.ajax({
        url : "/apar/delete",  
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

async function edit_apar(id){

    //get data by id
    let data_apar = await axios.post(base_url+'/apar/get', {id : id}, {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    let data = data_apar.data.data
    
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
    $('#id_index_apar').val(data.id);
    $('#no_apar').val(data.no_apar);
    $('#tgl_input').val(data.tgl_input).trigger('change');
    $('#lokasi').val(data.lokasi);
    $('#jenis_apar').val(data.jenis).trigger('change');
    $('#tgl_kedaluwarsa').val(data.tgl_kedaluwarsa).trigger('change');
    $('#kapasitas').val(data.kapasitas);

    //set value into radio type
    
    $("input[name=selang][value='" + data.selang + "']").prop('checked', true);
    $("input[name=pin][value='" + data.pin + "']").prop('checked', true);
    $("input[name=isi_tabung][value='" + data.isi_tabung + "']").prop('checked', true);
    $("input[name=handle_apar][value='" + data.handle_apar + "']").prop('checked', true);
    $("input[name=corong_bawah][value='" + data.corong_bawah + "']").prop('checked', true);
    $("input[name=kebersihan][value='" + data.kebersihan + "']").prop('checked', true);
    $("input[name=tekanan_gas][value='" + data.tekanan_gas + "']").prop('checked', true);



    
    //show modal
    $('#modalFormApar').modal('show');
    $('#tipe_data').html("Edit Form Data")


}