<!DOCTYPE html>
<html lang="it">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>FATTURA</title>
</head>
<body>
  <div class="container">

    <?php

    define('EURO', " ".chr(128)." ");

    class MovimentoSoggetto {
      public $denominazione;
      public $indirizzo;
      public $cap;
      public $citta;
      public $provincia;
      public $telefono;
      public $email;
      public $piva;
      public $cf;

      public function __construct($denominazione, $indirizzo, $cap, $citta, $provincia, $telefono, $email, $piva, $cf){
        $this->denominazione=utf8_decode($denominazione);
        $this->indirizzo=utf8_decode($indirizzo);
        $this->cap=$cap;
        $this->citta=utf8_decode($citta);
        $this->provincia=utf8_decode($provincia);
        $this->telefono=$telefono;
        $this->email=utf8_decode($email);
        $this->piva=$piva;
        $this->cf=$cf;
      }
    }

    class MovimentoLibro {
      public $quantita;
      public $casaeditrice;
      public $titolo;
      public $tipologia;
      public $isbn;
      public $prezzo;
      public $sconto;
      public $iva;

      public function __construct($quantita, $casaeditrice, $titolo, $tipologia, $isbn, $prezzo, $sconto, $iva){
        $this->quantita=$quantita;
        $this->casaeditrice=utf8_decode($casaeditrice);
        $this->titolo=utf8_decode($titolo);
        $this->tipologia=$tipologia;
        $this->isbn=$isbn;
        $this->prezzo=$prezzo;
        $this->sconto=$sconto;
        $this->iva=$iva;
      }
    }

    class Movimento {
      public $cliente;
      public $numero;
      public $tipologia;
      public $causale;
      public $dataemissione;
      public $note;
      public $aspetto;
      public $trasporto;
      public $pagamentotipologia;
      public $pagamentotermine;
      public $pagamentoeffettuato;
      public $pagato;

      public $libri;

      public $spesespedizione;
      public $scontospedizione;

      public $chiuso;

      public function __construct($cliente,$numero,$tipologia,$causale,$dataemissione,$note,$aspetto,$trasporto,$pagato,$pagamentotipologia,$pagamentotermine,$pagamentoeffettuato,$libri,$spesespedizione,$scontospedizione,$chiuso){
        $this->cliente = $cliente;
        $this->numero = $numero;
        $this->tipologia = $tipologia;
        $this->causale = $causale;
        $this->dataemissione = $dataemissione;
        $this->note = $note;
        $this->aspetto = $aspetto;
        $this->trasporto = $trasporto;
        $this->pagamentotipologia = $pagamentotipologia;
        $this->pagamentotermine = $pagamentotermine;
        $this->pagamentoeffettuato = $pagamentoeffettuato;
        $this->pagato = $pagato;
        $this->libri = $libri;
        $this->spesespedizione = $spesespedizione;
        $this->scontospedizione = $scontospedizione;
        $this->chiuso = $chiuso;
      }
    }

    require('numeropagine.php');
    require('fpdf.php');
    include 'php/movimenti.php';
    include 'php/config.php';
    include 'php/utilita.php';
    include 'php/iva.php';

    // MAX RIGHE PER PAGINA
    $maxrighe=25;

    if (!isset($_GET['idmovimento'])) {
        echo "MOVIMENTO NON SELEZIONATO";
        die;
    } else {
        $idmovimento = $_GET['idmovimento'];
    }

    // CICLA TROVA IVA PER OGNI TIPOLOGIA DI LIBRO










    list(   $mov_denominazione, $mov_indirizzo, $mov_cap, $mov_comune, $mov_provincia, $mov_telefono, $mov_email, $mov_piva, $mov_cf,
    $mov_codice, $mov_anno, $mov_numero,
    $mov_tipologia, $mov_causale, $mov_dataemissione, $mov_riferimento,
    $mov_aspetto, $mov_trasporto,
    $mov_spedizione, $mov_spedizionesconto,
    $mov_pagato, $mov_pagamentotipologia, $mov_datapagamento, $mov_dataentro, $mov_chiuso) = movimentoDettagli($idmovimento);

    $mov_numero = sprintf("%03d", $mov_numero);

    $mov_dataemissione_o = DateTime::createFromFormat('Y-m-d', $mov_dataemissione);
    $mov_dataemissione_formattata = $mov_dataemissione_o->format('d/m/Y');


    if(empty($mov_datapagamento)) {
      $mov_datapagamento_formattata = '-';
    } else {
      $mov_datapagamento_o = DateTime::createFromFormat('Y-m-d', $mov_datapagamento);
      $mov_datapagamento_formattata = $mov_datapagamento_o->format('d/m/Y');
    }


    $mov_dataentro_o = DateTime::createFromFormat('Y-m-d', $mov_dataentro);
    $mov_dataentro_formattata = $mov_dataentro_o->format('d/m/Y');

    // CARICA I LIBRI NEL MOVIMENTO
    try {
        $db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpswd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');

        $result = $db->query('SELECT libri.*, casaeditrice.*, libritipologia.*, movimentidettaglio.* FROM movimentidettaglio INNER JOIN libri ON movimentidettaglio.fklibro = libri.idlibro INNER JOIN casaeditrice ON libri.fkcasaeditrice = casaeditrice.idcasaeditrice INNER JOIN libritipologia ON libri.fktipologia = libritipologia.idlibrotipologia WHERE libri.cancellato = 0 && movimentidettaglio.fkmovimento='.$idmovimento);
        foreach ($result as $row) {
            $row = get_object_vars($row);

            // TODO: Manca la percentuale dell'iva calcolata automaticamente
            $temp_iva = trovaIVA($row['fktipologia'], $mov_dataemissione);

            $lista[] = new MovimentoLibro($row['quantita'], $row['casaeditrice'], $row['titolo'], $row['librotipologia'], $row['isbn'], number_format($row['prezzo'], 2), number_format($row['sconto'],2), $temp_iva);
        }
        // chiude il database
        $db = NULL;
    } catch (PDOException $e) {
        throw new PDOException("Errore : " . $e->getMessage());
    }


    $numrighe=count($lista);
    //$numrighe=26;
    $pagine = new Pagine($maxrighe, $numrighe);

    $pagineTotali = $pagine->PagineTotali();

    $cliente = new MovimentoSoggetto($mov_denominazione, $mov_indirizzo, $mov_cap, $mov_comune, $mov_provincia, $mov_telefono, $mov_email, $mov_piva, $mov_cf);

    $fat = new Movimento($cliente,$mov_anno."-".$mov_codice."-".$mov_numero,strtoupper($mov_tipologia),strtoupper($mov_causale),$mov_dataemissione_formattata,$mov_riferimento,strtoupper($mov_aspetto),strtoupper($mov_trasporto),$mov_pagato,strtoupper($mov_pagamentotipologia),$mov_dataentro_formattata,$mov_datapagamento_formattata,$lista,$mov_spedizione,$mov_spedizionesconto,$mov_chiuso);

    $mx = 10;
    $my = 10;

    ob_end_clean ();
    $pdf = new FPDF('P','mm','A4');
    $pdf->SetAutoPageBreak(true, $my);

    // Per ogni pagina
    for($paginacorrente = 1; $paginacorrente <= $pagineTotali; $paginacorrente++) {
      $pdf->AddPage();


      // Logo
      $pdf->SetFont('Arial','B',16);
      $pdf->Image('logo.jpg',10,10,38);$pdf->ln();
      // Intestazione
      $pdf->SetFont('Arial','B',18);
      $pdf->SetXY(40+$mx,0+$my);$pdf->Cell(150,10,"Casa editrice Elmi's World di Elettra Groppo");$pdf->ln();
      $pdf->SetFont('Arial','',10);
      $pdf->SetXY(40+$mx,10+$my);$pdf->Cell(150,5,"via Guillet, 6 - 11027 Saint Vincent (AO)");$pdf->ln();
      $pdf->SetXY(40+$mx,15+$my);$pdf->Cell(150,5,"Telefono: 388 92 07 016 - Email: info@elmisworld.it");$pdf->ln();
      $pdf->SetXY(40+$mx,20+$my);$pdf->Cell(150,5,"PIVA: 011 463 700 75 - CF: GRP LTR 82P47 Z126I");$pdf->ln();
      $pdf->SetXY(40+$mx,25+$my);$pdf->Cell(150,5,"CC. Banco Posta intestato a Elettra Groppo - IBAN IT78 L076 0101 2000 0101 8616 480");$pdf->ln();
      $pdf->ln();
      // Dati Cliente
      $clienteY=32;
      $pdf->SetFont('Arial','',10);
      $pdf->SetXY(0+$mx,$clienteY+$my);$pdf->Cell(28,7,"CLIENTE:",1,0,'R');$pdf->ln();
      $pdf->SetXY(0+$mx,$clienteY+7+$my);$pdf->Cell(28,5,"INDIRIZZO:",1,0,'R');$pdf->ln();
      $pdf->SetXY(0+$mx,$clienteY+7+5+$my);$pdf->Cell(28,5,"RECAPITO:",1,0,'R');$pdf->ln();
      $pdf->SetXY(0+$mx,$clienteY+7+5+5+$my);$pdf->Cell(28,5,"DATI FISCALI:",1,0,'R');$pdf->ln();
      $pdf->SetXY(0+$mx,$clienteY+7+5+5+5+$my);$pdf->Cell(28,10,"NOTE:",1,0,'R');$pdf->ln();

      $pdf->SetFont('Arial','B',14);
      $pdf->SetXY(28+$mx,$clienteY+$my);$pdf->Cell(115,7,$fat->cliente->denominazione,1);$pdf->ln();
      $pdf->SetFont('Arial','',10);
      $pdf->SetXY(28+$mx,$clienteY+7+$my);$pdf->Cell(115,5, $fat->cliente->indirizzo." - ".$fat->cliente->cap." ".$fat->cliente->citta." (".$fat->cliente->provincia.")",1,0,'L');$pdf->ln();
      $pdf->SetXY(28+$mx,$clienteY+7+5+$my);$pdf->Cell(115,5,(!empty($fat->cliente->telefono)?"tel: ".$fat->cliente->telefono." " : "").(!empty($fat->cliente->email)?"email: ".$fat->cliente->email : ""),1,0,'L');$pdf->ln();
      $pdf->SetXY(28+$mx,$clienteY+7+5+5+$my);$pdf->Cell(115,5,(!empty($fat->cliente->piva)?"PIVA: ".$fat->cliente->piva." " : "").(!empty($fat->cliente->cf)?"CF: ".$fat->cliente->cf : ""),1,0,'L');$pdf->ln();
      $pdf->SetXY(28+$mx,$clienteY+7+5+5+5+$my);$pdf->Cell(115,5,$fat->note,1,0,'L');$pdf->ln();
      $pdf->SetXY(28+$mx,$clienteY+7+5+5+5+5+$my);$pdf->Cell(115,5,"",1,0,'L');$pdf->ln();
      // Dati fattura
      $pdf->SetFont('Arial','B',12);
      $pdf->SetXY(143+$mx,$clienteY+$my);$pdf->Cell(47,7,$fat->dataemissione,1,0,'C');$pdf->ln();
      $pdf->SetFont('Arial','B',8);
      $pdf->SetXY(143+$mx,$clienteY+7+$my);$pdf->Cell(47,5,$fat->tipologia,1,0,'C');$pdf->ln();
      $pdf->SetXY(143+$mx,$clienteY+7+5+$my);$pdf->Cell(47,5,"CAUSALE: ".$fat->causale,1,0,'C');$pdf->ln();
      $pdf->SetFont('Arial','B',18);
      $pdf->SetXY(143+$mx,$clienteY+7+5+5+$my);$pdf->Cell(47,10,$fat->numero,1,0,'C');$pdf->ln();
      $pdf->SetFont('Arial','',8);
      $pdf->SetXY(143+$mx,$clienteY+7+5+5+5+5+$my);$pdf->Cell(47,5,"PAGINA ".$paginacorrente."/".$pagineTotali,1,0,'C');$pdf->ln();

      $intestazioneY = 66;
      // Intestazione libri nel movimento
      $pdf->SetFont('Arial','B',8);
      $pdf->SetXY(0+$mx,$intestazioneY+$my);
      $pdf->Cell(10,10,"QT",1,0,'C');
      $pdf->Cell(82,10,"TITOLO",1,0,'C');
      $pdf->Cell(28,10,"ISBN",1,0,'C');
      $pdf->Cell(15,10,"PREZZO",1,0,'C');
      $pdf->Cell(10,10,"",1,0,'C');
      $pdf->Cell(10,10,"",1,0,'C');
      $pdf->Cell(15,10,"IVA",1,0,'C');
      $pdf->Cell(20,10,"",1,0,'C');$pdf->ln();
      $pdf->SetXY(135+$mx,$intestazioneY+$my);$pdf->Cell(10,5,"SCO",0,0,'C');$pdf->ln();
      $pdf->SetXY(135+$mx,$intestazioneY+5+$my);$pdf->Cell(10,5,"[%]",0,0,'C');$pdf->ln();
      $pdf->SetXY(145+$mx,$intestazioneY+$my);$pdf->Cell(10,5,"IVA",0,0,'C');$pdf->ln();
      $pdf->SetXY(145+$mx,$intestazioneY+5+$my);$pdf->Cell(10,5,"[%]",0,0,'C');$pdf->ln();
      $pdf->SetXY(170+$mx,$intestazioneY+$my);$pdf->Cell(20,5,"IMPORTO",0,0,'C');$pdf->ln();
      $pdf->SetXY(170+$mx,$intestazioneY+5+$my);$pdf->Cell(20,5,"SCONTATO",0,0,'C');$pdf->ln();

      $listaY= $intestazioneY+10;

      $totaleivacarta =0;
      $totaleivaebook =0;
      $totaleivaaltro =0;
      $imponibilecarta =0;
      $imponibileebook =0;
      $imponibilealtro =0;

      $totalesconto = 0;
      $totalenonscontato =0;



      // Calcolo valori globali movimento
      foreach($fat->libri as $l){
        $riga_iva=0;
        if($l->tipologia=="Carta") {
          $riga_iva = 0;
          $imponibilecarta +=$l->quantita*$l->prezzo*(1-$l->sconto/100);
        } elseif($l->tipologia=="Ebook") {
          $imponibileebook +=$l->quantita*$l->prezzo*(1-$l->sconto/100)/(1+$l->iva/100);
          $riga_iva = $l->quantita*$l->prezzo*(1-$l->sconto/100)-$l->quantita*$l->prezzo*(1-$l->sconto/100)/(1+$l->iva/100);
          $totaleivaebook+=$riga_iva;
        } else {
          $imponibilealtro +=$l->quantita*$l->prezzo*(1-$l->sconto/100)/(1+$l->iva/100);
          $riga_iva = $l->quantita*$l->prezzo*(1-$l->sconto/100)-$l->quantita*$l->prezzo*(1-$l->sconto/100)/(1+$l->iva/100);
          $totaleivaaltro+=$riga_iva;
        }
        $totalesconto+=$l->quantita*$l->sconto/100*$l->prezzo;
        $totalenonscontato +=$l->quantita*$l->prezzo;
      }














      // Inserimento libri
      $linea = 0;
      for($contatore = ($paginacorrente-1)*$maxrighe+1; $contatore <= $paginacorrente*$maxrighe; $contatore++){
        $pdf->SetFont('Arial','',8);
        $pdf->SetXY(0+$mx,$listaY+$my+$linea*6);
        $pdf->Cell(10,6,$lista[$contatore-1]->quantita,1,0,'C');
        $pdf->Cell(82,6,$lista[$contatore-1]->casaeditrice . " - " . $lista[$contatore-1]->titolo . " (". $lista[$contatore-1]->tipologia.")",1,0,'L');
        $pdf->Cell(28,6,$lista[$contatore-1]->isbn,1,0,'C');
        $pdf->Cell(15,6,EURO.number_format($lista[$contatore-1]->prezzo, 2, ',', ' '),1,0,'R');
        $pdf->Cell(10,6,$lista[$contatore-1]->sconto,1,0,'C');
        $pdf->Cell(10,6,$lista[$contatore-1]->iva,1,0,'C');
        // iva
        $riga_iva=0;
        if($lista[$contatore-1]->tipologia=="Carta") {
          $riga_iva = 0;
          $pdf->Cell(15,6,"-",1,0,'C');
        } else {
          $riga_iva = $lista[$contatore-1]->quantita*$lista[$contatore-1]->prezzo*(1-$lista[$contatore-1]->sconto/100)-$lista[$contatore-1]->quantita*$lista[$contatore-1]->prezzo*(1-$lista[$contatore-1]->sconto/100)/(1+$lista[$contatore-1]->iva/100);
          $pdf->Cell(15,6,EURO. number_format($riga_iva, 2, ',', ' '),1,0,'R');
        }

        // importo scontato
        $pdf->Cell(20,6,EURO. number_format($lista[$contatore-1]->quantita*(1-$lista[$contatore-1]->sconto/100)*$lista[$contatore-1]->prezzo, 2, ',', ' '),1,0,'R');
        $pdf->ln();

        $linea += 1;

        if($contatore == count($lista)) { break; }
      }






      // DISEGNO LE LINEE RIMANENTI
      $rimanenti = $maxrighe -$linea;
      for($i=0; $i<($rimanenti); $i++){
        $pdf->SetFont('Arial','',8);
        $pdf->SetXY(0+$mx,$listaY+$my+$linea*6);
        $pdf->Cell(10,6,"",1,0,'C');
        $pdf->Cell(82,6,"",1,0,'L');
        $pdf->Cell(28,6,"",1,0,'C');
        $pdf->Cell(15,6,"",1,0,'R');
        $pdf->Cell(10,6,"",1,0,'C');
        $pdf->Cell(10,6,"",1,0,'C');
        $pdf->Cell(15,6,"",1,0,'C');
        $pdf->Cell(20,6,"",1,0,'R');
        $pdf->ln();

        $linea+=1;
      }


      // Info IVA
      $ivaY = $listaY+25*6-3;
      $pdf->SetFont('Arial','',8);
      //$pdf->SetXY(0+$mx,$ivaY+$my);
      //$pdf->Cell(190,4,"Operazione non imponibile ai sensi dell'art. 41 comma 1 lettera a D.L. 331/1993 - Contributo ambientale CONAI assolto",0,0,'L');
      $pdf->SetXY(0+$mx,$ivaY+3.5+$my);
      $pdf->Cell(190,4,"* Riferimenti di legge IVA ASSOLTA DALL'EDITORE ART. 74 D.P.R. 633/72",0,0,'L');

      // Zona timbri vettore e cliente
      $fondoY = $ivaY + 9;
      $fondoFirmeX = 48;
      $pdf->SetFont('Arial','',8);

      $pdf->SetXY(0+$mx,$fondoY+$my);
      $pdf->SetLineWidth(0.2);
      $pdf->Cell($fondoFirmeX,45,"",1,0,'L');$pdf->ln();

      $pdf->SetLineWidth(0.2);
      $pdf->SetXY(0+$mx,$fondoY+$my);
      $pdf->Cell($fondoFirmeX,22.5,"",1,0,'L');$pdf->ln();
      $pdf->Cell($fondoFirmeX,22.5,"",1,0,'L');

      // Scritta vettore
      $pdf->SetXY(0+$mx,$fondoY+0.5+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell($fondoFirmeX,4,$fat->trasporto." - ".$fat->aspetto,0,0,'L');$pdf->ln();
      $pdf->Cell($fondoFirmeX,4,"Firma vettore",0,0,'L');

      // Scritta cliente
      $pdf->SetXY(0+$mx,$fondoY+22.5+0.5+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell($fondoFirmeX,4,"Firma cliente",0,0,'L');

      // Scritta vettore
      $pdf->SetXY(0+$mx+$fondoFirmeX+2,$fondoY+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(22,7.5,"ALIQUOTA IVA",1,0,'C');
      $pdf->Cell(20,7.5,"IMPONIBILE",1,0,'C');
      $pdf->Cell(18,7.5,"IMPOSTA",1,0,'C');$pdf->ln();

      // LISTA IVA
      list($aliquotaIVAcarta, $aliquotaIVAebook, $aliquotaIVAaltro) = listaIVA($mov_dataemissione);

      // IVA CARTA
      $pdf->SetXY(0+$mx+$fondoFirmeX+2,$fondoY+7.5+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(22,5,"Carta: ".$aliquotaIVAcarta."%",1,0,'C');
      $pdf->Cell(20,5,EURO.  number_format($imponibilecarta, 2, ',', ' '),1,0,'R');
      $pdf->Cell(18,5,EURO.  number_format($totaleivacarta, 2, ',', ' '),1,0,'R');$pdf->ln();

      // IVA EBOOK
      $pdf->SetXY(0+$mx+$fondoFirmeX+2,$fondoY+7.5+5+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(22,5,"Ebook: ".$aliquotaIVAebook."%",1,0,'C');
      $pdf->Cell(20,5,EURO.  number_format($imponibileebook, 2, ',', ' '),1,0,'R');
      $pdf->Cell(18,5,EURO.  number_format($totaleivaebook, 2, ',', ' '),1,0,'R');$pdf->ln();

      // IVA ALTRO
      $pdf->SetXY(0+$mx+$fondoFirmeX+2,$fondoY+7.5+5+5+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(22,5,"Altro: ".$aliquotaIVAaltro."%",1,0,'C');
      $pdf->Cell(20,5,EURO.  number_format($imponibilealtro, 2, ',', ' '),1,0,'R');
      $pdf->Cell(18,5,EURO.  number_format($totaleivaaltro, 2, ',', ' '),1,0,'R');$pdf->ln();

      // ZONA PAGAMENTO
      $pdf->SetXY(0+$mx+$fondoFirmeX+2,$fondoY+7.5+5+5+5+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(22,7.5,"PAGAMENTO ",1,0,'R');
      if($fat->pagato){
        $pdf->Cell(38,7.5,"PAGATO",1,0,'L');
      }
      else {
        $pdf->Cell(38,7.5,"NON PAGATO",1,0,'L');
      }
      $pdf->ln();
      $pdf->SetXY(0+$mx+$fondoFirmeX+2,$fondoY+7.5+5+5+5+7.5+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(22,5,"TERMINE:",1,0,'R');
      $pdf->Cell(38,5,$fat->pagamentotermine,1,0,'L');
      $pdf->ln();
      $pdf->SetXY(0+$mx+$fondoFirmeX+2,$fondoY+7.5+5+5+5+7.5+5+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(22,5,"PAGAMENTO:",1,0,'R');
      $pdf->Cell(38,5,$fat->pagamentotipologia,1,0,'L');
      $pdf->ln();
      $pdf->SetXY(0+$mx+$fondoFirmeX+2,$fondoY+7.5+5+5+5+7.5+5+5+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(22,5,"EFFETTUATO:",1,0,'R');
      $pdf->Cell(38,5,$fat->pagamentoeffettuato,1,0,'L');
      $pdf->ln();

      // TOTALI
      $fondoPagamentoX = 64;
      $pdf->SetXY(0+$mx+$fondoFirmeX+$fondoPagamentoX,$fondoY+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(50,7.5,"LORDO TOTALE ",1,0,'R');
      $pdf->Cell(30,7.5,EURO. number_format($totalenonscontato, 2, ',', ' '),1,0,'R');
      $pdf->ln();
      $pdf->SetXY(0+$mx+$fondoFirmeX+$fondoPagamentoX,$fondoY+7.5+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(50,5,"SCONTO TOTALE ",1,0,'R');
      $pdf->Cell(30,5,EURO.  number_format($totalesconto, 2, ',', ' '),1,0,'R');
      $pdf->ln();
      $pdf->SetXY(0+$mx+$fondoFirmeX+$fondoPagamentoX,$fondoY+7.5+5+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(50,5,"IVA TOTALE ",1,0,'R');
      $pdf->Cell(30,5,EURO.  number_format($totaleivaebook+$totaleivaaltro, 2, ',', ' '),1,0,'R');
      $pdf->ln();
      $pdf->SetXY(0+$mx+$fondoFirmeX+$fondoPagamentoX,$fondoY+7.5+5+5+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(50,5,"IMPORTO SCONTATO TOTALE ",1,0,'R');
      $pdf->Cell(30,5,EURO.  number_format($totalenonscontato-$totalesconto, 2, ',', ' '),1,0,'R');
      $pdf->ln();
      $pdf->SetXY(0+$mx+$fondoFirmeX+$fondoPagamentoX,$fondoY+7.5+5+5+5+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(50,7.5,"SPEDIZIONE".EURO.  number_format($fat->spesespedizione, 2, ',', ' ')." SCONTO ".$fat->scontospedizione."%",1,0,'R');
      $pdf->Cell(30,7.5,EURO.  number_format($fat->spesespedizione*(1-$fat->scontospedizione/100), 2, ',', ' '),1,0,'R');
      $pdf->ln();
      $pdf->SetXY(0+$mx+$fondoFirmeX+$fondoPagamentoX,$fondoY+7.5+5+5+5+7.5+$my);
      $pdf->SetFont('Arial','B',16);

      if($fat->pagato){
        $pdf->Cell(50,15,"PAGATO ",1,0,'R');
      }
      else {
        $pdf->Cell(50,15,"DA PAGARE ",1,0,'R');
      }
      $pdf->Cell(30,15,EURO.  number_format($totalenonscontato-$totalesconto+($fat->spesespedizione*(1-$fat->scontospedizione/100)), 2, ',', ' '),1,0,'R');
      $pdf->ln();

      // CONTROLLO LA CHIUSURA DEL MOVIMENTO
      if($fat->chiuso==1) {
        $pdf->Line(0,0,210,297);
        $pdf->Line(210,0,0,297);
      }
    }



    // Chiudo il PDF
    $pdf->Output(I, $fat->numero." ".str_replace(".", "", $fat->cliente->denominazione).".pdf");

    ?>

  </div>
</body>
</html>
