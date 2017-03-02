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

    
    require('numeropagine.php');
    require('fpdf.php');
    include 'php/config.php';
    include 'php/utilita.php';

    // DDT
    include 'php/fattura.php';
    include 'php/ddt.php';
    include 'php/ddtdettaglio.php';

    // MAX RIGHE PER PAGINA
    $maxrighe=25;

    if (!isset($_GET['fat_id'])) {
        echo "FATTURA NON SELEZIONATA";
        die;
    } else {
        $fat_id = $_GET['fat_id'];
    }
    
    $fat = new Fattura();
    $fat->CaricaSQL($fat_id);

    // Trova il numero di DDT presenti in fattura
    $listaDDT = $fat->CercaDDT($fat_id);

    // Per ogni DDT presente in fattura carica DDT e DDD relativo
    $ddts = array();
    $ddds = array();
    $listaDDD = array();
    
    $contatoreDDT = 0;

    foreach($listaDDT as $ddt_id){
        $ddts[$contatoreDDT] = new DDT();
        $ddts[$contatoreDDT]->CaricaSQL($ddt_id);
    
        $contatoreDDT++;
    }
    
    // per ogni DDT cerca il numero dei prodotti associati
    foreach($ddts as $ddt){
        // CARICA IL DDD
        $d = new DDTDettaglio();
        $risultato = $d->CaricaSQL($ddt->ddt_id);
        
        foreach($risultato as $ddd) {
            $ddds[] = $ddd;
        }
    } 
    
    // Cerco il numero totale di prodotti venduti da inserire
    $numrighe=count($ddds)+count($ddts);
    $pagine = new Pagine($maxrighe, $numrighe);

    $pagineTotali = $pagine->PagineTotali();

    /*
    print "<pre>";
    print_r($ddts);
    print_r($ddds);
    print "</pre>";
    print "<br>";
    print "DDD 0: ".$ddds[0]->ddd_quantita."<br>";
    print "<br>";
    print "Numero righe: ".$numrighe."<br>";
    die();
    */

    $mx = 10;
    $my = 10;

    $totaleiva10 =0;
    $totaleiva4 =0;
    
    $totaleimponibile =0;
    $totaleimponibile4 =0;
    $totaleimponibile10 =0;
    $fkddt_vecchio = -1;
    
    $contatoreDDT = 0;
    $contatoreDDD = 0;
    $acconto = 0;

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
      $pdf->SetXY(28+$mx,$clienteY+$my);$pdf->Cell(115,7, $ddt->ddt_fkcliente_denominazione,1);$pdf->ln();
      $pdf->SetFont('Arial','',10);
      $pdf->SetXY(28+$mx,$clienteY+7+$my);$pdf->Cell(115,5, $ddt->ddt_fkcliente_indirizzo." - ".$ddt->ddt_fkcliente_cap." ".$ddt->ddt_fkcliente_comune,1,0,'L');$pdf->ln();
      $pdf->SetXY(28+$mx,$clienteY+7+5+$my);$pdf->Cell(115,5,(!empty($ddt->ddt_fkcliente_telefono)?"tel: ".$ddt->ddt_fkcliente_telefono." " : "").(!empty($ddt->ddt_fkcliente_fax)?"fax: ".$ddt->ddt_fkcliente_fax : ""),1,0,'L');$pdf->ln();
      $pdf->SetXY(28+$mx,$clienteY+7+5+5+$my);$pdf->Cell(115,5,(!empty($ddt->ddt_fkcliente_piva)?"P.IVA / C.F.: ".$ddt->ddt_fkcliente_piva." " : ""),1,0,'L');$pdf->ln();
      $pdf->SetXY(28+$mx,$clienteY+7+5+5+5+$my);$pdf->Cell(115,5,$ddt->ddt_destinazione,1,0,'L');$pdf->ln();
      $pdf->SetXY(28+$mx,$clienteY+7+5+5+5+5+$my);$pdf->Cell(115,5,(!empty($ddt->ddt_fkcliente_email)?"email: ".$ddt->ddt_fkcliente_email : ""),1,0,'L');$pdf->ln();
      
      // Dati fattura
      $pdf->SetFont('Arial','B',12);
      $pdf->SetXY(143+$mx,$clienteY+$my);$pdf->Cell(47,7,$fat->fat_data_stringa,1,0,'C');$pdf->ln();
      $pdf->SetFont('Arial','B',20);
      $pdf->SetXY(143+$mx,$clienteY+7+$my);$pdf->Cell(47,10,"FATTURA",1,0,'C');$pdf->ln();
      $pdf->SetFont('Arial','B',16);
      $pdf->SetXY(143+$mx,$clienteY+7+5+5+$my);$pdf->Cell(47,10,'FAT-'.$fat->fat_anno.'-'.$fat->fat_numero_formattato,1,0,'C');$pdf->ln();
      $pdf->SetFont('Arial','',8);
      $pdf->SetXY(143+$mx,$clienteY+7+5+5+5+5+$my);$pdf->Cell(47,5,"PAGINA ".$paginacorrente."/".$pagineTotali,1,0,'C');$pdf->ln();



      // DETTAGLIO


      $intestazioneY = 66;
      // Intestazione libri nel movimento
      $pdf->SetFont('Arial','B',8);
      $pdf->SetXY(0+$mx,$intestazioneY+$my);
      $pdf->Cell(20,10,"QUANTITA'",1,0,'C');
      $pdf->Cell(75,10,"PRODOTTO",1,0,'C');
      $pdf->Cell(25,10,"TRACCIABILITA'",1,0,'C');
      $pdf->Cell(20,10,"PREZZO",1,0,'C');
      $pdf->Cell(15,10,"IVA [%]",1,0,'C');
      $pdf->Cell(15,10,"IVA",1,0,'C');
      $pdf->Cell(20,10,"IMPORTO",1,0,'C');
      $pdf->ln();
          

      $listaY= $intestazioneY+10;

      // Inserimento Dettagli
      $linea = 0;
      for($contatore = ($paginacorrente-1)*$maxrighe+1; $contatore <= $paginacorrente*$maxrighe; $contatore++){
        
        // ATTENZIONE NUMERAZIONE CONTATORE DDT E DDD
        if(!($ddds[$contatoreDDD]->ddd_fkddt == $fkddt_vecchio)) {
          $fkddt_vecchio = $ddds[$contatoreDDD]->ddd_fkddt;

          $pdf->SetFont('Arial','B',10);
          $pdf->SetXY(0+$mx,$listaY+$my+$linea*6);

          if(($ddts[$contatoreDDT]->ddt_pagato) || $ddts[$contatoreDDT]->ddt_causale=="Omaggio") {
            $pagato = " (Pagato)";
          } else {
            $pagato = "";
          }
          
          $stringaDDT = " DDT-".$ddts[$contatoreDDT]->ddt_anno."-".$ddts[$contatoreDDT]->ddt_numero_formattato." del ".$ddts[$contatoreDDT]->ddt_data_stringa." - ".$ddts[$contatoreDDT]->ddt_causale." - scontrino n. ".$ddts[$contatoreDDT]->ddt_scontrino.$pagato;

          $pdf->Cell(190,6,$stringaDDT,1,0,'L');

          if($contatore == $numrighe) { break; }

          $linea += 1;
          $contatoreDDT += 1;

          continue;
        }

        $fkddt_vecchio = $ddds[$contatoreDDD]->ddd_fkddt;

        // SE DDD
        $pdf->SetFont('Arial','',8);
        $pdf->SetXY(0+$mx,$listaY+$my+$linea*6);
        $pdf->Cell(20,6,$ddds[$contatoreDDD]->ddd_quantita . " ".$ddds[$contatoreDDD]->ddd_fkprodotto_misura,1,0,'C');
        $pdf->Cell(75,6,$ddds[$contatoreDDD]->ddd_fkprodotto_categoria . " - " . $ddds[$contatoreDDD]->ddd_fkprodotto_descrizione ,1,0,'L');
        $pdf->Cell(25,6,$ddds[$contatoreDDD]->ddd_tracciabilita,1,0,'C');
        $pdf->Cell(20,6,number_format($ddds[$contatoreDDD]->ddd_fkprodotto_prezzo, 2, ',', ' ').EURO."/ ".$ddds[$contatoreDDD]->ddd_fkprodotto_misura,1,0,'R');
        $pdf->Cell(15,6,$ddds[$contatoreDDD]->ddd_fkprodotto_iva,1,0,'C');

        $importotemp = $ddds[$contatoreDDD]->ddd_quantita*$ddds[$contatoreDDD]->ddd_fkprodotto_prezzo;
        $ivatemp = ($ddds[$contatoreDDD]->ddd_fkprodotto_iva/100);
        $riga_iva = $importotemp - $importotemp/(1+$ivatemp);
        $pdf->Cell(15,6,number_format($riga_iva, 2, ',', ' ').EURO,1,0,'R');

        // importo
        $imponibile = $ddds[$contatoreDDD]->ddd_quantita*$ddds[$contatoreDDD]->ddd_fkprodotto_prezzo;
        $totaleimponibile += $imponibile;
        $pdf->Cell(20,6,number_format($imponibile, 2, ',', ' ').EURO,1,0,'R');
        $pdf->ln();

        
        if(($ddts[$contatoreDDT-1]->ddt_pagato) || $ddts[$contatoreDDT-1]->ddt_causale=="Omaggio") {
          $acconto += $imponibile;
        }
        
        switch($ddds[$contatoreDDD]->ddd_fkprodotto_iva) {
          case 4: $totaleiva4 += $riga_iva; $totaleimponibile4 += $imponibile; break;
          case 10: $totaleiva10 += $riga_iva; $totaleimponibile10 += $imponibile; break;
        }
        
        // Se arrivo al numero delle righe chiudo
        if($contatore == $numrighe) { break; }

        // Aggiorno contatore linea
        $linea += 1;
        $contatoreDDD += 1;
      }

      // DISEGNO LE LINEE RIMANENTI
      $rimanenti = $maxrighe -$linea;
      for($i=0; $i<($rimanenti); $i++){
        $pdf->SetFont('Arial','',8);
        $pdf->SetXY(0+$mx,$listaY+$my+$linea*6);
        $pdf->Cell(20,6,"",1,0,'C');
        $pdf->Cell(75,6,"",1,0,'L');
        $pdf->Cell(25,6,"",1,0,'C');
        $pdf->Cell(20,6,"",1,0,'R');
        $pdf->Cell(15,6,"",1,0,'C');
        $pdf->Cell(15,6,"",1,0,'C');
        $pdf->Cell(20,6,"",1,0,'R');
        $pdf->ln();

        $linea+=1;
      }



      // Info 
      $ivaY = $listaY+25*6-3;
      $pdf->SetFont('Arial','',8);
      //$pdf->SetXY(0+$mx,$ivaY+$my);
      //$pdf->Cell(190,4,"",0,0,'L');
      $pdf->SetXY(0+$mx,$ivaY+3.5+$my);
      $pdf->Cell(190,4,"Assolve agli obblighi di cui all'art.62 comma 1 del D.L. 24/01/2012 n.1 convertito con modificazioni L. 24/3/2012 n.27 ",0,0,'L');

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
      $pdf->Cell($fondoFirmeX,4,"Firma emittente",0,0,'L');$pdf->ln();

      // Scritta cliente
      $pdf->SetXY(0+$mx,$fondoY+22.5+0.5+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell($fondoFirmeX,4,"Firma cliente",0,0,'L');$pdf->ln();
      

      // Scritta Aliquote
      $pdf->SetXY(0+$mx+$fondoFirmeX+2,$fondoY+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(22,7.5,"ALIQUOTA IVA",1,0,'C');
      $pdf->Cell(20,7.5,"IMPONIBILE",1,0,'C');
      $pdf->Cell(18,7.5,"IMPOSTA",1,0,'C');$pdf->ln();


      // IVA 4
      $pdf->SetXY(0+$mx+$fondoFirmeX+2,$fondoY+7.5+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(22,5,"4%",1,0,'C');
      $pdf->Cell(20,5,number_format($totaleimponibile4-$totaleiva4, 2, ',', ' ').EURO,1,0,'R');
      $pdf->Cell(18,5,number_format($totaleiva4, 2, ',', ' ').EURO,1,0,'R');$pdf->ln();

      // IVA 10
      $pdf->SetXY(0+$mx+$fondoFirmeX+2,$fondoY+7.5+5+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(22,5,"10%",1,0,'C');
      $pdf->Cell(20,5,number_format($totaleimponibile10-$totaleiva10, 2, ',', ' ').EURO,1,0,'R');
      $pdf->Cell(18,5,number_format($totaleiva10, 2, ',', ' ').EURO,1,0,'R');$pdf->ln();

      // ALTRO
      $pdf->SetXY(0+$mx+$fondoFirmeX+2,$fondoY+7.5+5+5+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(22,5,"",1,0,'C');
      $pdf->Cell(20,5,"",1,0,'R');
      $pdf->Cell(18,5,"",1,0,'R');$pdf->ln();


      // ZONA PAGAMENTO
      $pdf->SetXY(0+$mx+$fondoFirmeX+2,$fondoY+7.5+5+5+5+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(60,7.5,"PAGAMENTO ",1,0,'C');
      $pdf->ln();
      $pdf->SetXY(0+$mx+$fondoFirmeX+2,$fondoY+7.5+5+5+5+7.5+$my);
      $pdf->SetFont('Arial','B',16);
      $pdf->Cell(60,15,(!empty($fat->fat_pagata)?"PAGATO" : ""),1,0,'C');

      $pdf->ln();
      

      // TOTALI
      $fondoPagamentoX = 64;
      $pdf->SetXY(0+$mx+$fondoFirmeX+$fondoPagamentoX,$fondoY+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(45,7.5,"TOTALE FATTURA ",1,0,'R');
      $pdf->Cell(35,7.5,number_format($totaleimponibile, 2, ',', ' ').EURO,1,0,'R');
      $pdf->ln();
      $pdf->SetXY(0+$mx+$fondoFirmeX+$fondoPagamentoX,$fondoY+7.5+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(45,5,"IVA TOTALE ",1,0,'R');
      $pdf->Cell(35,5,number_format($totaleiva4 + $totaleiva10, 2, ',', ' ').EURO,1,0,'R');
      $pdf->ln();
      $pdf->SetXY(0+$mx+$fondoFirmeX+$fondoPagamentoX,$fondoY+7.5+5+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(45,5,"IMPONIBILE ",1,0,'R');
      $pdf->Cell(35,5,number_format($totaleimponibile-($totaleiva4 + $totaleiva10), 2, ',', ' ').EURO,1,0,'R');
      $pdf->ln();
      $pdf->SetXY(0+$mx+$fondoFirmeX+$fondoPagamentoX,$fondoY+7.5+5+5+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(45,5,"ACCONTO ",1,0,'R');
      $pdf->Cell(35,5,number_format($acconto, 2, ',', ' ').EURO,1,0,'R');
      $pdf->ln();
      $pdf->SetXY(0+$mx+$fondoFirmeX+$fondoPagamentoX,$fondoY+7.5+5+5+5+$my);
      $pdf->SetFont('Arial','',8);
      $pdf->Cell(45,7.5,"",1,0,'R');
      $pdf->Cell(35,7.5,"",1,0,'R');
      $pdf->ln();

      $pdf->SetXY(0+$mx+$fondoFirmeX+$fondoPagamentoX,$fondoY+7.5+5+5+5+7.5+$my);
      $pdf->SetFont('Arial','B',16);

      $pdf->Cell(45,15,"TOTALE ",1,0,'R');

      $pdf->Cell(35,15,number_format($totaleimponibile-$acconto, 2, ',', ' ').EURO,1,0,'R');
      $pdf->ln();

      // CONTROLLO LA CHIUSURA DEL MOVIMENTO
      /*
      if($fat->chiuso==1) {
        $pdf->Line(0,0,210,297);
        $pdf->Line(210,0,0,297);
      }
      */
      

    } // chiusura per ogni pagina



    // Chiudo il PDF
    //
    $pdf->Output('', 'FAT-'.$fat->fat_anno.'-'.$fat->fat_numero_formattato." ".str_replace(".", "", $ddt->ddt_fkcliente_denominazione).".pdf");

    ?>

  </div>
</body>
</html>