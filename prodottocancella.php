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

                    if (empty($errore)) {
                        
                        // controlla che non abbia DDTDETTAGLIO associati altrimenti blocca subito
                        if($prodotto->ControllaProdotto($id)) {

                        } else {
                            $errore['ddt'] = 'Presenza di DDT associato al prodotto';
                        }

                    }

                    if (empty($errore)) {
                        
                        echo "<div class='box box-primary'>";
                        
                        echo "<div class='box-header with-border'>";
                        echo "<h3 class='box-title'>ATTENZIONE</h3>";
                        echo "</div>";
                       
                        echo "<div class='box-body'>";

                        echo "<div class='row'>";
                        echo "<div class='col-md-12'>";
                        echo "<p>Il prodotto verrà cancellato solo se non ha ddt/fatture associate</p>";
                        
                        echo "</div>";
                        echo "</div>"; // div row

                        echo "<div class='row'>";
                        echo "<div class='col-md-6'>";
                        echo "<a class='btn btn-block btn-default btn-lg' href='prodottolista.php'>Annulla</a>";
                        echo "</div>";
                        echo "<div class='col-md-6'>";
                        echo "<a class='btn btn-block btn-danger btn-lg' href='prodottocancellasql.php?pro_id=".$id."'>Cancella prodotto</a>";
                        echo "</div>";
                        echo "</div>"; // div row
                        
                        echo "</div>"; // div box body
                        echo "</div>"; // div box
                    }

                    if (!empty($errore)) {
                        foreach($errore as $err => $messaggio){
                            switch ($err) {
                                case 'ddt' :    echo "<div class='callout callout-danger'><h4>$messaggio</h4><p>Non è possibile cancellare il prodotto che ha dei DDT associati</p></div>";
                                                break;
                                default :       echo "<div class='callout callout-danger'><h4>Errore id del prodotto</h4><p>Ricontrollare i dati inseriti o chiamare l'amministratore</p></div>"; 
                                                break;
                            }
                        }
                        
                        
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

</html>