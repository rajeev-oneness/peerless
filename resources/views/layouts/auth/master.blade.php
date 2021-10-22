<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$APP_data->APP__name}} | @yield('title')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/croppie/croppie.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/custom.css') }}">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button" title="Fullscreen">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" data-widget="control-sidebar" data-slide="true" role="button" title="Sign out" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt text-danger"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('home') }}" class="brand-link">
                <img src="{{ asset('admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset(Auth::user()->image_path) }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="{{ route('user.profile') }}" class="d-block">{{Auth::user()->name}}</a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link {{ (request()->is('home*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.employee.list') }}" class="nav-link {{ (request()->is('user/employee*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.profile') }}" class="nav-link {{ (request()->is('user/profile*')) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-circle"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                        <li class="nav-item sidebar-logout">
                            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>

                        {{-- <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Starter Pages
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Active Page</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Inactive Page</p>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}

                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('title')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item active">@yield('title')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            @yield('content')

        </div>

        @include('admin.modal.image-change-crop')

        <footer class="main-footer">
            <div class="">
                Copyright &copy; {{date('Y')}}
            </div>
        </footer>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/croppie/croppie.js') }}"></script>
    <script src="{{ asset('admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('admin/dist/js/adminlte.min.js') }}"></script>
</body>

</html>

<script>
    // toast fires | type = success, info, danger, warning
    function toastFire(type='success', title, body='') {
        $icon = 'check';
        if (type == 'info') {
            $icon = 'info-circle';
        } else if (type == 'danger') {
            $icon = 'times';
        } else if (type == 'warning') {
            $icon = 'exclamation';
        }

        $(document).Toasts('create', {
            class: 'bg-'+type,
            title: title,
            autohide: true,
            delay: 3000,
            icon: 'fas fa-'+$icon+' fa-lg',
            // body: body
        });
    }

    // on session toast fires
    @if (Session::has('success'))
        toastFire('success', '{{Session::get('success')}}');
    @elseif (Session::has('error'))
        toastFire('danger', '{{Session::get('success')}}');
    @endif

    // sweetalert delete alert
    function confirm4lert(path, id, type) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to '+type+' the record',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, '+type+' it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url : path,
                    method : 'post',
                    data : {'_token' : '{{csrf_token()}}', id : id},
                    success : function (response) {
                        if (type == 'delete') {
                            $('#tr_'+id).remove();
                            Swal.fire(
                                response.title,
                                response.message,
                                'success'
                            )
                        } else if (type == 'block') {
                            if (response.title == 'Blocked') {
                                $('#tr_'+id+' .block-button').text('BLOCKED');
                            } else {
                                $('#tr_'+id+' .block-button').text('Block');
                            }
                            Swal.fire(
                                response.title+'!',
                                response.message,
                                'success'
                            )
                        }
                    }
                });
            }
        });
    }
</script>

@yield('script')