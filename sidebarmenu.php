<ul class="sidebar-menu">
    <li class="header">Menu</li>
    <li class="<?php echo ($menugenerale)?'active':''; ?> treeview">
        <a href="index.php">
            <i class="fa fa-dashboard"></i> <span>Generale</span>
        </a>
    </li>
    <li class="<?php echo ($menuclienti)?'active':''; ?> treeview">
        <a href="#">
            <i class="fa fa-user"></i> <span>Clienti</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="clientenuovo.php"><i class="fa fa-plus"></i> Nuovo cliente</a></li>
            <li><a href="clientelista.php"><i class="fa fa-list"></i> Lista clienti</a></li>
        </ul>
    </li>
    <li class="<?php echo ($menuprodotti)?'active':''; ?> treeview">
        <a href="#">
            <i class="fa fa-barcode"></i> <span>Prodotti</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="prodottonuovo.php"><i class="fa fa-plus"></i> Nuovo prodotto</a></li>
            <li><a href="prodottolista.php"><i class="fa fa-list"></i> Lista prodotti</a></li>
        </ul>
    </li>
    <li class="<?php echo ($menuddt)?'active':''; ?> treeview">
        <a href="#">
            <i class="fa fa-truck"></i> <span>DDT</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="ddtnuovo.php"><i class="fa fa-plus"></i> Nuovo DDT</a></li>
            <li><a href="ddtlista.php"><i class="fa fa-list"></i> Lista DDT</a></li>
        </ul>
    </li>
    <li class="<?php echo ($menufatture)?'active':''; ?> treeview">
        <a href="#">
            <i class="fa fa-table"></i> <span>Fatture</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="fatturanuova.php"><i class="fa fa-plus"></i> Nuova fattura</a></li>
            <li><a href="fatturalista.php"><i class="fa fa-list"></i> Lista fatture</a></li>
            <li><a href="fatturalistanonpagate.php"><i class="fa fa-euro"></i> Lista fatture non pagate</a></li>
        </ul>
    </li>
    <li class="<?php echo ($menustatistiche)?'active':''; ?> treeview">
        <a href="#">
            <i class="fa fa-pie-chart"></i> <span>Report</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="reportprodotto.php"><i class="fa fa-line-chart"></i> Top prodotti</a></li>
            <li><a href="reportcategoria.php"><i class="fa fa-bar-chart"></i> Top categorie</a></li>
            <li><a href="reportcliente.php"><i class="fa fa-money"></i> Top clienti</a></li>
            <li><a href="reportmensile.php"><i class="fa fa-bar-chart"></i> Mensile vendite</a></li>
        </ul>
    </li>
    <li class="<?php echo ($menuutilita)?'active':''; ?> treeview">
        <a href="#">
            <i class="fa fa-gear"></i> <span>Utilit&agrave;</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="utilitasalvadb.php"><i class="fa fa-database"></i> Salva database</a></li>
        </ul>
    </li>

</ul>
