<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Fatturazione | DDT</title>
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
                    $menugenerale = 0; $menuclienti = 0; $menuprodotti = 0; $menuddt = 1; $menufatture = 0; $menustatistiche = 0;
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
                include 'php/config.php';
                include 'php/ddt.php';
                ?>

                <?php
                // RECUPERO DATI E AGGIUNGO
                define('CHARSET', 'UTF-8');
                define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);

                $errorecreazione = array();
                $errorevisualizzazione = array();
                $erroreaggiunta = array();
                $errorecancella = array();

                abstract class tipoOperazione {

                    const nondefinita = 0;
                    const crea = 1;
                    const visualizza = 2;

                }

                $TipoOperazione = tipoOperazione::nondefinita;

                // Definisci il tipo di operazione
                if (isset($_GET['TipoOperazione'])) {
                    $TipoOperazione = $_GET['TipoOperazione'];
                }

                $ddt = new DDT();

                // SE CREO IL DDT
                if ($TipoOperazione == tipoOperazione::crea) {
                    // Carico le variabili
                    if (!isset($_GET['cliente'])) {
                        $errorecreazione['cliente'] = 'ID cliente';
                    } else {
                        $ddt->ddt_fkcliente = $_GET['cliente'];
                    }

                    if (!isset($_GET['dataEmissione'])) {
                        $errorecreazione['data'] = 'Data di emissione';
                    } else {
                        $ddt->ddt_data = DateTime::createFromFormat('d/m/Y', $_GET['dataEmissione']);
                        $ddt->ddt_anno = $ddt->ddt_data->format('Y');
                    }

                    if (!isset($_GET['causale'])) {
                        $errorecreazione['causale'] = 'Causale';
                    } else {
                        $ddt->ddt_causale = $_GET['causale'];
                    }

                    if (!isset($_GET['destinazione'])) {
                        //$errorecreazione['destinazione'] = 'Destinazione';
                    } else {
                        $ddt->ddt_destinazione = $_GET['destinazione'];
                    }

                    if (!isset($_GET['trasporto'])) {
                        $errorecreazione['trasporto'] = 'Trasporto';
                    } else {
                        $ddt->ddt_trasporto = $_GET['trasporto'];
                    }

                    if (!isset($_GET['aspetto'])) {
                        $errorecreazione['aspetto'] = 'Aspetto';
                    } else {
                        $ddt->ddt_aspetto = $_GET['aspetto'];
                    }

                    if (!isset($_GET['colli'])) {
                        $errorecreazione['colli'] = 'Colli';
                    } else {
                        $ddt->ddt_colli = $_GET['colli'];
                    }

                    if (!isset($_GET['ritirato'])) {
                        $errorecreazione['ritirato'] = 'Ritirato';
                    } else {
                        $ddt->ddt_ritiro = DateTime::createFromFormat('d/m/Y', $_GET['ritirato']);
                    }

                    if (!isset($_GET['scontrino'])) {
                        $errorecreazione['scontrino'] = 'scontrino';
                    } else {
                        $ddt->ddt_scontrino = $_GET['scontrino'];
                    }
                    
                    /*
                    if (!isset($_GET['importo'])) {
                        $errorecreazione['importo'] = 'Importo';
                    } else {
                        $ddt->ddt_importo = $_GET['importo'];
                    }
                    */
                    
                    if (!isset($_GET['fatturazioneelettronica'])) {
                        $ddt->ddt_fatturazioneelettronica = 0;;
                    } else {
                        $ddt->ddt_fatturazioneelettronica = 1;
                    }
                    
                    if (!isset($_GET['pagato'])) {
                        $ddt->ddt_pagato = 0;
                    } else {
                        $ddt->ddt_pagato = 1;
                    }

                    if (empty($errorecreazione)) {

                        if ($ddt->AggiungiSQL()) {
                            print "<div class='pad margin no-print'><div class='callout callout-success' style='margin-bottom: 0!important;'><h4><i class='fa fa-check'></i> Risultato:</h4> Inserito</div></div>";
                        } else {
                            $errorecreazione['creazione'] = 'Database';
                        }
                    }

                    if (!empty($errorecreazione)) {
                        print "<div class='pad margin no-print'><div class='callout callout-danger' style='margin-bottom: 0!important;'><h4><i class='fa fa-ban'></i> Note:</h4>Errori " . implode(", ", $errorecreazione) . "</div></div>";
                    }
                }
                //FINE CREAZIONE DDT
                // SE NON SO COSA FARE
                if ($TipoOperazione == tipoOperazione::nondefinita) {
                    print "<div class='pad margin no-print'><div class='callout callout-danger' style='margin-bottom: 0!important;'><h4><i class='fa fa-ban'></i> Note:</h4>Operazione non definita</div></div>";
                }
                ?>
                <section class="content-header">
                    <h1>
                        DDT
                        <small>Aggiungi</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li> Home</li>
                        <li class="active">DDT</li>
                        <li class="active">Aggiungi</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">


                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">DDT</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <?php DDTTabella(); ?>
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
            $('#example2').DataTable({
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

