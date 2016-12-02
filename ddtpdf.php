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

    /*class Cliente {
      public $cli_id;
      public $cli_denominazione;
      public $cli_indirizzo;
      public $cli_cap;
      public $cli_comune;
      public $cli_telefono;
      public $cli_fax;
      public $cli_email;
      public $cli_piva;
      public $cli_vecchio;

      public function __construct($denominazione, $indirizzo, $cap, $comune, $telefono, $fax, $email, $piva){
        $this->cli_denominazione=utf8_decode($denominazione);
        $this->cli_indirizzo=utf8_decode($indirizzo);
        $this->cli_cap=$cap;
        $this->cli_comune=utf8_decode($comune);
        $this->cli_telefono=$telefono;
        $this->cli_fax=$fax;
        $this->cli_email=$email;
        $this->cli_piva=$piva;
      }
    }*/





    require('numeropagine.php');
    require('fpdf.php');
    include 'php/config.php';
    include 'php/utilita.php';

    // DDT
    include 'php/ddt.php';
    include 'php/ddtdettaglio.php';

    // MAX RIGHE PER PAGINA
    $maxrighe=25;

    if (!isset($_GET['ddt_id'])) {
        echo "DDT NON SELEZIONATO";
        die;
    } else {
        $ddt_id = $_GET['ddt_id'];
    }

    $ddt = new DDT();
    $ddt->CaricaSQL($ddt_id);

    /*$this->ddt_id = $row['ddt_id'];
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
    $this->ddt_annullato = $row['ddt_annullato'];*/
    

    // CARICA I DDT DETTAGLIO
    $DDD = new DDTDettaglio();
    $lista = $DDD->CaricaSQL($ddt_id);


    $numrighe=count($lista);
    $pagine = new Pagine($maxrighe, $numrighe);

    $pagineTotali = $pagine->PagineTotali();

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
      $pdf->SetFont('Arial','B',20);
      $pdf->SetXY(35+$mx,0+$my);$pdf->Cell(150,10,"Macelleria Peaquin s.n.c");$pdf->ln();
      $pdf->SetFont('Arial','I',10);
      $pdf->SetXY(35+$mx,10+$my);$pdf->Cell(150,5,"Di Peaquin Sandro e Martino");$pdf->ln();
      $pdf->SetFont('Arial','',10);
      $pdf->SetXY(35+$mx,15+$my);$pdf->Cell(150,5,"P.zza Zerbion, 27 - 11027 Saint Vincent (AO)");$pdf->ln();
      $pdf->SetXY(35+$mx,20+$my);$pdf->Cell(150,5,"Telefono: 0166 51 21 87 - P.IVA e C.F. 011 777 100 74");$pdf->ln();
      $pdf->SetXY(35+$mx,25+$my);$pdf->Cell(150,5,"IBAN IT05 S0200 83167 0000 1025 22836");$pdf->ln();
      $pdf->ln();
      // Dati Cliente
      $clienteY=32;
      $pdf->SetFont('Arial','',9);
      $pdf->SetXY(0+$mx,$clienteY+$my);$pdf->Cell(28,7,"CLIENTE ",1,0,'R');$pdf->ln();
      $pdf->SetXY(0+$mx,$clienteY+7+$my);$pdf->Cell(28,5,"INDIRIZZO ",1,0,'R');$pdf->ln();
      $pdf->SetXY(0+$mx,$clienteY+7+5+$my);$pdf->Cell(28,5,"RECAPITO ",1,0,'R');$pdf->ln();
      $pdf->SetXY(0+$mx,$clienteY+7+5+5+$my);$pdf->Cell(28,5,"DATI FISCALI ",1,0,'R');$pdf->ln();
      $pdf->SetXY(0+$mx,$clienteY+7+5+5+5+$my);$pdf->Cell(28,5,"DESTINAZIONE ",1,0,'R');$pdf->ln();
      $pdf->SetXY(0+$mx,$clienteY+7+5+5+5+5+$my);$pdf->Cell(28,5,"ALTRO ",1,0,'R');$pdf->ln();

      $pdf->SetFont('Arial','B',14);
      $pdf->SetXY(28+$mx,$clienteY+$my);$pdf->Cell(115,7,$ddt->ddt_fkcliente_denominazione,1);$pdf->ln();
      $pdf->SetFont('Arial','',10);
      $pdf->SetXY(28+$mx,$clienteY+7+$my);$pdf->Cell(115,5, $ddt->ddt_fkcliente_indirizzo." - ".$ddt->ddt_fkcliente_cap." ".$ddt->ddt_fkcliente_comune,1,0,'L');$pdf->ln();
      
      $pdf->SetXY(28+$mx,$clienteY+7+5+$my);$pdf->Cell(115,5,(!empty($ddt->ddt_fkcliente_telefono)?"tel: ".$ddt->ddt_fkcliente_telefono." " : "").(!empty($ddt->ddt_fkcliente_fax)?"fax: ".$ddt->ddt_fkcliente_fax : ""),1,0,'L');$pdf->ln();
      $pdf->SetXY(28+$mx,$clienteY+7+5+5+$my);$pdf->Cell(115,5,(!empty($ddt->ddt_fkcliente_piva)?"PIVA: ".$ddt->ddt_fkcliente_piva." " : "").(!empty($ddt->ddt_fkcliente_email)?"email: ".$ddt->ddt_fkcliente_email : ""),1,0,'L');$pdf->ln();
      $pdf->SetXY(28+$mx,$clienteY+7+5+5+5+$my);$pdf->Cell(115,5,$ddt->ddt_destinazione,1,0,'L');$pdf->ln();
      $pdf->SetXY(28+$mx,$clienteY+7+5+5+5+5+$my);$pdf->Cell(115,5,"",1,0,'L');$pdf->ln();
      
      // Dati fattura
      $pdf->SetFont('Arial','B',12);
      $pdf->SetXY(143+$mx,$clienteY+$my);$pdf->Cell(47,7,$ddt->ddt_data_stringa,1,0,'C');$pdf->ln();
      $pdf->SetFont('Arial','B',8);
      $pdf->SetXY(143+$mx,$clienteY+7+$my);$pdf->Cell(47,5,"DOCUMENTO DI TRASPORTO",1,0,'C');$pdf->ln();
      $pdf->SetXY(143+$mx,$clienteY+7+5+$my);$pdf->Cell(47,5,"CAUSALE: ".strtoupper($ddt->ddt_causale),1,0,'C');$pdf->ln();
      $pdf->SetFont('Arial','B',16);
      $pdf->SetXY(143+$mx,$clienteY+7+5+5+$my);$pdf->Cell(47,10,'DDT-'.$ddt->ddt_anno.'-'.$ddt->ddt_numero_formattato,1,0,'C');$pdf->ln();
      $pdf->SetFont('Arial','',8);
      $pdf->SetXY(143+$mx,$clienteY+7+5+5+5+5+$my);$pdf->Cell(47,5,"PAGINA ".$paginacorrente."/".$pagineTotali,1,0,'C');$pdf->ln();



      // DETTAGLIO


      $intestazioneY = 66;
      // Intestazione libri nel movimento
      $pdf->SetFont('Arial','B',8);
      $pdf->SetXY(0+$mx,$intestazioneY+$my);
      $pdf->Cell(20,10,"QUANTITA'",1,0,'C');
      $pdf->Cell(80,10,"PRODOTTO",1,0,'C');
      $pdf->Cell(25,10,"TRACCIABILITA'",1,0,'C');
      $pdf->Cell(15,10,"PREZZO",1,0,'C');
      $pdf->Cell(15,10,"IVA [%]",1,0,'C');
      $pdf->Cell(15,10,"IVA",1,0,'C');
      $pdf->Cell(20,10,"IMPORTO",1,0,'C');
      $pdf->ln();
          

      $listaY= $intestazioneY+10;

      $totaleiva10 =0;
      $totaleiva4 =0;
      
      $imponibile10 =0;
      $imponibile4 =0;

      // TEMP

      //$pdf->Cell(100,100,var_dump($listaDDD),1,0,'C');

      /*
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

      */




      // Inserimento Dettagli
      $linea = 0;
      for($contatore = ($paginacorrente-1)*$maxrighe+1; $contatore <= $paginacorrente*$maxrighe; $contatore++){
        $pdf->SetFont('Arial','',8);
        $pdf->SetXY(0+$mx,$listaY+$my+$linea*6);
        $pdf->Cell(20,6,$lista[$contatore-1]->ddd_quantita . " kg",1,0,'C');
        $pdf->Cell(80,6,$lista[$contatore-1]->ddd_fkprodotto_categoria . " - " . $lista[$contatore-1]->ddd_fkprodotto_descrizione ,1,0,'L');
        $pdf->Cell(25,6,$lista[$contatore-1]->ddd_tracciabilita,1,0,'C');
        $pdf->Cell(15,6,EURO.number_format($lista[$contatore-1]->ddd_fkprodotto_prezzo, 2, ',', ' '),1,0,'R');
        $pdf->Cell(15,6,$lista[$contatore-1]->ddd_fkprodotto_iva,1,0,'C');
        
        $riga_iva = $lista[$contatore-1]->ddd_quantita*$lista[$contatore-1]->ddd_fkprodotto_prezzo*($lista[$contatore-1]->ddd_fkprodotto_iva/100);
        $pdf->Cell(15,6,EURO. number_format($riga_iva, 2, ',', ' '),1,0,'R');
        
        // importo
        $pdf->Cell(20,6,EURO. number_format($lista[$contatore-1]->ddd_quantita*$lista[$contatore-1]->ddd_fkprodotto_prezzo, 2, ',', ' '),1,0,'R');
        $pdf->ln();

        $linea += 1;

        if($contatore == count($lista)) { break; }
      }

      // DISEGNO LE LINEE RIMANENTI
      $rimanenti = $maxrighe -$linea;
      for($i=0; $i<($rimanenti); $i++){
        $pdf->SetFont('Arial','',8);
        $pdf->SetXY(0+$mx,$listaY+$my+$linea*6);
        $pdf->Cell(20,6,"",1,0,'C');
        $pdf->Cell(80,6,"",1,0,'L');
        $pdf->Cell(25,6,"",1,0,'C');
        $pdf->Cell(15,6,"",1,0,'R');
        $pdf->Cell(15,6,"",1,0,'C');
        $pdf->Cell(15,6,"",1,0,'C');
        $pdf->Cell(20,6,"",1,0,'R');
        $pdf->ln();

        $linea+=1;
      }

/*

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
      }*/
      

    } // chiusura per ogni pagina



    // Chiudo il PDF
    $pdf->Output(I, $fat->numero." ".str_replace(".", "", $fat->cliente->denominazione).".pdf");

    ?>

  </div>
</body>
</html>
