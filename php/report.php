<?php 

function report_prodotti_tabella() {
    try {
        include 'config.php';
        
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $sql = "SELECT prodotto.pro_categoria, prodotto.pro_descrizione, prodotto.pro_prezzo, ".
               "SUM(prodotto.pro_prezzo * ddtdettaglio.ddd_quantita) As TotaleVenduto, SUM(ddtdettaglio.ddd_quantita) As TotalePeso ". 
               "FROM prodotto ".
               "INNER JOIN ddtdettaglio ON ddtdettaglio.ddd_fkprodotto = prodotto.pro_id ".
               "WHERE pro_vecchio = 0 AND ddtdettaglio.ddd_annullato = 0 ".
               "GROUP BY prodotto.pro_categoria, prodotto.pro_descrizione ".
               "ORDER BY TotaleVenduto DESC, prodotto.pro_categoria ASC, prodotto.pro_descrizione ASC";

        $result = $db->query($sql);
        foreach ($result as $row) {
            $row = get_object_vars($row);
                        
            print "<tr>";
            
            print "<td>".convertiStringaToHTML(utf8_decode($row['pro_categoria']))."</td>";
            print "<td>".convertiStringaToHTML(utf8_decode($row['pro_descrizione']))."</td>";
            print "<td>&euro; ".number_format($row['pro_prezzo'], 2, '.', '')."</td>";
            print "<td>&euro; ".number_format($row['TotaleVenduto'], 2, '.', '')."</td>";
            print "<td>".number_format($row['TotalePeso'], 3, '.', '')."</td>";

            print "</tr>";
        }
        // chiude il database
        $db = NULL;
    } catch (PDOException $e) {
        throw new PDOException("Error  : " . $e->getMessage());
    }
}


function report_categorie_tabella() {
    try {
        include 'config.php';
        
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $sql = "SELECT prodotto.pro_categoria, ".
               "SUM(prodotto.pro_prezzo * ddtdettaglio.ddd_quantita) As TotaleVenduto, ".
               "SUM(ddtdettaglio.ddd_quantita) As TotalePeso ". 
               "FROM prodotto ".
               "INNER JOIN ddtdettaglio ON ddtdettaglio.ddd_fkprodotto = prodotto.pro_id ".
               "WHERE pro_vecchio = 0 AND ddtdettaglio.ddd_annullato = 0 ".
               "GROUP BY prodotto.pro_categoria ".
               "ORDER BY TotaleVenduto DESC";

        $result = $db->query($sql);
        foreach ($result as $row) {
            $row = get_object_vars($row);
                        
            print "<tr>";
            
            print "<td>".convertiStringaToHTML(utf8_decode($row['pro_categoria']))."</td>";
            print "<td>&euro; ".number_format($row['TotaleVenduto'], 2, '.', '')."</td>";
            print "<td>".number_format($row['TotalePeso'], 3, '.', '')."</td>";

            print "</tr>";
        }
        // chiude il database
        $db = NULL;
    } catch (PDOException $e) {
        throw new PDOException("Error  : " . $e->getMessage());
    }
}


function report_cliente_tabella() {
    try {
        include 'config.php';
        
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $sql = "SELECT cliente.cli_denominazione, SUM(prodotto.pro_prezzo * ddtdettaglio.ddd_quantita) As TotaleVenduto, ".
               "SUM(ddtdettaglio.ddd_quantita) As TotalePeso ".
               "FROM prodotto ".
               "INNER JOIN ddtdettaglio ON ddtdettaglio.ddd_fkprodotto = prodotto.pro_id ".
               "INNER JOIN ddt ON ddtdettaglio.ddd_fkddt = ddt.ddt_id ".
               "INNER JOIN cliente ON ddt.ddt_fkcliente = cliente.cli_id ".
               "WHERE pro_vecchio = 0 AND ddtdettaglio.ddd_annullato = 0 AND cliente.cli_vecchio = 0 ".
               "GROUP BY cliente.cli_denominazione ".
               "ORDER BY TotaleVenduto DESC, cliente.cli_denominazione ASC";

        $result = $db->query($sql);
        foreach ($result as $row) {
            $row = get_object_vars($row);
                        
            print "<tr>";
            
            print "<td>".convertiStringaToHTML(utf8_decode($row['cli_denominazione']))."</td>";
            print "<td>&euro; ".number_format($row['TotaleVenduto'], 2, '.', '')."</td>";
            print "<td>".number_format($row['TotalePeso'], 3, '.', '')."</td>";

            print "</tr>";
        }
        // chiude il database
        $db = NULL;
    } catch (PDOException $e) {
        throw new PDOException("Error  : " . $e->getMessage());
    }
}

