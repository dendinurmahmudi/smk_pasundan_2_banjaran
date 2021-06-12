<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="{{ asset('assets/favicon.png') }}"/>
    <title>@yield('judul')</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('assets/templates/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="{{ asset('assets/templates/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/templates/plugins/bower_components/html5-editor/bootstrap-wysihtml5.css') }}" />
    <!-- toast CSS -->
    <!-- <link href="{{ asset('assets/templates/plugins/bower_components/toast-master/css/jquery.toast.css') }}" rel="stylesheet"> -->
    <!-- morris CSS -->
    <link href="{{ asset('assets/templates/plugins/bower_components/morrisjs/morris.css') }}" rel="stylesheet">
    <!-- chartist CSS -->
    <link href="{{ asset('assets/templates/plugins/bower_components/chartist-js/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/templates/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">
    <!-- Calendar CSS -->
    <link href="{{ asset('assets/templates/plugins/bower_components/calendar/dist/fullcalendar.css') }}" rel="stylesheet" />
    <!-- animation CSS -->
    <link href="{{ asset('assets/templates/css/animate.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('assets/templates/css/style.css') }}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{ asset('assets/templates/css/colors/megna-dark.css') }}" id="theme" rel="stylesheet">
    <link href="{{ asset('assets/templates/plugins/bower_components/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/templates/plugins/bower_components/dropify/dist/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/mystyle.css') }}">
    <link href="{{ asset('assets/templates/plugins/bower_components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<body class="fix-header">
<!-- header -->

<!-- <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div> -->

    <!-- ============================================================== -->
    <!-- Wrapper -->
    <!-- ============================================================== -->
    <div id="wrapper">

        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <nav class="navbar navbar-default navbar-static-top m-b-">
            <div class="navbar-header">
                <div class="top-left-part">
                    <!-- Logo -->
                    <a class="logo" href="/">
                        <b>
                        <img src="{{ asset('assets/favicon.png') }}" alt="home" class="dark-logo" height="30" />
                        <img src="{{ asset('assets/favicon.png') }}" alt="home" class="light-logo" height="30"/>
                     </b>
                        <span class="hidden-xs">
                        <h4 class="dark-logo">SMK Pasundan 2</h4>
                        <h4 alt="home" class="light-logo">SMK Pasundan 2</h4>
                     </span> </a>
                </div>
                <!-- /Logo -->
                <!-- Search input and Toggle icon -->
                <ul class="nav navbar-top-links navbar-left">
                    <li><a href="javascript:void(0)" class="open-close waves-effect waves-light"><i class="ti-menu"></i></a></li>
                    <li class="dropdown">
                        <a class="waves-effect waves-light" href="/chat{{ Auth::user()->hak_akses}}"> <i class="mdi mdi-gmail"></i>
                            <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                        </a>
                        <!-- /.dropdown-messages -->
                    </li>
                </ul>
                <!--  -->
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>
                        <form role="search" class="app-search hidden-sm hidden-xs m-r-10">
                            <input type="text" placeholder="Search..." class="form-control"> <a href=""><i class="fa fa-search"></i></a> </form>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="{{ asset('data_file/profile/'.Auth::user()->foto ) }}" alt="user-img" width="36" height="36" class="img-circle"><b class="hidden-xs">{{ Auth::user()->name }} </b><span class="caret"></span> </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img class="thumb-lg img-circle" src="{{ asset('data_file/profile/'.Auth::user()->foto ) }}" alt="user" /></div>
                                    <div class="u-text">
                                        <h4>{{ Auth::user()->name }}</h4>
                                        <p class="text-muted">{{ Auth::user()->email }}</p><a href="/profile{{ Auth::user()->hak_akses}}" class="btn btn-rounded btn-danger btn-sm">View Profile</a></div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="/profile{{ Auth::user()->hak_akses}}"><i class="ti-user"></i> Profil</a></li>
                            @if(Auth::user()->hak_akses=='1')
                            <li><a href="#"><i class="ti-wallet"></i> Pemberitahuan</a></li>
                            @endif
                            <li><a href="logout"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>

<!-- end header -->
<!-- sidebar -->
@yield('sidebar')
<!-- end sidebar -->
<!-- konten -->
<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title"><i class="@yield('class')"></i> @yield('label')</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="/"><i class="fa fa-dashboard fa-fw"></i>Dashboard</a></li>
                            <li class="active"><i class="@yield('class')"></i>@yield('label')</li>
                        </ol>
                    </div>
                </div>
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="{{ asset('assets/templates/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/templates/plugins/bower_components/jquery/dist/jquery.js') }}"></script>
    <script src="{{ asset('assets/js2/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/templates/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/templates/js/chat.js') }}"></script>
    <!--Morris JavaScript -->
    <script src="{{ asset('assets/templates/plugins/bower_components/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('assets/templates/plugins/bower_components/morrisjs/morris.js') }}"></script>
    <script src="{{ asset('assets/templates/js/morris-data.js') }}"></script>
    <script src="{{ asset('assets/templates/plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/templates/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js') }}"></script>
<!-- <script src="{{ asset('assets/templates/bootstrap/dist/js/bootstrap.min.js') }}"></script> -->
@yield('konten')
<!-- end konten -->
 </div>    
 <footer class=" footer text-center">
     {{date('Y')}} &copy; SMK Pasundan 2 Banjaran, BY themedesigner.in
 </footer>
</div>
</div>
    <script src="{{ asset('assets/templates/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
    <script src="{{ asset('assets/templates/js/custom.min.js') }}"></script>
    <script src="{{ asset('assets/templates/js/jasny-bootstrap.js') }}"></script>
    <script src="{{ asset('assets/templates/js/waves.js') }}"></script>
    <script src="{{ asset('assets/templates/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/templates/plugins/bower_components/dropify/dist/js/dropify.min.js') }}"></script>
    <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();
        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });
        // Used events
        var drEvent = $('#input-file-events').dropify();
        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });
        drEvent.on('dropify.afterClear', function(event, element) {
            alert('File deleted');
        });
        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });
        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });
    </script>
    <!--Counter js -->
    <script src="{{ asset('assets/templates/plugins/bower_components/waypoints/lib/jquery.waypoints.js') }}"></script>
    <script src="{{ asset('assets/templates/plugins/bower_components/counterup/jquery.counterup.min.js') }}"></script>
    <!-- chartist chart -->
    <script src="{{ asset('assets/templates/plugins/bower_components/chartist-js/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('assets/templates/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <!-- Calendar JavaScript -->
    <script src="{{ asset('assets/templates/plugins/bower_components/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/templates/plugins/bower_components/calendar/dist/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('assets/templates/plugins/bower_components/calendar/dist/cal-init.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('assets/templates/js/dashboard1.js') }}"></script>
    <!-- Custom tab JavaScript -->
    <script src="{{ asset('assets/templates/js/cbpFWTabs.js') }}"></script>
    <script type="text/javascript">
    (function() {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
            new CBPFWTabs(el);
        });
    })();
    </script>
    <!-- <script src="{{ asset('assets/templates/plugins/bower_components/toast-master/js/jquery.toast.js') }}"></script> -->
    <script src="{{ asset('assets/templates/plugins/bower_components/styleswitcher/jQuery.style.switcher.js') }}"></script>
    <script src="{{ asset('assets/templates/plugins/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js') }}"></script>
    <script src="{{ asset('assets/templates/plugins/bower_components/jquery.easy-pie-chart/easy-pie-chart.init.js') }}"></script>
    <script src="{{ asset('assets/templates/plugins/bower_components/html5-editor/wysihtml5-0.3.0.js') }}"></script>
    <script src="{{ asset('assets/templates/plugins/bower_components/html5-editor/bootstrap-wysihtml5.js') }}"></script>
    <script src="{{ asset('assets/templates/plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/templates/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js') }}"></script>


</body>

</html>
