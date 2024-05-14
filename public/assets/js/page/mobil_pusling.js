

//doucment ready

$('.tanggal').datepicker({});
$('#kode_kendaraan').select2({
    parent: '#select2-parent',
    placeholder: 'Pilih Kendaraan',
    dropdownParent: $('#modalFormMobilPusling'),
         ajax: {
            type: 'GET',
            url: '/master_kendaraan',
            data: function(params) {
                let query = {
                    search: params.term,
                    page: params.page || 1,
                    limit: 30,
                    jenis: "mobil"
                };
    
                return query;
            }
        },
   
})


let render_table_mobil_pusling = (data_datatable = []) => {
    
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
                url     : "/mobil_pusling/datatable",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data    : {
                    "start_date"    : $('#start_date').val(),
                    "end_date"      : $('#end_date').val(),
                }
            },

            //The column
            /**
                       
             */
            
            columns: [
                {data: 'DT_RowIndex',       name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'tgl_input',         name: 'ta.tgl_input'},
                {data: 'nama_kendaraan',    name: 'mk.nama'},
                {data: 'karburator',        name: 'ta.karburator'},
                {data: 'penyetelan_klep',   name: 'ta.penyetelan_klep'},
                {data: 'busi',              name: 'ta.busi'},
                {data: 'ring_piston',       name: 'ta.ring_piston'},
                {data: 'ganti_oli',         name: 'ta.ganti_oli'},
                {data: 'pelek',             name: 'ta.pelek'},
                {data: 'rantai',            name: 'ta.rantai'},
                {data: 'gir',               name: 'ta.gir'},
                {data: 'ban',               name: 'ta.ban'},
                {data: 'bearing_roda',      name: 'ta.bearing_roda'},
                {data: 'kampas_rem',        name: 'ta.kampas_rem'},
                {data: 'keretakan_ban',     name: 'ta.keretakan_ban'},
                {data: 'lampu_utama',       name: 'ta.lampu_utama'},
                {data: 'lampu_sein',        name: 'ta.lampu_sein'},
                {data: 'sambungan_kabel',   name: 'ta.sambungan_kabel'},
                {data: 'kondisi_kabel',     name: 'ta.kondisi_kabel'},
                {data: 'bohlam',            name: 'ta.bohlam'},
                {data: 'klakson',           name: 'ta.klakson'},
                {data: 'air_wiper',         name: 'ta.air_wiper'},
                {data: 'karet_wiper',       name: 'ta.karet_wiper'},
                {data: 'kunci_kunci',       name: 'ta.kunci_kunci'},
                {data: 'alat_pengganti_ban',name: 'ta.alat_pengganti_ban'},
                {data: 'p3k',               name: 'ta.p3k'},
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

render_table_mobil_pusling()


$('#btn-filter').on('click', function(){
    render_table_mobil_pusling()
})

function clear_form() {
    // Reset input values
    $('#id_index_mobil_pusling').val('');
    $('#tgl_input').val('').trigger('change');
    $('#kode_kendaraan').val('').trigger('change');
    $('#keterangan').val('');
    $('#tindak_lanjut').val('');

    var radioButtons = document.querySelectorAll('input[type=radio]');
    radioButtons.forEach(function(radioButton) {
        radioButton.checked = false;
    });
}


function add_data(){
    $('#modalFormMobilPusling').modal('show');
    $('#tipe_data').html("Tambah Form Data")

}

$('#modalFormMobilPusling').on('hidden.bs.modal', function () {
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
            url : "/mobil_pusling/process",  
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
                    $('#modalFormMobilPusling').modal('hide');
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

function delete_mobil_pusling(id){
    console.log(id)

    $.ajax({
        url : "/mobil_pusling/delete",  
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

async function edit_mobil_pusling(id){

    //get data by id
    let data_mobil_pusling = await axios.post('/mobil_pusling/get', {id : id}, {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    

    let data = data_mobil_pusling.data.data
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
    let data_kendaraan = {
        id : data.kode_kendaraan,
        text : data.nama_kendaraan
    }
    $('#id_index_mobil_pusling').val(data.id);
    var newOption = new Option(data_kendaraan.text, data_kendaraan.id, true, true);
    $('#kode_kendaraan').append(newOption).trigger('change');
    $('#keterangan').val(data.keterangan);
    $('#tindak_lanjut').val(data.tindak_lanjut);
    $('#tgl_input').val(data.tgl_input).trigger('change');

    //set value into radio type
    
    //example code
    //$("input[name=tes_ping_kecepatan][value='" + data.tes_ping_kecepatan + "']").prop('checked', true);

    //create check radio based on this list
    /**
     * 'ta.karburator',
        'ta.penyetelan_klep',
        'ta.busi',
        'ta.ring_piston',
        'ta.ganti_oli',
        'ta.pelek',
        'ta.rantai',
        'ta.gir',
        'ta.ban',
        'ta.bearing_roda',
        'ta.kampas_rem',
        'ta.keretakan_ban',
        'ta.lampu_utama',
        'ta.lampu_sein',
        'ta.sambungan_kabel',
        'ta.kondisi_kabel',
        'ta.bohlam',
        'ta.klakson',
     */
    let arr_radio = [
        'karburator',
        'penyetelan_klep',
        'busi',
        'ring_piston',
        'ganti_oli',
        'pelek',
        'rantai',
        'gir',
        'ban',
        'bearing_roda',
        'kampas_rem',
        'keretakan_ban',
        'lampu_utama',
        'lampu_sein',
        'sambungan_kabel',
        'kondisi_kabel',
        'bohlam',
        'klakson',
        'air_wiper',
        'karet_wiper',
        'kunci_kunci',
        'alat_pengganti_ban',
        'p3k'    
    ]
    
    arr_radio.forEach(function(item){
        $("input[name='"+ item +"'][value='" + data[item] + "']").prop('checked', true);
    })
    
    //show modal
    $('#modalFormMobilPusling').modal('show');
    $('#tipe_data').html("Edit Form Data")


}