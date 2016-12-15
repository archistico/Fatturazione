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


            <form role="form" name="ddtForm" action="ddtmodificasql.php" method="get">

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











                <!-- ********************************** DDD ****************************** -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">DETTAGLIO PRODOTTI</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">


                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Quantità</label>
                                    <input type="text" class="form-control" placeholder="Quantità" value="0" name='quantita' id='quantita'>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Prodotto</label>
                                    <select class="form-control select2" style="width: 100%;" name='lista' id='lista'>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Tracciabilita</label>
                                    <input type="text" class="form-control" placeholder="Tracciabilità" name='tracciabilita' id='tracciabilita'>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Aggiungi nuovo prodotto al DDT</label>
                                    <input type="button" class="btn btn-primary btn-block" style="margin-right: 5px;" id="btnaggiungi" value="AGGIUNGI" />
                                </div>
                            </div>
                            <!-- /.col -->

                        </div>
                        <!-- /.row -->

                        <!-- TABELLA PRODOTTI -->
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box-body">
                                    

                                    <table id="tabellaProdotti" class="table table-bordered table-hover order-list">
                                        <thead>
                                            <tr>
                                                <td>#</td>
                                                <td>Prodotto</td>
                                                <td>Quantit&agrave; (kg/cad)</td>
                                                <td>Prezzo</td>
                                                <td>Subtotale</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>

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
                                <h4>Importo Totale: <b>&euro; <span id="importoTotale"></span></b></h4>
                            </div>
                        </div>

                        </div>
                    <!-- /.box-body -->

                </div>
                <!-- /.box -->









                <input type="hidden" name="prodotti" value="" id="prodotti" />
                <input type="hidden" name="importo" value="0" id="importo" />

                <div class="form-group row m-t-md">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-block btn-primary btn-lg">MODIFICA</button>
                    </div>
                </div>

            </form>
            <!-- /.form -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include 'footer.php'; ?>
</div>
<!-- ./wrapper -->

<?php include 'script.php'; ?>

<script>

// DICHIARAZIONE VARIABILI GENERALI
var jslista = [];
var dbProdotti = [];
var counter = 0;
var jsonListaProdotti = [];

