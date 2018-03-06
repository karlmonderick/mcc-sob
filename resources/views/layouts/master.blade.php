<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>        
        <!-- META SECTION -->
        <title>SOB</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="/css/theme-default.css"/>

        <!-- EOF CSS INCLUDE -->                                      
    </head>
    <style type="text/css">
        input[type=text] {
            text-transform: capitalize;
        }
    </style>
    <body class="page-container-boxed">
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            
            <!-- START PAGE SIDEBAR -->
                <div class="page-sidebar">
                    <!-- START X-NAVIGATION -->
                    <ul class="x-navigation">
                        <li class="xn-logo">
                            <a href="{{ route('home') }}">SOB</a>
                            <a href="#" class="x-navigation-control"></a>
                        </li>
                        <li class="xn-profile">
                            
                            <a href="#" class="profile-mini">
                                <img style="height: 30px;" src="/uploads/{{Auth::user()->photo}}" alt="profile picture"/>
                            </a>
                            
                            <div class="profile">
                                <div class="profile-image">
                                    <img style="height: 95px;" src="/uploads/{{Auth::user()->photo}}" alt="profile picture"/>
                                </div>
                                <div class="profile-data">
                                <div class="profile-data-name">{{ $auth->first_name }} {{ $auth->last_name }}</div>
                                    <div class="profile-data-title">
                                        @php
                                            switch ( $auth->role_id ) {
                                            case 1:
                                                echo "OSCA COORDINATOR";
                                                break;
                                            case 2:
                                                echo "IGP";
                                                break;
                                            case 3:
                                                echo "SAS DIRECTOR";
                                                break;
                                            case 4:
                                                echo "{
                                                    $user_org->position}";
                                                break;
                                            case 5:
                                            echo "ADMIN";
                                            break;    
                                            }
                                        @endphp
                                            </br>
                                            @if($auth->role_id==4)
                                                {{ $user_org->name }}
                                            @endif
                                    </div>
                                </div>
                                <div class="profile-controls">
                                @foreach($user as $user)
                                    <a href="{{ route('users.show', $auth->id) }}" class="profile-control-left"><span class="fa fa-cog"></span></a>  @endforeach
                                    <!--
                                    <a href="pages-messages.html" class="profile-control-right"><span class="fa fa-envelope"></span></a>-->
                                </div>
                            </div>                                                                        
                        </li>
                        <li class="xn-title">Navigation</li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/home') }}"><em class="fa fa-dashboard"></em> <span class="xn-text">Dashboard</span> <span class="sr-only"></span></a></li>
                        
                        <!-- SHOW IF OSCA OR SAS -->
                        @if(Auth::user()->role_id == 3)
                            <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}"><em class="fa fa-user"></em> <span class="xn-text">Users</span> <span class="sr-only"></span></a></li>
                        @endif
                        @if($auth->role_id==1 OR $auth->role_id==3)
                            <li class="nav-item"><a class="nav-link" href="{{ route('institutes.index') }}"><em class="fa fa-building"></em> <span class="xn-text">Institutes</span>  <span class="sr-only"></span></a></li>
                        @endif   
                        @if(Auth::user()->role_id == 1)
                            <li class="nav-item"><a class="nav-link" href="{{ route('organizations.index') }}"><em class="fa fa-group"></em> <span class="xn-text">Organizations</span> <span class="sr-only"></span></a></li>
                        @endif                 
                    
                        @if($auth->role_id!=2 || $auth->role_id!=3) 
                            <li class="xn-openable">
                                <a href="#"><i class="fa fa-sitemap fa-fw"></i> <span class="xn-text">Academic Year</span><span class="fa arrow"></span></a>       
                                @include('academic_years.index')
                            </li>
                        @endif 
                    </ul>
                    <!-- END X-NAVIGATION -->
                </div>
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->
                <div class="page-content">
                
                    <!-- START X-NAVIGATION VERTICAL -->
                
                    <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                        <!-- TOGGLE NAVIGATION -->
                        <li class="xn-icon-button">
                            <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                        </li>
                        <!-- END TOGGLE NAVIGATION -->
                        <!-- SIGN OUT -->
                        <li class="xn-icon-button pull-right">
                            <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>                        
                        </li> 
                        <!-- END SIGN OUT -->
                        <!-- Time -->

                        @if($auth->role_id==1)
                            @include('layouts.master_osca')
                        @elseif($auth->role_id==3)
                            @include('layouts.master_sas')
                        @elseif($auth->role_id==4)
                            @include('layouts.master_student')
                        @endif
                        

                    </ul>
                    <!-- END X-NAVIGATION VERTICAL -->                    
               
                    @include('errors.message')

                    @yield('content')
                    <!-- END PAGE CONTENT WRAPPER -->                
                </div>                                               
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Are you sure you want to log out?</p>                    
                        <p>Press No if you want to continue work. Press Yes to logout current user.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="{{ route('logout') }}" class="btn btn-success btn-lg"
                               onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                                Yes
                            </a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>



        <!-- START PRELOADS -->
        <audio id="audio-alert" src="/audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="/audio/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->          
        
    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="/js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="/js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="/js/plugins/bootstrap/bootstrap.min.js"></script> 
        <script type='text/javascript' src='/js/plugins/bootstrap/bootstrap-datepicker.js'></script>       
        <!-- END PLUGINS -->

        <!-- START THIS PAGE PLUGINS-->        
        <script type='text/javascript' src='/js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        <script type='text/javascript' src='/js/plugins/bootstrap/bootstrap-datepicker.js'></script>                
        <script type="text/javascript" src="/js/plugins/owl/owl.carousel.min.js"></script>                 

        <script type="text/javascript" src="/js/plugins/moment.min.js"></script>
        <script type="text/javascript" src="/js/plugins/daterangepicker/daterangepicker.js"></script>
        <script type="text/javascript" src="/js/plugins/sparkline/jquery.sparkline.min.js"></script>
        <script type="text/javascript" src="/js/plugins/knob/jquery.knob.min.js"></script>
       
        <!-- END THIS PAGE PLUGINS-->    
        <script type="text/javascript" src="/js/plugins/summernote/summernote.js"></script>  
        <script type='text/javascript' src='/js/plugins/jquery-validation/jquery.validate.js'></script>  
        <script type='text/javascript' src='/js/plugins/maskedinput/jquery.maskedinput.min.js'></script> 
        

        <!-- START TEMPLATE -->
        <!-- <script type="text/javascript" src="js/settings.js"></script> -->
        
        <script type="text/javascript" src="/js/plugins.js"></script>        
        <script type="text/javascript" src="/js/actions.js"></script>  
        <script type="text/javascript" src="/js/plugins/tocify/jquery.tocify.min.js"></script>    
        <script type="text/javascript" src="/js/plugins/bootstrap/bootstrap-select.js"></script>  
        <!-- END TEMPLATE -->

        <!-- DataTables JavaScript -->
        <script type="text/javascript" src="/js/plugins/datatables/jquery.dataTables.min.js"></script>  
    <!-- END SCRIPTS -->         
    </body>
</html>






