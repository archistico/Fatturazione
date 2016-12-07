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

