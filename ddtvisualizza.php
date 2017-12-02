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
                    $menugenerale = 0; $menuclienti = 0; $menuprodotti = 0; $menuddt = 1; $menufatture = 0; $menustatistiche = 0; $menuutilita = 0;
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
                include 'php/ddtdettaglio.php';
                ?>

                <?php
                // RECUPERO DATI E AGGIUNGO
                define('CHARSET', 'UTF-8');
                define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);

                $errorevisualizzazione = array();
                $erroreaggiunta = array();
                $errorecancella = array();

                abstract class tipoOperazione {

                    const nondefinita = 0;
                    const visualizza = 1;
                    const aggiungi = 2;
                    const cancella = 3;
                }

                $TipoOperazione = tipoOperazione::nondefinita;

                // Definisci il tipo di operazione
                if (isset($_GET['TipoOperazione'])) {
                    $TipoOperazione = $_GET['TipoOperazione'];
                }

                $ddt = new DDT();
                $ddd = new DDTDettaglio();

                // SE VISUALIZZO
                if ($TipoOperazione == tipoOperazione::visualizza) {
                    // Carico le variabili
                    if (!isset($_GET['ddt_id'])) {
                        $errorevisualizzazione['ddt'] = 'ID DDT';
                    } else {
                        $ddt_id = $_GET['ddt_id'];
                    }

                    if (empty($errorevisualizzazione)) {

                        if ($ddt->CaricaSQL($ddt_id)) {
                            // OK
                        } else {
                            $errorevisualizzazione['database'] = 'Database';
                        }
                    }

                    if (!empty($errorevisualizzazione)) {
                        print "<div class='pad margin no-print'><div class='callout callout-danger' style='margin-bottom: 0!important;'><h4><i class='fa fa-ban'></i> Note:</h4>Errori " . implode(", ", $errorecreazione) . "</div></div>";
                    }
                }
                //FINE CARICAMENTO DATI
                
                // SE AGGIUNGO
                if ($TipoOperazione == tipoOperazione::aggiungi) {
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
                        $ddd->ddd_quantita = $_GET['quantita'];
                    }
                    
                    if (!isset($_GET['prodotto'])) {
                        $erroreaggiunta['prodotto'] = 'Prodotto';
                    } else {
                        $ddd->ddd_fkprodotto = $_GET['prodotto'];
                    }
                    
                    if (!isset($_GET['tracciabilita'])) {
                        $erroreaggiunta['tracciabilita'] = 'Tracciabilita';
                    } else {
                        $ddd->ddd_tracciabilita = $_GET['tracciabilita'];
                    }
                    
                    if (empty($erroreaggiunta) && $ddd->AggiungiSQL()) {

                        if ($ddt->CaricaSQL($ddt_id)) {
                            // OK
                        } else {
                            $erroreaggiunta['database'] = 'Database';
                        }
                    }

                    if (!empty($erroreaggiunta)) {
                        print "<div class='pad margin no-print'><div class='callout callout-danger' style='margin-bottom: 0!important;'><h4><i class='fa fa-ban'></i> Note:</h4>Errori " . implode(", ", $erroreaggiunta) . "</div></div>";
                    }
                }
                //FINE AGGIUNGO
                
                // SE CANCELLA
                if ($TipoOperazione == tipoOperazione::cancella) {
                    // Carico le variabili
                    if (!isset($_GET['ddt_id'])) {
                        $errorecancella['ddt'] = 'ID DDT';
                    } else {
                        $ddd->ddd_fkddt = $_GET['ddt_id'];
                        $ddt_id = $_GET['ddt_id'];
                    }
                    
                    if (!isset($_GET['ddtdettaglio'])) {
                        $errorecancella['ddtdettaglio'] = 'ID DDTDettaglio';
                    } else {
                        $ddd->ddd_id = $_GET['ddtdettaglio'];
                    }
                    
                    if (empty($errorecancella) && $ddd->CancellaSQL()) {

                        if ($ddt->CaricaSQL($ddt_id)) {
                            // OK
                        } else {
                            $errorecancella['database'] = 'Database';
                        }
                    }

                    if (!empty($errorecancella)) {
                        print "<div class='pad margin no-print'><div class='callout callout-danger' style='margin-bottom: 0!important;'><h4><i class='fa fa-ban'></i> Note:</h4>Errori " . implode(", ", $errorecancella) . "</div></div>";
                    }
                }
                //FINE CANCELLA
                
                
                ?>
                <section class="content-header">
                    <h1>
                        DDT
                        <small>Visualizza</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li> Home</li>
                        <li class="active">DDT</li>
                        <li class="active">Visualizza</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="invoice">
                               
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            Mittente:
                            <h2>Macelleria Peaquin s.n.c.</h2>
                            <h4>di Peaquin Sandro e Martino</h4>
                            <address>
                                piazza Zerbion, 27<br>
                                11027 Saint Vincent<br>
                                Tel: 0166 51 21 87<br>
                                Email: <br>
                                P.IVA: 011 77 71 00 74
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            Destinatario:
                            <h2><?php echo convertiStringaToHTML(utf8_decode($ddt->ddt_fkcliente_denominazione)); ?></h2>
                            <address>
                                <?php echo convertiStringaToHTML(utf8_decode($ddt->ddt_fkcliente_indirizzo)); ?><br>
                                <?php echo $ddt->ddt_fkcliente_cap ." ". convertiStringaToHTML(utf8_decode($ddt->ddt_fkcliente_comune)); ?><br>
                                Tel: <?php echo $ddt->ddt_fkcliente_telefono; ?><br>
                                Email: <?php echo $ddt->ddt_fkcliente_email; ?><br>
                                P.IVA: <?php echo $ddt->ddt_fkcliente_piva; ?><br>
                            </address>
                            <address>
                                Destinazione DDT: <?php if(empty($ddt->ddt_destinazione)){ echo " come sopra"; } else {echo $ddt->ddt_destinazione;} ?>
                            </address>
                                
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            Documento:
                            <h2><?php echo "DDT ".$ddt->ddt_anno."-".$ddt->ddt_numero_formattato; ?></h2>
                            <b>Causale:</b> <?php echo $ddt->ddt_causale; ?><br>
                            <b>Data emissione:</b> <?php echo $ddt->ddt_data_stringa; ?><br>
                            <b>Colli:</b> <?php echo $ddt->ddt_colli; ?><br>
                            <b>Aspetto:</b> <?php echo $ddt->ddt_aspetto; ?><br>
                            <b>Trasporto:</b> <?php echo $ddt->ddt_trasporto; ?><br>
                            <b>Scontrino:</b> <?php echo $ddt->ddt_scontrino; ?><br>
                            <b>Fatturazione Elettronica:</b> <?php echo $ddt->ddt_fatturazioneelettronica==1?'Sì':'No'; ?><br>
                            <b>Pagato:</b> <?php echo $ddt->ddt_pagato==1?'Sì':'No'; ?><br>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    
                    <hr class="visualizzafattura">

                    <!-- INSERIMENTO NUOVI DETTAGLI -->
                    <div class="row">
                        <form name="ddtForm" action="ddtvisualizza.php" method="get" class="no-print">

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Quantità</label>
                                    <input type="number" min="0" max="1000" step="0.001" class="form-control" placeholder="Qt" value="0" name='quantita' required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Prodotto</label>
                                    <select class="form-control select2" style="width: 100%;" name='prodotto' required>
                                        <?php
                                        include 'php/prodotto.php';
                                        prodotto_select();
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Tracciabilita</label>
                                    <input type="text" class="form-control" placeholder="Tracciabilità" name='tracciabilita' required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="hidden" name="ddt_id" value="<?php echo $_GET['ddt_id']; ?>">
                                    <input type="hidden" name="TipoOperazione" value="2">
                                    <label>Aggiungi nuovo prodotto al DDT</label>
                                    <button type="submit" class="btn btn-primary btn-block" style="margin-right: 5px;">
                                        <i class="fa fa-download"></i> AGGIUNGI
                                    </button>
                                </div>
                            </div>
                            <!-- /.col -->

                        </form>
                    </div>

                    <!-- TABELLA DETTAGLIO -->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box-body">
                                <?php ddtdettaglio_tabella($ddt_id); ?>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    
                    <div class="row">
                        <div class="col-md-8">
                        </div>
                        <div class="col-md-4">
                            <h4>Importo Totale: <b>&euro; <?php echo number_format($ddt->ddt_importo, 2, ',', ' '); ?></b></h4>
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
    <!-- page script -->
    <script>
        $(function () {
            $('#ddtdettagliotabella').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": true
            });
            
        });
    </script>
    </body>
</html>

