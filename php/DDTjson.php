<?php

try {
    include 'config.php';

    $cliente_id = $_POST['cliente_id'];
    //$cliente_id = $_GET['cliente_id'];

    $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

    $sql = "SELECT ddt.*, cliente.* ".
        "FROM ddt INNER JOIN cliente ON ddt.ddt_fkcliente = cliente.cli_id ".
        "WHERE ddt.ddt_annullato = 0 AND ddt.ddt_fkfattura IS NULL AND ddt.ddt_fatturazioneelettronica = 0 AND ddt.ddt_fkcliente = ".$cliente_id;

    //echo $sql; die();

    $result = $db->query($sql);

    foreach ($result as $row) {
        $row = get_object_vars($row);
        $numero_padded = sprintf("%04d", $row['ddt_numero']);
        $dataEmissione = DateTime::createFromFormat('Y-m-d', $row['ddt_data'])->format('d/m/Y');

        $listaDDT[] = array('ddt_id' => $row['ddt_id'], 'descrizione' => "DDT ".$numero_padded . " del " .$dataEmissione. " - ". $row['cli_denominazione']." = &euro; " . $row['ddt_importo'] ." (".$row['ddt_causale'].")");
    }
    // chiude il database
    //utf8_encode()
    $db = NULL;

    //echo var_dump($listaDDT);

    header('Content-type:application/json;charset=utf-8');
    echo json_encode($listaDDT);

} catch (PDOException $e) {
    throw new PDOException("Error  : " . $e->getMessage());
}
