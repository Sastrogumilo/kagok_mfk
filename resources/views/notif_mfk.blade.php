<!-- content @s -->
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">{!! $title !!}</h3>
                            <span>Isi dengan angka 0 untuk menon-aktifkan notifikasi</span>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        
                    
                                    </ul>
                                </div>
                            </div>
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                
                {{-- <div class="nk-block">
                   
                </div><!-- .nk-block --> --}}

                <div class="nk-block nk-block-sm">
                    <div class="card card-bordered card-preview">
                        <div class="card-inner">
                        <form class="form-validate is-alter" id="form-data-menu-mfk">
                           @foreach ($data_menu_mfk as $item)
                           <div class="form-group">
                                <label class="form-label">{!!$item->nama!!}</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="{{$item->menu}}" id="{{$item->menu}}" value="{{$item->jumlah}}" required>
                                </div>
                            </div>
                            @endforeach
                            <hr class="preview-hr">
                            <button type="submit" class="btn btn-sm text-white" style="background-color: green" id="btn-submit">Save</button>
                        </form>

                        </div>
                    </div><!-- .card-preview -->
                </div> <!-- nk-block -->
            </div>
        </div>
    </div>
</div>
<!-- content @e -->

