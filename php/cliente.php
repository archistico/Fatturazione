<?php

class Cliente {
      public $cli_id;
      public $cli_denominazione;
      public $cli_indirizzo;
      public $cli_cap;
      public $cli_comune;
      public $cli_telefono;
      public $cli_fax;
      public $cli_email;
      public $cli_piva;
      public $cli_vecchio;

      /*public function __construct($denominazione, $indirizzo, $cap, $comune, $telefono, $fax, $email, $piva){
        $this->cli_denominazione=utf8_decode($denominazione);
        $this->cli_indirizzo=utf8_decode($indirizzo);
        $this->cli_cap=$cap;
        $this->cli_comune=utf8_decode($comune);
        $this->cli_telefono=$telefono;
        $this->cli_fax=$fax;
        $this->cli_email=$email;
        $this->cli_piva=$piva;
      }*/

      public function AggiungiSQL() {
        try {
            include "config.php";
            
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
            
            $sql = "INSERT INTO cliente VALUES (NULL, '$this->cli_denominazione', '$this->cli_indirizzo', '$this->cli_cap', '$this->cli_comune', '$this->cli_telefono', '$this->cli_fax', '$this->cli_email', '$this->cli_piva', '0');";

            $db->exec($sql);

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
            
            $result = $db->query('SELECT cliente.* FROM cliente WHERE cliente.cli_id='.$id.' LIMIT 1');
            $row = $result->fetch(PDO::FETCH_ASSOC);

            if ($result->rowCount() == 0) {
                return false;
            }

            $this->cli_id=$row['cli_id'];
            $this->cli_denominazione=$row['cli_denominazione'];
            $this->cli_indirizzo=$row['cli_indirizzo'];
            $this->cli_cap=$row['cli_cap'];
            $this->cli_comune=$row['cli_comune'];
            $this->cli_telefono=$row['cli_telefono']; 
            $this->cli_fax=$row['cli_fax'];
            $this->cli_email=$row['cli_email'];
            $this->cli_piva=$row['cli_piva'];
            
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
            
            $sql = "UPDATE cliente SET cli_denominazione = '$this->cli_denominazione', cli_indirizzo = '$this->cli_indirizzo', cli_cap = '$this->cli_cap', cli_comune = '$this->cli_comune', cli_telefono = '$this->cli_telefono', cli_fax = '$this->cli_fax', cli_email = '$this->cli_email', cli_piva = '$this->cli_piva' WHERE cliente.cli_id = $this->cli_id;";
            
            $db->exec($sql);

            // chiude il database
            $db = NULL;
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}

function cliente_select() {
    try {
        include 'config.php';
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $result = $db->query('SELECT * FROM cliente WHERE cli_vecchio=0 ORDER BY cli_denominazione ASC');
        foreach ($result as $row) {
            $row = get_object_vars($row);
            print "<option value='" . $row['cli_id'] . "'>" . $row['cli_denominazione'] . "</option>\n";
        }
        // chiude il database
        $db = NULL;
    } catch (PDOException $e) {
        throw new PDOException("Error  : " . $e->getMessage());
    }
}

function ClienteTabella() {
    try {
        include 'config.php';
        
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $result = $db->query('SELECT cliente.* FROM cliente ORDER BY cliente.cli_denominazione ASC');
        
        // Parte iniziale
        print "<table id='clientetabella' class='table table-bordered table-hover'>";
        print "<thead><tr>";
        print "<th>#</th><th>Denominazione</th><th>Indirizzo</th><th>Recapiti</th><th>Email</th><th>Fiscali</th>";
        print "</tr></thead><tbody>";
        
        foreach ($result as $row) {
            $row = get_object_vars($row);
                                    
            print "<tr>";
            
            print "<td>";
            
            print "<a class='btn btn-xs btn-warning' href='clientemodifica.php?cli_id=".$row['cli_id']."' role='button' style='width: 30px; margin-right: 15px; margin-bottom: 3px'><i class = 'fa fa-pencil'></i></a>";
                        
            print "<a class='btn btn-xs btn-danger' href='clientecancella.php?cli_id=".$row['cli_id']."' role='button' style='margin-bottom: 3px'><i class = 'fa fa-remove'></i></a>";         
            
            print "</td>";
            
            print "<td>".$row['cli_denominazione']."</td>";
            print "<td>".$row['cli_indirizzo']. " - " .$row['cli_cap']. " " .$row['cli_comune']."</td>";
            print "<td>".$row['cli_telefono']. " / " .$row['cli_fax']. "</td>";
            print "<td>".$row['cli_email']."</td>";
            print "<td>".$row['cli_piva']."</td>";

            
            print "</tr>";
        }
        // chiude il database
        $db = NULL;
        
        // Parte finale
        print "</tbody></table>";
        
    } catch (PDOException $e) {
        throw new PDOException("Error  : " . $e->getMessage());
    }
}

