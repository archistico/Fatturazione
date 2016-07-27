<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> HelpBook | MOVIMENTO - NUOVO</title>
        <!-- Tell the browser to be responsive to screen width -->
        <?php include 'link.php'; ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="index.php" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>H</b>B</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>HELP</b>BOOK</span>
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

                <?php
                include 'php/utilita.php';
                include 'php/config.php';
                include 'php/movimenti.php';
                ?>
                
                <?php
                // RECUPERO DATI E AGGIUNGO
                define('CHARSET', 'UTF-8');
                define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);
                
                $errorevisualizzazione = array();
                $erroreaggiunta = array();
                $errorecancella = array();
                
                abstract class tipoOperazione
                {
                    const nondefinita = 0;
                    const visualizza = 1;
                    const aggiungi = 2;
                    const cancella = 3;
                }
                
                $TipoOperazione = tipoOperazione::nondefinita;
                
                // Definisci il tipo di operazione
                if(isset($_GET['idmovimento']) && !(isset($_GET['idlibro']) && isset($_GET['quantita']) && isset($_GET['sconto'])) && !(isset($_GET['idmovimentodettaglio']))) {
                    $TipoOperazione = tipoOperazione::visualizza;
                }
                
                if((isset($_GET['idmovimento']) && isset($_GET['idlibro']) && isset($_GET['quantita']) && isset($_GET['sconto'])) && !(isset($_GET['idmovimentodettaglio']))) {
                    $TipoOperazione = tipoOperazione::aggiungi;
                }
                
                if(isset($_GET['idmovimento']) && !(isset($_GET['idlibro']) && isset($_GET['quantita']) && isset($_GET['sconto'])) && (isset($_GET['idmovimentodettaglio']))) {
                    $TipoOperazione = tipoOperazione::cancella;
                }
                
                // Carica le variabili
                if (!isset($_GET['idmovimento'])) {
                    $errorevisualizzazione['idmovimento'] = 'ID movimento';
                } else {
                    $idmovimento = $_GET['idmovimento'];
                }
                
                // SE AGGIUNGO
                if($TipoOperazione == tipoOperazione::aggiungi)
                {
                    if (empty($_GET['quantita']) || $_GET['quantita']==0 ) {
                        $erroreaggiunta['quantita'] = 'quantita';
                    } else {
                        $quantita = $_GET['quantita'];
                    }

                    if (!isset($_GET['idlibro'])) {
                        $erroreaggiunta['idlibro'] = 'ID libro';
                    } else {
                        $idlibro = $_GET['idlibro'];
                    }

                    if (!isset($_GET['sconto'])) {
                        $erroreaggiunta['sconto'] = 'sconto';
                    } else {
                        $sconto = $_GET['sconto'];
                    }

                    if(!empty($erroreaggiunta)) {
                        print "<div class='pad margin no-print'><div class='callout callout-danger' style='margin-bottom: 0!important;'><h4><i class='fa fa-ban'></i> Note:</h4>Errori ".implode(", ", $erroreaggiunta)."</div></div>";
                    }

                    if (empty($errorevisualizzazione) && empty($erroreaggiunta)) {
                        try {
                            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
                            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

                            date_default_timezone_set('Europe/Rome');

                            $db->exec("INSERT INTO movimentidettaglio (idmovimentodettaglio, fkmovimento, fklibro, quantita, sconto, cancellato) VALUES (NULL, '".$idmovimento."', '".$idlibro."', '".$quantita."', '".$sconto."', '0');");

                            // chiude il database
                            $db = NULL;
                            print "<div class='pad margin no-print'><div class='callout callout-success' style='margin-bottom: 0!important;'><h4><i class='fa fa-check'></i> Note:</h4>Aggiunto</div></div>";

                        } catch (PDOException $e) {
                            print "<div class='pad margin no-print'><div class='callout callout-danger' style='margin-bottom: 0!important;'><h4><i class='fa fa-ban'></i> Note:</h4>Errore con il database</div></div>";
                        }
                    }
                }
                
                
                // SE CANCELLO
                if($TipoOperazione == tipoOperazione::cancella)
                {
                    if (!isset($_GET['idmovimentodettaglio'])) {
                        $errorecancella['idmovimentodettaglio'] = 'idmovimentodettaglio';
                    } else {
                        $idmovimentodettaglio = $_GET['idmovimentodettaglio'];
                    }

                    if(!empty($errorecancella)) {
                        print "<div class='pad margin no-print'><div class='callout callout-danger' style='margin-bottom: 0!important;'><h4><i class='fa fa-ban'></i> Note:</h4>Errori ".implode(", ", $errorecancella)."</div></div>";
                    }

                    if (empty($errorevisualizzazione) && empty($erroreaggiunta)) {
                        try {
                            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
                            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

                            date_default_timezone_set('Europe/Rome');

                            $db->exec("DELETE FROM movimentidettaglio WHERE movimentidettaglio.idmovimentodettaglio = ".$idmovimentodettaglio.";");

                            // chiude il database
                            $db = NULL;
                            print "<div class='pad margin no-print'><div class='callout callout-success' style='margin-bottom: 0!important;'><h4><i class='fa fa-check'></i> Note:</h4>Eliminato</div></div>";

                        } catch (PDOException $e) {
                            print "<div class='pad margin no-print'><div class='callout callout-danger' style='margin-bottom: 0!important;'><h4><i class='fa fa-ban'></i> Note:</h4>Errore con il database</div></div>";
                        }
                    }
                }
                
                // SE NON SO COSA FARE
                if($TipoOperazione == tipoOperazione::nondefinita){
                    print "<div class='pad margin no-print'><div class='callout callout-danger' style='margin-bottom: 0!important;'><h4><i class='fa fa-ban'></i> Note:</h4>Operazione non definita</div></div>";
                }
                   
                ?>

                <section class="content-header">
                    <h1>
                        Movimento
                        <small>Codice: </small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Movimenti</a></li>
                        <li class="active">Visualizza</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="invoice">
                    
                    
                    
                    <?php
                        // Estraggo i dati del movimento
                        list(   $mov_denominazione, $mov_indirizzo, $mov_cap, $mov_comune, $mov_telefono, $mov_email, $mov_piva, $mov_cf, 
                                $mov_codice, $mov_anno, $mov_numero, 
                                $mov_tipologia, $mov_causale, $mov_dataemissione, $mov_riferimento, 
                                $mov_aspetto, $mov_trasporto, 
                                $mov_spedizione, $mov_spedizionesconto, 
                                $mov_pagato, $mov_datapagamento, $mov_dataentro) = movimentoDettagli($idmovimento);
                        
                                $mov_numero = sprintf("%03d", $mov_numero);
                                
                                $mov_dataemissione_o = DateTime::createFromFormat('Y-m-d', $mov_dataemissione);
                                $mov_dataemissione_formattata = $mov_dataemissione_o->format('d/m/Y');
                                
                                
                                if(empty($mov_datapagamento)) {
                                    $mov_datapagamento_formattata = 'Non definita';
                                } else {
                                    $mov_datapagamento_o = DateTime::createFromFormat('Y-m-d', $mov_datapagamento);
                                    $mov_datapagamento_formattata = $mov_datapagamento_o->format('d/m/Y');
                                }
                                
                                
                                $mov_dataentro_o = DateTime::createFromFormat('Y-m-d', $mov_dataentro);
                                $mov_dataentro_formattata = $mov_dataentro_o->format('d/m/Y');
                                
                    ?>
                    
                                        
                    
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">
                                <i class="fa fa-book"></i> Elmi's World - Casa Editrice
                            </h2>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            Mittente:
                            <h2>Elmi's World</h2>
                            <address>
                                via Guillet, 6<br>
                                11027 Saint Vincent<br>
                                Tel: 388 92 07 016<br>
                                Email: info@elmisworld.it<br>
                                P.IVA: 011 463 700 75<br>
                                C.F.: GRP LTR 82P47 Z126 I
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            Destinatario:
                            <h2><?php echo $mov_denominazione; ?></h2>
                            <address>
                                <?php echo convertiStringaToHTML($mov_indirizzo); ?><br>
                                <?php echo $mov_cap. " ". convertiStringaToHTML($mov_comune); ?><br>
                                Tel: <?php echo $mov_telefono; ?><br>
                                Email: <?php echo $mov_email; ?><br>
                                P.IVA: <?php echo $mov_piva; ?><br>
                                C.F.: <?php echo $mov_cf; ?>
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            Documento:
                            <h2><?php echo $mov_anno."-".$mov_codice."-".$mov_numero; ?></h2>
                            <b>Tipologia:</b> <?php echo $mov_tipologia; ?><br>
                            <b>Causale:</b> <?php echo $mov_causale; ?><br>
                            <b>Data emissione:</b> <?php echo $mov_dataemissione_formattata; ?><br>
                            <b>Riferimento:</b> <?php echo $mov_riferimento; ?><br>
                            <b>Aspetto:</b> <?php echo $mov_aspetto; ?><br>
                            <b>Trasporto:</b> <?php echo $mov_trasporto; ?>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style='width: 40px'>Qt.</th>
                                        <th>Titolo del libro</th>
                                        <th style='width: 150px'>ISBN</th>
                                        <th style='width: 120px'>Prezzo</th>
                                        <th style='width: 120px'>Sconto</th>
                                        <th style='width: 120px'>Prezzo scontato</th>
                                        <th style='width: 120px'>Subtotale</th>
                                        <th style='width: 40px'></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        include 'php/movimentidettaglio.php';
                                        movimentiDettaglioListaTabella($idmovimento);
                                        ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    
                    
                    
                    <form role="form" name="movimentoForm" action="movimentovisualizza.php" method="get">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Quantità</label>
                                    <input type="number" min="0" max="1000" step="1" class="form-control" placeholder="Qt" value="0" name='quantita' required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Libro</label>
                                    <select class="form-control select2" style="width: 100%;" name='idlibro' required>
                                        <?php
                                        include 'php/libri.php';
                                        libriSelect();
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Sconto %</label>
                                    <input type="number" min="0" max="100" step="0.01" class="form-control" placeholder="Sconto" value="0" name='sconto' required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="hidden" name="idmovimento" value="<?php echo $_GET['idmovimento']; ?>">
                                    <label>Aggiungi nuovo libro al movimento</label>
                                    <button type="submit" class="btn btn-primary btn-block" style="margin-right: 5px;">
                                        <i class="fa fa-download"></i> AGGIUNGI
                                    </button>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                    
                    
                    
                    

                    <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-xs-8">
                            <p class="lead">Altri dati:</p>


                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                C.C. BancoPosta intestato a Elettra Groppo<br>
                                IBAN: IT78 L076 0101 2000 0101 8616 480
                            </p>
                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                * Riferimenti di legge IVA ASSOLTA DALL'EDITORE ART. 74 DPR 633/72
                            </p>
                            
                            <?php 
                                if($mov_pagato) {
                                    print "<div class='callout callout-success' style='margin-bottom: 0!important;'><h4><i class='fa fa-check'></i> Pagato</h4></div>";
                                } else {
                                    print "<div class='callout callout-danger' style='margin-bottom: 0!important;'><h4><i class='fa fa-warning'></i> Non pagato</h4></div>";
                                }
                            ?>
                            <br>
                        </div>
                        <!-- /.col -->
                        
                        <div class="col-xs-4">
                            <p class="lead">Da pagare entro: <?php echo $mov_dataentro_formattata; ?></p>

                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Totale imponibile:</th>
                                        <td>&euro; 
                                            <?php
                                                list ($totaleimponibile, $totalesconto, $totaleiva) = movimentoDettaglioImportoTotaleScontoIva($_GET['idmovimento']);
                                                print $totaleimponibile;
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Totale sconto:</th>
                                        <td>&euro; 
                                            <?php
                                                print $totalesconto;
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>IVA *:</th>
                                        <td>&euro; 
                                            <?php
                                                print $totaleiva;
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Spese di spedizione:</th>
                                        <td>&euro; 
                                            <?php echo number_format($mov_spedizione, 2). " (sconto ".number_format(($mov_spedizionesconto/100), 2)." %)" ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>TOTALE DA PAGARE:</th>
                                        <td>&euro; <?php $totaledapagare=$totaleimponibile+$mov_spedizione*(1-$mov_spedizionesconto/100); echo number_format($totaledapagare, 2); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-xs-12">
                            <a target="_blank" class="btn btn-default"><i class="fa fa-print"></i> STAMPA</a>
                            <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                                <i class="fa fa-download"></i> CREA PDF
                            </button>
                            <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                                <i class="fa fa-download"></i> INVIA EMAIL MITTENTE
                            </button>
                            <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                                <i class="fa fa-download"></i> INVIA EMAIL DESTINATARIO
                            </button>
                        </div>
                    </div>
                </section>
                <!-- /.content -->
                <div class="clearfix"></div>
            </div>
            <!-- /.content-wrapper -->
            <?php include 'footer.php'; ?>
        </div>
        <!-- ./wrapper -->

        <?php include 'script.php'; ?>
    </body>
</html>

