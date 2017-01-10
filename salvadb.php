<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Fatturazione | SALVA DB</title>
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
        $menugenerale = 0; $menuclienti = 0; $menuprodotti = 0; $menuddt = 0; $menufatture = 0; $menustatistiche = 0; $menuutilita = 1;
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
          Utilit&agrave;
          <small>Salva DB</small>
        </h1>
        <ol class="breadcrumb">
          <li> Home</li>
          <li class="active">Utilit&agrave;</li>
          <li class="active">Salva DB</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">

        <?php
        include 'php/utilita.php';
        include 'php/config.php';

        ?>

        <div class='box box-primary'>

          <div class='box-header with-border'>
            <h3 class='box-title'>INFORMAZIONI</h3>
          </div>
          <div class='box-body'>
            <div class='row'>
              <div class='col-md-12'>
                <?php
                try {
                  $mysqlUserName      = $dbuser;
                  $mysqlPassword      = $dbpswd;
                  $mysqlHostName      = $dbhost;
                  $DbName             = $dbname;

                  $filename = "backup/backup-" . date('Y-m-d')."_".date('H-i-s') . ".sql";
                  exec("mysqldump --user=$mysqlUserName --password=$mysqlPassword --host=$mysqlHostName $DbName > $filename");

                } catch (Exception $e) {
                    print "<div class='pad margin no-print'><div class='callout callout-danger' style='margin-bottom: 0!important;'><h4><i class='fa fa-ban'></i> ERRORE:</h4>Backup non eseguito</div></div>";
                } finally {
                  print "<div class='pad margin no-print'><div class='callout callout-success' style='margin-bottom: 0!important;'><h4><i class='fa fa-check'></i> Risultato:</h4> Backup eseguito</div></div>";
                }
                ?>
              </div>
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

</html>
