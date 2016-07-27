<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> HelpBook | MOVIMENTO - NUOVO</title>
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
                ?>



                <section class="content-header">
                    <h1>
                        MOVIMENTO
                        <small>NUOVO</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Movimenti</a></li>
                        <li class="active">Nuovo</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    
                    <form role="form" name="movimentoForm" action="movimentonuovoSQL.php" method="get">
                    
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
                                        <select class="form-control select2" style="width: 100%;" name='cliente' required>
                                            <?php
                                            include 'php/soggetti.php';
                                            soggettiSelect();
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- /.col -->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Data movimento</label>
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




                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tipologia</label>
                                        <select class="form-control select2" style="width: 100%;" name='tipologia' required>
                                            <?php
                                            include 'php/movimentitipologia.php';
                                            movimentiTipologiaSelect();
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- /.col -->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Causale</label>
                                        <select class="form-control select2" style="width: 100%;" name='causale' required>
                                            <?php
                                            include 'php/movimenticausale.php';
                                            movimentiCausaleSelect();
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Riferimento <em>(opzionale)</em></label>
                                        <input type="text" class="form-control" placeholder="Riferimento" name='riferimento'>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Spese di spedizione</label>
                                        <input type="number" min="0" max="1000" step="0.01" class="form-control" placeholder="Spese spedizione" value="0" name='spedizione' required>
                                    </div>
                                </div>
                                <!-- /.col -->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Sconto spedizione (%)</label>
                                        <input type="number" min="0" max="100" step="0.01" class="form-control" placeholder="Sconto spedizione" value='0' name='spedizionesconto' required>
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
                                            <?php
                                            include 'php/movimentitrasporto.php';
                                            movimentiTrasportoSelect();
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- /.col -->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Aspetto</label>
                                        <select class="form-control select2" style="width: 100%;" name='aspetto' required>
                                            <?php
                                            include 'php/movimentiaspetto.php';
                                            movimentiAspettoSelect();
                                            ?>
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


                    
                    
                    
                    
                    
                    
                    
                    <!-- **********************************PAGAMENTO****************************** -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">PAGAMENTO</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cliente</label>
                                        <select class="form-control select2" style="width: 100%;"  name='modalita' required>
                                            <?php
                                            include 'php/pagamentitipologia.php';
                                            pagamentiTipologiaSelect();
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- /.col -->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Da pagare entro</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right" id="datepicker2" name='dataEntro' required>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->




                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pagato</label>
                                        <select class="form-control select2" style="width: 100%;" name='pagato' required>
                                            <option value="1">Sì</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- /.col -->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Data di effettivo pagamento</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right" id="datepicker3"  name='dataPagamento'>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Note <em>(opzionale)</em></label>
                                        <input type="text" class="form-control" placeholder="Note" name='note'>
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
                
                //Date picker
                $('#datepicker3').datepicker({
                    autoclose: true
                });
                
            });
        </script>
    </body>
</html>