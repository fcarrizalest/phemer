<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Phener | Dashboard</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.1 -->
     <link href="{{{$INETROOT}}}/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.2.0 -->
    <link href="{{{$INETROOT}}}/dist/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="{{{$INETROOT}}}/dist/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Theme style -->
    <link href="{{{$INETROOT}}}/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="{{{$INETROOT}}}/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <link href="{{{$INETROOT}}}/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">

    .content .user-panel{
      list-style: none;
      
    }
    .content .user-panel .user-header{
      text-align: center;

    }
    </style>
  </head>
  <body class="skin-black">
    <div class="wrapper">
      <!-- header logo: style can be found in header.less -->
      <header class="main-header">
        <!-- Logo -->
        <a href="{{{$INETROOT}}}/" class="logo">Phener</a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              

              <!-- Notifications: style can be found in dropdown.less -->
              
              <!-- Tasks: style can be found in dropdown.less -->
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="{{{$INETROOT}}}/dist/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                  <span class="hidden-xs">{{{ $username or 'Guest' }}}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="{{{$INETROOT}}}/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
                    <p>
                      {{{ $username or 'Guest' }}} - Web Developer
                      <small>Member since Nov. 2012</small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="{{{$INETROOT}}}/logout" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>



















      <!-- Left side column. contains the logo and sidebar -->
      <aside class="left-side">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="{{{$INETROOT}}}/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p> {{{ $username or 'Guest' }}}</p>

             
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-gear "></i> <span>Configuration</span> <i class="fa fa-angle-left pull-right"></i>
              </a>


              <ul class="treeview-menu">
                
                  @section('main_menu')
                  
                  @if ( in_array( "administer users"  , $permission ))
                   <li><a href="{{{$INETROOT}}}/people"><i class="fa fa-angle-double-right"></i> People</a></li>
                  @endif

                  @if ( in_array( "administer permissions"  , $permission ))
                   <li><a href="{{{$INETROOT}}}/people/roles"><i class="fa fa-angle-double-right"></i> Roles</a></li>
                  @endif

                  @if ( in_array( "administer permissions"  , $permission ))
                   <li><a href="{{{$INETROOT}}}/people/permissions"><i class="fa fa-angle-double-right"></i> Permissions</a></li>
                  @endif

                
                  @show

              </ul>


            </li>
            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
























      <!-- Right side column. Contains the navbar and content of the page -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

          @yield('content-header')
          
          <ol class="breadcrumb">
            <li><a href="{{{$INETROOT}}}/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>




        <!-- Main content -->
        <section class="content">

          @if ( is_array( $flash->getMessages() )    )
             
             @foreach($flash->getMessages() as $error)

                <div class="alert alert-danger alert-dismissable">                                        
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Error!</h4>
                    {{{$error}}}
                  </div>

                
            @endforeach
            
        @endif

           @yield('content')
        </section><!-- /.content -->

      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.0
        </div>
        <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights reserved.
      </footer>
    </div><!-- ./wrapper -->
     <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js" type="text/javascript"></script>

   

    <script src="{{{$INETROOT}}}/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="{{{$INETROOT}}}/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <script src="{{{$INETROOT}}}/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>

     <script type="text/javascript">
      $(function () {
        
        $('#example2').dataTable({
          "bPaginate": false,
          "bLengthChange": true,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
    </script>

    <script src="{{{$INETROOT}}}/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    
    <!-- AdminLTE App -->
    <script src="{{{$INETROOT}}}/dist/js/app.js" type="text/javascript"></script>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    
    <!-- AdminLTE for demo purposes -->
    
  </body>
</html>