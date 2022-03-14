<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="assets/vendor/bootstrap/css/app.css" rel="stylesheet">

    <!-- VENDOR CSS -->

    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendor/linearicons/style.css">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="assets/css/main.css">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.ico">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                                'csrfToken' => csrf_token(),
                            ]); ?>
    </script>
</head>

<body>
    <div id="app">
        <!-- WRAPPER -->
        <div id="wrapper">

            @if(!Request::is('login') && !Request::is('task_create') && !Request::is('create') && !Request::is('register')
            && Request::segment(1)!='read' && Request::segment(1)!='edit' && Request::segment(1)!='task_edit' && Request::segment(1)!='task_read'))

            <!-- NAVBAR -->
            <nav class="navbar navbar-default navbar-fixed-top">

            @if(Session::has('alert'))
                <div class="alert alert-dismissable alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>
                        {{ Session::get('alert')}}
                    </strong>
                </div>
                @endif

                <div class="brand">
                    <a href="{{url('list')}}"><img src="assets/img/bino-logo.png" alt="Logo" class="img-responsive logo"></a>
                </div>
                <div class="container-fluid">
                    <div class="navbar-btn">
                        <!-- <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button> -->
                    </div>
                    <!-- <div id="navbar-menu">
                        <ul class="nav navbar-nav navbar-right">

                            @if(Session::has('alert'))
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle icon-menu" data-toggle="collapse" data-target="#app-navbar-collapse">
                                    <i class="lnr lnr-alarm"></i>
                                    <span class="badge bg-danger">New</span>
                                </a>

                                <ul class="dropdown-menu notifications" id="app-navbar-collapse" style="margin-top: -40px;">
                                    <li><a href="#" class="notification-item"><span class="dot bg-success"></span>{{ Session::get('alert')}}</a></li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </div> -->
                </div>
            </nav>

            <!-- END NAVBAR -->

            <!-- LEFT SIDEBAR -->
            <div id="sidebar-nav" class="sidebar">
                <div class="sidebar-scroll">
                    <nav>
                        <ul class="nav">
                            <li><br>
                                <img src="assets/img/download (1).png" width="50" height="40" class="img-circle" alt="Avatar" style="margin-left: 30px; margin-top: -20px;">
                            <li style="margin-left: 90px; color: white; margin-top: -30px;">{{ Auth::user()->username }}</li>
                            </li>
                            <hr />
                            <li>
                                <a href="{{ url('/logout') }}" class="" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"><i class="lnr lnr-power-switch"></i>
                                    <span>Logout</span>
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                            <hr />
                            <li>
                                <a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-home"></i> <span>Ticketing</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                                <div id="subPages" class="collapse ">
                                    <ul class="nav">
                                        <li><a href="{{url('list')}}" id="new"><i class="lnr lnr-book"></i>Tabel Ticket</a></li>
                                        <li><a href="{{url('create')}}" id="new"><i class="lnr lnr-pencil"></i>Create Ticket</a></li>
                                    </ul>
                                </div>
                            </li>
                            @if (Auth::user()->type == 'root')
                            <li>
                                <a href="#subPages_task" data-toggle="collapse" class="collapsed"><i class="lnr lnr-briefcase"></i> <span>Task</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                                <div id="subPages_task" class="collapse ">
                                    <ul class="nav">
                                        <li><a href="{{url('task')}}" id="new"><i class="lnr lnr-book"></i>Tabel Task</a></li>
                                        <li><a href="{{url('task_create')}}" id="new"><i class="lnr lnr-pencil"></i>Create Task</a></li>
                                    </ul>
                                </div>
                            </li>
                            @endif
                            <li><a href="https://ody.binosaurus.com/cms" class=""><i class="lnr lnr-file-empty"></i> <span>Binokular Odyssey CMS</span></a></li>
                            @if (Auth::user()->type == 'root')
                            <li><a href="{{url('admin')}}" class=""><i class="lnr lnr-user"></i> <span>Admin Panel</span></a></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- END LEFT SIDEBAR -->

            @endif


            <!-- Pagiantion Link -->

            @if(!Request::is('login') && !Request::is('task_create') && !Request::is('admin') && !Request::is('create') && !Request::is('register') && Request::segment(1)!='edit'
            && Request::segment(1)!='read' && Request::segment(1)!='task_edit' && Request::segment(1)!='task_read'))
            <div style="margin-left: 240px; margin-top: 100px;">

                <center class="form-group">{{ $data->links() }}</center>

                @else

                <div style="margin-top: 20px;">
                    @endif
                    @yield('content')
                </div>
            </div>

            <!--END Pagiantion Link -->


        </div>
        <!-- END WRAPPER -->

        <!-- scroll to top -->
        <div>
            <button style="padding: 0.5em 1em; display: none; position: fixed; bottom: 20px; right: 15px; font-size: 10px;" class="btn btn-md btn-info" onclick="scroll_top()" id="tombolNya">Top</button>
        </div>
        <script>
            window.onscroll = function() {
                fungsiScrollnya()
            };
            // tombol akan muncul setelah scroll barnya di turunkan 20 pixel
            function fungsiScrollnya() {
                if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                    document.getElementById("tombolNya").style.display = "block";
                } else {
                    document.getElementById("tombolNya").style.display = "none";
                }
            }

            function scroll_top() {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0; // 0 untuk kembali kepaling atas halaman, ubah jikalau perlu
            }
        </script>
        <!-- scroll to top -->

        <!-- Scripts -->
        <script src="/js/app.js"></script>

        <!-- Javascript -->
        <script src="assets/vendor/jquery/jquery.min.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="assets/scripts/klorofil-common.js"></script>

</body>

</html>