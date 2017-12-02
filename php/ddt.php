<?php

class DDT {
    public $ddt_id;
    public $ddt_numero;
    public $ddt_numero_formattato;
    public $ddt_anno;
    public $ddt_data;
    public $ddt_data_stringa;
    public $ddt_fkcliente;
    public $ddt_fkcliente_denominazione;
    public $ddt_fkcliente_indirizzo;
    public $ddt_fkcliente_cap;
    public $ddt_fkcliente_comune;
    public $ddt_fkcliente_piva;
    public $ddt_fkcliente_telefono;
    public $ddt_fkcliente_fax;
    public $ddt_fkcliente_email;
    public $ddt_destinazione;
    public $ddt_causale;
    public $ddt_trasporto;
    public $ddt_aspetto;
    public $ddt_colli;
    public $ddt_ritiro;
    public $ddt_ritiro_stringa;
    public $ddt_scontrino;
    public $ddt_importo;
    public $ddt_fatturazioneelettronica;
    public $ddt_pagato;
    public $ddt_fkfattura;
    public $ddt_annullato;
    public $ddt_ultimoID;

    public function AggiungiSQL() {
        try {
            include "config.php";
            
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            date_default_timezone_set('Europe/Rome');
            
            $result = $db->query("SELECT MAX(ddt_numero) AS ultimo FROM ddt WHERE ddt_annullato=0 AND ddt_anno = '" . $this->ddt_anno . "'");
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $this->ddt_numero = $row['ultimo'] + 1;
            
            $dataEmissione = $this->ddt_data->format('Y-m-d');
            $dataRitiro = $this->ddt_ritiro->format('Y-m-d');
            
            $this->ddt_ultimoID = -1;
              
            $db->exec("INSERT INTO ddt VALUES (NULL, '$this->ddt_numero','$this->ddt_anno','$dataEmissione', '$this->ddt_fkcliente', '$this->ddt_destinazione', '$this->ddt_causale', '$this->ddt_trasporto', '$this->ddt_aspetto', '$this->ddt_colli', '$dataRitiro', '$this->ddt_scontrino', '$this->ddt_importo', '$this->ddt_fatturazioneelettronica', '$this->ddt_pagato', null, '0');");

            $this->ddt_ultimoID = $db->lastInsertId();

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
            
            $result = $db->query("SELECT ddt.*, cliente.* FROM ddt INNER JOIN cliente ON ddt.ddt_fkcliente = cliente.cli_id WHERE ddt.ddt_annullato = 0 AND ddt_id = $id");
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


    public function ModificaSQL() {
        try {
            include "config.php";
            
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
            
            // 16 dati da modificare + 1 id
            // di cui 5 non vengono cambiati (importo, numero, anno, fkfattura e annullato)
            // "ddt_numero = '$this->ddt_numero', ddt_anno = '$this->ddt_anno', ddt_fkfattura = '$this->ddt_fkfattura', ddt_annullato = '$this->ddt_annullato', ddt_importo = '$this->ddt_importo'".

            $dataEmissione = $this->ddt_data->format('Y-m-d');
            $dataRitiro = $this->ddt_ritiro->format('Y-m-d');

            $sql =  "UPDATE ddt ".
                    "SET ".
                    "ddt_data = '$dataEmissione', ddt_fkcliente  = '$this->ddt_fkcliente', ".
                    "ddt_destinazione  = '$this->ddt_destinazione', ddt_causale = '$this->ddt_causale', ddt_trasporto = '$this->ddt_trasporto', ddt_aspetto = '$this->ddt_aspetto', ".
                    "ddt_colli = '$this->ddt_colli', ddt_ritiro = '$dataRitiro', ddt_scontrino = '$this->ddt_scontrino', ".
                    "ddt_fatturazioneelettronica = '$this->ddt_fatturazioneelettronica', ddt_pagato = '$this->ddt_pagato' ".
                    "WHERE ddt_id = $this->ddt_id;";
 
            $db->exec($sql);

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

            $sql = "DELETE FROM ddt WHERE ddt.ddt_id = ".$this->ddt_id;
            $db->exec($sql);
            
            // cerca tutti i ddtdettaglio con ddtdettaglio.ddd_fkddt = id
            $sql = "DELETE FROM ddtdettaglio WHERE ddtdettaglio.ddd_fkddt = ".$this->ddt_id;      
            $db->exec($sql);
            
            // chiude il database
            $db = NULL;

            return true;

        } catch (PDOException $e) {
            return false;
        }
    }



    public function VerificaFatturatoSQL() {
        try {
            include "config.php";
            
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

            date_default_timezone_set('Europe/Rome');
            
            $sql = "SELECT ddt.ddt_fkfattura FROM ddt WHERE ddt_id = '" . $this->ddt_id . "';";

            $result = $db->query($sql);
            $row = $result->fetch(PDO::FETCH_ASSOC);
 
            // chiude il database
            $db = NULL;
            // || isset($row['ddt_fkfattura'])

            if (is_null($row['ddt_fkfattura'])) {
                return false;
            } else { 
                return true;
            }
            
        } catch (PDOException $e) {
            return false;
        }
    }
}


function DDTTabella() {
    try {
        include 'config.php';
        
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $result = $db->query('SELECT ddt.*, cliente.* FROM ddt INNER JOIN cliente ON ddt.ddt_fkcliente = cliente.cli_id WHERE ddt.ddt_annullato = 0 ORDER BY ddt.ddt_anno DESC, ddt.ddt_numero DESC');
        
        // Parte iniziale
        print "<table id='ddttabella' class='table table-bordered table-hover'>";
        print "<thead><tr>";
        print "<th>PDF</th><th>Data</th><th>Numero</th><th>Cliente</th><th>Importo</th><th>Pagato</th><th>F. elettr. / Fatturato</th><th>Modifica</th><th>Cancella</th>";
        //print "<th>#</th><th>Data</th><th>Numero</th><th>Cliente</th><th>DDT</th><th>Importo</th><th>Pagato</th><th>PDF</th><th>Cancella</th>";
        print "</tr></thead><tbody>";
        
        foreach ($result as $row) {
            $row = get_object_vars($row);
            $numero_padded = sprintf("%04d", $row['ddt_numero']);
            $dataEmissione = DateTime::createFromFormat('Y-m-d', $row['ddt_data'])->format('d/m/Y');
            $dataRitiro = DateTime::createFromFormat('Y-m-d', $row['ddt_ritiro'])->format('d/m/Y');
            
            // fa-file-pdf-o
            // fa-pencil

            print "<tr>";
            print "<td>";
            print "<a class='btn btn-xs btn-success' href='ddtpdf.php?ddt_id=".$row['ddt_id']."' role='button' style='width: 30px;margin-right: 3px; margin-bottom: 3px' target='_blank'><i class = 'fa fa-file-pdf-o'></i></a>";
            //print "<a class='btn btn-xs btn-success' href='ddtvisualizza.php?ddt_id=".$row['ddt_id']."&TipoOperazione=1' role='button' style='width: 30px;margin-right: 3px; margin-bottom: 3px'><i class = 'fa fa-eye'></i></a>";
            print "</td>";
            print "<td>$dataEmissione</td>";
            print "<td>".$row['ddt_anno']."-".$numero_padded."</td>";

            $denominazione = db2html($row['cli_denominazione']);
            /*
            if(strlen($denominazione)>26) {
                $denominazione=substr($denominazione,0,26)." ..."; 
            }
            */

            if($row['cli_comune']) {
                 print "<td>".$denominazione." (".db2html($row['cli_comune']).")</td>";
            } else {
                 print "<td>".$denominazione."</td>";
            }
            
            print "<td>&euro; " . $row['ddt_importo'] . "</td>";
            if($row['ddt_pagato']) {
                print "<td><i class = 'fa fa-fw fa-circle fa-lg' style = 'color:green'></i></td>";
            } else {
                print "<td><i class = 'fa fa-fw fa-circle fa-lg' style = 'color:red'></i></td>";
            }

            print "<td>";
            print "<div class='icone-unite'>";
            if($row['ddt_fatturazioneelettronica']) {
                print "<i class = 'fa fa-fw fa-circle fa-lg' style = 'color:green'></i>";
            } else {
                print "<i class = 'fa fa-fw fa-circle fa-lg' style = 'color:red'></i>";
            }
            
            print " / ";
            
            if($row['ddt_fkfattura']) {
                //print "<i class = 'fa fa-fw fa-square fa-lg' style = 'color:green'></i>";
                list($numero, $anno) = CercaFattura($row['ddt_fkfattura']);
                print "<span class = 'inlinea'>FAT ".$anno. "-".sprintf("%04d", $numero)."</span>";
            } else {
                print "<i class = 'fa fa-fw fa-circle fa-lg' style = 'color:red'></i>";
            }
            print "</div>";
            print "</td>";

            print "<td>";
            print "<a class='btn btn-xs btn-warning' href='ddtmodifica.php?ddt_id=".$row['ddt_id']."' role='button' style='width: 30px; margin-bottom: 3px'><i class = 'fa fa-pencil'></i></a>";
            print "</td>";

            print "<td>";
            print "<a class='btn btn-xs btn-danger' href='ddtcancella.php?ddt_id=".$row['ddt_id']."' role='button' style='width: 30px; margin-bottom: 3px'><i class = 'fa fa-remove'></i></a>";
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


function CercaFattura($id) {
        try {
            include 'config.php';
                        
            $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
                      
            $result = $db->query("SELECT fattura.fat_numero, fattura.fat_anno FROM fattura WHERE fat_id = '" . $id . "' LIMIT 1");
            $row = $result->fetch(PDO::FETCH_ASSOC);
            
            // chiude il database
            $db = NULL;

            return array($row['fat_numero'], $row['fat_anno']);

        } catch (PDOException $e) {
            return false;
        }
    }

function DDTTabellaNonFatturati() {
    
}
