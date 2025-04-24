<?php
include_once "../../../inc/class_bd.php";
include ('../../../Convites/evento/pdf/mpdf.php');

$proposta = 12;

$mpdf = new mPDF();
$mpdf->AddPage('P');
$Obj_Con = new Abre_Bd();
$dt_hj = date('d/m/Y H:i:s');
$dt = date('Y-m-d');

$sql_dados = "select * from [SisClube].[dbo].Dados_Proposta a left join SisClube.dbo.Profissao b on a.profissao=b.IdProf left join SisClube.dbo.EstCivil c on a.estado_civil=c.IdEstCiv where a.num_proposta = $proposta order by a.id desc";

$res = $Obj_Con->query($sql_dados);
$i = 0;
while ($row = mssql_fetch_array($res)) {
	if($i == 0){
		$id_produto       = strtoupper(trim($row['id_produto']));
		$id_parentesco    = strtoupper(trim($row['id_parentesco']));
		$nome_associado   = strtoupper(trim($row['nome_associado']));
		$nacionalidade    = trim($row['nacionalidade']);
		$genero           = trim($row['genero']);
		$dt_nascimento    = strtoupper(trim($row['dt_nascimento']));
		$email            = strtoupper(trim($row['email']));
		$estado_civil     = strtoupper(trim($row['estado_civil']));
		$profissao        = strtoupper(trim($row['profissao']));
		$num_documento    = strtoupper(trim($row['num_documento']));
		$num_rg           = strtoupper(trim($row['num_rg']));
		$nome_pai         = strtoupper(trim($row['nome_pai']));
		$nome_mae         = strtoupper(trim($row['nome_mae']));
		$fone_res         = strtoupper(trim($row['fone_res']));
		$fone_celular     = strtoupper(trim($row['fone_celular']));
		$CEP              = strtoupper(trim($row['CEP']));
		$UF               = strtoupper(trim($row['UF']));
		$endereco         = strtoupper(trim($row['endereco']));
		$cidade           = strtoupper(trim($row['cidade']));
		$bairro           = strtoupper(trim($row['bairro']));
		$numero           = strtoupper(trim($row['numero']));
		$dia_vencimento   = strtoupper(trim($row['dia_vencimento']));
		$observacao       = strtoupper(trim($row['observacao']));
		$dt_cadastro      = strtoupper(trim($row['dt_cadastro']));
		$usuario_cadastro = strtoupper(trim($row['usuario_cadastro']));
		$status           = strtoupper(trim($row['status']));
		$num_proposta     = strtoupper(trim($row['num_proposta']));
		$regime_uniao     =	strtoupper(trim($row['regime_uniao']));
	}
$i++;}

$corpo = utf8_encode('<link rel="stylesheet" href="../../../assets/css/bootstrap.css"><img src="../../../img/logo_color.jpg"></p><br>');

//DADOS DO TITULAR
$corpo .= utf8_encode('<table class="table table-bordered">
	   <tbody>
	    <tr>
	      	<td colspan="2">TITULAR: <b>'.$nome_associado.'</b></td>
			<td colspan="2">TITULAR: <b>'.$nome_associado.'</b></td>
	    </tr>
	    <tr>
	        <td>Vencimento: <b>'.$dia_vencimento.'</b></td>
	        <td>Nacinalidade: <b>'.$nacionalidade.'</b></td>
			<td colspan="2">CPF/CNPJ: <b>'. $num_documento.'</b></td>
	    </tr>
	    <tr>
		 	<td>RG: <b>'. $num_rg .'</b></td>
	        <td>Gênero: <b>'. $genero .'</b></td>
	        <td colspan="2">DT de Nasc: <b>'. $dt_nascimento .'</b></td>
	    </tr>
	    <tr>
	        <td>E-MAIL: <b>'. $email.'</b></td>
			<td>Estado Civil: <b>'.$estado_civil .'</b></td>
		    <td colspan="2">Profissão: <b>'. $profissao .'</b></td>
	    </tr>
	    <tr>
	      <td colspan="4">Nome do Pai: <b>'. $nome_pai.'</b></td>
	    </tr>
		<tr>
	      <td colspan="4">Nome da Mãe: <b>'.$nome_mae .'</b></td>
	    </tr>
	    <tr>
	      <td>Fone Residencial: <b>'. $fone_res.'</b></td> 
	     <td>Fone Celular: <b>'. $fone_celular .'</b></td>
		 <td>CEP: <b>'. $CEP .'</b></td>
		 <td>UF: <b>'.$UF .'</b></td>
	    </tr>
	    <tr>
		 	<td>Endereço:<b> '. $endereco .'</b> </td>
	        <td colspan="4"> Cidade: <b>'. $cidade .'</b></td>
	     
	    </tr>
	    <tr>
		   <td colspan="2">Bairro: <b>'. $bairro .'</b></td>
	        <td colspan="2">Número:<b>'. $numero .'</b></td>
	
	    </tr>
	
	</tbody>
	</table>

');

$res_dep = $Obj_Con->query($sql_dados);
$ii = 0;
	
while ($row_dep = mssql_fetch_array($res_dep)) {
	if($ii > 0){
		$id_parentesco_dependente    = strtoupper(trim($row_dep['id_parentesco']));
		$nome_associado_dependente   = strtoupper(trim($row_dep['nome_associado']));
		$nacionalidade_dependente    = trim($row_dep['nacionalidade']);
		$genero_dependente           = trim($row_dep['genero']);
		$dt_nascimento_dependente    = strtoupper(trim($row_dep['dt_nascimento']));
		$email_dependente            = strtoupper(trim($row_dep['email']));
		$estado_civil_dependente     = strtoupper(trim($row_dep['estado_civil']));
		$profissao_dependente        = strtoupper(trim($row_dep['profissao']));
		$num_documento_dependente    = strtoupper(trim($row_dep['num_documento']));
		$num_rg_dependente           = strtoupper(trim($row_dep['num_rg']));
		$fone_celular_dependente     = strtoupper(trim($row_dep['fone_celular']));
		
		//DADOS DOS DEPENTENTES
		$corpo .= utf8_encode('DEPENDENTES '.$ii.' : <br>');
		$corpo .= utf8_encode('<table class="table table-bordered">
	  <tbody>
    <tr>
        <td colspan="4">Nome completo: <b>'. $nome_associado_dependente .'</b></td>
    </tr>
	<tr>
		<td>Parentesco: <b>'. $id_parentesco_dependente .'</b></td>
        <td >CPF/CNPJ: <b>'. $num_documento_dependente .'</b></td>
	</tr>

    <tr>
        <td>Gênero: <b>'. $genero_dependente .'</b></td>
        <td >RG: <b>'. $num_rg_dependente .'</b></td>
        <td >DT de Nasc: <b>'. $dt_nascimento_dependente .'</b></td>
    </tr>
    <tr>
        <td>Estado Civil: <b>'. $estado_civil_dependente .'</b></td>
        <td >Nacionalidade: <b>'. $nacionalidade_dependente .'</b></td>
        <td>Profissão: <b>'. $profissao_dependente .'</b></td>
    </tr>
    <tr>
        <td>Fone Celular: <b>'. $fone_celular_dependente .'</b></td>
        <td colspan="2">E-MAIL: <b>'. $email_dependente .'</b></td>
    </tr>
</tbody>
</table>

');		
	
	}
$ii++;}

$mpdf->WriteHTML($corpo);
$mpdf->Output();
?>