<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Fatturazione | PRODOTTO</title>
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
                    $menugenerale = 0; $menuclienti = 0; $menuprodotti = 1; $menuddt = 0; $menufatture = 0; $menustatistiche = 0;
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
                        <small>MODIFICA</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i> Home</li>
                        <li>Prodotto</li>
                        <li class="active">Modifica</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <form role="form" name="Form" action="prodottomodificasql.php" method="get">

                        <!-- **********************************PRODOTTO****************************** -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">MODIFICA</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">

                                <!-- CARICA DATI -->

                                <?php
                                include 'php/utilita.php';
                                include 'php/prodotto.php';
                            
                                $prodotto = new Prodotto();

                                if (!isset($_GET['pro_id'])) {
                                    $errore['pro_id'] = 'ID non presente';
                                } else {
                                    $id = $_GET['pro_id'];
                                }
                            
                                if (empty($errore)) {
                                
                                    if ($prodotto->CaricaSQL($id)) {
                                        // ok
                                    } else {
                                        $errore['db'] = 'Ricerca DB';
                                    }
                                }
                            
                                if (!empty($errore)) {
                                    print "<div class='pad margin no-print'><div class='callout callout-danger' style='margin-bottom:       0!important;'><h4><i class='fa fa-times'></i> Risultato:</h4> ERRORE</div></div>";
                                    print "<a href='index.php'>Torna alla home</a>";
                                    die();
                                }
                            
                            
                                ?>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Categoria</label>
                                            <input type="text" class="form-control" placeholder="Categoria: tipo Carne bovina, Insaccato, ..." name='categoria' value="<?php echo $prodotto->pro_categoria; ?>" required>
                                        </div>
                                    </div>
                                    <!-- /.col -->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Descrizione</label>
                                            <input type="text" class="form-control" placeholder="Descrizione: tipo Rolata, Sottofiletto, ..." name='descrizione' value="<?php echo $prodotto->pro_descrizione; ?>" required>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Prezzo (&euro;)</label>
                                            <input type="number" min="0" max="1000000" step="0.01" class="form-control" placeholder="Prezzo" name='prezzo' value="<?php echo $prodotto->pro_prezzo; ?>" required>
                                        </div>
                                    </div>
                                    <!-- /.col -->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>IVA (&percnt;)</label>
                                            <input type="number" min="0" max="100" step="0.5" class="form-control" placeholder="IVA: tipo 10 o 4" name='iva' value="<?php echo $prodotto->pro_iva; ?>" required>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.box-body -->

                        </div>
                        <!-- /.box -->

                        <input type="hidden" name="id" value="<?php echo $id; ?>" />

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

    </body>
</html>
