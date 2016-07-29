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

    public function AggiungiSQL() {
        try {
            include "config.php";
            
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            date_default_timezone_set('Europe/Rome');
            
            // Controlla numero ultima fattura e aggiungi 1
            $result = $db->query("SELECT MAX(fat_numero) AS ultimo FROM fatture WHERE fat_anno = '" . $this->fat_anno . "'");
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $this->fat_numero = $row['ultimo'] + 1;
            
            // Converti data
            $data = $this->fat_data->format('Y-m-d');
            
            // INSERT INTO fattura VALUES (NULL, '1', '2016', '2016-07-29', '1', '0', '0');
            $db->exec("INSERT INTO fattura VALUES (NULL, '$this->fat_numero','$this->fat_anno','$data', '$this->fat_fkcliente', '$this->fat_pagata', '0', '0');");

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

            date_default_timezone_set('Europe/Rome');
            
            $result = $db->query("SELECT ddt.*, cliente.*, fattura.* FROM ddt INNER JOIN cliente ON ddt.ddt_fkcliente = cliente.cli_id WHERE ddt.ddt_annullato = 0 AND ddt_id = $id");
            $row = $result->fetch(PDO::FETCH_ASSOC);
                                  
            $this->ddt_id = $row['ddt_id'];
            $this->ddt_numero = $row['ddt_numero'];
            $this->ddt_numero_formattato = sprintf("%04d", $this->ddt_numero);
            $this->ddt_anno = $row['ddt_anno'];
            $this->ddt_data = DateTime::createFromFormat('Y-m-d', $row['ddt_data']);
            $this->ddt_data_stringa = $this->ddt_data->format('d/m/Y');
            $this->ddt_fkcliente = $row['ddt_fkcliente'];
            $this->ddt_fkcliente_denominazione = $row['cli_denominazione'];
            $this->ddt_fkcliente_indirizzo = $row['cli_indirizzo'];
            $this->ddt_fkcliente_cap = $row['cli_cap'];
            $this->ddt_fkcliente_comune = $row['cli_comune'];
            $this->ddt_fkcliente_piva = $row['cli_piva'];
            $this->ddt_fkcliente_telefono = $row['cli_telefono'];
            $this->ddt_fkcliente_fax = $row['cli_fax'];
            $this->ddt_fkcliente_email = $row['cli_email'];
            $this->ddt_destinazione = $row['ddt_destinazione'];
            $this->ddt_causale = $row['ddt_causale'];
            $this->ddt_trasporto = $row['ddt_trasporto'];
            $this->ddt_aspetto = $row['ddt_aspetto'];
            $this->ddt_colli = $row['ddt_colli'];
            $this->ddt_ritiro = DateTime::createFromFormat('Y-m-d', $row['ddt_ritiro']);
            $this->ddt_ritiro_stringa = $this->ddt_ritiro->format('d/m/Y');
            $this->ddt_scontrino = $row['ddt_scontrino'];
            $this->ddt_importo = $row['ddt_importo'];
            $this->ddt_fatturazioneelettronica = $row['ddt_fatturazioneelettronica'];
            $this->ddt_pagato = $row['ddt_pagato'];
            $this->ddt_fkfattura = $row['ddt_fkfattura'];
            $this->ddt_annullato = $row['ddt_annullato'];
            
            // chiude il database
            $db = NULL;
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

        $result = $db->query('SELECT ddt.*, cliente.* FROM ddt INNER JOIN cliente ON ddt.ddt_fkcliente = cliente.cli_id WHERE ddt.ddt_annullato = 0');
        
        // Parte iniziale
        print "<table id='fattabella' class='table table-bordered table-hover'>";
        print "<thead><tr>";
        print "<th>#</th><th>Data</th><th>Numero</th><th>Cliente</th><th>Importo</th><th>Pagato</th>";
        print "</tr></thead><tbody>";
        
        foreach ($result as $row) {
            $row = get_object_vars($row);
            $numero_padded = sprintf("%04d", $row['ddt_numero']);
            $dataEmissione = DateTime::createFromFormat('Y-m-d', $row['ddt_data'])->format('d/m/Y');
            $dataRitiro = DateTime::createFromFormat('Y-m-d', $row['ddt_ritiro'])->format('d/m/Y');
            
            print "<tr>";
            print "<td><a class='btn btn-xs btn-info' href='ddtvisualizza.php?ddt_id=".$row['ddt_id']."&TipoOperazione=1' role='button' style='margin-right: 5px'><i class = 'fa fa-eye'></i></a><a class='btn btn-xs btn-danger' href='ddtcancella.php?ddt_id=".$row['ddt_id']."' role='button'><i class = 'fa fa-remove'></i></a></td>";
            print "<td>$dataEmissione</td>";
            print "<td>".$numero_padded."</td>";
            if($row['cli_comune']) {
                 print "<td>".$row['cli_denominazione']." (".$row['cli_comune'].")</td>";
            } else {
                 print "<td>".$row['cli_denominazione']."</td>";
            }
            
            print "<td>&euro; " . $row['ddt_importo'] . "</td>";
            if($row['ddt_pagato']) {
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