function report_mensile_tabella() {
    try {
        include 'config.php';
        
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $sql =  "SELECT ddt.ddt_anno AS anno, MONTH(ddt.ddt_data) AS mese, ".
                "SUM(prodotto.pro_prezzo * ddtdettaglio.ddd_quantita) As Totale ".
                "FROM prodotto ".
                "INNER JOIN ddtdettaglio ON ddtdettaglio.ddd_fkprodotto = prodotto.pro_id ".
                "INNER JOIN ddt ON ddtdettaglio.ddd_fkddt = ddt.ddt_id ".
                "WHERE pro_vecchio = 0 AND ddtdettaglio.ddd_annullato = 0 ".
                "GROUP BY ddt.ddt_anno, MONTH(ddt.ddt_data) ".
                "ORDER BY ddt.ddt_anno DESC, MONTH(ddt.ddt_data) ASC";

        $result = $db->query($sql);
        foreach ($result as $row) {
            $row = get_object_vars($row);
                        
            print "<tr>";
            

            print "<td>".$row['mese']." / ".$row['anno']."</td>";
            print "<td>&euro; ".number_format($row['Totale'], 2, '.', '')."</td>";

            print "</tr>";
        }
        // chiude il database
        $db = NULL;
    } catch (PDOException $e) {
        throw new PDOException("Error  : " . $e->getMessage());
    }
}

