<?php

class DDTDettaglio {
    public $ddd_id;
    public $ddd_fkddt;
    public $ddd_quantita;
    public $ddd_fkprodotto;
    public $ddd_tracciabilita;

    public $ddd_fkprodotto_categoria;
    public $ddd_fkprodotto_descrizione;
    public $ddd_fkprodotto_prezzo;
    public $ddd_fkprodotto_iva;
    public $ddd_fkprodotto_misura;

    public function CaricaSQL($id) {
    try {
        include 'config.php';
        
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
        
        $listaDettaglio = array();

        $result = $db->query('SELECT ddtdettaglio.*, prodotto.* FROM ddtdettaglio INNER JOIN prodotto ON ddtdettaglio.ddd_fkprodotto = prodotto.pro_id WHERE ddtdettaglio.ddd_annullato = 0 AND ddtdettaglio.ddd_fkddt = '. $id);
        foreach ($result as $row) {
            $row = get_object_vars($row);

            $dettaglio = new DDTDettaglio();
            $dettaglio->ddd_fkddt = $row['ddd_fkddt'];
            $dettaglio->ddd_quantita = $row['ddd_quantita'];
            $dettaglio->ddd_tracciabilita = $row['ddd_tracciabilita'];
            $dettaglio->ddd_fkprodotto = $row['ddd_fkprodotto'];
            $dettaglio->ddd_fkprodotto_categoria = $row['pro_categoria'];
            $dettaglio->ddd_fkprodotto_descrizione = $row['pro_descrizione'];
            $dettaglio->ddd_fkprodotto_prezzo = $row['pro_prezzo'];
            $dettaglio->ddd_fkprodotto_iva = $row['pro_iva'];
            $dettaglio->ddd_fkprodotto_misura = $row['pro_misura'];
            
            $listaDettaglio[]=$dettaglio;
        }


        // chiude il database
        $db = NULL;
        return $listaDettaglio;

        } catch (PDOException $e) {
            throw new PDOException("Error  : " . $e->getMessage());
        }
    }

