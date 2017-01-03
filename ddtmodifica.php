<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Fatturazione | DDT</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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

        <section class="content-header">
            <h1>
                DDT
                <small>Modifica</small>
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i> Home</li>
                <li>DDT</li>
                <li class="active">Modifica</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            
            <!-- ********************************** CARICA DATI ****************************** -->    

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
            // Carico le variabili
            if (!isset($_GET['ddt_id'])) {
                $errore['ddt_id'] = 'Errore nel passaggio del ID del DDT';
            } else {
                $id = $_GET['ddt_id'];
                if ($ddt->CaricaSQL($id)) {
                    // OK
                    $ddt->ddt_id = $id;
                } else {
                    $errore['letturaDDT'] = 'Lettura DDT';
                }
            }

            if (empty($errore)) {
                // OK
            } else { // se non ci sono errori di lettura nel DDT
                print "<div class='pad margin no-print'><div class='callout callout-danger' style='margin-bottom:0!important;'><h4><i class='fa fa-ban'></i> Note:</h4>Errori " . implode(", ", $errore) ."</div></div>";
            }

            ?>


            <form role="form" name="ddtForm" action="ddtmodificasql.php" onsubmit="return validateForm()" method="get">

                <!-- **********************************DATI NASCOSTI****************************** -->
                <input type="hidden" name="ddt_id" value="<?php echo $ddt->ddt_id; ?>">

                <!-- **********************************DATI GENERALI****************************** -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">DATI GENERALI</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Cliente</label>
                                    <select class="form-control select2" style="width: 100%;" name='cliente' required>
                                        <?php cliente_selectbyID($ddt->ddt_fkcliente); ?>
                                    </select>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Data</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="datepicker1" name='dataEmissione' value="<?php print $ddt->ddt_data_stringa; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Causale</label>
                                    <select class="form-control select2" style="width: 100%;" name='causale' required>
                                        <option value="Vendita" <?php print $ddt->ddt_causale=="Vendita"?"selected":""; ?> >Vendita</option>
                                        <option value="Tentata vendita" <?php print $ddt->ddt_causale=="Tentata vendita"?"selected":""; ?>>Tentata vendita</option>
                                        <option value="Omaggio" <?php print $ddt->ddt_causale=="Omaggio"?"selected":""; ?>>Omaggio</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <!-- ********************SPEDIZIONE************************* -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">SPEDIZIONE</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Destinazione</label>
                                    <input type="text" class="form-control" placeholder="Destinazione se diversa" name='destinazione' value="<?php print $ddt->ddt_destinazione; ?>">
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Trasporto</label>
                                    <select class="form-control select2" style="width: 100%;" name='trasporto' required>
                                        <option value="Mittente" <?php print $ddt->ddt_trasporto=="Mittente"?"selected":""; ?>>Mittente</option>
                                        <option value="Destinatario" <?php print $ddt->ddt_trasporto=="Destinatario"?"selected":""; ?>>Destinatario</option>
                                        <option value="Vettore" <?php print $ddt->ddt_trasporto=="Vettore"?"selected":""; ?>>Vettore</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.col -->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Aspetto</label>
                                    <select class="form-control select2" style="width: 100%;" name='aspetto' required>
                                        <option value="Sfuso" <?php print $ddt->ddt_aspetto=="Sfuso"?"selected":""; ?>>Sfuso</option>
                                        <option value="Pacco" <?php print $ddt->ddt_aspetto=="Pacco"?"selected":""; ?>>Pacco</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Numero colli</label>
                                    <select class="form-control select2" style="width: 100%;"  name='colli' required>
                                        <option value="1" <?php print $ddt->ddt_colli=="1"?"selected":""; ?>>1</option>
                                        <option value="2" <?php print $ddt->ddt_colli=="2"?"selected":""; ?>>2</option>
                                        <option value="3" <?php print $ddt->ddt_colli=="3"?"selected":""; ?>>3</option>
                                        <option value="4" <?php print $ddt->ddt_colli=="4"?"selected":""; ?>>4</option>
                                        <option value="5" <?php print $ddt->ddt_colli=="5"?"selected":""; ?>>5</option>
                                        <option value="6" <?php print $ddt->ddt_colli=="6"?"selected":""; ?>>6</option>
                                        <option value="7" <?php print $ddt->ddt_colli=="7"?"selected":""; ?>>7</option>
                                        <option value="8" <?php print $ddt->ddt_colli=="8"?"selected":""; ?>>8</option>
                                        <option value="9" <?php print $ddt->ddt_colli=="9"?"selected":""; ?>>9</option>
                                        <option value="10" <?php print $ddt->ddt_colli=="10"?"selected":""; ?>>10</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.col -->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ritirato il</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="datepicker2" name='ritirato' value="<?php print $ddt->ddt_ritiro_stringa; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                    </div>
                    <!-- /.box-body -->

                </div>
                <!-- /.box -->









                <!-- **********************************ALTRO****************************** -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">ALTRO</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">


                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Numero scontrino</label>
                                    <input type="text" class="form-control" placeholder="Numero scontrino" name='scontrino' value="<?php print $ddt->ddt_scontrino; ?>" required>
                                </div>
                            </div>
                            <!-- /.col -->

                            <div class="col-md-4">
                                <br>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" placeholder="Fatturazione elettronica" name='fatturazioneelettronica' <?php print $ddt->ddt_fatturazioneelettronica?"checked":""; ?>> Fatturazione elettronica
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->

                            <div class="col-md-4">
                                <br>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" placeholder="Pagato" name='pagato' <?php print $ddt->ddt_pagato?"checked":""; ?>> DDT pagato
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->

                </div>
                <!-- /.box -->

                <div class="form-group row m-t-md">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-block btn-success btn-lg">MODIFICA DDT</button>
                    </div>
                </div>
            </form>
            <!-- /.form -->










                <!-- ********************************** DDD ****************************** -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">DETTAGLIO PRODOTTI</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">


                       <!-- INSERIMENTO NUOVI DETTAGLI -->
                    <div class="row">
                        <form name="ddtForm" action="dddaggiungi.php" method="get" class="no-print">
                            
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
                                <?php ddtdettaglio_tabella($ddt->ddt_id); ?>
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

                        

                    </div>
                    <!-- /.box-body -->

                </div>
                <!-- /.box -->
            
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include 'footer.php'; ?>
</div>
<!-- ./wrapper -->

<?php include 'script.php'; ?>

<script>

$(function () {
    //Date picker
    $('#datepicker1').datepicker({
        autoclose: true
    });
    //Date picker
    $('#datepicker2').datepicker({
        autoclose: true
    });
});

</script>
</body>
</html>