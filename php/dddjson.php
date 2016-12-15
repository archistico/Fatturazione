<?php

try {
    include 'config.php';

    $id = $_GET['ddt_id'];

    $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

    $sql = "SELECT ddtdettaglio.*, prodotto.* ".
        " FROM ddtdettaglio ".
        " INNER JOIN prodotto ON ddtdettaglio.ddd_fkprodotto = prodotto.pro_id ".
        " WHERE ddtdettaglio.ddd_fkddt = ". $id;

    //echo $sql; die();

    $counter = 1;
    $result = $db->query($sql);

    foreach ($result as $row) {
        $row = get_object_vars($row);
        $numero_padded = sprintf("%04d", $row['ddt_numero']);
        
        $listaDDD[] = array('id'=>$counter, 'fkprodotto'=>$row['ddd_fkprodotto'], 'quantita'=>$row['ddd_quantita'], 'prezzo'=>$row['pro_prezzo'], 'tracciabilita'=>$row['ddd_tracciabilita'], 'categoria'=>$row['pro_categoria'], 'descrizione'=>$row['pro_descrizione'], 'ddd_id'=>$row['ddd_id']);

        $counter++;
    }
    // chiude il database
    $db = NULL;

    header('Content-type:application/json;charset=utf-8');
    echo json_encode($listaDDD);

} catch (PDOException $e) {
    throw new PDOException("Error  : " . $e->getMessage());
}
