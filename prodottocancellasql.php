<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Fatturazione | PRODOTTO</title>
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
                    $menugenerale = 0; $menuclienti = 0; $menuprodotti = 1; $menuddt = 0; $menufatture = 0; $menustatistiche = 0; $menuutilita = 0;
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
                        <small>Cancella</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li> Home</li>
                        <li class="active">Prodotto</li>
                        <li class="active">Cancella</li>
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
                    if (!isset($_GET['pro_id'])) {
                        $errore['pro_id'] = 'ID';
                    } else {
                        $id = $_GET['pro_id'];
                    }

                                        
                    if (!$prodotto->Cancella($id)){
                        $errore['database'] = 'Errore SQL';
                    }


                    if (empty($errore)) {
                        echo "<div class='callout callout-success'><h4>Prodotto cancellato</h4><p>Modifiche alla base dati effettuata correttamente</p></div>";
                    }

                    if (!empty($errore)) {
                        echo "<div class='callout callout-danger'><h4>Errore nella cancellazione del prodotto</h4><p>Ricontrollare i dati inseriti o chiamare l'amministratore</p></div>";
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
        setTimeout(function () { window.location.href= 'prodottolista.php'; },1000); // 3.5 secondi
    </script>
</html>