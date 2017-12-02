<?php

class Prodotto {
    public $pro_id;
    public $pro_categoria;
    public $pro_descrizione;
    public $pro_prezzo;
    public $pro_iva;
    public $pro_vecchio;
    public $pro_misura;
    
    public function AggiungiSQL() {
        try {
            include "config.php";
            
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            $db->exec("INSERT INTO prodotto VALUES (NULL, '$this->pro_categoria', '$this->pro_descrizione', '$this->pro_prezzo', '$this->pro_iva','0','$this->pro_misura');");

            // chiude il database
            $db = NULL;
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function CaricaSQL($id) {
        try {
            include "config.php";
            
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            $result = $db->query('SELECT * FROM prodotto WHERE pro_vecchio=0 AND pro_id='.$id.' LIMIT 1');
            foreach ($result as $row) {
                $row = get_object_vars($row);
                
                $this->pro_id = $row['pro_id'];
                $this->pro_categoria = $row['pro_categoria'];
                $this->pro_descrizione = $row['pro_descrizione'];
                $this->pro_prezzo = $row['pro_prezzo'];
                $this->pro_iva = $row['pro_iva'];
                $this->pro_misura = $row['pro_misura'];
            }

            // chiude il database
            $db = NULL;
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function ControllaProdotto($id) {
        try {
            include "config.php";
            
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
            
            // Controllo nella tabella DDTDETTAGLIO se ci sono prodotti associati
            $result = $db->query("SELECT ddd_id FROM ddtdettaglio WHERE ddd_fkprodotto=$id;");
            $row = $result->fetch(PDO::FETCH_ASSOC);

            if (!($result->rowCount() == 0)) {
                $db = NULL;
                return false;
            } 

            // chiude il database
            $db = NULL;
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }


    public function Cancella($id) {
        try {
            include "config.php";
            
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            if ($this->ControllaProdotto($id)) {

                // Se non ci sono DDT collegati al prodotto posso cancellarlo
                $sql = "DELETE FROM prodotto WHERE prodotto.pro_id=$id;";
                $db->exec($sql);

            } else {
                $db = NULL;
                return false;
            }

            // chiude il database
            $db = NULL;
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }


    public function ModificaSQL() {
        try {
            include "config.php";
            
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
            
            $sql = "UPDATE prodotto SET pro_categoria = '$this->pro_categoria', pro_descrizione = '$this->pro_descrizione', pro_prezzo = '$this->pro_prezzo', pro_iva = '$this->pro_iva', pro_misura = '$this->pro_misura' WHERE pro_id = $this->pro_id;";
            
            $db->exec($sql);

            // chiude il database
            $db = NULL;
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function Vecchio() {
        try {
            include "config.php";
            
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
                        
            $result = $db->query("SELECT pro_vecchio FROM prodotto WHERE pro_id = '" . $this->pro_id . "' LIMIT 1");
            $row = $result->fetch(PDO::FETCH_ASSOC);

            if($row['pro_vecchio']==0) {
                $sql = "UPDATE prodotto SET pro_vecchio = 1 WHERE pro_id = ".$this->pro_id;      
                $db->exec($sql);
            } else {
                $sql = "UPDATE prodotto SET pro_vecchio = 0 WHERE pro_id = ".$this->pro_id;      
                $db->exec($sql);
            }

            // chiude il database
            $db = NULL;
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

}


// --------- 

function prodotto_select() {
    try {
        include 'config.php';
                
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $result = $db->query('SELECT * FROM prodotto WHERE pro_vecchio=0 ORDER BY pro_categoria ASC, pro_descrizione ASC, pro_prezzo ASC');
        foreach ($result as $row) {
            $row = get_object_vars($row);
            print "<option value='" . $row['pro_id'] . "'>". db2html($row['pro_categoria'] . " - " . $row['pro_descrizione'])." (&euro; ".$row['pro_prezzo'].")</option>\n";
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

        $result = $db->query('SELECT * FROM prodotto ORDER BY pro_categoria ASC, pro_descrizione ASC, pro_prezzo ASC');
        foreach ($result as $row) {
            $row = get_object_vars($row);
                        
            print "<tr>";
            print "<td>";
            
            print "<a class='btn btn-xs btn-warning' href='prodottomodifica.php?pro_id=".$row['pro_id']."' role='button' style='width: 30px; margin-bottom: 3px'><i class = 'fa fa-pencil'></i></a>";
            
            print "</td>";

            print "<td>".db2html($row['pro_categoria'])."</td>";
            print "<td>".db2html($row['pro_descrizione'])."</td>";
            print "<td>&euro; ".$row['pro_prezzo']."</td>";
            print "<td>".$row['pro_iva']." &percnt;</td>";
            
            print "<td>";
            if(!$row['pro_vecchio']) {
                print "<i class = 'fa fa-fw fa-square fa-lg' style = 'color:green'></i>";               
            } else {
                print "<i class = 'fa fa-fw fa-square fa-lg' style = 'color:red'></i>";
            }
            print "<a class='btn btn-xs btn-warning' href='prodottovecchio.php?pro_id=".$row['pro_id']."' role='button' style='width: 30px; margin-bottom: 3px'><i class = 'fa fa-clock-o'></i></a>";
            print "</td>";
            
            print "<td>";
            print "<a class='btn btn-xs btn-danger' href='prodottocancella.php?pro_id=".$row['pro_id']."' role='button' style='width: 30px;margin-bottom: 3px'><i class = 'fa fa-remove'></i></a>";
            print "</td>";

            print "</tr>";
        }
        // chiude il database
        $db = NULL;
    } catch (PDOException $e) {
        throw new PDOException("Error  : " . $e->getMessage());
    }
}