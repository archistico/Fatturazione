<?php

$errors = array();
$data = array();

//session_start();
//if (isset($_SESSION['idutente'])) 
//{
//    $idutente = $_SESSION['idutente'];
//} else {
//    $errors['idutente'] = 'Utente non loggato';
//    $idutente = null;
//}
// Getting posted data and decodeing json
$_POST = json_decode(file_get_contents('php://input'), true);

//cliente: $scope.cliente,
if (empty($_POST['cliente'])) {
    $errors['cliente'] = 'ID cliente non passato';
} else {
    $cliente = $_POST['cliente'];
}

//dataEmissione: $scope.dataEmissione,
if (empty($_POST['dataEmissione'])) {
    $errors['dataEmissione'] = 'dataEmissione non passato';
} else {
    $dataEmissione = $_POST['dataEmissione'];
}

//tipologia: $scope.tipologia,
if (empty($_POST['tipologia'])) {
    $errors['tipologia'] = 'tipologia non passato';
} else {
    $tipologia = $_POST['tipologia'];
}

//causale: $scope.causale,
if (empty($_POST['causale'])) {
    $errors['causale'] = 'causale non passato';
} else {
    $causale = $_POST['causale'];
}

//riferimento: $scope.riferimento,
if (empty($_POST['riferimento'])) {
    $riferimento = '-';
} else {
    $riferimento = $_POST['riferimento'];
}

//spedizione: $scope.spedizione,
if (!isset($_POST['spedizione'])) {
    $errors['spedizione'] = 'spedizione non passato';
} else {
    $spedizione = $_POST['spedizione'];
}

//spedizionesconto: $scope.spedizionesconto,
if (!isset($_POST['spedizionesconto'])) {
    $errors['spedizionesconto'] = 'spedizionesconto non passato';
} else {
    $spedizionesconto = $_POST['spedizionesconto'];
}

//trasporto: $scope.trasporto,
if (empty($_POST['trasporto'])) {
    $errors['trasporto'] = 'trasporto non passato';
} else {
    $trasporto = $_POST['trasporto'];
}

//aspetto: $scope.aspetto,
if (empty($_POST['aspetto'])) {
    $errors['aspetto'] = 'aspetto non passato';
} else {
    $aspetto = $_POST['aspetto'];
}

//modalita: $scope.modalita,
if (empty($_POST['modalita'])) {
    $errors['modalita'] = 'modalita non passato';
} else {
    $modalita = $_POST['modalita'];
}

//dataEntro: $scope.dataEntro,
if (empty($_POST['dataEntro'])) {
    $errors['dataEntro'] = 'dataEntro non passato';
} else {
    $dataEntro = $_POST['dataEntro'];
}

//pagato: $scope.pagato,
if (!isset($_POST['pagato'])) {
    $errors['pagato'] = 'pagato non passato';
} else {
    $pagato = $_POST['pagato'];
}

//dataPagamento: $scope.dataPagamento,
if (empty($_POST['dataPagamento'])) {
    //
} else {
    $dataPagamento = $_POST['dataPagamento'];
    $dataPagamento_S = new DateTime(date('Y-m-d H:i',strtotime('+1 hour',strtotime($dataPagamento))));
}

//note: $scope.note
if (empty($_POST['note'])) {
    $note = '-';
} else {
    $note = $_POST['note'];
}

if (empty($errors)) {
    try {
        include 'config.php';
        
        $dbhost = "localhost";
        $dbname = "helpbookdb";
        $dbuser = "root";
        $dbpswd = "";
        
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
        
        date_default_timezone_set('Europe/Rome');
        $dataEmissione_S = new DateTime(date('Y-m-d H:i',strtotime('+1 hour',strtotime($dataEmissione))));
        $dataEntro_S = new DateTime(date('Y-m-d H:i',strtotime('+1 hour',strtotime($dataEntro))));
        
        $result = $db->query("SELECT MAX(numero) AS ultimo FROM movimenti WHERE anno = '".date_format($dataEmissione_S, "Y")."' AND fktipologia = ".$tipologia."");
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $numero = $row['ultimo'] + 1;        
                
        $db->exec("INSERT INTO helpbookdb.movimenti (idmovimento, fktipologia, fkcausale, numero, anno, riferimento, fksoggetto, movimentodata, pagamentoentro, pagata, fkpagamentotipologia, datapagamento, spedizionecosto, spedizionesconto, fkaspetto, fktrasporto, note, cancellato) VALUES (NULL, '".$tipologia."', '".$causale."', '".$numero."', '".date_format($dataEmissione_S, "Y")."', '', '".$cliente."', '".date_format($dataEmissione_S, "Y-m-d")."', '".date_format($dataEntro_S, "Y-m-d")."', '".$pagata."', '".$modalita."', '".date_format($dataPagamento_S, "Y-m-d")."', '".$spedizione."', '".$spedizionesconto."', '".$aspetto."', '".$trasporto."', '".$note."', '0');");
        
        // chiude il database
        $db = NULL;
    } catch (PDOException $e) {
        $errors['database'] = "Errore inserimento nel database";
    }
}

if (!empty($errors)) {
    //$errors['POST']=$_POST;
    $data['errors'] = $errors;
    $data['message'] = 'ATTENZIONE';
} else {
    $data['message'] = 'OK';
}

// response back.
echo json_encode($data);
?>