    public function AggiungiSQL() {
        try {
            include "config.php";
            
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            // Aggiungo la riga
            $db->exec("INSERT INTO ddtdettaglio VALUES (NULL, '$this->ddd_fkddt','$this->ddd_quantita', '$this->ddd_fkprodotto', '$this->ddd_tracciabilita', '0');");
            
            // Calcolo l'importo
            $result = $db->query('SELECT ddtdettaglio.*, prodotto.* FROM ddtdettaglio INNER JOIN prodotto ON ddtdettaglio.ddd_fkprodotto = prodotto.pro_id WHERE ddtdettaglio.ddd_annullato = 0 AND ddtdettaglio.ddd_fkddt = ' . $this->ddd_fkddt);

            $importototale = 0;
            foreach ($result as $row) {
                $row = get_object_vars($row);
                $importo = $row['ddd_quantita'] * $row['pro_prezzo'];
                $importototale = $importototale + $importo;
            }

            // Correggo il valore dell'importo del DDT
            $db->exec("UPDATE ddt SET ddt_importo = '$importototale' WHERE ddt.ddt_id = '$this->ddd_fkddt';");
            
            // chiude il database
            $db = NULL;
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function CancellaSQL() {
        try {
            include "config.php";
            
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            // Cancello il DDT Dettaglio
            $db->exec("DELETE FROM ddtdettaglio WHERE ddd_id = '$this->ddd_id';");
            
            // Corretto l'importo del DDT
            $result = $db->query('SELECT ddtdettaglio.*, prodotto.* FROM ddtdettaglio INNER JOIN prodotto ON ddtdettaglio.ddd_fkprodotto = prodotto.pro_id WHERE ddtdettaglio.ddd_annullato = 0 AND ddtdettaglio.ddd_fkddt = ' . $this->ddd_fkddt);

            $importototale = 0;
            foreach ($result as $row) {
                $row = get_object_vars($row);
                $importo = $row['ddd_quantita'] * $row['pro_prezzo'];
                $importototale = $importototale + $importo;
            }

            // Correggo il valore dell'importo del DDT
            $db->exec("UPDATE ddt SET ddt_importo = '$importototale' WHERE ddt.ddt_id = '$this->ddd_fkddt';");
            
            // chiude il database
            $db = NULL;
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}


/*
function ddtdettaglio_tabella($id) {
    try {
        include 'config.php';
        
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
        
        // Parte iniziale
        print "<table id='ddtdettagliotabella' class='table table-bordered table-hover'>";
        print "<thead><tr>";
        print "<th>Quantit&agrave;</th><th>Prodotto</th><th>Tracciabilit&agrave;</th><th>Importo</th><th class='no-print'>#</th>";
        print "</tr></thead><tbody>";
        
        $result = $db->query('SELECT ddtdettaglio.*, prodotto.* FROM ddtdettaglio INNER JOIN prodotto ON ddtdettaglio.ddd_fkprodotto = prodotto.pro_id WHERE ddtdettaglio.ddd_annullato = 0 AND ddtdettaglio.ddd_fkddt = '. $id);
        foreach ($result as $row) {
            $row = get_object_vars($row);
                        
            print "<tr>";
            print "<td>".$row['ddd_quantita']."</td>";
            print "<td>". $row['pro_categoria'] . " - " . convertiStringaToHTML(utf8_decode($row['pro_descrizione']))." (&euro; ".$row['pro_prezzo'].")</td>";
            print "<td>".$row['ddd_tracciabilita']."</td>";
            $importo = $row['ddd_quantita']*$row['pro_prezzo'];
            print "<td>&euro; " . number_format($importo, 2, ',', ' ') . "</td>";
            print "<td class='no-print'><a class='btn btn-xs btn-danger' href='ddtvisualizza.php?ddt_id=".$id."&ddtdettaglio=".$row['ddd_id']."&TipoOperazione=3' role='button'><i class = 'fa fa-remove'></i></a></td>";
            print "</tr>";
        }
        
        // Parte finale
        print "</tbody></table>";
        
        // chiude il database
        $db = NULL;
    } catch (PDOException $e) {
        throw new PDOException("Error  : " . $e->getMessage());
    }
}
*/


// Della pagina modifica
function ddtdettaglio_tabella($id) {
    try {
        include 'config.php';
        
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
        
        // Parte iniziale
        print "<table id='ddtdettagliotabella' class='table table-bordered table-hover'>";
        print "<thead><tr>";
        print "<th>Quantit&agrave;</th><th>Prodotto</th><th>Tracciabilit&agrave;</th><th>Importo</th><th class='no-print'>#</th>";
        print "</tr></thead><tbody>";
        
        $result = $db->query('SELECT ddtdettaglio.*, prodotto.* FROM ddtdettaglio INNER JOIN prodotto ON ddtdettaglio.ddd_fkprodotto = prodotto.pro_id WHERE ddtdettaglio.ddd_annullato = 0 AND ddtdettaglio.ddd_fkddt = '. $id);
        foreach ($result as $row) {
            $row = get_object_vars($row);
                        
            print "<tr>";
            print "<td>".$row['ddd_quantita']."</td>";
            print "<td>". db2html($row['pro_categoria']) . " - " . db2html($row['pro_descrizione'])." (&euro; ".$row['pro_prezzo'].")</td>";
            print "<td>".$row['ddd_tracciabilita']."</td>";
            $importo = $row['ddd_quantita']*$row['pro_prezzo'];
            print "<td>&euro; " . number_format($importo, 2, ',', ' ') . "</td>";
            print "<td class='no-print'><a class='btn btn-danger btn-block' href='dddcancella.php?ddt_id=".$id."&ddtdettaglio=".$row['ddd_id']."' role='button'><i class = 'fa fa-remove'></i></a></td>";
            print "</tr>";
        }
        
        // Parte finale
        print "</tbody></table>";
        
        // chiude il database
        $db = NULL;
    } catch (PDOException $e) {
        throw new PDOException("Error  : " . $e->getMessage());
    }
}
