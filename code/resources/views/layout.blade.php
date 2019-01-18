<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')Admin Page</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dropify/css/dropify.min.css') }}" rel="stylesheet" >
    <link href="{{ asset('assets/summernote/summernote-bs4.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/bootstrap-timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/feathericon-release/css/feathericon.min.css') }}" rel="stylesheet">

    <style>
        .select2-container--default .select2-selection--single{
            height: 36px;
            border: 1px solid #ced4da;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 36px;
            padding-left: 12px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow{
            top: 4px;
        }
        .nav-tabs{
            border-bottom: 1px solid #ddd;
        }
        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{
            color: black !important;
            font-weight: bold;
            border: 0;
            background-color: transparent;
            border-bottom: 3px solid #dee2e6;
        }
        .nav-link:hover{
            border: 0;
        }
        .card-header-tab{
            padding: 0;
        }
        .table td{
            vertical-align: middle;
        }
    </style>
    @yield('csspage')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                Admin Page
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                </ul>

                <ul class="navbar-nav ml-auto">
                    @if(Session::has('user_active'))
                        @php
                            $menu_active = '';
                            if(Session::has('menu_active')){
                                $menu_active = Session::get('menu_active');
                            }
                            $list_menu = [
                                ['url' => '/', 'caption' => 'Dashboard'],
                                ['url' => 'user_level', 'caption' => 'User Level'],
                                ['url' => '#', 'caption' => 'Data Master', 'sub_menu' => [
                                    ['url' => 'user_level', 'caption' => 'User Level'],
                                    ['url' => 'user', 'caption' => 'User'],
                                    ['url' => 'user_log', 'caption' => 'User Log']
                                ]],
                                ['url' => 'team', 'caption' => 'Team'],
                                ['url' => 'client', 'caption' => 'Client'],
                                ['url' => 'project', 'caption' => 'Feed'],
                            ];
                            $user_active = Session::get('user_active');
                        @endphp
                        @foreach($list_menu as $menu)
                            @if($menu['url'] != '#')
                            <li class="nav-item @if($menu_active == $menu['url']) active @endif">
                                <a class="nav-link" href="{{ url($menu['url']) }}">{{ $menu['caption'] }}</a>
                            </li>
                            @else
                                <li class="nav-item dropdown nav-item-user">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ $menu['caption'] }} <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        @foreach($menu['sub_menu'] as $sub_menu)
                                        <a class="dropdown-item" href="{{ url($sub_menu['url']) }}">
                                            {{ $sub_menu['caption'] }}
                                        </a>
                                        @endforeach
                                    </div>
                                </li>
                            @endif
                        @endforeach
                        <li class="nav-item dropdown nav-item-user">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ $user_active->fullname }} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('edit_profile') }}">
                                    Edit Profile
                                </a>
                                <a class="dropdown-item" href="{{ url('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('assets/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('assets/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>
<script>
    $('.select2').select2();
    $('.dropify').dropify({
        messages: {
            'default': 'Drag and drop a file here or click',
            'replace': 'Drag and drop or click to replace',
            'remove':  'Remove',
            'error':   'File Extension Error!'
        }
    });
    $('.summernote').summernote({
        placeholder: 'Content goes here',
        tabsize: 2,
        height: 800
    });
    $('.datepicker').datepicker({
        autoclose:true,
        format:'dd-mm-yyyy',
        oritentation:"auto",
        useCurrent: false,
    });
    $('.timepicker').timepicker({
        showMeridian: false,
        showSeconds: true,
        defaultTime: false,
        icons:{
            up: 'fe fe-arrow-up',
            down: 'fe fe-arrow-down'
        }
    });
</script>
@yield('jspage')
</body>
</html>