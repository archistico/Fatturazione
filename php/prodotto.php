<?php

class Prodotto {
    public $pro_id;
    public $pro_categoria;
    public $pro_descrizione;
    public $pro_prezzo;
    public $pro_iva;
    public $pro_vecchio;
    
    public function AggiungiSQL() {
        try {
            include "config.php";
            
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            $db->exec("INSERT INTO prodotto VALUES (NULL, '$this->pro_categoria', '$this->pro_descrizione', '$this->pro_prezzo', '$this->pro_iva','0');");

            // chiude il database
            $db = NULL;
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}





function prodotto_select() {
    try {
        include 'config.php';
                
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $result = $db->query('SELECT * FROM prodotto WHERE pro_vecchio=0 ORDER BY pro_descrizione ASC');
        foreach ($result as $row) {
            $row = get_object_vars($row);
            print "<option value='" . $row['pro_id'] . "'>". $row['pro_categoria'] . " - " . convertiStringaToHTML($row['pro_descrizione'])." (&euro; ".$row['pro_prezzo'].")</option>\n";
        }
        // chiude il database
        $db = NULL;
    } catch (PDOException $e) {
        throw new PDOException("Error  : " . $e->getMessage());
    }
}

function prodotto_tabella() {
    try {
        include 'config.php';
        
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $result = $db->query('SELECT * FROM prodotto');
        foreach ($result as $row) {
            $row = get_object_vars($row);
                        
            print "<tr>";
            print "<td><a class='btn btn-xs btn-danger' href='ddtcancella.php?ddt_id=".$row['pro_id']."' role='button'><i class = 'fa fa-remove'></i></a></td>";
            print "<td>".convertiStringaToHTML($row['pro_categoria'])."</td>";
            print "<td>".convertiStringaToHTML($row['pro_descrizione'])."</td>";
            print "<td>&euro; ".$row['pro_prezzo']."</td>";
            print "<td>".$row['pro_iva']." &percnt;</td>";
            if(!$row['pro_vecchio']) {
                print "<td><i class = 'fa fa-fw fa-circle' style = 'color:green'></i></td>";
            } else {
                print "<td><i class = 'fa fa-fw fa-circle' style = 'color:red'></i></td>";
            }
            print "</tr>";
        }
        // chiude il database
        $db = NULL;
    } catch (PDOException $e) {
        throw new PDOException("Error  : " . $e->getMessage());
    }
}