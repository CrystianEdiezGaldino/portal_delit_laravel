<?php
require "./code128.php";
include_once "../../../../inc/class_bd.php";
$Obj_Con = new Abre_Bd();

$pdf = new PDF_Code128('P','mm',array(110,200));
$pdf->SetMargins(4,5,4);
$pdf->AddPage();
$pdf->SetFont('Courier','',9);
$pdf->Image('logo.png',30);
$pdf->Ln(3);
$pdf->MultiCell(0,5,"BR 166 KM6 N° 5000 - Mauá - Colombo - PR",0,'C',false);
$pdf->MultiCell(0,5,"CNPJ: 75.031.278.0001-25 IE: Isento",0,'C',false);
$pdf->MultiCell(0,5,"TEL:41 3675-4200",0,'C',false);
$pdf->MultiCell(0,5,"Email: smcc@santamonica.rec.br",0,'C',false);
$pdf->Ln(1);
$pdf->Cell(0,5,utf8_encode("----------------------------------------------------"),0,0,'L');
$pdf->Ln(5);


$proposta = $_GET['proposta'];

$sqlRecibo = "SELECT a.nome_associado, a.usuario_cadastro, b.entrada, b.parcela, b.ini_parcelamento, c.Produto, c.ValorProduto from [SisClube].[dbo].[Dados_Proposta] a inner join [SisClube].[dbo].[Pagamento_Proposta] b on a.num_proposta=b.num_proposta left join [SisClube].[dbo].[Produto] c on a.id_produto=c.IdProduto where a.id_categ <> 2 and a.num_proposta = $proposta";
$resRecibo = $Obj_Con->query($sqlRecibo);
while ($rowRecibo = mssql_fetch_array($resRecibo)) {
	$pagante = trim($rowRecibo["nome_associado"]);
	$cobrador = trim($rowRecibo["usuario_cadastro"]);
	$parcela = trim($rowRecibo["parcela"]);
	$produto = trim($rowRecibo["Produto"]);
	$entrada = number_format(trim($rowRecibo["entrada"]), 2, ',', '.');
	$total_produto = number_format(trim($rowRecibo["ValorProduto"]), 2, ',', '.');
	$ini_parcelamento = date("m/Y", strtotime(trim($rowRecibo["ini_parcelamento"])));
}
	
	$pdf->MultiCell(0,5,utf8_encode("Nome:".strtoupper(utf8_decode($pagante))),0,'L',false);
	$pdf->MultiCell(0,5,utf8_encode("Vendedor:".strtoupper($cobrador)),0,'L',false);
	$pdf->MultiCell(0,5,utf8_encode('Pagamento:'.date("d/m/Y H:i:s")),0,'L',false);
	
	$pdf->MultiCell(0,5,"----------------------Descrição---------------------",0,'C',false);
	
	$pdf->MultiCell(0,5,utf8_encode("Pagamento da entrada: R$".strtoupper($entrada)),0,'L',false);
	$pdf->MultiCell(0,5,utf8_encode("Produto: ".strtoupper($produto)),0,'L',false);
	$pdf->MultiCell(0,5,utf8_encode("Valor total do produto: R$".strtoupper($total_produto)),0,'L',false);
	$pdf->MultiCell(0,5,utf8_encode("Parcelado em: ".strtoupper($parcela)."X"),0,'L',false);
	$pdf->MultiCell(0,5,utf8_encode("Inicio parcelamento: ".strtoupper($ini_parcelamento)),0,'L',false);
	

	$pdf->MultiCell(0,5,utf8_encode('----------------------------------------------------'),0,'C',false);
	
	$pdf->SetFont('Courier','',12);
	$pdf->MultiCell(0,5,utf8_encode('Total pago: R$'.$entrada),0,'C',false);
	
	$pdf->Output("I","Recibo.pdf",true);
?>

		