// function principale
$(document).ready(function () {
    
    // Carica prodotti nel select
    $.ajax({
        dataType: "json",
        url: 'php/prodottijson.php',
        success: function (data) {
            for (var key in data) {
                if (data.hasOwnProperty(key)) {
                    var item = data[key];
                    dbProdotti.push({
                        "fkprodotto": parseInt(item.pro_id),
                        "categoria": item.pro_categoria,
                        "descrizione": item.pro_descrizione,
                        "prezzo": parseFloat(item.pro_prezzo)
                    });            
                }
            }
        
            var option = '';
            for (var i=0;i<dbProdotti.length;i++){
                option += '<option value="'+ dbProdotti[i].fkprodotto + '">' + dbProdotti[i].categoria + " - " + dbProdotti[i].descrizione + ' (&euro; '+(dbProdotti[i].prezzo).toFixed(2)+')' + '</option>';
            }
            $('#lista').append(option);
        }
    });

    // --------------CARICA DDD GIA ESISTENTI----------------------

    $.ajax({
        dataType: "json",
        url: 'php/dddjson.php?ddt_id=<?php echo $id?>',
        success: function (data) {
            for (var key in data) {
                if (data.hasOwnProperty(key)) {
                    var item = data[key];
                    jsonListaProdotti.push({
                        "id": parseInt(item.id),
                        "fkprodotto": parseInt(item.fkprodotto),
                        "quantita": parseFloat(item.quantita),
                        "categoria": item.categoria,
                        "descrizione": item.descrizione,
                        "tracciabilita": item.tracciabilita,
                        "prezzo": parseFloat(item.prezzo),
                        "ddd_id": parseInt(item.ddd_id)
                    });

                }
            } // chiudo il for

            // inserisco le righe alla tabella e creo array prodotti
            for (c = 0; c <= jsonListaProdotti.length -1; c++) {
                // aggiungo
                aggiungiRiga(jsonListaProdotti[c].id, jsonListaProdotti[c].categoria, jsonListaProdotti[c].descrizione, jsonListaProdotti[c].quantita, jsonListaProdotti[c].prezzo);

                
                var jsprodotto = {
                    "id": jsonListaProdotti[c].id,
                    "fkprodotto": jsonListaProdotti[c].fkprodotto,
                    "quantita": jsonListaProdotti[c].quantita,
                    "prezzo": jsonListaProdotti[c].prezzo,
                    "tracciabilita": jsonListaProdotti[c].tracciabilita
                };
                
                jslista.push(jsprodotto);    
            }

            counter = jsonListaProdotti.length;
            visualizzaLista();

            // calcola il totale
            calculateGrandTotal();
        }
    });


    // -------------FUNZIONI AGGIUNTA E MODIFICA-------------------

    $("#btnaggiungi").on("click", function () {
        
        // Controlla che i tre dati quantita select e tracciabilità siano stati inseriti
        if(isEmpty($("#lista").val()) || isEmpty($('#quantita').val()) || isEmpty($("#tracciabilita").val()) ) {
            alert("Inserire tutti i dati");
            return;
        }

        counter++;
        quantitatesto = $('#quantita').val();
		quantita = parseFloat(quantitatesto.replace(",","."));
        var newRow = $("<tr>");
        var cols = "";
		
        prodottoid = $("#lista").val();
        prodottotesto = $("#lista option:selected").text();
        prodottotracciabilita = $("#tracciabilita").val();

        if(prodottotracciabilita == "") {
            prodottotracciabilita = "-";
        } 

        //cerca il prezzo del prodotto in base all'ID
        prezzo = parseFloat(cercaPrezzo(prodottoid));

        if(isNaN(prezzo) || isNaN(quantita)) {
            prezzo = 0;
            quantita = 0;
        }

        cols += '<td>'+ counter + '</td>';
        cols += '<td><span name="prodotto">' + prodottotesto + '</span></td>';
        cols += '<td><span type="text" name="quantita' + counter + '">' + quantita.toFixed(3) + '</span></td>';
        cols += '<td><span type="text" name="prezzo' + counter + '">&euro; ' + prezzo.toFixed(2) + '</span></td>';
        cols += '<td><span type="text" name="subtotale' + counter + '"><strong>&euro; ' + (quantita*prezzo).toFixed(2) + '</strong></span></td>';
        cols += '<td><input type="button" class="ibtnDel btn btn-default btn-block"  value="X"></td>';
        newRow.append(cols);

        $("table.order-list").append(newRow);
        
        var jsprodotto = {
            "id": counter,
            "fkprodotto": prodottoid,
            "quantita": quantita,
            "prezzo": prezzo,
            "tracciabilita": prodottotracciabilita
        };

        jslista.push(jsprodotto);

        // pulisce valori quantita e tracciabilità
        $('#quantita').val("");
        $('#tracciabilita').val("");

        visualizzaLista();

        // calcola il totale
        calculateGrandTotal();
    });

    // Se premo su una X della tabella
    $("table.order-list").on("click", ".ibtnDel", function (event) {
        // cancella dall'array l'oggetto selezionato da ID
        var tempID = $(this).closest("tr")[0].cells[0].textContent;
        jslista = jslista.filter(function(el) {
            return el.id != tempID;
        });
        visualizzaLista();

        // cancella la riga dalla tabella
        $(this).closest("tr").remove();
        
        // Ricalcola il totale
        calculateGrandTotal();
    });


});

// verifica che la stringa sia vuota
function isEmpty(str) {
    return (!str || 0 === str.length);
}

// cerca prezzo
function cercaPrezzo(id) {
    for (c = 0; c <= dbProdotti.length -1; c++) {
        if(dbProdotti[c].fkprodotto == id) {
            return dbProdotti[c].prezzo;
        }
    }
}

// visualizza lista prodotti
function visualizzaLista() {
    // crea la lista
    var listaprodotti = "";

    for (index = 0; index <= jslista.length -1; index++) {
        listaprodotti=listaprodotti + " " + jslista[index].fkprodotto;
    }

    $("#prodotti").val(JSON.stringify(jslista));
}

// Calcolo totale
function calculateGrandTotal() {
    // Calcola da array
    var importoTotale = 0;
    for (index = 0; index <= jslista.length -1; index++) {
        importoTotale=importoTotale + jslista[index].quantita * jslista[index].prezzo;
    }
    $("#importoTotale").text(importoTotale.toFixed(2));
    $("#importo").val(importoTotale.toFixed(2));
}


function aggiungiRiga(tcontatore, tcategoria, tdescrizione, tquantita, tprezzo) {
    var newRow = $("<tr>");
    var cols = "";
	
    cols += '<td>'+ tcontatore + '</td>';
    cols += '<td><span name="prodotto">' + tcategoria + ' - ' + tdescrizione + ' (&euro; ' + tprezzo.toFixed(2) + ')</span></td>';
    cols += '<td><span type="text" name="quantita' + tcontatore + '">' + tquantita.toFixed(3) + '</span></td>';
    cols += '<td><span type="text" name="prezzo' + tcontatore + '">&euro; ' + tprezzo.toFixed(2) + '</span></td>';
    cols += '<td><span type="text" name="subtotale' + tcontatore + '"><strong>&euro; ' + (tquantita*tprezzo).toFixed(2) +'</strong></span></td>';
    cols += '<td><input type="button" class="ibtnDel btn btn-default btn-block"  value="X"></td>';
    
    newRow.append(cols);
    $("table.order-list").append(newRow);
}

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