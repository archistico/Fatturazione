<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Fatturazione | Report</title>
        <!-- Tell the browser to be responsive to screen width -->
        <?php include 'link.php'; ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
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
                    $menugenerale = 0; $menuclienti = 0; $menuprodotti = 0; $menuddt = 0; $menufatture = 0; $menustatistiche = 1;
                    include 'sidebarmenu.php';
                    ?>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                
                <section class="content-header">
                    <h1>
                        REPORT
                        <small>Mensile</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li> Home</li>
                        <li class="active">Report</li>
                        <li class="active">Mensile</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <?php
                    include 'php/utilita.php';
                    include 'php/config.php';
                    include 'php/report.php';

                    // RECUPERO DATI E AGGIUNGO
                    define('CHARSET', 'UTF-8');
                    define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);

                    ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Vendite suddivise per mesi</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <table id="reportmensile" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Mese / Anno</th>
                                                <th>Totale &euro;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php report_mensile_tabella(); ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <!-- AREA CHART -->
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Istogramma vendite (valori in Euro)</h3>
                                </div>
                                <div class="box-body">
                                    <div class="chart">
                                        <canvas id="VenditeMensiliChart" style="height:350px"></canvas>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->

                        </div>
                        <!-- /.col (LEFT) -->
                        
                    </div>
                    <!-- /.row -->

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
        $(function () {
            $('#reportmensile').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "order": [[ 1, 'desc' ]],
                "info": true,
                "autoWidth": true
            });
            
        });


        $(function () {
            //--------------
            //- AREA CHART -
            //--------------

            <?php
                VenditeMensiliGrafico();
            ?>
      
            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $("#VenditeMensiliChart").get(0).getContext("2d");
            var barChart = new Chart(barChartCanvas);
            var barChartData = areaChartData;
            barChartData.datasets[0].fillColor = "#00a65a";
            barChartData.datasets[0].strokeColor = "#00a65a";
            barChartData.datasets[0].pointColor = "#00a65a";
            var barChartOptions = {
                //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                scaleBeginAtZero: true,
                //Boolean - Whether grid lines are shown across the chart
                scaleShowGridLines: true,
                //String - Colour of the grid lines
                scaleGridLineColor: "rgba(0,0,0,.05)",
                //Number - Width of the grid lines
                scaleGridLineWidth: 1,
                //Boolean - Whether to show horizontal lines (except X axis)
                scaleShowHorizontalLines: true,
                //Boolean - Whether to show vertical lines (except Y axis)
                scaleShowVerticalLines: true,
                //Boolean - If there is a stroke on each bar
                barShowStroke: true,
                //Number - Pixel width of the bar stroke
                barStrokeWidth: 2,
                //Number - Spacing between each of the X value sets
                barValueSpacing: 5,
                //Number - Spacing between data sets within X values
                barDatasetSpacing: 1,
                //String - A legend template
                legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
                //Boolean - whether to make the chart responsive
                responsive: true,
                maintainAspectRatio: true
            };
      
            barChartOptions.datasetFill = false;
            barChart.Bar(barChartData, barChartOptions);
      
            });

    </script>
</html>



