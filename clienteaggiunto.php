<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Fatturazione | CLIENTE</title>
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
                    $menugenerale = 0; $menuclienti = 1; $menuprodotti = 0; $menuddt = 0; $menufatture = 0; $menustatistiche = 0;
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
                        <small>Nuovo</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li> Home</li>
                        <li class="active">CLIENTE</li>
                        <li class="active">Nuovo</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    
                    <?php 
                    include 'php/utilita.php';
                    include 'php/config.php';
                    include 'php/cliente.php';
                    
                    // RECUPERO DATI E AGGIUNGO
                    define('CHARSET', 'UTF-8');
                    define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);

                    $errore = array();
                    
                    $cliente = new Cliente();

                    // Carico le variabili
                    if (!isset($_GET['denominazione'])) {
                        $errore['denominazione'] = 'denominazione';
                    } else {
                        $cliente->cli_denominazione = $_GET['denominazione'];
                    }

                    if (!isset($_GET['nome'])) {
                        // nessun errore - non obbligatorio
                    } else {
                        $cliente->cli_denominazione .= " ". $_GET['nome'];
                    }

                    if (!isset($_GET['indirizzo'])) {
                        $errore['indirizzo'] = 'indirizzo';
                    } else {
                        $cliente->cli_indirizzo = $_GET['indirizzo'];
                    }

                    if (!isset($_GET['cap'])) {
                        $errore['cap'] = 'cap';
                    } else {
                        $cliente->cli_cap = $_GET['cap'];
                    }

                    if (!isset($_GET['comune'])) {
                        $errore['comune'] = 'comune';
                    } else {
                        $cliente->cli_comune = $_GET['comune'];
                    }

                    if (!isset($_GET['telefono'])) {
                        $cliente->cli_telefono = "";
                    } else {
                        $cliente->cli_telefono = $_GET['telefono'];
                    }

                    if (!isset($_GET['fax'])) {
                        $cliente->cli_fax = "";
                    } else {
                        $cliente->cli_fax = $_GET['fax'];
                    }

                    if (!isset($_GET['email'])) {
                        $cliente->cli_email = "";
                    } else {
                        $cliente->cli_email = $_GET['email'];
                    }

                    if (!isset($_GET['piva'])) {
                        $errore['piva'] = 'piva';
                    } else {
                        $cliente->cli_piva = $_GET['piva'];
                    }

                    if (empty($errore)) {

                        if ($cliente->AggiungiSQL()) {
                            echo "<div class='callout callout-success'><h4>Aggiunta riuscita</h4><p>Inserito nel database</p></div>";
                        } else {
                            $errore['creazione'] = 'Database';
                        }
                    }

                    if (!empty($errore)) {
                        echo "<div class='callout callout-danger'><h4>Errore nell'inserimento nel database</h4><p>Ricontrollare i dati inseriti o chiamare l'amministratore</p></div>";
                    }
                    

                    


                    
                    
                    
                    ?>

                    <a href="clientelista.php">Vai alla lista dei clienti</a>

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
    <<script>
        setTimeout(function () {
            window.location.href= 'clientelista.php'; 
        },3500); // 5 secondi
    </script>
</html>


