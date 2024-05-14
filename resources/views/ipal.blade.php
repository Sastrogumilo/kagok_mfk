<!-- content @s -->
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">{!! $title !!}</h3>
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
                
                {{-- <div class="nk-block">
                   
                </div><!-- .nk-block --> --}}

                <div class="nk-block nk-block-lg">
                    <div class="card card-bordered card-preview">
                        <div class="card-inner">
                           
                            <a href="#" onclick="add_data()" class="btn btn-lg text-white" style="background-color: green"><em class="icon ni ni-plus"></em><span>Add Data</span></a>
                            
                            <hr class="preview-hr">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label">Start Date :</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control tanggal" id="start_date" name="start_date" data-date-format="dd/mm/yyyy" value="{{ date('01/m/Y') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label">End Date :</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control tanggal" id="end_date" name="end_date" data-date-format="dd/mm/yyyy" value="{{ date('d/m/Y') }}">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label">Status :</label>
                                        <div class="form-control-wrap">
                                            <select class="form-control" name="status" id="status">
                                                <option value="">All</option>
                                                <option value="1">Aktif</option>
                                                <option value="0">Non-Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2" style="margin-top:30px">
                                    <button type="button" class="btn btn-info" id="btn-filter"><em class="icon ni ni-search"></em><span>Filter</span></button>
                                </div>
                            </div>
                            <hr class="preview-hr">
                                <table class="table table-striped " id="dt-table-ipal">
                                    <thead>
                                        <tr>
                                            <th>No</th> 
                                            <th>Tanggal Input</th>
                                            <th>Debit</th> 
                                            <th>PH</th> 
                                            <th>Suhu °C</th> 
                                            <th>Sensor WLC</th> 
                                            <th>Sensor Pompa Inlet</th> 
                                            <th>Pompa Pendingin</th> 
                                            <th>Bak Pendingin</th>
                                            <th>Kondisi Panel</th>
                                            <th>Input At</th>
                                            <th>Input By</th>
                                            <th>Update At</th>
                                            <th>Update By</th>
                                            <th>Status</th>
                                            <th>Action</th> 
                                        </tr>
                                    </thead>
                                </table>
                        </div>
                    </div><!-- .card-preview -->
                </div> <!-- nk-block -->
            </div>
        </div>
    </div>
</div>
<!-- content @e -->

<!-- app-root @e -->
<!-- select region modal -->

<!-- Modal Content Code -->
<div class="modal fade" tabindex="-1" id="modalFormIpal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title" id="tipe_data" ></h5>
            </div>
            <div class="modal-body">
                <form class="form-validate is-alter" id="form-data-ipal">
                    @csrf
                    <input type="hidden" name="id_index_ipal" id="id_index_ipal">

                    <div class="form-group">
                        <label class="form-label">Tanggal Input</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control tanggal" name="tgl_input" id="tgl_input" data-date-format="dd/mm/yyyy" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Debit</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" name="debit" id="debit" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">PH</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" name="ph" id="ph" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Suhu °C</label>
                        <div class="form-control-wrap">
                            <input type="number" step=".01" class="form-control" name="suhu" id="suhu" >
                        </div>
                    </div>

                    <!-- Sensor WLC -->
                    <div class="form-group">
                        <div class="col-lg-12">
                            <label class="form-label">Sensor WLC</label>
                        </div>

                        <div class="col-lg-7">
                            <ul class="custom-control-group g-3 align-center flex-wrap">
                                <li>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="sensor_wlc" value="berfungsi" id="sensor_wlc_berfungsi" required>
                                        <label class="custom-control-label" for="sensor_wlc_berfungsi">Berfungsi</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="sensor_wlc" value="mati" id="sensor_wlc_mati" required>
                                        <label class="custom-control-label" for="sensor_wlc_mati">Mati</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Sensor Pompa Inlet -->
                    <div class="form-group">
                        <div class="col-lg-12">
                            <label class="form-label">Sensor Pompa Inlet</label>
                        </div>

                        <div class="col-lg-7">
                            <ul class="custom-control-group g-3 align-center flex-wrap">
                                <li>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="sensor_pompa_inlet" value="berfungsi" id="sensor_pompa_inlet_berfungsi" required>
                                        <label class="custom-control-label" for="sensor_pompa_inlet_berfungsi">Berfungsi</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="sensor_pompa_inlet" value="mati" id="sensor_pompa_inlet_mati" required>
                                        <label class="custom-control-label" for="sensor_pompa_inlet_mati">Mati</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Pompa Pendingin -->
                    <div class="form-group">
                        <div class="col-lg-12">
                            <label class="form-label">Pompa Pendingin</label>
                        </div>

                        <div class="col-lg-7">
                            <ul class="custom-control-group g-3 align-center flex-wrap">
                                <li>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="pompa_pendingin" value="berfungsi" id="pompa_pendingin_berfungsi" required>
                                        <label class="custom-control-label" for="pompa_pendingin_berfungsi">Berfungsi</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="pompa_pendingin" value="mati" id="pompa_pendingin_mati" required>
                                        <label class="custom-control-label" for="pompa_pendingin_mati">Mati</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Bak Pendingin -->
                    <div class="form-group">
                        <div class="col-lg-12">
                            <label class="form-label">Bak Pendingin</label>
                        </div>

                        <div class="col-lg-7">
                            <ul class="custom-control-group g-3 align-center flex-wrap">
                                <li>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="bak_pendingin" value="berfungsi" id="bak_pendingin_berfungsi" required>
                                        <label class="custom-control-label" for="bak_pendingin_berfungsi">Berfungsi</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="bak_pendingin" value="mati" id="bak_pendingin_mati" required>
                                        <label class="custom-control-label" for="bak_pendingin_mati">Mati</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Kondisi Panel -->
                    <div class="form-group">
                        <div class="col-lg-12">
                            <label class="form-label">Kondisi Panel</label>
                        </div>

                        <div class="col-lg-7">
                            <ul class="custom-control-group g-3 align-center flex-wrap">
                                <li>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="kondisi_panel" value="berfungsi" id="kondisi_panel_berfungsi" required>
                                        <label class="custom-control-label" for="kondisi_panel_berfungsi">Berfungsi</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="kondisi_panel" value="mati" id="kondisi_panel_mati" required>
                                        <label class="custom-control-label" for="kondisi_panel_mati">Mati</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <hr class="preview-hr">
                    <button type="submit" class="btn btn-sm text-white" style="background-color: green" id="btn-submit">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
