<?php

function soggettiSelect() {
    try {
        include 'config.php';
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
        
        $result = $db->query('SELECT denominazione, idsoggetto, provincia FROM soggetti WHERE cancellato=0 ORDER BY denominazione ASC');
        foreach ($result as $row) {
            $row = get_object_vars($row);
            if(empty($row['provincia'])) {
                print "<option value='" . $row['idsoggetto'] . "'>" . convertiStringaToHTML($row['denominazione']) . "</option>\n";
            }
            else {
                print "<option value='" . $row['idsoggetto'] . "'>" . convertiStringaToHTML($row['denominazione']) . " (".$row['provincia'].")</option>\n";
            } 
        }
        // chiude il database
        $db = NULL;
    } catch (PDOException $e) {
        throw new PDOException("Error  : " . $e->getMessage());
    }
}



