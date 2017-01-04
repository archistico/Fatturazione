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

            //echo $this->fat_numero;
            //die();
            
            // Converti data
            $data = $this->fat_data->format('Y-m-d');
            
            // INSERT INTO fattura VALUES (NULL, '1', '2016', '2016-07-29', '1', '0', '0');
            $sql = "INSERT INTO fattura VALUES (NULL, '$this->fat_numero','$this->fat_anno','$data', '$this->fat_fkcliente', '$this->fat_pagata', '0');";        
            $db->exec($sql);

            // Cerca ID della fattura creata per mettera nei dettagli
            $fkfattura = $this->CercaId($this->fat_numero, $this->fat_anno);

            // DEVO AGGIUNGERE I DETTAGLI DEI DDT COLLEGATI
            foreach($this->fat_ddt as $ddt) { 
                $sql = "UPDATE ddt SET ddt_fkfattura = '".$fkfattura."' WHERE ddt.ddt_id = '".$ddt."';";    
                $db->exec($sql);
            }
     

            // chiude il database
            $db = NULL;
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function CercaId($fatturanumero, $fatturaanno) {
        try {
            include "config.php";
            
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            date_default_timezone_set('Europe/Rome');
            
            // Controlla numero ultima fattura e aggiungi 1
            $sql = "SELECT fattura.fat_id ".
                   "FROM fattura WHERE fat_numero = '" . $fatturanumero . "' AND fat_anno ='".$fatturaanno."' ".
                   "LIMIT 1";

            $result = $db->query($sql);
            $row = $result->fetch(PDO::FETCH_ASSOC);
            
            
            // chiude il database
            $db = NULL;

            return $row['fat_id'];

        } catch (PDOException $e) {
            return false;
        }
    }

    
    public function CercaDDT($id) {
        try {
            include "config.php";
            
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
          
            // Cerca tutti i numeri di fattura e mettili in un array che restituisci
            $sql="SELECT ddt.ddt_id FROM ddt WHERE ddt.ddt_fkfattura=$id";
            $result = $db->query($sql);

            $lista = array();

            foreach ($result as $row) {
                $row = get_object_vars($row);
                $lista[] = $row['ddt_id'];      
            }

            // chiude il database
            $db = NULL;

            return $lista;

        } catch (PDOException $e) {
            return false;
        }
    }

    public function Pagata() {
        try {
            include "config.php";
            
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            date_default_timezone_set('Europe/Rome');
            
            $result = $db->query("SELECT fattura.fat_pagata FROM fattura WHERE fat_id = '" . $this->fat_id . "' LIMIT 1");
            $row = $result->fetch(PDO::FETCH_ASSOC);

            if($row['fat_pagata']==0) {
                $sql = "UPDATE fattura SET fat_pagata = 1 WHERE fattura.fat_id = ".$this->fat_id;      
                $db->exec($sql);
            } else {
                $sql = "UPDATE fattura SET fat_pagata = 0 WHERE fattura.fat_id = ".$this->fat_id;      
                $db->exec($sql);
            }
            
            
            // chiude il database
            $db = NULL;

            return true;

        } catch (PDOException $e) {
            return false;
        }
    }

    public function Cancella() {
        try {
            include "config.php";
            
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            date_default_timezone_set('Europe/Rome');

            
            //$sql = "UPDATE fattura SET fat_annullata = 1 WHERE fattura.fat_id = ".$this->fat_id;
            $sql = "DELETE FROM fattura WHERE fattura.fat_id = ".$this->fat_id;
            $db->exec($sql);
            
            // cerca tutti i ddt con ddt.ddt_fkfattura = id e metti tutto a null
            $resultDDT = $db->query("SELECT * FROM ddt WHERE ddt.ddt_fkfattura = ".$this->fat_id);
            foreach ($resultDDT as $rowddt) {
                $rowddt = get_object_vars($rowddt);
                $sql = "UPDATE ddt SET ddt.ddt_fkfattura = null WHERE ddt.ddt_id = ".$rowddt['ddt_id'];      
                $db->exec($sql);
            }
            
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
            
            $result = $db->query("SELECT * FROM fattura WHERE fattura.fat_annullata = 0 AND fattura.fat_id = ".$id);
            $row = $result->fetch(PDO::FETCH_ASSOC);
                                  
            $this->fat_id = $row['fat_id'];
            $this->fat_numero = $row['fat_numero'];
            $this->fat_numero_formattato = sprintf("%04d", $this->fat_numero);
            $this->fat_anno = $row['fat_anno'];
            $this->fat_data = DateTime::createFromFormat('Y-m-d', $row['fat_data']);
            $this->fat_data_stringa = $this->fat_data->format('d/m/Y');
            $this->fat_pagata = $row['fat_pagata'];
            /*$this->fat_fkcliente = $row['fat_fkcliente'];
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
            $this->fat_fkfattura = $row['fat_fkfattura'];
            $this->fat_annullato = $row['fat_annullato'];*/
            
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

        $result = $db->query('SELECT fattura.*, cliente.* FROM fattura INNER JOIN cliente ON fattura.fat_fkcliente = cliente.cli_id WHERE fattura.fat_annullata = 0 ORDER BY fattura.fat_numero ASC');
        
        // Parte iniziale
        print "<table id='fattabella' class='table table-bordered table-hover'>";
        print "<thead><tr>";
        print "<th>PDF</th><th>Data</th><th>Numero</th><th>Cliente</th><th>DDT</th><th>Importo</th><th>Pagato</th><th>Modifica</th><th>Cancella</th>";
        print "</tr></thead><tbody>";
        
        foreach ($result as $row) {
            $row = get_object_vars($row);
            $numero_padded = sprintf("%04d", $row['fat_numero']);
            $dataEmissione = DateTime::createFromFormat('Y-m-d', $row['fat_data'])->format('d/m/Y');
                        
            print "<tr>";
            
            print "<td>";
            print "<a class='btn btn-xs btn-success' href='fatturapdf.php?fat_id=".$row['fat_id']."' role='button' style='width: 30px; margin-bottom: 3px' target='_blank'><i class = 'fa fa-file-pdf-o'></i></a>";
            //print "<a class='btn btn-xs btn-info' href='fatturavisualizza.php?fat_id=".$row['fat_id']."' role='button' style='width: 30px; margin-bottom: 3px'><i class = 'fa fa-eye'></i></a>";
            print "</td>";
            
            print "<td>$dataEmissione</td>";
            print "<td> FAT ".$row['fat_anno']."-".$numero_padded."</td>";
            if($row['cli_comune']) {
                 print "<td>".$row['cli_denominazione']." (".$row['cli_comune'].")</td>";
            } else {
                 print "<td>".$row['cli_denominazione']."</td>";
            }

            // DEVO SCORRERE I DDT COLLEGATI PER AVERE LA SOMMA DEGLI IMPORTI
            $importo = 0;
            $listaDDT = "";

            $resultDDT = $db->query("SELECT * FROM ddt WHERE ddt.ddt_fkfattura = ".$row['fat_id']);
            foreach ($resultDDT as $rowddt) {
                $rowddt = get_object_vars($rowddt);
                $importo += $rowddt['ddt_importo'];
                $numeroDDT = sprintf("%04d", $rowddt['ddt_numero']);
                if(empty($listaDDT)){
                    $listaDDT = "DDT ".$rowddt['ddt_anno']."-".$numeroDDT;
                } else {
                    $listaDDT .= ", DDT ".$rowddt['ddt_anno']."-".$numeroDDT;
                }
            }
            print "<td>".$listaDDT."</td>";
            
            print "<td>&euro; " . number_format($importo, 2, '.', '') . "</td>";

            print "<td>";
            if($row['fat_pagata']) {
                print "<i class = 'fa fa-fw fa-square fa-lg' style = 'color:green'></i>";
            } else {
                print "<i class = 'fa fa-fw fa-square fa-lg' style = 'color:red'></i>";
            }
            print "<a class='btn btn-xs btn-success' href='fatturapagata.php?fat_id=".$row['fat_id']."' role='button' style='width: 30px; margin-left: 15px'><i class = 'fa fa-euro'></i></a>";
            print "</td>";

            print "<td>";
            print "<a class='btn btn-xs btn-warning' href='fatturamodifica.php?fat_id=".$row['fat_id']."' role='button' style='width: 30px; margin-bottom: 3px'><i class = 'fa fa-pencil'></i></a>";
            print "</td>";

            print "<td>";
            print "<a class='btn btn-xs btn-danger' href='fatturacancella.php?fat_id=".$row['fat_id']."' role='button' style='width: 30px'><i class = 'fa fa-remove'></i></a>";
            print "</td>";

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


function FATTabellaNonPagate() {
    try {
        include 'config.php';
        
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $result = $db->query('SELECT fattura.*, cliente.* FROM fattura INNER JOIN cliente ON fattura.fat_fkcliente = cliente.cli_id WHERE fattura.fat_annullata = 0 AND fattura.fat_pagata = 0 ORDER BY fattura.fat_numero ASC');
        
        // Parte iniziale
        print "<table id='fattabella' class='table table-bordered table-hover'>";
        print "<thead><tr>";
        print "<th>PDF</th><th>Data</th><th>Numero</th><th>Cliente</th><th>DDT</th><th>Importo</th><th>Pagato</th><th>Modifica</th><th>Cancella</th>";
        print "</tr></thead><tbody>";
        
        foreach ($result as $row) {
            $row = get_object_vars($row);
            $numero_padded = sprintf("%04d", $row['fat_numero']);
            $dataEmissione = DateTime::createFromFormat('Y-m-d', $row['fat_data'])->format('d/m/Y');
                        
            print "<tr>";
            
            print "<td>";
            print "<a class='btn btn-xs btn-success' href='fatturapdf.php?fat_id=".$row['fat_id']."' role='button' style='width: 30px; margin-bottom: 3px' target='_blank'><i class = 'fa fa-file-pdf-o'></i></a>";
            //print "<a class='btn btn-xs btn-info' href='fatturavisualizza.php?fat_id=".$row['fat_id']."' role='button' style='width: 30px; margin-bottom: 3px'><i class = 'fa fa-eye'></i></a>";
            print "</td>";
            
            print "<td>$dataEmissione</td>";
            print "<td> FAT ".$row['fat_anno']."-".$numero_padded."</td>";
            if($row['cli_comune']) {
                 print "<td>".$row['cli_denominazione']." (".$row['cli_comune'].")</td>";
            } else {
                 print "<td>".$row['cli_denominazione']."</td>";
            }

            // DEVO SCORRERE I DDT COLLEGATI PER AVERE LA SOMMA DEGLI IMPORTI
            $importo = 0;
            $listaDDT = "";

            $resultDDT = $db->query("SELECT * FROM ddt WHERE ddt.ddt_fkfattura = ".$row['fat_id']);
            foreach ($resultDDT as $rowddt) {
                $rowddt = get_object_vars($rowddt);
                $importo += $rowddt['ddt_importo'];
                $numeroDDT = sprintf("%04d", $rowddt['ddt_numero']);
                if(empty($listaDDT)){
                    $listaDDT = "DDT ".$rowddt['ddt_anno']."-".$numeroDDT;
                } else {
                    $listaDDT .= ", DDT ".$rowddt['ddt_anno']."-".$numeroDDT;
                }
            }
            print "<td>".$listaDDT."</td>";
            
            print "<td>&euro; " . number_format($importo, 2, '.', '') . "</td>";

            print "<td>";
            if($row['fat_pagata']) {
                print "<i class = 'fa fa-fw fa-square fa-lg' style = 'color:green'></i>";
            } else {
                print "<i class = 'fa fa-fw fa-square fa-lg' style = 'color:red'></i>";
            }
            print "<a class='btn btn-xs btn-success' href='fatturapagata.php?fat_id=".$row['fat_id']."' role='button' style='width: 30px; margin-left: 15px'><i class = 'fa fa-euro'></i></a>";
            print "</td>";

            print "<td>";
            print "<a class='btn btn-xs btn-warning' href='fatturamodifica.php?fat_id=".$row['fat_id']."' role='button' style='width: 30px; margin-bottom: 3px'><i class = 'fa fa-pencil'></i></a>";
            print "</td>";

            print "<td>";
            print "<a class='btn btn-xs btn-danger' href='fatturacancella.php?fat_id=".$row['fat_id']."' role='button' style='width: 30px'><i class = 'fa fa-remove'></i></a>";
            print "</td>";

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