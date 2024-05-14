
<html lang="zxx" class="js">

<head>
    <!-- <base href="<?php base_asset() ?>"> -->
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">

    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.1/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.1/theme/material.min.css">
    
    <!-- Page Title  -->
    <title>Puskesmas Kagok App</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <style>
        /* CSS */
        .shimmer {
            width: 100%;
            height: 100%;
            /* background: linear-gradient(to right, #fafafa 0%, #f4f4f4 20%, #fafafa 40%, #f4f4f4 60%, #fafafa 80%, #f4f4f4 100%); */
            background-size: 1000% 1000%;
            animation : shimmer 2s infinite;
            background: linear-gradient(to right,#eff1f3 4%,#e2e2e2 30%,#eff1f3 36%);
        }

        /* .content {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f4f4f4;
        } */
      

        @keyframes shimmer {
            0% {
                background-position: -100px 0;
            }
            100% {
                background-position: 100px 0;
            }
        }

        .CodeMirror .string-token {
            color: green; /* Color for strings */
            font-weight: bold; /* Bold font for strings */
        }
            
    </style>

    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?php echo asset('/assets/css/dashlite1.css') ?>">
    <link rel="stylesheet" href="<?php echo asset('/assets/css/libs/toastr.css') ?>">
    <script src="<?php echo asset('/assets/js/libs/toastr.min.js') ?>"></script>    
    <link id="skin-default" rel="stylesheet" href="<?php echo asset('/assets/css/theme.css')?>">

    {{-- cdn color pick js --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.css"/>
    <script src="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.js"></script>

    <script>
        // inisialisasi color pick in all page
        Coloris({
            el: '.coloris',
            swatches: [
                '#264653',
                '#2a9d8f',
                '#e9c46a',
                '#f4a261',
                '#e76f51',
                '#d62828',
                '#023e8a',
                '#0077b6',
                '#0096c7',
                '#00b4d8',
                '#48cae4'
            ]
            });
    </script>

    @csrf

</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-sidebar-brand">
                        <a href="{{ base_url('/dashboard') }}" class="logo-link nk-sidebar-logo">
                            <img class="logo-dark logo-img" src="{{ base_url('/images/main_logo.png') }}" alt="logo">
                            <img class="logo-light logo-img" src="{{ base_url('/images/main_logo.png') }}" srcset="https://minio.nexa.net.id/wahook/logo_nexa_white.png 2x" alt="logo-dark">
                            <img class="logo-small logo-img logo-img-small" src="<?php echo asset('favicon.png')?>" srcset="<?php echo asset('favicon.png')?> 2x" alt="logo-small">
                        </a>
                    </div>
                    <div class="nk-menu-trigger me-n2">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                        <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                    </div>
                </div><!-- .nk-sidebar-element -->
                <div class="nk-sidebar-element">
                    <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar>
                            <ul class="nk-menu">
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">Menu</h6>
                                </li><!-- .nk-menu-item -->

                                <!-- Ambil menu dari controller -->

                                <?php echo $menu ?>


                            </ul><!-- .nk-menu -->
                        </div><!-- .nk-sidebar-menu -->
                    </div><!-- .nk-sidebar-content -->
                </div><!-- .nk-sidebar-element -->
            </div>
            <!-- sidebar @e -->
             <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <div class="nk-header nk-header-fixed is-light">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">
                            <div class="nk-menu-trigger d-xl-none ms-n1">
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                            </div>
                            <div class="nk-header-brand d-xl-none">
                                <a href="{{route('dashboard')}}" class="logo-link">
                                    <img class="logo-light logo-img" src="{{ base_url('/images/main_logo.png') }}" srcset="{{ base_url('/images/main_logo.png') }} 2x" alt="logo">
                                    <img class="logo-dark logo-img" src="{{ base_url('/images/main_logo.png') }}" srcset="{{ base_url('/images/main_logo.png') }} 2x" alt="logo-dark">
                                </a>
                            </div><!-- .nk-header-brand -->
                            
                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">
                                    <li class="dropdown notification-dropdown">
                                        <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-bs-toggle="dropdown">
                                            <div id="notifTotal" class=""><em class="icon ni ni-bell"></em></div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                            <div class="dropdown-head">
                                                <span class="sub-title nk-dropdown-title">Notifications</span>
                                                <a href="#" id="markAsRead">Mark All as Read</a>
                                            </div>
                                            <div class="dropdown-body">
                                                <div class="nk-notification">
                                                    {{-- <div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon">
                                                            <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <a href="">
                                                                <div class="nk-notification-text">You have requested to <span>Widthdrawl</span></div>
                                                                <div class="nk-notification-time">2 hrs ago</div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="nk-notification-item dropdown-inner" style="background: #dbdbdb">
                                                        <div class="nk-notification-icon">
                                                            <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <a href="">
                                                                <div class="nk-notification-text">You have requested to <span>Widthdrawl</span></div>
                                                                <div class="nk-notification-time">2 hrs ago</div>
                                                            </a>
                                                        </div>
                                                    </div> --}}
                                                </div><!-- .nk-notification -->
                                            </div><!-- .nk-dropdown-body -->
                                            {{-- <div class="dropdown-foot center">
                                                <a href="#">View All</a>
                                            </div> --}}
                                        </div>
                                    </li>
                                    <li class="dropdown user-dropdown">
                                        <a href="#" class="dropdown-toggle me-n1" data-bs-toggle="dropdown">
                                            <div class="user-toggle">
                                                <div class="user-avatar sm" style="background-color: #FE7B1C">
                                                    <em class="icon ni ni-user-alt"></em>
                                                </div>
                                                <div class="user-info d-none d-xl-block">
                                                    <div class="user-status user-status-unverified">Halo</div>
                                                    <div class="user-name dropdown-indicator"><?php echo session()->get('username') ?></div>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end">
                                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                                <div class="user-card">
                                                    <div class="user-avatar text-whire" style="background-color: #FE7B1C">
                                                        <span>{{ strtoupper(substr(session()->get('username'), 0,1)) }}</span>
                                                    </div>
                                                    <div class="user-info">
                                                        <span class="lead-text"><?php echo session()->get('username') ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    {{-- <li><a href="#" data-bs-toggle="modal" data-bs-target="#profile-edit"><em class="icon ni ni-user-alt"></em><span>Update Profile</span></a></li> --}}
                                                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#changePassword"><em class="icon ni ni-exchange"></em><span>Change Password</span></a></li>
                                                    {{-- <li><a href="#" data-bs-toggle="modal" data-bs-target="#changeRingtone"><em class="icon ni ni-bell-fill"></em><span>Change Ringtone</span></a></li> --}}
                                                    
                                                    {{-- <li><a href="html/user-profile-regular.html"><em class="icon ni ni-user-alt"></em><span>View Profile</span></a></li> --}}
                                                    {{-- <li><a href="html/user-profile-setting.html"><em class="icon ni ni-setting-alt"></em><span>Account Setting</span></a></li> --}}
                                                    {{-- <li><a href="html/user-profile-activity.html"><em class="icon ni ni-activity-alt"></em><span>Login Activity</span></a></li> --}}
                                                    {{-- <li><a class="dark-switch" href="#"><em class="icon ni ni-moon" id="dark-switch"></em><span>Dark Mode</span></a></li> --}}
                                                    {{-- <li><em class="icon ni ni-moon" id="dark-switch"></em><span>Dark Mode</span><input type="checkbox" class="dark-switch active" checked id="dark-switch"></li> --}}
                                                </ul>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a href="{{route('logout')}}" onclick="logout()" ><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- .nk-header-wrap -->
                    </div><!-- .container-fliud -->
                </div>
