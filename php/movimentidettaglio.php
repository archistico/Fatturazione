<?php

function movimentiDettaglioListaTabella($idmovimento) {
    try {
        include 'config.php';
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $result = $db->query('SELECT libri.*, casaeditrice.*, libritipologia.*, movimentidettaglio.* FROM movimentidettaglio INNER JOIN libri ON movimentidettaglio.fklibro = libri.idlibro INNER JOIN casaeditrice ON libri.fkcasaeditrice = casaeditrice.idcasaeditrice INNER JOIN libritipologia ON libri.fktipologia = libritipologia.idlibrotipologia WHERE libri.cancellato = 0 && movimentidettaglio.fkmovimento='.$idmovimento);
        foreach ($result as $row) {
            $row = get_object_vars($row);
            print "<tr>";
            print "<td>".$row['quantita']."</td>";
            print "<td>". $row['casaeditrice']." - ".convertiStringaToHTML($row['titolo']) . " (".$row['librotipologia'].")</td>";
            print "<td>".$row['isbn']."</td>";
            print "<td>&euro; ".number_format($row['prezzo'], 2)."</td>";
            print "<td>".number_format($row['sconto'],2)." %</td>";
            $prezzoscontato = $row['prezzo'] *(1 - $row['sconto']/100);
            print "<td>&euro;".number_format($prezzoscontato, 2)."</td>";
            $subtotale = $prezzoscontato * $row['quantita'];
            print "<td>&euro;".number_format($subtotale, 2)."</td>";
            print "<td><div class = 'btn-group'><a class='btn btn-xs btn-danger' href='movimentovisualizza.php?idmovimento=".$idmovimento."&idmovimentodettaglio=".$row['idmovimentodettaglio']."' role='button'><i class = 'fa fa-remove'></i></a></div></td>";
            print "</tr>";
        }
        // chiude il database
        $db = NULL;
    } catch (PDOException $e) {
        throw new PDOException("Error  : " . $e->getMessage());
    }
}

