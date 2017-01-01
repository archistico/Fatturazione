<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Fatturazione | Cliente</title>
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
                        CLIENTE
                        <small>MODIFICA</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i> Home</li>
                        <li>Cliente</li>
                        <li class="active">Modifica</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <form role="form" name="Form" action="clientemodificasql.php" method="get">

                        <?php
                        include 'php/utilita.php';
                        include 'php/cliente.php';
                    
                        $cliente = new Cliente();
                        
                        if (!isset($_GET['cli_id'])) {
                            $errore['cli_id'] = 'ID non presente';
                        } else {
                            $id = $_GET['cli_id'];
                        }

                        if (empty($errore)) {

                            if ($cliente->CaricaSQL($id)) {
                                // ok
                            } else {
                                $errore['db'] = 'Ricerca DB';
                            }
                        }

                        if (!empty($errore)) {
                            print "<div class='pad margin no-print'><div class='callout callout-danger' style='margin-bottom: 0!important;'><h4><i class='fa fa-times'></i> Risultato:</h4> ERRORE</div></div>";
                            print "<a href='index.php'>Torna alla home</a>";
                            die();
                        }

                    
                        ?>

                        <!-- **********************************CLIENTE****************************** -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">MODIFICA</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Denominazione / Cognome</label>
                                            <input type="text" class="form-control" placeholder="Inserisci la denominazione dell'azienda o il cognome" name='denominazione' value="<?php echo $cliente->cli_denominazione; ?>" required>
                                        </div>
                                    </div>
                                    <!-- /.col -->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nome</label>
                                            <input type="text" class="form-control" placeholder="Eventuale nome se il cliente è un privato" name='nome'>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Indirizzo</label>
                                            <input type="text" class="form-control" placeholder="Via / Piazza ... e numero civico" name='indirizzo'  value="<?php echo $cliente->cli_indirizzo; ?>" required>
                                        </div>
                                    </div>
                                    <!-- /.col -->

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>CAP</label>
                                            <input type="text" class="form-control" placeholder="CAP" name='cap' value="<?php echo $cliente->cli_cap; ?>" required>
                                        </div>
                                    </div>
                                    <!-- /.col -->

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Comune</label>
                                            <input type="text" class="form-control" placeholder="Comune" name='comune'  value="<?php echo $cliente->cli_comune; ?>" required>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Telefono</label>
                                            <input type="text" class="form-control" placeholder="Numero di telefono" name='telefono'  value="<?php echo $cliente->cli_telefono; ?>">
                                        </div>
                                    </div>
                                    <!-- /.col -->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fax</label>
                                            <input type="text" class="form-control" placeholder="fax" name='fax'  value="<?php echo $cliente->cli_fax; ?>">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>P.IVA / Codice fiscale</label>
                                            <input type="text" class="form-control" placeholder="Partita iva e/o codice fiscale" name='piva'  value="<?php echo $cliente->cli_piva; ?>" required>
                                        </div>
                                    </div>
                                    <!-- /.col -->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control" placeholder="Indirizzo email" name='email' value="<?php echo $cliente->cli_email; ?>">
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                            </div>
                            <!-- /.box-body -->

                        </div>
                        <!-- /.box -->

                        <input type="hidden" name="id" value="<?php echo $id; ?>">

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
