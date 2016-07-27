<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function VenditeSuddiviseAnni() {
    try {
        include 'config.php';
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $suddivisione = array();

        $result = $db->query('SELECT libri.prezzo, libritipologia.librotipologia, movimenti.anno, movimentitipologia.codice, movimentidettaglio.quantita, movimentidettaglio.sconto FROM movimentidettaglio INNER JOIN movimenti ON movimentidettaglio.fkmovimento = movimenti.idmovimento INNER JOIN libri ON libri.idlibro = movimentidettaglio.fklibro INNER JOIN libritipologia ON libri.fktipologia = libritipologia.idlibrotipologia INNER JOIN movimentitipologia ON movimenti.fktipologia = movimentitipologia.idmovimentotipologia WHERE movimentidettaglio.cancellato = 0 AND libri.cancellato = 0 AND movimenti.cancellato = 0 ORDER BY movimenti.anno ASC;');
        foreach ($result as $row) {
            $row = get_object_vars($row);

            if (!isset($suddivisione[(string) $row['anno']])) {
                $suddivisione[(string) $row['anno']] = 0;
            }
            if ($row['codice'] == 'FA' || $row['codice'] == 'FD' || $row['codice'] == 'FI' || $row['codice'] == 'RI') {
                $prezzo = $row['prezzo'];
                $quantita = $row['quantita'];
                $sconto = 1 - $row['sconto'] / 100;

                $totale = $prezzo * $quantita * $sconto;
                $totale = round($totale * 100) / 100;

                $suddivisione[(string) $row['anno']] += $totale;
            }
        }

        print "var areaChartData = {" . "\n";
        print "labels: [";

        $numItems = count($suddivisione);
        $cont = 0;

        foreach ($suddivisione as $key => $value) {
            if (++$cont === $numItems) {
                print "'" . $key . "'";
            } else {
                print "'" . $key . "',";
            }
        }
        print "],\n";
        print "datasets: [{ label: 'Vendite', fillColor: 'rgba(210, 214, 222, 1)', strokeColor: 'rgba(210, 214, 222, 1)', pointColor: 'rgba(210, 214, 222, 1)', pointStrokeColor: '#c1c7d1', pointHighlightFill: '#fff', pointHighlightStroke: 'rgba(220,220,220,1)'," . "\n";
        print "data: [";

        $cont = 0;

        foreach ($suddivisione as $key => $value) {
            if (++$cont === $numItems) {
                print "'" . $value . "'";
            } else {
                print "'" . $value . "',";
            }
        }
        print "]\n";
        print "}]};\n";

        // chiude il database
        $db = NULL;
    } catch (PDOException $e) {
        throw new PDOException("Error  : " . $e->getMessage());
    }
}
