<?php
require("pdf/fpdf.php");

function LoadData($file)
{		// Read file lines
	$lines = file($file);
	$data = array();
	foreach($lines as $line)
		$data[] = explode(';',trim($line));
	return $data;
}

function BasicTable($header, $data)
{
	// Header
	foreach($header as $col)
		$this->Cell(40,7,$col,1);
	$this->Ln();
	// Data
	foreach($data as $row)
	{
		foreach($row as $col)
			$this->Cell(40,6,$col,1);
		$this->Ln();
	}
}

$cabecario_posto = 'POSTO AVANCADO TRT SAO PAULO - 02 REGIAO';
$cabecario_setor_parte1 = 'PROTOCOLO INTEGRADO - CAPITAL';
$cabecario_setor_parte2 = 'CASA DA ADVOCACIA E DA CIDADANIA - TRABALHISTA';
$cabecario_setor_endereco = 'Avenida Ipiranga, 1.267 - 3 andar - Republica';
#$titulo = 'CONTROLE DE PROTOCOLO';
$titulo = 'RELATORIO MENSAL - PROTOCOLO TRT 2 REGIAO';
$cabecario_titulo = str_repeat(" ", 40-strlen($titulo)/2).$titulo;	
$cabecario_tabela = 'DATA       CIDADE                        VARA PROCESSO(S)           CHANCELA  P';
$rodape_usuarios = 'Cadastrado por: ';
$rodape_recebido = 'Recebido em: ____/ ____/ 20____.';
$rodape_assinatura_parte1 = '___________________';
$rodape_assinatura_parte2 = 'Assinatura e Carimbo';
$rodape_observacao = 'Observação:';
$dados_rel = "03/10/2016       p08    23.000    23.000     145 \n03/10/2016       p08    23.000    23.000     145"; 


$pdf= new FPDF("P","pt","A4"); 
$pdf->SetFont('arial','',10);

$pdf->AddPage();

# Logo
$pdf->Image('html/images/logo.png',260,10,60,30);
$pdf->Ln(15); 

# Cabeçario 
$pdf->SetFont('arial','',10);
$pdf->Cell(0,10,$cabecario_posto,0,1,'L');
$pdf->Cell(0,10,$cabecario_setor_parte1,0,1,'L');
$pdf->SetFont('arial','B',10);
$pdf->Cell(0,10,$cabecario_setor_parte2,0,1,'L');
$pdf->SetFont('arial','',10);
$pdf->Cell(0,10,$cabecario_setor_endereco,0,1,'L');
$pdf->Cell(0,10,"","B",1,'C');
$pdf->Ln(15); 

# Titulo
$pdf->SetFont('arial','B',10); 
$pdf->Cell(0,10,$titulo,0,1,'C');
$pdf->Ln(15); 

$header = array('DATA', 'MAQUINA', 'INICIO', 'FINAL','TOTAL');
$dados = LoadData("pdf.txt");
$total = 0;
$chave = false;
$i = 1;

	// Header
	$pdf->SetFont('arial','B',10);
    foreach($header as $col)			
			$pdf->Cell(108,30,$col,1,0,'C');		
		$pdf->Ln();
		// Data
		$pdf->SetFont('arial','',10);
		foreach($dados as $row)
		{			
			foreach($row as $col)				
				$pdf->Cell(108,20,$col,1,0,'C');
			$pdf->Ln();
			$total += $col;
		}
#total
$pdf->Ln(15); 
$pdf->SetFont('arial','B',10);
$pdf->Cell(0,10,"TOTAL DE PROTOCOLOS RECEBIDOS: ".$total,0);

#var_dump($dados);
$pdf->Output("arquivo.pdf","D");

?>