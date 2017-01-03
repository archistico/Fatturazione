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
                        DDT
                        <small>Modifica</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li> Home</li>
                        <li class="active">DDT</li>
                        <li class="active">Modifica</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    

                <?php

                include 'php/utilita.php';
                include 'php/config.php';
                include 'php/ddt.php';
                                
                // RECUPERO DATI E AGGIUNGO
                define('CHARSET', 'UTF-8');
                define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);

                $errore = array();
                
                $ddt = new DDT();

                // Carico le variabili
                if (!isset($_GET['ddt_id'])) {
                    $errore['ddt_id'] = 'ID ddt';
                } else {
                    $ddt->ddt_id = $_GET['ddt_id'];
                }
                if (!isset($_GET['cliente'])) {
                    $errore['cliente'] = 'ID cliente';
                } else {
                    $ddt->ddt_fkcliente = $_GET['cliente'];
                }
                if (!isset($_GET['dataEmissione'])) {
                    $errore['data'] = 'Data di emissione';
                } else {
                    $ddt->ddt_data = DateTime::createFromFormat('d/m/Y', $_GET['dataEmissione']);
                    $ddt->ddt_anno = $ddt->ddt_data->format('Y');
                }
                if (!isset($_GET['causale'])) {
                    $errore['causale'] = 'Causale';
                } else {
                    $ddt->ddt_causale = $_GET['causale'];
                }
                if (!isset($_GET['destinazione'])) {
                    //$errore['destinazione'] = 'Destinazione';
                } else {
                    $ddt->ddt_destinazione = pulisciStringa($_GET['destinazione']);
                }
                if (!isset($_GET['trasporto'])) {
                    $errore['trasporto'] = 'Trasporto';
                } else {
                    $ddt->ddt_trasporto = $_GET['trasporto'];
                }
                if (!isset($_GET['aspetto'])) {
                    $errore['aspetto'] = 'Aspetto';
                } else {
                    $ddt->ddt_aspetto = $_GET['aspetto'];
                }
                if (!isset($_GET['colli'])) {
                    $errore['colli'] = 'Colli';
                } else {
                    $ddt->ddt_colli = $_GET['colli'];
                }
                if (!isset($_GET['ritirato'])) {
                    $errore['ritirato'] = 'Ritirato';
                } else {
                    $ddt->ddt_ritiro = DateTime::createFromFormat('d/m/Y', $_GET['ritirato']);
                }
                if (!isset($_GET['scontrino'])) {
                    $errore['scontrino'] = 'scontrino';
                } else {
                    $ddt->ddt_scontrino = pulisciStringa($_GET['scontrino']);
                }
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
                if (empty($errore)) {
                    
                    if ($ddt->VerificaFatturatoSQL()) {
                        if(!$ddt->ModificaSQL()) {
                            $errore['ErroreMod'] = 'Errore nella modifica del database';
                        }
                    } else {
                        $errore['creazioneFAT'] = 'Presente una fattura con questo DDT per cui impossibile cambiare il nome';
                    }

                    if (empty($errore)) {
                        print "<div class='pad margin no-print'><div class='callout callout-success' style='margin-bottom:0!important;'><h4><i class='fa fa-check'></i> Risultato:</h4> DDT Modificato</div></div>";
                    }

                }
                if (!empty($errore)) {
                    print "<div class='pad margin no-print'><div class='callout callout-danger' style='margin-bottom:0!important;'><h4><i class='fa fa-ban'></i> Errore:</h4> " . implode(", ", $errore) ."</div></div>";
                }
                
                //FINE CREAZIONE DDT
                ?>


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
        <?php 
        if (empty($errore)) {
            print "setTimeout(function () { window.location.href= 'ddtlista.php'; },1000);";
        } else {
            print "setTimeout(function () { window.location.href= 'ddtlista.php'; },3500);";
        }
        ?>
    </script>
</html>