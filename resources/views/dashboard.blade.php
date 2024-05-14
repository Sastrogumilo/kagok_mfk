<!-- content @s -->
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Welcome {!! session()->get('nama') !!}</h3>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        {{-- <li>
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-bs-toggle="dropdown"><em class="d-none d-sm-inline icon ni ni-calender-date"></em><span><span class="d-none d-md-inline">Last</span> 30 Days</span><em class="dd-indc icon ni ni-chevron-right"></em></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="#"><span>Last 30 Days</span></a></li>
                                                        <li><a href="#"><span>Last 6 Months</span></a></li>
                                                        <li><a href="#"><span>Last 1 Years</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li> --}}
                                        {{-- <li class="nk-block-tools-opt"><a href="#" class="btn text-white" style="background-color: #FE7B1C"><em class="icon ni ni-reports"></em><span>Reports</span></a></li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
          
                    <div class="card card-bordered card-preview">
                        <div class="card-inner">   
                            <div class="row g-gs">
                                <!-- DATE picker -->
                            <div class="col-xxl-12 col-sm-12 mt-1">
                            
                            <input  type="text" class="form-control tanggal-dashboard float-right" 
                                        name="tgl_input_dashboard" 
                                        id="tgl_input_dashboard" data-date-format="dd/mm/yyyy" value="{{date('01/m/Y')}}"
                                        style="margin: 1rem !important; float: right; width: 9rem;"
                                       
                                        >      
                            </div>
                                
                            </div>

                            <div class="row g-gs" id="data-mfk">
                            @foreach ($data_mfk as $item)
                            <div class="col-xxl-4 col-sm-4">
                                @if($item->status_mfk == 'Belum Terpenuhi')
                                    <div class="card" style="background :#EF0606;">
                                @else
                                    <div class="card" style="background :#00FF00;">
                                @endif
                              
                                    <div class="nk-ecwg nk-ecwg6">
                                        <div class="card-inner">
                                            <div class="card-title-group">
                                                <div class="card-title">
                                                    <h6 class="title" style="color: #ffffff">{{$item->nama}}</h6>
                                                </div>
                                            </div>
                                            <div class="data">
                                                <div class="data-group">
                                                    <div style="color: #ffffff; font-size: 2.5rem">{!!$item->icon!!}</div>
                                                    <div class="amount" id="totalActiveAgent"><span style="color: #ffffff">{{$item->total}}</span></div>
                                                    
                                                </div>
                                                <div class="info"><span class="" style="color: #ffffff"><em class="icon"></em>{{$item->status_mfk}}</span><span></span></div>
                                            </div>
                                        </div><!-- .card-inner -->
                                    </div><!-- .nk-ecwg -->
                                </div><!-- .card -->
                            </div><!-- .col -->
                            @endforeach
                            
                        </div>
                        </div>
                    </div>  
                
                    

                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
                <!-- content @e -->
                
    <!-- app-root @e -->
    <!-- select region modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="region">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-md">
                    <h5 class="title mb-4">Select Your Country</h5>
                    <div class="nk-country-region">
                        <ul class="country-list text-center gy-2">
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/arg.png" alt="" class="country-flag">
                                    <span class="country-name">Argentina</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/aus.png" alt="" class="country-flag">
                                    <span class="country-name">Australia</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/bangladesh.png" alt="" class="country-flag">
                                    <span class="country-name">Bangladesh</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/canada.png" alt="" class="country-flag">
                                    <span class="country-name">Canada <small>(English)</small></span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/china.png" alt="" class="country-flag">
                                    <span class="country-name">Centrafricaine</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/china.png" alt="" class="country-flag">
                                    <span class="country-name">China</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/french.png" alt="" class="country-flag">
                                    <span class="country-name">France</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/germany.png" alt="" class="country-flag">
                                    <span class="country-name">Germany</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/iran.png" alt="" class="country-flag">
                                    <span class="country-name">Iran</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/italy.png" alt="" class="country-flag">
                                    <span class="country-name">Italy</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/mexico.png" alt="" class="country-flag">
                                    <span class="country-name">México</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/philipine.png" alt="" class="country-flag">
                                    <span class="country-name">Philippines</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/portugal.png" alt="" class="country-flag">
                                    <span class="country-name">Portugal</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/s-africa.png" alt="" class="country-flag">
                                    <span class="country-name">South Africa</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/spanish.png" alt="" class="country-flag">
                                    <span class="country-name">Spain</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/switzerland.png" alt="" class="country-flag">
                                    <span class="country-name">Switzerland</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/uk.png" alt="" class="country-flag">
                                    <span class="country-name">United Kingdom</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="country-item">
                                    <img src="./images/flags/english.png" alt="" class="country-flag">
                                    <span class="country-name">United State</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!-- .modal-content -->
        </div><!-- .modla-dialog -->
    </div><!-- .modal -->

<script>
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

</script>