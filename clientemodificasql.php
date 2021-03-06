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
                        <small>Modifica</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li> Home</li>
                        <li class="active">Cliente</li>
                        <li class="active">Modifica</li>
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
                    
                    if (!isset($_GET['id'])) {
                        $errore['id'] = 'id';
                    } else {
                        $cliente->cli_id = $_GET['id'];
                    }

                    if (!isset($_GET['denominazione'])) {
                        $errore['denominazione'] = 'denominazione';
                    } else {
                        $cliente->cli_denominazione = pulisciStringa($_GET['denominazione']);
                    }

                    if (!isset($_GET['nome'])) {
                        // nessun errore - non obbligatorio
                    } else {
                        $cliente->cli_denominazione .= " ". pulisciStringa($_GET['nome']);
                    }

                    if (!isset($_GET['indirizzo'])) {
                        $errore['indirizzo'] = 'indirizzo';
                    } else {
                        $cliente->cli_indirizzo = pulisciStringa($_GET['indirizzo']);
                    }

                    if (!isset($_GET['cap'])) {
                        $errore['cap'] = 'cap';
                    } else {
                        $cliente->cli_cap = pulisciStringa($_GET['cap']);
                    }

                    if (!isset($_GET['comune'])) {
                        $errore['comune'] = 'comune';
                    } else {
                        $cliente->cli_comune = pulisciStringa($_GET['comune']);
                    }

                    if (!isset($_GET['telefono'])) {
                        $cliente->cli_telefono = "";
                    } else {
                        $cliente->cli_telefono = pulisciStringa($_GET['telefono']);
                    }

                    if (!isset($_GET['fax'])) {
                        $cliente->cli_fax = "";
                    } else {
                        $cliente->cli_fax = pulisciStringa($_GET['fax']);
                    }

                    if (!isset($_GET['email'])) {
                        $cliente->cli_email = "";
                    } else {
                        $cliente->cli_email = pulisciStringa($_GET['email']);
                    }

                    if (!isset($_GET['piva'])) {
                        $errore['piva'] = 'piva';
                    } else {
                        $cliente->cli_piva = pulisciStringa($_GET['piva']);
                    }
                    
                    if (!$cliente->ModificaSQL()){
                        $errore['database'] = 'Errore SQL';
                    }


                    if (empty($errore)) {
                        echo "<div class='callout callout-success'><h4>Cliente modificato</h4><p>Modifiche alla base dati effettuata correttamente</p></div>";
                    }

                    if (!empty($errore)) {
                        echo "<div class='callout callout-danger'><h4>Errore nella modifica</h4><p>Ricontrollare i dati inseriti o chiamare l'amministratore</p></div>";
                    }
                    

                    


                    
                    
                    
                    ?>

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
    <script>
        setTimeout(function () { window.location.href= 'clientelista.php'; },1000); // 3.5 secondi
    </script>
</html>