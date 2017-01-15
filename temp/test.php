<?php

try {
    include '../php/config.php';
    include '../php/utilita.php';

    $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

    $sql = "SELECT * ".
        "FROM prodotto ".
        "WHERE pro_vecchio = 0 AND pro_categoria = 'Bovino'".
        "ORDER BY pro_categoria ASC, pro_descrizione ASC, pro_prezzo ASC";

    //echo $sql; die();

    $result = $db->query($sql);

    foreach ($result as $row) {
        $row = get_object_vars($row);
        
        $listaProdotti[] = array('pro_id' => $row['pro_id'], 'pro_categoria' =>  utf8_encode($row['pro_categoria']), 'pro_descrizione' =>  utf8_encode($row['pro_descrizione']), 'pro_prezzo' =>  $row['pro_prezzo']);
    }
    // chiude il database
    // utf8_encode()
    $db = NULL;
    
    /*
    echo "<pre>";
    echo var_dump($listaProdotti); 
    echo "</pre>";
    die();
    */

    header('Content-type:application/json;charset=utf-8');
    echo json_encode($listaProdotti);

} catch (PDOException $e) {
    throw new PDOException("Error  : " . $e->getMessage());
}
