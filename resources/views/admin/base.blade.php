@extends('layouts.admin')

@section('body')
    <body class="page-body">

    <div class="page-container">
        <div class="sidebar-menu toggle-others fixed">

            <div class="sidebar-menu-inner">

                <header class="logo-env">

                    <!-- logo -->
                    <div class="logo">
                        <a href="{{ route('admin.home') }}" class="logo-expanded">
                            <img src="{{ asset('admin/images/logo@2x.png') }}" width="80" alt="" />
                        </a>

                        <a href="{{ route('admin.home') }}" class="logo-collapsed">
                            <img src="{{ asset('admin/images/logo-collapsed@2x.png') }}" width="40" alt="" />
                        </a>
                    </div>

                    <!-- This will toggle the mobile menu and will be visible only on mobile devices -->
                    <div class="mobile-menu-toggle visible-xs">
                        <a href="#" data-toggle="user-info-menu">
                            <i class="fa-bell-o"></i>
                            <span class="badge badge-success">7</span>
                        </a>

                        <a href="#" data-toggle="mobile-menu">
                            <i class="fa-bars"></i>
                        </a>
                    </div>

                </header>

                <ul id="main-menu" class="main-menu">
                    <li @if(isset($activeTab) && $activeTab == 'home') class="active opened active" @endif>
                        <a href="{{ route('admin.home') }}">
                            <i class="linecons-cloud"></i>
                            <span class="title">数据统计</span>
                        </a>
                    </li>

                    <li @if(isset($activeTab) && ($activeTab=='mill.index' || $activeTab=='millClasses.index')) class="active opened active" @endif>

                        <a href="{{ route('mill.index') }}">
                            <i class="linecons-money"></i>
                            <span class="title">矿机管理</span>
                        </a>
                        <ul>
                            <li @if(isset($activeTab) && $activeTab == 'millClasses.index') class="active" @endif>
                                <a href="{{ route('millClasses.index') }}">
                                    <span class="title">矿机分类</span>
                                </a>
                            </li>
                            <li @if(isset($activeTab) && $activeTab == 'mill.index') class="active" @endif>
                                <a href="{{ route('mill.index') }}">
                                    <span class="title">矿机列表</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>

        </div>

        <div class="main-content">

            <!-- User Info, Notifications and Menu Bar -->
            <nav class="navbar user-info-navbar" role="navigation">

                <!-- Left links for user info navbar -->
                <ul class="user-info-menu left-links list-inline list-unstyled">

                    <li class="hidden-sm hidden-xs">
                        <a href="#" data-toggle="sidebar">
                            <i class="fa-bars"></i>
                        </a>
                    </li>

                </ul>


                <!-- Right links for user info navbar -->
                <ul class="user-info-menu right-links list-inline list-unstyled">

                    <li class="dropdown user-profile">
                        <a href="#" data-toggle="dropdown">
                            <img src="{{ asset('admin/images/logo-collapsed@2x.png') }}" alt="user-image" class="img-circle img-inline userpic-32" width="28" />
                            <span>
								{{--{{ auth('admin')->user()->name }}--}}
								<i class="fa-angle-down"></i>
							</span>
                        </a>

                        <ul class="dropdown-menu user-profile-menu list-unstyled">
                            <li>
                                <a href="#help">
                                    <i class="fa-info"></i>
                                    帮助
                                </a>
                            </li>
                            <li class="last">
                                <a href="{{ route('admin.logout') }}">
                                    <i class="fa-lock"></i>
                                    退出
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

            </nav>

            @yield('top')

            @if(count($errors) > 0)
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Close</span>
                    </button>

                    <strong>错误提示 !</strong>&nbsp;&nbsp;&nbsp;
                    @foreach ($errors->all() as $error){{ $error }}@endforeach
                </div>
            </div>
            @endif

            @if(isset($errorMessage) && count($errorMessage) > 0)
                <div class="col-md-12">
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>

                        <strong>错误提示 !</strong>&nbsp;&nbsp;&nbsp;
                        {{ $errorMessage }}
                    </div>
                </div>
            @endif

            @yield('content')

            <!-- Main Footer -->
            <footer class="main-footer sticky footer-type-1">

                <div class="footer-inner">

                    <!-- Add your copyright text here -->
                    <div class="footer-text">
                        &copy; 2018-2019
                        <strong>Nodeasy</strong>
                    </div>


                    <!-- Go to Top Link, just add rel="go-top" to any link to add this functionality -->
                    <div class="go-up">

                        <a href="#" rel="go-top">
                            <i class="fa-angle-up"></i>
                        </a>

                    </div>

                </div>

            </footer>
        </div>

    </div>

    <script src="{{ asset('/org/layer/layer.js') }}"></script>

@endsection