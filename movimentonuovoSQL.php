<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> HelpBook | MOVIMENTO - AGGIUNGI AL DATABASE</title>
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
                    
     
                    
                    
                    
                    <!-- **********************************CONTENUTO****************************** -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">INSERIMENTO DATABASE</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    
                                    
                                    
                                    
                                    
                                    <?php
                                    
                                    // RECUPERO DATI E AGGIUNGO
                                    define('CHARSET', 'UTF-8');
                                    define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);

                                    $errors = array();
                                    
                                    if (empty($_GET['cliente'])) {
                                        $errors['cliente'] = 'ID cliente non passato';
                                    } else {
                                        $cliente = $_GET['cliente'];
                                    }

                                    if (empty($_GET['dataEmissione'])) {
                                        $errors['dataEmissione'] = 'dataEmissione non passato';
                                    } else {
                                        $dataEmissione = DateTime::createFromFormat('d/m/Y', $_GET['dataEmissione']);
                                    }

                                    if (empty($_GET['tipologia'])) {
                                        $errors['tipologia'] = 'tipologia non passato';
                                    } else {
                                        $tipologia = $_GET['tipologia'];
                                    }

                                    if (empty($_GET['causale'])) {
                                        $errors['causale'] = 'causale non passato';
                                    } else {
                                        $causale = $_GET['causale'];
                                    }

                                    if (!isset($_GET['riferimento'])) {
                                        $riferimento = '-';
                                    } else {
                                        $riferimento = $_GET['riferimento'];
                                    }

                                    if (!isset($_GET['spedizione'])) {
                                        $errors['spedizione'] = 'spedizione non passato';
                                    } else {
                                        $spedizione = $_GET['spedizione'];
                                    }

                                    if (!isset($_GET['spedizionesconto'])) {
                                        $errors['spedizionesconto'] = 'spedizionesconto non passato';
                                    } else {
                                        $spedizionesconto = $_GET['spedizionesconto'];
                                    }

                                    if (empty($_GET['trasporto'])) {
                                        $errors['trasporto'] = 'trasporto non passato';
                                    } else {
                                        $trasporto = $_GET['trasporto'];
                                    }

                                    if (empty($_GET['aspetto'])) {
                                        $errors['aspetto'] = 'aspetto non passato';
                                    } else {
                                        $aspetto = $_GET['aspetto'];
                                    }

                                    if (empty($_GET['modalita'])) {
                                        $errors['modalita'] = 'modalita non passato';
                                    } else {
                                        $modalita = $_GET['modalita'];
                                    }

                                    if (empty($_GET['dataEntro'])) {
                                        $errors['dataEntro'] = 'dataEntro non passato';
                                    } else {
                                        $dataEntro = DateTime::createFromFormat('d/m/Y', $_GET['dataEntro']);
                                    }

                                    if (!isset($_GET['pagato'])) {
                                        $errors['pagato'] = 'pagato non passato';
                                    } else {
                                        $pagato = $_GET['pagato'];
                                    }

                                    if (empty($_GET['dataPagamento'])) {
                                        //
                                    } else {
                                        $dataPagamento = DateTime::createFromFormat('d/m/Y', $_GET['dataPagamento']);
                                    }

                                    if (!isset($_GET['note'])) {
                                        $note = '-';
                                    } else {
                                        $note = $_GET['note'];
                                    }

                                    if (empty($errors)) {
                                        try {
                                            include 'php/config.php';
                                            
                                            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
                                            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                                            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                                            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

                                            date_default_timezone_set('Europe/Rome');

                                            $result = $db->query("SELECT MAX(numero) AS ultimo FROM movimenti WHERE anno = '" . $dataEmissione->format('Y') . "' AND fktipologia = " . $tipologia . "");
                                            $row = $result->fetch(PDO::FETCH_ASSOC);
                                            $numero = $row['ultimo'] + 1;

                                            if (!isset($dataPagamento)) {
                                                $db->exec("INSERT INTO movimenti (idmovimento, fktipologia, fkcausale, numero, anno, riferimento, fksoggetto, movimentodata, pagamentoentro, pagata, fkpagamentotipologia, datapagamento, spedizionecosto, spedizionesconto, fkaspetto, fktrasporto, note, cancellato) VALUES (NULL, '" . $tipologia . "', '" . $causale . "', '" . $numero . "', '" . $dataEmissione->format('Y') . "', '" . $riferimento . "', '" . $cliente . "', '" . $dataEmissione->format('Y-m-d') . "', '" . $dataEntro->format('Y-m-d') . "', '" . $pagato . "', '" . $modalita . "', NULL, '" . $spedizione . "', '" . $spedizionesconto . "', '" . $aspetto . "', '" . $trasporto . "', '" . $note . "', '0');");
                                            } else {
                                                $db->exec("INSERT INTO movimenti (idmovimento, fktipologia, fkcausale, numero, anno, riferimento, fksoggetto, movimentodata, pagamentoentro, pagata, fkpagamentotipologia, datapagamento, spedizionecosto, spedizionesconto, fkaspetto, fktrasporto, note, cancellato) VALUES (NULL, '" . $tipologia . "', '" . $causale . "', '" . $numero . "', '" . $dataEmissione->format('Y') . "', '" . $riferimento . "', '" . $cliente . "', '" . $dataEmissione->format('Y-m-d') . "', '" . $dataEntro->format('Y-m-d') . "', '" . $pagato . "', '" . $modalita . "', '" . $dataPagamento->format('Y-m-d') . "', '" . $spedizione . "', '" . $spedizionesconto . "', '" . $aspetto . "', '" . $trasporto . "', '" . $note . "', '0');");
                                            }
                                                                                        
                                            // chiude il database
                                            $db = NULL;
                                        } catch (PDOException $e) {
                                            $errors['database'] = "Errore inserimento nel database";
                                        }
                                    }

                                    if (!empty($errors)) {
                                        echo "<div class='alert alert-danger alert-dismissible'><h4><i class='icon fa fa-ban'></i> ATTENZIONE!</h4>Ci sono degli errori</div>";
                                    } else {
                                        echo "<div class='alert alert-success alert-dismissible'><h4><i class='icon fa fa-check'></i> OK!</h4>Inserimento riuscito</div>";
                                    }

                                    ?>


                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                </div>
                                <!-- /.col -->

                                <div class="col-md-6">
                                    
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

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
    </body>
</html>