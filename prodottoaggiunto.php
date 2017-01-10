<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Fatturazione | Prodotto</title>
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
                    $menugenerale = 0; $menuclienti = 0; $menuprodotti = 1; $menuddt = 0; $menufatture = 0; $menustatistiche = 0; $menuutilita = 0;
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
                        PRODOTTO
                        <small>Aggiungi</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li> Home</li>
                        <li class="active">Prodotto</li>
                        <li class="active">Aggiungi</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                <?php
                include 'php/utilita.php';
                include 'php/config.php';
                include 'php/prodotto.php';
                
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

                $pro = new Prodotto();

                // SE CREO IL DDT
                if ($TipoOperazione == tipoOperazione::crea) {
                    // Carico le variabili
                    if (!isset($_GET['categoria'])) {
                        $errorecreazione['categoria'] = 'categoria';
                    } else {
                        $pro->pro_categoria = pulisciStringa($_GET['categoria']);
                    }
                    
                    if (!isset($_GET['descrizione'])) {
                        $errorecreazione['descrizione'] = 'descrizione';
                    } else {
                        $pro->pro_descrizione = pulisciStringa($_GET['descrizione']);
                    }
                    
                    if (!isset($_GET['prezzo'])) {
                        $errorecreazione['prezzo'] = 'prezzo';
                    } else {
                        $pro->pro_prezzo = $_GET['prezzo'];
                    }
                    
                    if (!isset($_GET['iva'])) {
                        $errorecreazione['iva'] = 'iva';
                    } else {
                        $pro->pro_iva = $_GET['iva'];
                    }

                    if (!isset($_GET['misura'])) {
                        $errorecreazione['misura'] = 'misura';
                    } else {
                        $pro->pro_misura = $_GET['misura'];
                    }

                    if (empty($errorecreazione)) {

                        if ($pro->AggiungiSQL()) {
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
        if (empty($errorecreazione)) {
            print "setTimeout(function () { window.location.href= 'prodottolista.php'; },1000);";
        } else {
            print "setTimeout(function () { window.location.href= 'prodottolista.php'; },2000);";
        }
        ?>
    </script>
</html>



