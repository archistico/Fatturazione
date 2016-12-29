<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Fatturazione | Generale</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include 'link.php'; ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini" onload="startTime()">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="index.php" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>F</b>AT</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>FATTUR</b>AZIONE</span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="dist/img/avatar3.png" class="user-image" alt="User Image">
                                    <span class="hidden-xs">Emilie Rollandin</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="dist/img/avatar3.png" class="img-circle" alt="User Image">
                                        <p>
                                            Emilie Rollandin
                                            <small>Amministratore</small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-right">
                                            <a href="#" class="btn btn-default btn-flat">Logout</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <?php
                    $menugenerale = 1; $menuclienti = 0; $menuprodotti = 0; $menuddt = 0; $menufatture = 0; $menustatistiche = 0;
                    include 'sidebarmenu.php';
                    ?>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                
                <?php
                include 'php/utilita.php';
                ?>
                
                <section class="content-header">
                    <h1>
                        Generale
                        <small>Principale</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Generale</a></li>
                        <li class="active">Principale</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">INFORMAZIONI</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="col-md-6 col-xs-12">
                                        <h1>
                                            MACELLERIA PEAQUIN <small>snc</small>
                                        </h1>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <h1>
                                            <span id="orario" class="pull-right"></span>
                                        </h1>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                                        
                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="ion ion-calculator"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Totale venduto</span>
                                    <span class="info-box-number">2016</span>
                                    <span class="info-box-number"><small>&euro; 1000.00</small></span>
                                </div>
                            <!-- /.info-box-content -->
                            </div>
                        <!-- /.info-box -->
                        </div>

                        <div class="col-md-4 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-aqua"><i class="ion ion-ribbon-b"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Migliore cliente</span>
                                    <span class="info-box-number">Emilie Rollandin</span>
                                    <span class="info-box-number"><small>&euro; 1000.00</small></span>
                                </div>
                            <!-- /.info-box-content -->
                            </div>
                        <!-- /.info-box -->
                        </div>

                        <div class="col-md-4 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="ion ion-trophy"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Migliore prodotto</span>
                                    <span class="info-box-number">Bovino - Affettato</span>
                                    <span class="info-box-number"><small>&euro; 1000.00</small></span>
                                </div>
                            <!-- /.info-box-content -->
                            </div>
                        <!-- /.info-box -->
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">MENU RAPIDO</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <a class="btn btn-app" href="clientenuovo.php">
                                        <i class="fa fa-user"></i> + Cliente
                                    </a>
                                    <a class="btn btn-app" href="prodottonuovo.php">
                                        <i class="fa fa-barcode"></i> + Prodotto
                                    </a>
                                    <a class="btn btn-app" href="ddtnuovo.php">
                                        <i class="fa fa-truck"></i> + DDT
                                    </a>
                                    <a class="btn btn-app" href="fatturanuova.php">
                                        <i class="fa fa-table"></i> + Fattura
                                    </a>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>

                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <?php include 'footer.php'; ?>
        </div>
        <!-- ./wrapper -->
        
        <?php include 'script.php'; ?>
    </body>
    <!-- page script -->
    <script>
        function startTime() {
            var today = new Date();

            var dd = today.getDate();
        	var mm = today.getMonth()+1; //January is 0!
        
        	var yyyy = today.getFullYear();
        	if(dd<10){
            	dd='0'+dd;
        	} 
        	if(mm<10){
               mm='0'+mm;
        	} 
        	var oggi = dd+'/'+mm+'/'+yyyy;

            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('orario').innerHTML = oggi + " - " + h + ":" + m + ":" + s;
            var t = setTimeout(startTime, 500);
        }
        function checkTime(i) {
            if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
            return i;
        }
    </script>
</html>

