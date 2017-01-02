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
                    include 'php/ddtdettaglio.php';
                    include "php/cliente.php";
                    
                    // RECUPERO DATI E AGGIUNGO
                    define('CHARSET', 'UTF-8');
                    define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);

                    $errore = array();
                    
                    $ddt = new DDT();
                    $ddd = new DDTDettaglio();

                    // SE AGGIUNGO
                
                    // Carico le variabili
                    if (!isset($_GET['ddt_id'])) {
                        $erroreaggiunta['ddt'] = 'ID DDT';
                    } else {
                        $ddd->ddd_fkddt = $_GET['ddt_id'];
                        $ddt_id = $_GET['ddt_id'];
                    }
                    
                    if (!isset($_GET['quantita'])) {
                        $erroreaggiunta['quantita'] = 'Quantita';
                    } else {
                        $ddd->ddd_quantita = pulisciStringa($_GET['quantita']);
                    }
                    
                    if (!isset($_GET['prodotto'])) {
                        $erroreaggiunta['prodotto'] = 'Prodotto';
                    } else {
                        $ddd->ddd_fkprodotto = $_GET['prodotto'];
                    }
                    
                    if (!isset($_GET['tracciabilita'])) {
                        $erroreaggiunta['tracciabilita'] = 'Tracciabilita';
                    } else {
                        $ddd->ddd_tracciabilita = pulisciStringa($_GET['tracciabilita']);
                    }
                    
                    if (empty($erroreaggiunta) && $ddd->AggiungiSQL()) {

                        if ($ddt->CaricaSQL($ddt_id)) {
                            // OK
                            echo "<div class='callout callout-success'><h4>Dettaglio aggiunto</h4><p>Modifica alla base dati effettuata correttamente</p></div>";
                        } else {
                            $erroreaggiunta['database'] = 'Database';
                        }
                    }

                    if (!empty($erroreaggiunta)) {
                        print "<div class='pad margin no-print'><div class='callout callout-danger' style='margin-bottom: 0!important;'><h4><i class='fa fa-ban'></i> Note:</h4>Errori " . implode(", ", $erroreaggiunta) . "</div></div>";
                    }
                
                    //FINE AGGIUNGO

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
        setTimeout(function () { window.location.href= 'ddtmodifica.php?ddt_id=<?php echo $ddt_id; ?>'; },1000); // 3.5 secondi
    </script>
</html>





