<?php

class Fattura {
    public $fat_id;
    public $fat_numero;
    public $fat_numero_formattato;
    public $fat_anno;
    public $fat_data;
    public $fat_fkcliente;
    public $fat_pagata;
    public $fat_annullata;
    // DDT collegati
    public $fat_ddt = array();

    public function AggiungiSQL() {
        try {
            include "config.php";
            
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            date_default_timezone_set('Europe/Rome');
            
            // Controlla numero ultima fattura e aggiungi 1
            $result = $db->query("SELECT MAX(fat_numero) AS ultimo FROM fattura WHERE fat_anno = '" . $this->fat_anno . "'");
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $this->fat_numero = $row['ultimo'] + 1;
            
            // Converti data
            $data = $this->fat_data->format('Y-m-d');
            
            // INSERT INTO fattura VALUES (NULL, '1', '2016', '2016-07-29', '1', '0', '0');
            $sql = "INSERT INTO fattura VALUES (NULL, '$this->fat_numero','$this->fat_anno','$data', '$this->fat_fkcliente', '$this->fat_pagata', '0');";        
            $db->exec($sql);

            // Cerca ID della fattura creata per mettera nei dettagli
            $id = $this->CercaId($this->fat_numero);

            // DEVO AGGIUNGERE I DETTAGLI DEI DDT COLLEGATI
            foreach($this->fat_ddt as $ddt) {
                $sql = "INSERT INTO fatturadettaglio VALUES (NULL, '$id', '$ddt', '0');";        
                $db->exec($sql);
            }
          

            // chiude il database
            $db = NULL;
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function CercaId($fatturanumero) {
        try {
            include "config.php";
            
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            date_default_timezone_set('Europe/Rome');
            
            // Controlla numero ultima fattura e aggiungi 1
            $result = $db->query("SELECT fattura.fat_id FROM fattura WHERE fat_numero = '" . $fatturanumero . "' LIMIT 1");
            $row = $result->fetch(PDO::FETCH_ASSOC);
            
            
            // chiude il database
            $db = NULL;

            return $row['fat_id'];

        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function CaricaSQL($id) {
        try {
            /*include "config.php";
            
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            date_default_timezone_set('Europe/Rome');
            
            $result = $db->query("SELECT fattura.*, cliente.*, fattura.* FROM ddt INNER JOIN cliente ON fattura.fat_fkcliente = cliente.cli_id WHERE fattura.fat_annullato = 0 AND fat_id = $id");
            $row = $result->fetch(PDO::FETCH_ASSOC);
                                  
            $this->fat_id = $row['fat_id'];
            $this->fat_numero = $row['fat_numero'];
            $this->fat_numero_formattato = sprintf("%04d", $this->fat_numero);
            $this->fat_anno = $row['fat_anno'];
            $this->fat_data = DateTime::createFromFormat('Y-m-d', $row['fat_data']);
            $this->fat_data_stringa = $this->fat_data->format('d/m/Y');
            $this->fat_fkcliente = $row['fat_fkcliente'];
            $this->fat_fkcliente_denominazione = $row['cli_denominazione'];
            $this->fat_fkcliente_indirizzo = $row['cli_indirizzo'];
            $this->fat_fkcliente_cap = $row['cli_cap'];
            $this->fat_fkcliente_comune = $row['cli_comune'];
            $this->fat_fkcliente_piva = $row['cli_piva'];
            $this->fat_fkcliente_telefono = $row['cli_telefono'];
            $this->fat_fkcliente_fax = $row['cli_fax'];
            $this->fat_fkcliente_email = $row['cli_email'];
            $this->fat_destinazione = $row['fat_destinazione'];
            $this->fat_causale = $row['fat_causale'];
            $this->fat_trasporto = $row['fat_trasporto'];
            $this->fat_aspetto = $row['fat_aspetto'];
            $this->fat_colli = $row['fat_colli'];
            $this->fat_ritiro = DateTime::createFromFormat('Y-m-d', $row['fat_ritiro']);
            $this->fat_ritiro_stringa = $this->fat_ritiro->format('d/m/Y');
            $this->fat_scontrino = $row['fat_scontrino'];
            $this->fat_importo = $row['fat_importo'];
            $this->fat_fatturazioneelettronica = $row['fat_fatturazioneelettronica'];
            $this->fat_pagato = $row['fat_pagato'];
            $this->fat_fkfattura = $row['fat_fkfattura'];
            $this->fat_annullato = $row['fat_annullato'];
            
            // chiude il database
            $db = NULL;*/
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}


function FATTabella() {
    try {
        include 'config.php';
        
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $result = $db->query('SELECT fattura.*, cliente.* FROM fattura INNER JOIN cliente ON fattura.fat_fkcliente = cliente.cli_id WHERE fattura.fat_annullata = 0');
        
        // Parte iniziale
        print "<table id='fattabella' class='table table-bordered table-hover'>";
        print "<thead><tr>";
        print "<th>#</th><th>Data</th><th>Numero</th><th>Cliente</th><th>Importo</th><th>Pagato</th>";
        print "</tr></thead><tbody>";
        
        foreach ($result as $row) {
            $row = get_object_vars($row);
            $numero_padded = sprintf("%04d", $row['fat_numero']);
            $dataEmissione = DateTime::createFromFormat('Y-m-d', $row['fat_data'])->format('d/m/Y');
                        
            print "<tr>";
            print "<td><a class='btn btn-xs btn-info' href='fatturavisualizza.php?fat_id=".$row['fat_id']."&TipoOperazione=1' role='button' style='margin-right: 5px'><i class = 'fa fa-eye'></i></a><a class='btn btn-xs btn-danger' href='fatturacancella.php?fat_id=".$row['fat_id']."' role='button'><i class = 'fa fa-remove'></i></a></td>";
            print "<td>$dataEmissione</td>";
            print "<td>".$numero_padded."</td>";
            if($row['cli_comune']) {
                 print "<td>".$row['cli_denominazione']." (".$row['cli_comune'].")</td>";
            } else {
                 print "<td>".$row['cli_denominazione']."</td>";
            }
            
            print "<td>&euro; " . $row['fat_importo'] . "</td>";
            if($row['fat_pagato']) {
                print "<td><i class = 'fa fa-fw fa-circle' style = 'color:green'></i></td>";
            } else {
                print "<td><i class = 'fa fa-fw fa-circle' style = 'color:red'></i></td>";
            }
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
