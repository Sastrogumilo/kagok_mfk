
<html lang="zxx" class="js">

<head>
    <!-- <base href="<?php base_asset() ?>"> -->
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="favicon.png">
    <!-- Page Title  -->
    <title><?php echo isset($title) ? $title : "Ini Judul" ?></title>

    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?php echo asset('./assets/css/dashlite1.css?ver=3.1.0') ?>">
    <link id="skin-default" rel="stylesheet" href="<?php echo asset('./assets/css/theme.css?ver=3.1.0')?>">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @csrf

</head>

<body class="nk-body bg-white npc-default pg-auth">
    
    <style>
        .bg-abstract2 {
    /* background-image: linear-gradient(to right, #2c3782 calc(60% - 150px), #39469f calc(60% - 150px), #39469f 60%, #4856b5 60%, #4856b5 calc(60% + 150px), #5b6ac6 calc(60% + 150px), #5b6ac6 100%); */
    background-image: url('./images/image-login.png'), url('./images/image-login-base.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    }
    </style>
    
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    
                    <div class="nk-split nk-split-page nk-split-md">
 
                        <div class="nk-split-content nk-split-stretch bg-abstract2 d-none d-md-block">
                        </div><!-- .nk-split-content -->

                        <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
                            <div class="nk-block nk-block-middle nk-auth-body">
                                <div class="brand-logo pb-2" style="margin-left: -25px">
                                    <a href="{{ url('/') }}" class="logo-link">
                                        <!-- <img class="logo-light logo-img logo-img-lg" src="./images/logo.png" srcset="./images/logo2x.png 2x" alt="logo"> -->
                                        <!-- <img class="logo-dark logo-img logo-img-lg" src="./images/logo-dark.png" srcset="./images/logo-dark2x.png 2x" alt="logo-dark"> -->
                                        <img src="{{ base_url('/images/main_logo.png') }}" alt="logo">
                                    </a>
                                </div>
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h5 class="nk-block-title">Welcome </h5>
                                        <div class="nk-block-des">
                                            <p>Please insert your username, and password to continue</p>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <div id="notification" class="mb-2"></div>
                                <form id="formlogin" action="#">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="default-01">Username</label>
                                            <!-- <a class="link link-primary link-sm" tabindex="-1" href="#">Need Help?</a> -->
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control form-control-lg" name="username" id="username" placeholder="Masukan username Anda">
                                        </div>
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">Password</label>
                                            <!-- <a class="link link-primary link-sm" tabindex="-1" href="#">Forgot Code?</a> -->
                                        </div>
                                        <div class="form-control-wrap">
                                            <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" class="form-control form-control-lg" name="password" id="password" placeholder="Masukan password Anda">
                                        </div>
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-block text-white" style="background: #FF731B">Login</button>
                                    </div>
                                </form><!-- form -->
                                
                                <!-- <div class="form-note-s2 pt-4"> New on our platform? <a href="html/pages/auths/auth-register-v3.html">Create an account</a>
                                </div>
                                <div class="text-center pt-4 pb-3">
                                    <h6 class="overline-title overline-title-sap"><span>OR</span></h6>
                                </div>
                                <ul class="nav justify-center gx-4">
                                    <li class="nav-item"><a class="nav-link" href="#">Facebook</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#">Google</a></li>
                                </ul>
                                <div class="text-center mt-5">
                                    <span class="fw-500">I don't have an account? <a href="#">Try 15 days free</a></span>
                                </div> -->
                            </div><!-- .nk-block -->
                            <div class="nk-block nk-auth-footer">
                                
                                <div class="mt-3">
                                    <p>&copy; <?php echo date('Y') ?> Puskesmas Kagok. All Rights Reserved.</p>
                                </div>
                            </div><!-- .nk-block -->
                        </div><!-- .nk-split-content -->

                    </div><!-- .nk-split -->

                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
   
    <!-- select region modal -->


     <!-- JavaScript -->
    <script src="<?php echo base_url('/assets/js/bundle.js?ver=3.1.0') ?>"></script>
    <script src="<?php echo base_url('/assets/js/scripts.js?ver=3.1.0') ?>"></script>

    <!-- Login JS -->
    <script src="<?php echo base_url('/assets/js/page/login.js') ?>"></script>
    <script type="text/javascript">
        var base_url = "<?php echo url('/'); ?>"
    </script>


</html>