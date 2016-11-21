<?php

class DDTDettaglio {
    public $ddd_fkddt;
    public $ddd_quantita;
    public $ddd_fkprodotto;
    public $ddd_tracciabilita;

    public function AggiungiSQL() {
        try {
            include "config.php";
            
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            $db->exec("INSERT INTO ddtdettaglio VALUES (NULL, '$this->ddd_fkddt','$this->ddd_quantita', '$this->ddd_fkprodotto', '$this->ddd_tracciabilita', '0');");

            // chiude il database
            $db = NULL;
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}








function ddtdettaglio_tabella($id) {
    try {
        include 'config.php';
        
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $result = $db->query('SELECT ddtdettaglio.*, prodotto.* FROM ddtdettaglio INNER JOIN prodotto ON ddtdettaglio.ddd_fkprodotto = prodotto.pro_id WHERE ddtdettaglio.ddd_annullato = 0 AND ddtdettaglio.ddd_fkddt = '. $id);
        foreach ($result as $row) {
            $row = get_object_vars($row);
                        
            print "<tr>";
            print "<td class='no-print'><a class='btn btn-xs btn-danger' href='ddtvisualizza.php?ddt_id=".$id."&ddtdettaglio=".$row['ddd_id']."&TipoOperazione=3' role='button'><i class = 'fa fa-remove'></i></a></td>";
            print "<td>".$row['ddd_quantita']."</td>";
            print "<td>". $row['pro_categoria'] . " - " . convertiStringaToHTML($row['pro_descrizione'])." (&euro; ".$row['pro_prezzo'].")</td>";
            print "<td>".$row['ddd_tracciabilita']."</td>";
            $importo = $row['ddd_quantita']*$row['pro_prezzo'];
            print "<td>&euro; $importo</td>";
            print "</tr>";
        }
        // chiude il database
        $db = NULL;
    } catch (PDOException $e) {
        throw new PDOException("Error  : " . $e->getMessage());
    }
}

