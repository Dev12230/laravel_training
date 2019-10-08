<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'News') }}</title>
   <!-- Styles -->
   <link href="{{ asset('theme/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    
    {{-- Yajra Datatables --}}
    {{-- <link href="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">

</head>

<body>
    <div id="app">
        <div id="wrapper">
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav metismenu" id="side-menu">
                        <li class="nav-header">
                            <div class="dropdown profile-element">
                                <img alt="image" class="img-circle" src="{{ asset('/theme/img/profile_small.jpg')}}" />
                                </span>
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David Williams</strong>
                                        </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                    <li><a href="profile.html">Profile</a></li>
                                    <li><a href="contacts.html">Contacts</a></li>
                                    <li><a href="mailbox.html">Mailbox</a></li>
                                    <li class="divider"></li>
                                    <li><a href="login.html">Logout</a></li>
                                </ul>
                            </div>
                            <div class="logo-element">
                                IN+
                            </div>
                        </li>
                        <!-- Sidebar -->
                        <!-- ------- -->
                    <li class="active">
                        <a href="/cities"><i class="fa fa-th-large"></i><span class="nav-label">Cities</span></a> 
                    </li> 
                    @role('Admin')
                    <li class="active">
                        <a href="/roles"><i class="fa fa-th-large"></i><span class="nav-label">Roles</span></a> 
                    </li> 
                    @endrole
        
                    <li class="active">
                        <a href="/jobs"><i class="fa fa-th-large"></i><span class="nav-label">Jobs</span></a> 
                    </li> 
                    <li class="active">
                        <a href="/staff"><i class="fa fa-th-large"></i><span class="nav-label">Staff</span></a> 
                    </li> 
                    <li class="active">
                        <a href="/visitors"><i class="fa fa-th-large"></i><span class="nav-label">Visitors</span></a> 
                    </li> 

                    <li class="active">
                        <a href="/news"><i class="fa fa-th-large"></i><span class="nav-label">News</span></a> 
                    </li> 
               
               
               
                    </ul>

                </div>
            </nav>
            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li>
                                <span class="m-r-sm text-muted welcome-message">Welcome to INSPINIA+ Admin Theme.</span>
                            </li>

                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i> {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>

                        </ul>

                    </nav>
                </div>
              <!-- Start -->
                <div class="wrapper wrapper-content">
                    <!-- content  -->
                    <main class="py-4">
                        @yield('content')
                        
                    </main>

                </div>      

                <!-- End -->
                <div class="footer">
         
                    <div>
                        <strong>Copyright</strong> Ibtikar Company &copy; 2019
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- Mainly scripts -->
    <script src="{{ asset('theme/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('theme/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('theme/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Flot -->
    <script src="{{ asset('theme/js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('theme/js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('theme/js/plugins/flot/jquery.flot.spline.js') }}"></script>
    <script src="{{ asset('theme/js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('theme/js/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('theme/js/plugins/flot/jquery.flot.symbol.js') }}"></script>
    <script src="{{ asset('theme/js/plugins/flot/jquery.flot.time.js') }}"></script>

    <!-- Peity -->
    <script src="{{ asset('theme/js/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('theme/js/demo/peity-demo.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('theme/js/inspinia.js') }}"></script>
    <script src="{{ asset('theme/js/plugins/pace/pace.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('theme/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Jvectormap -->
    <script src="{{ asset('theme/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('theme/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

    <!-- DataTables  -->
    <script src="{{ asset('theme/js/plugins/dataTables/datatables.min.js') }}"></script>

    <!-- iCheck -->
    <script src="{{ asset('theme/js/plugins/iCheck/icheck.min.js') }}"></script>

    
    @stack('scripts')
</body>

</html> 
</html>



</body>

</html>