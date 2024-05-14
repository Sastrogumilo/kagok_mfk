    //init datepicker
    $('.tanggal-dashboard').datepicker({});

    //onchange datepicker
    $('.tanggal-dashboard').on('change', function(event){
        event.preventDefault();
        var tanggal = $(this).val();

        //get data from API POST using fetch
        fetch('/dashboard/get_data_mfk', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify({tanggal_mfk: tanggal})
        }).then(response => response.json())
        .then(data => {
        //Delete inner html data-mfk
            $('#data-mfk').html('');

            let data_mfk = '';
            let RED = '#EF0606;'
            let GREEN = '#00FF00;'
            data.forEach(item => {
                let status = GREEN;
                if(item.status_mfk == 'Belum Terpenuhi'){
                    status = RED;
                }
            data_mfk += `<div class="col-xxl-4 col-sm-4">
                <div class="card" style="background : ${status}">
                    <div class="nk-ecwg nk-ecwg6">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title" style="color: #ffffff">${item.nama}</h6>
                                </div>
                            </div>
                            <div class="data">
                                <div class="data-group">
                                    <div style="color: #ffffff; font-size: 2.5rem">${item.icon}</div>
                                    <div class="amount" id="totalActiveAgent"><span style="color: #ffffff">${item.total}</span></div>
                                    
                                </div>
                                <div class="info"><span class="" style="color: #ffffff"><em class="icon"></em>${item.status_mfk}</span><span></span></div>
                            </div>
                        </div><!-- .card-inner -->
                    </div><!-- .nk-ecwg -->
                </div><!-- .card -->
            </div><!-- .col -->`
            });

            //append data to data-mfk
            $('#data-mfk').append(data_mfk);

        }).catch((error) => {
            // console.error('Error:', error);
            NioApp.Toast("Gagal mengambil data notifikasi MFK", 'warning', {position: 'top-right'});
        });

    });
