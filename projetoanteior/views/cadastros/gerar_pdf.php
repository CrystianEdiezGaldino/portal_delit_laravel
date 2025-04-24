<?php
require_once('tcpdf/tcpdf.php'); // Inclua a biblioteca TCPDF

class MYPDF extends TCPDF {
    // Configurações do cabeçalho e rodapé (vazio conforme solicitado)
    public function Header() {}
    public function Footer() {}
}

// Criar novo PDF
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Configurações do documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Supremo Conselho');
$pdf->SetTitle('Cadastro Maçônico');
$pdf->SetMargins(15, 15, 15);

// Adicionar página
$pdf->AddPage();

// Processar dados do formulário
$dados = $_POST;

// Construir conteúdo HTML
$html = '
<style>
    .titulo {
        font-size: 14pt;
        text-align: center;
        margin-bottom: 10px;
    }
    .dados {
        font-size: 10pt;
        margin-bottom: 5px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    td {
        padding: 3px;
        vertical-align: top;
    }
</style>

<div class="titulo">
    SUPREMO CONSELHO DO BRASIL DO GRAU 33<br>
    PARA O R. E. A. A.<br>
    Delegacia Litúrgica Sul-Paraná - 20.1 - CADASTRO
</div>

<table border="1">
    <tr>
        <td width="15%">Registro: '.$dados['id_registro'].'</td>
        <td width="85%">Nome: '.$dados['cadastro'].'</td>
    </tr>
    <tr>
        <td>IME nº: '.$dados['ime_num'].'</td>
        <td>CGOnº: '.$dados['cgo_num'].'</td>
        <td>Email: '.$dados['email'].'</td>
        <td>Cel.: '.$dados['celular'].'</td>
    </tr>
    <tr>
        <td colspan="2">End.Res: '.$dados['endereco_residencial'].'</td>
        <td>Bairro: '.$dados['bairro'].'</td>
    </tr>
    <tr>
        <td>CPF: '.$dados['cpf'].'</td>
        <td>Nasc.: '.$dados['nascimento'].'</td>
        <td>Estado Civil: '.$dados['estado_civil'].'</td>
        <td>NºFilhos: '.$dados['numero_filhos'].'</td>
    </tr>
</table>

<div class="titulo" style="margin-top:15px;">TESOURARIA</div>
<table border="1">
    <tr>
        <td>Iniciado: '.$dados['iniciado_loja'].'</td>
        <td>Loja Nº: '.$dados['numero_loja'].'</td>
        <td>Grau: '.$dados['ativo_no_grau'].'</td>
    </tr>
</table>

<div class="titulo" style="margin-top:15px;">HISTÓRICO DE GRAUS</div>
<table border="1">
    <tr>
        <th width="15%">Grau</th>
        <th width="25%">Data</th>
        <th width="30%">Colou</th>
        <th width="30%">Documento</th>
    </tr>';

$graus = [4,7,9,10,14,15,16,17,18,19,22,29,30,31,32,33];
foreach ($graus as $grau) {
    if (!empty($dados["grau_{$grau}_em"])) {
        $documento = ($grau >= 30) 
            ? 'Patente Nº: '.$dados["patente_{$grau}_num"] 
            : 'Diploma Nº: '.$dados["diploma_{$grau}_num"];
        
        $html .= '
        <tr>
            <td>Grau '.$grau.'</td>
            <td>'.$dados["grau_{$grau}_em"].'</td>
            <td>'.$dados["col_corpo_".$col_corpo_mapping[$grau]].'</td>
            <td>'.$documento.'</td>
        </tr>';
    }
}

$html .= '</table>

<div style="margin-top:20px; font-size:8pt;">
    R: Mal. Deodoro, 502 - 7º andar - Sala 710-Centro-Curitiba-PR-80010-010<br>
    Fone (41) 3222-5178 - e-mail: delitsulpr@gmail.com
</div>';

// Gerar PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Saída do PDF
$pdf->Output('cadastro_maconico.pdf', 'D');