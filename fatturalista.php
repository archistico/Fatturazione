<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Fatturazione | FATTURA</title>
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
                        FATTURA
                        <small>Lista</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li> Home</li>
                        <li class="active">FATTURA</li>
                        <li class="active">Lista</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    
                    <?php 
                    include 'php/utilita.php';
                    include 'php/config.php';
                    include 'php/fattura.php';
                    
                    // RECUPERO DATI E AGGIUNGO
                    define('CHARSET', 'UTF-8');
                    define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);

                    $errorecreazione = array();
                    $erroreaggiunta = array();
                    $erroremodifica = array(); 
                    $errorecancella = array();

                    // Definisci il tipo di operazione
                    if (isset($_GET['operazione'])) {
                        $operazione = $_GET['operazione'];
                    }
                    


                    /*public $fat_id;
                    public $fat_numero;
                    public $fat_numero_formattato;
                    public $fat_anno;
                    public $fat_data;
                    public $fat_fkcliente;
                    public $fat_pagata;
                    public $fat_annullata;
                    public $fat_ddt = array();*/



                    $fattura = new Fattura();

                    // SE CREO IL DDT
                    if ($operazione == "aggiungi") {
                    // Carico le variabili
                    if (!isset($_GET['cliente'])) {
                        $errorecreazione['cliente'] = 'ID cliente';
                    } else {
                        $fattura->fat_fkcliente = $_GET['cliente'];
                    }

                    if (!isset($_GET['dataEmissione'])) {
                        $errorecreazione['data'] = 'Data di emissione';
                    } else {
                        $fattura->fat_data = DateTime::createFromFormat('d/m/Y', $_GET['dataEmissione']);
                        $fattura->fat_anno = $fattura->fat_data->format('Y');
                    }

                    if (!isset($_GET['DDT'])) {
                        $errorecreazione['DDT'] = 'DDT';
                    } else {
                        $stringaDDT = $_GET['DDT'];
                        $fattura->fat_ddt = json_decode($stringaDDT);
                    }
                                        
                                                          
                    if (!isset($_GET['pagata'])) {
                        $fattura->fat_pagata = 0;
                    } else {
                        $fattura->fat_pagata = 1;
                    }

                    if (empty($errorecreazione)) {

                        if ($fattura->AggiungiSQL()) {
                            echo "<div class='callout callout-success'><h4>Fattura aggiunta</h4><p>Documento inserito nel database</p></div>";
                        } else {
                            $errorecreazione['creazione'] = 'Database';
                        }
                    }

                    if (!empty($errorecreazione)) {
                        echo "<div class='callout callout-danger'><h4>Errore inserimento della fattura</h4><p>Ricontrollare i dati inseriti o chiamare l'amministratore</p></div>";
                    }
                }
                //FINE CREAZIONE FATTURA












                    
                    
                    
                    ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">LISTA FATTURE</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <?php FATTabella(); ?>
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
            $('#fattabella').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": true
            });
            
        });
    </script>
</html>





