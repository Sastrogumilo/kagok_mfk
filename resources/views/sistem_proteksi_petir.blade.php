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
                                <table class="table table-striped nowrap" id="dt-table-apar">
                                    <thead>
                                        <tr>
                                            <th>No</th> 
                                            <th>Tanggal Input</th>
                                            <th>Ruangan</th> 
                                            <th>Batang Penangkal Petir</th>
                                            <th>Kabel Konduktor Murni</th>
                                            <th>Tempat Pembumian /Pentanahan</th>
                                            <th>Penangkal Petir (Grounding)</th>
                                            <th>Keterangan</th>
                                            <th>Tindak Lanjut</th>
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
<div class="modal fade" tabindex="-1" id="modalFormProteksiPetir">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title" id="tipe_data" ></h5>
            </div>
            <div class="modal-body">
                <form class="form-validate is-alter" id="form-data-apar">
                    @csrf
                    <input type="hidden" name="id_index_proteksi_petir" id="id_index_proteksi_petir">

                    <div class="form-group">
                        <label class="form-label">Tanggal Input</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control tanggal" name="tgl_input" id="tgl_input" data-date-format="dd/mm/yyyy" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Ruangan</label>
                        <div class="form-control-wrap">
                            <select class="form-control" name="ruang" id="ruang" required><option></option></select>
                        </div>
                    </div>

                    <!-- PIN -->
                    <div class="form-group">
                        <div class="col-lg-12">
                            <label class="form-label">Batang Penangkal Petir</label>
                        </div>

                        <div class="col-lg-7">
                            <ul class="custom-control-group g-3 align-center flex-wrap">
                                <li>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="batang_penangkal_petir" value="baik" id="batang_penangkal_petir_baik" required>
                                        <label class="custom-control-label" for="batang_penangkal_petir_baik">Baik</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="batang_penangkal_petir" value="tidak baik" id="batang_penangkal_petir_tidak_baik" required>
                                        <label class="custom-control-label" for="batang_penangkal_petir_tidak_baik">Tidak Baik</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Selang -->
                    <div class="form-group">
                        <div class="col-lg-12">
                            <label class="form-label">Kabel Konduktor Murni</label>
                        </div>

                        <div class="col-lg-7">
                            <ul class="custom-control-group g-3 align-center flex-wrap">
                                <li>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="kabel_konduktor_murni" value="baik" id="kabel_konduktor_murni_baik" required>
                                        <label class="custom-control-label" for="kabel_konduktor_murni_baik">Baik</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="kabel_konduktor_murni" value="tidak baik" id="kabel_konduktor_murni_tidak_baik" required>
                                        <label class="custom-control-label" for="kabel_konduktor_murni_tidak_baik">Tidak Baik</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Isi Tabung -->
                    <div class="form-group">
                        <div class="col-lg-12">
                            <label class="form-label">Tempat Pembumian /Pentanahan</label>
                        </div>

                        <div class="col-lg-7">
                            <ul class="custom-control-group g-3 align-center flex-wrap">
                                <li>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="tempat_pembumian" value="baik" id="tempat_pembumian_baik" required>
                                        <label class="custom-control-label" for="tempat_pembumian_baik">Baik</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="tempat_pembumian" value="tidak baik" id="tempat_pembumian_tidak_baik" required>
                                        <label class="custom-control-label" for="tempat_pembumian_tidak_baik">Tidak Baik</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Handel Apar -->
                    <div class="form-group">
                        <div class="col-lg-12">
                            <label class="form-label">Penangkal Petir (Grounding)</label>
                        </div>

                        <div class="col-lg-7">
                            <ul class="custom-control-group g-3 align-center flex-wrap">
                                <li>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="penangkal_petir" value="baik" id="penangkal_petir_baik" required>
                                        <label class="custom-control-label" for="penangkal_petir_baik">Baik</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="penangkal_petir" value="tidak baik" id="penangkal_petir_tidak_baik" required>
                                        <label class="custom-control-label" for="penangkal_petir_tidak_baik">Tidak Baik</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Keterangan</label>
                        <div class="form-control-wrap">
                            <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
                        </div>
                    </div>

                    <!-- Tindak Lanjut -->
                    <div class="form-group">
                        <label class="form-label">Tindak Lanjut</label>
                        <div class="form-control-wrap">
                            <textarea class="form-control" name="tindak_lanjut" id="tindak_lanjut"></textarea>
                        </div>
                    </div>

                    

                    <hr class="preview-hr">
                    <button type="submit" class="btn btn-sm text-white" style="background-color: green" id="btn-submit">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
