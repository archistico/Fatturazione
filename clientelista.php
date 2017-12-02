<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Fatturazione | CLIENTI</title>
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

                    <?php include 'navbar.php'; ?>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <?php
                    $menugenerale = 0; $menuclienti = 1; $menuprodotti = 0; $menuddt = 0; $menufatture = 0; $menustatistiche = 0; $menuutilita = 0;
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
                        CLIENTI
                        <small>Lista</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li> Home</li>
                        <li class="active">Clienti</li>
                        <li class="active">Lista</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    
                    <?php 
                    include 'php/utilita.php';
                    include 'php/config.php';
                    include 'php/cliente.php';
           
                    ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">LISTA CLIENTI</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <?php ClienteTabella(); ?>
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
        $(function () {
            $('#clientetabella').DataTable({
                "paging": true,
                "lengthChange": true,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Tutti"]],
                "searching": true,
                "ordering": true,
                "order": [[ 1, 'asc' ]],
                "info": true,
                "autoWidth": true,
                "language": {
                    "lengthMenu": "Mostra _MENU_ clienti per pagina",
                    "zeroRecords": "Nessun cliente",
                    "info": "Pagina _PAGE_ di _PAGES_",
                    "sSearch": "Cerca: ",
                    "infoEmpty": "Nessun cliente",
                    "infoFiltered": "(filtrati _MAX_ prodotti)"
                },
                "oPaginate": {
		            "sFirst": "Inizio",
		            "sPrevious": "Precedente",
		            "sNext": "Prossimo",
		            "sLast": "Fine"
	            },
                "sLoadingRecords": "In caricamento...",
	            "sProcessing": "In caricamento..."
            });
            
        });
    </script>
</html>





