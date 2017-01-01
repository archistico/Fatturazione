<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Fatturazione | Prodotto</title>
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
                    $menugenerale = 0; $menuclienti = 0; $menuprodotti = 1; $menuddt = 0; $menufatture = 0; $menustatistiche = 0; $menuutilita = 0;
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
                        PRODOTTO
                        <small>NUOVO</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i> Home</li>
                        <li>PRODOTTO</li>
                        <li class="active">Nuovo</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <form role="form" name="ddtForm" action="prodottoaggiunto.php" method="get">

                        <!-- **********************************PRODOTTO****************************** -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">AGGIUNGI</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Categoria</label>
                                            <input type="text" class="form-control" placeholder="Categoria: tipo Carne bovino, Insaccato, ..." name='categoria' required>
                                        </div>
                                    </div>
                                    <!-- /.col -->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Descrizione</label>
                                            <input type="text" class="form-control" placeholder="Descrizione: tipo Rolata, Sottofiletto, ..." name='descrizione' required>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Prezzo (&euro;)</label>
                                            <input type="number" min="0" max="1000000" step="0.01" class="form-control" placeholder="Prezzo" value="0" name='prezzo' required>
                                        </div>
                                    </div>
                                    <!-- /.col -->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>IVA (&percnt;)</label>
                                            <input type="number" min="0" max="100" step="0.5" class="form-control" placeholder="IVA: tipo 10 o 4" value="10" name='iva' required>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.box-body -->

                        </div>
                        <!-- /.box -->

                        <input type="hidden" name="TipoOperazione" value="1" />

                        <div class="form-group row m-t-md">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-block btn-primary btn-lg">INSERISCI</button>
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
