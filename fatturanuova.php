<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Fatturazione | FATTURA</title>
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
        $menugenerale = 0; $menuclienti = 0; $menuprodotti = 0; $menuddt = 0; $menufatture = 1; $menustatistiche = 0;
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
      ?>


      <section class="content-header">
        <h1>
          FATTURA
          <small>NUOVA</small>
        </h1>
        <ol class="breadcrumb">
          <li><i class="fa fa-dashboard"></i> Home</li>
          <li>FATTURA</li>
          <li class="active">Nuova</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">

        <form role="form" name="FatturaForm" action="fatturalista.php" method="get" onsubmit="return validateForm()">

          <!-- **********************************DATI GENERALI****************************** -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">DATI GENERALI</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Cliente</label>
                    <select id="cliente_id" class="form-control select2" style="width: 100%;" name='cliente' onchange="cambioCliente(this)" required>
                      <option disabled selected value> -- lista clienti -- </option>
                      <?php include "php/cliente.php"; cliente_select(); ?>
                    </select>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Data</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="datepicker1" name='dataEmissione' required>
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

          <input type="hidden" id="DDT" name="DDT" value="">
          <input type="hidden" id="operazione" name="operazione" value="aggiungi">

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">DDT ALLEGATI</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-10">
                  <div class="form-group">
                    <label>Seleziona i ddt da mettere in fattura</label>
                    <select class="form-control"  style="width: 100%;" id="listaDDT" name='listaDDT' required>
                      <option disabled selected value> -- seleziona un cliente -- </option>
                    </select>


                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>&nbsp;</label>
                    <a id="btnaggiungi" onclick="aggiungiDDT()" class="btn btn-info btn-block">Aggiungi DDT</a>
                  </div>

                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <label>Lista DDT inseriti in fattura</label>
                  <table class='table table-bordered table-hover' id="tabellaDDT">
                    <thead>
                      <tr>
                        <th>DDT</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>

                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <div class="form-group row m-t-md">
            <div class="col-sm-12">
              <button type="submit" class="btn btn-block btn-success btn-lg">CREA FATTURA</button>
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
  function cambioCliente(obj)
  {
    $('#listaDDT').empty()
    var dropDown = document.getElementById("cliente_id");
    var cliente_id = dropDown.options[dropDown.selectedIndex].value;
    $.ajax({
      type: "POST",
      url: "php/DDTjson.php",
      data: { 'cliente_id': cliente_id  },
      dataType: 'json',
      success: function(data){

        // pulisce i dati
        arr.length = 0;
        var DDT = document.getElementById('DDT');
        DDT.value="";
        // cancella la tabella
        $("#tabellaDDT tr").remove();

        // riattiva il tasto aggiungi
        var btn = document.getElementById('btnaggiungi');
        btn.className = "btn btn-info btn-block";

        // Riattiva il select
        var select = document.getElementById("listaDDT");
        select.disabled=false;

        $.each(data, function(i, d) {
          $('#listaDDT').append('<option value="' + d.ddt_id + '">' + d.descrizione + '</option>');
        });

        // Se zero elementi allora blocca
        if(select.childElementCount == 0) {
          var btn = document.getElementById('btnaggiungi');
          btn.className = "btn btn-info btn-block disabled";
          select.disabled=true;
        }

      }
    });
  }

  var DDT = document.getElementById('DDT');
  var arr =[];

  function aggiungiDDT() {
    var table = document.getElementById("tabellaDDT");
    var select = document.getElementById("listaDDT");
        
    var row = table.insertRow(-1);
    var cell1 = row.insertCell(0);
    cell1.innerHTML = select.options[select.selectedIndex].text;

    arr.push(select.value);
    DDT.value=JSON.stringify(arr);

    valuesel = select.selectedIndex;
    select.removeChild(select[valuesel]);

    if(select.childElementCount == 0) {
      var btn = document.getElementById('btnaggiungi');
      btn.className = "btn btn-info btn-block disabled";
      select.disabled=true;
    }

  }

  $(function () {

    //Date picker
    $('#datepicker1').datepicker("update", new Date());

  });

  function validateForm() {
    if (document.getElementById('DDT').value != "") {
      return true;
    }
    else {
      alert('Inserire almeno un DDT');
      return false;
    }
  }
  </script>
</body>
</html>
