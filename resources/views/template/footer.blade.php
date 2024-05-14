

                    <!-- footer @s -->
                    <div class="nk-footer d-none">
                        <div class="container-fluid">
                            <div class="nk-footer-wrap">
                                <div class="nk-footer-copyright"> &copy; <?php echo date('Y') ?> Puskesmas Kagok</a>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <!-- footer @e -->
                </div>
                <!-- wrap @e -->
            </div>
            <!-- main @e -->
        </div>

        <!-- END OF CONTENT -->
        
        {{-- </div>
    </div>         --}}

    <!-- ================================================================ -->
    <!-- Modal untuk update profile -->
    <!-- ================================================================ -->

    <div class="modal fade" role="dialog" id="profile-edit">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title">Update Profile</h5>
                    <ul class="nk-nav nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personal">Personal</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#address">Address</a>
                        </li> --}}
                    </ul><!-- .nav-tabs -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="personal">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name">Nama Agent</label>
                                        <input type="text" class="form-control form-control-lg" id="nama-agent" value="{{ session()->get('nama_agent') }}" placeholder="Enter Full name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="display-name">Email</label>
                                        <input type="email" class="form-control form-control-lg" id="email" value="{{ session()->get('email') }}" placeholder="Enter email" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <button data-bs-dismiss="modal" type="submit" class="btn btn-lg btn-primary" id="update-profile">Update Profile</button>
                                        </li>
                                        <li>
                                            <a href="#" data-bs-dismiss="modal" class="link link-light">Cancel</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div><!-- .tab-pane -->
                        {{-- <div class="tab-pane" id="address">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="address-l1">Address Line 1</label>
                                        <input type="text" class="form-control form-control-lg" id="address-l1" value="2337 Kildeer Drive">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="address-l2">Address Line 2</label>
                                        <input type="text" class="form-control form-control-lg" id="address-l2" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="address-st">State</label>
                                        <input type="text" class="form-control form-control-lg" id="address-st" value="Kentucky">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="address-county">Country</label>
                                        <select class="form-select js-select2" id="address-county" data-ui="lg">
                                            <option>Canada</option>
                                            <option>United State</option>
                                            <option>United Kindom</option>
                                            <option>Australia</option>
                                            <option>India</option>
                                            <option>Bangladesh</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <a href="#" class="btn btn-lg btn-primary">Update Address</a>
                                        </li>
                                        <li>
                                            <a href="#" data-bs-dismiss="modal" class="link link-light">Cancel</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div> --}}
                    </div><!-- .tab-content -->
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div><!-- .modal -->

    {{-- Modals Change Password --}}
    <div class="modal fade" id="changePassword">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">Change Password</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form  class="form-validate is-alter" id="formChangePassword">
                        
                        
                        <div class="form-group" id="formPassword">
                            <label class="form-label" for="password">Current Password</label>
                            <div class="form-control-wrap">
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>
                        </div>
                        <div class="form-group" id="formPassword">
                            <label class="form-label" for="password">New Password</label>
                            <div class="form-control-wrap">
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                        </div>
                        <div class="form-group" id="formPassword">
                            <label class="form-label" for="password">Confirmation Password</label>
                            <div class="form-control-wrap">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                        </div>
    
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg text-white" style="background-color: #FE7B1C">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changeRingtone">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title">Change Ringtone</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="#" class="form-validate is-alter" id="formChangeRingtone">
                        @csrf
                        {{-- <input type="hidden" id="id_change" name="id_change"> --}}
                        
                        <div class="form-group" id="formRingtone">
                            <label class="form-label" for="ringtone">New Ringtone</label>
                            <div class="form-control-wrap">
                                <input type="file" class="form-control" id="new_ringtone" name="new_ringtone" required>
                            </div>
                        </div>
                        
    
                        <div class="form-group">
                            <button type="submit" class="btn btn-lg text-white" style="background-color: #FE7B1C">Simpan</button>
                        </div>
                    </form>
                </div>
                {{-- <div class="modal-footer bg-light">
                    <span class="sub-text">Modal Footer Text</span>
                </div> --}}
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/libs/datatable-btns.js') }}"></script>
    <script src="{{ asset('assets/js/apps/moment.js') }}"></script>
    <script src="{{ asset('assets/js/apps/chats.js') }}"></script>
    {{-- <script src="{{ asset('/assets/js/libs/toastr.min.js')}}"></script> --}}
    {{-- <script src="{{ asset('/assets/js/example-toastr.js') }}"></script>     --}}

    {{-- <script src="{{ asset('assets/js/charts/chart-ecommerce.js?ver=3.1.0') }}"></script> --}}
    <script src="<?php echo asset('/assets/js/page/login.js') ?>"></script>
    <script src="<?php echo asset('/assets/js/plugins/axios.min.js') ?>"></script>

    <script type="text/javascript">

        var session = "{{ current_session_hex() }}"
        globalThis.base_url = "<?php echo url('/'); ?>"
        var idleTime = 0;

        $('#formChangePassword').submit(function(e) {
            e.preventDefault();

            var data = new FormData(this);
            let validate = $(this).valid();

            if(validate){
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    url: '/change_password',
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    data: data,
                    success: function(res) {
                        if(res.status) {
                            Swal.fire(
                                "Success change password",
                                '',
                                "success"
                            );
                            $('#changePassword').modal('hide');
                        } else {
                            Swal.fire(
                                "Gagal change password",
                                '',
                                "error"
                            );
                        }
                    }
                })
            }
        })

        $(document).ready(function () {
            // Increment the idle time counter every minute.

            // Zero the idle timer on mouse movement.
            $(this).mousemove(function (e) {
                idleTime = 0;
            });
            $(this).keypress(function (e) {
                idleTime = 0;
            });
        });

        // inisialisasi color pick (tidak terpakai saat ini)
        Coloris({
            el: '.coloris'
        });

        function hex2a(hexx) {
            var hex = hexx.toString(); //force conversion
            var str = "";
            for (var i = 0; i < hex.length; i += 2)
                str += String.fromCharCode(parseInt(hex.substr(i, 2), 16));
            return str;
        }

        // dedoced session
        let decoded_session = JSON.parse(hex2a(session));

        function showAlert() {
            NioApp.Toast('Ada pesan yang belum anda baca !', 'warning', {
                position: 'top-right',
                "closeButton": false,
            });
        }

      
       

        // list notifikasi
        let list_notif = `<div class="nk-notification-item dropdown-inner" << style >>>
                            <div class="nk-notification-icon">
                                <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                            </div>
                            <div class="nk-notification-content">
                                <a href="#">
                                    <div class="nk-notification-text"><< notif_message >></div>
                                    <div class="nk-notification-time"><< notif_from >></div>
                                </a>
                            </div>
                        </div>`


        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            'positionClass':'toast-top-right',
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        // dark switch (dark or not)
        $(".dark-switch").click(function () {
            $.ajax({
                type: "POST",
                url: base_url + "/changeTheme",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            })
        });

        // Update Profile
        $("#update-profile").submit(function () {

            let name = $('#nama-agent').val();
            let email = $('#email').val();

            $.ajax({
                type: "POST",
                url: base_url + "/updateProfile",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: {
                    name: name,
                    email: email
                }
            }).done(function(res) {
                if(res.status) {
                    Swal.fire(
                        res.message,
                        '',
                        "success"
                    );
                } else {
                    Swal.fire(
                        res.message,
                        '',
                        "error"
                    );
                }
            })
        })

        // Change Password
      

        // Logout user agent
        function logout() {
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: '/logout',
                success: function(res) {
                    if(res.metadata.status == 200) {
                        
                        // clear local storage
                        localStorage.clear();

                        // redirect to login
                        location.href = '/login'

                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Masih ada session yang belum tertutup !',
                            html: '',
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading()
                                const b = Swal.getHtmlContainer().querySelector('b')
                                timerInterval = setInterval(() => {
                                    b.textContent = Swal.getTimerLeft()
                                }, 2000)
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        });
                    }
                }
            })
        }


        // notifikasi chat baru (di lonceng) tujuanya utk lihat list notif di satu divisi
        // sekarang dipake buat runAudioSirine

    </script>

    <script type="text/javascript"> 
        var base_url_server = "<?php echo (env('APP_ENV') == 'development') ?  "http://192.168.20.100:6969" : "https://wahook.nexagroup.id"?>"
        var base_url        = "<?php echo env('APP_URL') ?>"

    </script>

    {{-- <script src="<?php echo asset('/assets/js/page/main.js') ?>"></script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.1/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.1/mode/javascript/javascript.min.js"></script>
    

    <?php echo $js ?>

</body>

</html>