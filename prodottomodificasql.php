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

                    <?php 
                    include 'php/utilita.php';
                    include 'php/config.php';
                    include 'php/prodotto.php';
                    
                    // RECUPERO DATI E AGGIUNGO
                    define('CHARSET', 'UTF-8');
                    define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);

                    $errore = array();
                    
                    $prodotto = new Prodotto();

                    // Carico le variabili
                    
                    if (!isset($_GET['id'])) {
                        $errore['id'] = 'id';
                    } else {
                        $prodotto->pro_id = $_GET['id'];
                    }

                    if (!isset($_GET['categoria'])) {
                        $errore['categoria'] = 'categoria';
                    } else {
                        $prodotto->pro_categoria = $_GET['categoria'];
                    }

                    if (!isset($_GET['descrizione'])) {
                        $errore['descrizione'] = 'descrizione';
                    } else {
                        $prodotto->pro_descrizione = $_GET['descrizione'];
                    }

                    if (!isset($_GET['prezzo'])) {
                        $errore['prezzo'] = 'prezzo';
                    } else {
                        $prodotto->pro_prezzo = $_GET['prezzo'];
                    }

                    if (!isset($_GET['iva'])) {
                        $errore['iva'] = 'iva';
                    } else {
                        $prodotto->pro_iva = $_GET['iva'];
                    }

                    
                    if (empty($errore)){
                        if (!$prodotto->ModificaSQL()){
                            $errore['database'] = 'Errore SQL';
                        }
                    }


                    if (empty($errore)) {
                        echo "<div class='callout callout-success'><h4>Prodotto modificato</h4><p>Modifiche alla base dati effettuata correttamente</p></div>";
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
        setTimeout(function () { window.location.href= 'prodottolista.php'; },3500); // 3.5 secondi
    </script>
</html>