function VenditeMensiliGrafico() {
    try {
        include 'config.php';
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $suddivisione = array();
        $sql =  "SELECT ddt.ddt_anno AS anno, MONTH(ddt.ddt_data) AS mese, ".
                "SUM(prodotto.pro_prezzo * ddtdettaglio.ddd_quantita) As Totale ".
                "FROM prodotto ".
                "INNER JOIN ddtdettaglio ON ddtdettaglio.ddd_fkprodotto = prodotto.pro_id ".
                "INNER JOIN ddt ON ddtdettaglio.ddd_fkddt = ddt.ddt_id ".
                "WHERE pro_vecchio = 0 AND ddtdettaglio.ddd_annullato = 0 ".
                "GROUP BY ddt.ddt_anno, MONTH(ddt.ddt_data) ".
                "ORDER BY ddt.ddt_anno DESC, MONTH(ddt.ddt_data) ASC";

        $result = $db->query($sql);
        foreach ($result as $row) {
            $row = get_object_vars($row);
            $indice = ((string) $row['mese'])."/".((string) $row['anno']);
            if (isset($suddivisione[$indice]))
            { 
                $suddivisione[$indice] += $row['Totale']; 
            } else {
                $suddivisione[$indice] = $row['Totale'];
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


// Distribuito

function DistribuitoAnnoInCorso() {
    try {
        include 'config.php';
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
        
        $curYear = date('Y');

        $sql =  "SELECT SUM(prodotto.pro_prezzo * ddtdettaglio.ddd_quantita) As distribuito ".
                "FROM prodotto ".
                "INNER JOIN ddtdettaglio ON ddtdettaglio.ddd_fkprodotto = prodotto.pro_id ".
                "INNER JOIN ddt ON ddtdettaglio.ddd_fkddt = ddt.ddt_id ".
                "WHERE ddtdettaglio.ddd_annullato = 0 AND ddt.ddt_anno = ".$curYear;

        $result = $db->query($sql);
        $row = $result->fetch(PDO::FETCH_ASSOC);

        // chiude il database
        $db = NULL;

        return $row['distribuito'];

    } catch (PDOException $e) {
        throw new PDOException("Error  : " . $e->getMessage());
    }
}

function MiglioreClienteDenominazione() {
    try {
        include 'config.php';
        
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $sql = "SELECT cliente.cli_denominazione, SUM(prodotto.pro_prezzo * ddtdettaglio.ddd_quantita) As TotaleVenduto ".
               "FROM prodotto ".
               "INNER JOIN ddtdettaglio ON ddtdettaglio.ddd_fkprodotto = prodotto.pro_id ".
               "INNER JOIN ddt ON ddtdettaglio.ddd_fkddt = ddt.ddt_id ".
               "INNER JOIN cliente ON ddt.ddt_fkcliente = cliente.cli_id ".
               "WHERE pro_vecchio = 0 AND ddtdettaglio.ddd_annullato = 0 AND cliente.cli_vecchio = 0 ".
               "GROUP BY cliente.cli_denominazione ".
               "ORDER BY TotaleVenduto DESC, cliente.cli_denominazione ASC ".
               "LIMIT 1";

        $result = $db->query($sql);
        $row = $result->fetch(PDO::FETCH_ASSOC);

        // chiude il database
        $db = NULL;

        return $row['cli_denominazione'];

    } catch (PDOException $e) {
        throw new PDOException("Error  : " . $e->getMessage());
    }
}

function MiglioreClienteImporto() {
    try {
        include 'config.php';
        
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $sql = "SELECT cliente.cli_denominazione, SUM(prodotto.pro_prezzo * ddtdettaglio.ddd_quantita) As TotaleVenduto ".
               "FROM prodotto ".
               "INNER JOIN ddtdettaglio ON ddtdettaglio.ddd_fkprodotto = prodotto.pro_id ".
               "INNER JOIN ddt ON ddtdettaglio.ddd_fkddt = ddt.ddt_id ".
               "INNER JOIN cliente ON ddt.ddt_fkcliente = cliente.cli_id ".
               "WHERE pro_vecchio = 0 AND ddtdettaglio.ddd_annullato = 0 AND cliente.cli_vecchio = 0 ".
               "GROUP BY cliente.cli_denominazione ".
               "ORDER BY TotaleVenduto DESC, cliente.cli_denominazione ASC ".
               "LIMIT 1";

        $result = $db->query($sql);
        $row = $result->fetch(PDO::FETCH_ASSOC);

        // chiude il database
        $db = NULL;

        return $row['TotaleVenduto'];

    } catch (PDOException $e) {
        throw new PDOException("Error  : " . $e->getMessage());
    }
}

function MiglioreProdotto() {
    try {
        include 'config.php';
        
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $sql = "SELECT prodotto.pro_categoria, prodotto.pro_descrizione, ".
               "SUM(prodotto.pro_prezzo * ddtdettaglio.ddd_quantita) As TotaleVenduto ". 
               "FROM prodotto ".
               "INNER JOIN ddtdettaglio ON ddtdettaglio.ddd_fkprodotto = prodotto.pro_id ".
               "WHERE pro_vecchio = 0 AND ddtdettaglio.ddd_annullato = 0 ".
               "GROUP BY prodotto.pro_categoria, prodotto.pro_descrizione ".
               "ORDER BY TotaleVenduto DESC, prodotto.pro_categoria ASC, prodotto.pro_descrizione ASC ".
               "LIMIT 1";

        $result = $db->query($sql);
        $row = $result->fetch(PDO::FETCH_ASSOC);

        // chiude il database
        $db = NULL;

        return array($row['pro_categoria']." - ".$row['pro_descrizione'], $row['TotaleVenduto']);

    } catch (PDOException $e) {
        throw new PDOException("Error  : " . $e->getMessage());
    }
}