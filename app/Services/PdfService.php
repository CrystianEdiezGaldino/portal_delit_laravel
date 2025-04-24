<?php

namespace App\Services;

use TCPDF;
use Illuminate\Support\Facades\Storage;

class PdfService
{
    protected $pdf;

    public function __construct()
    {
        $this->pdf = new class extends TCPDF {
            public function Header() {}
            public function Footer() {}
        };
    }

    public function gerarFicha20($dados)
    {
        try {
            $pdf = $this->pdf;
            
            $pdf->SetCreator('Supremo Conselho');
            $pdf->SetAuthor('Supremo Conselho');
            $pdf->SetTitle('Cadastro Maçônico');
            $pdf->SetMargins(15, 15, 15);
            $pdf->AddPage();

            $logoPath = public_path('assets/images/logo_delit_curitiba.png');
            
            if (!file_exists($logoPath)) {
                \Log::error('Logo não encontrada em: ' . $logoPath);
            }
            
            $html = '
            <style>
                table { width: 100%; border-collapse: collapse; margin-bottom: 5px; }
                td { padding: 2px; vertical-align: middle; font-size: 9pt; }
                .header { width: 100%; margin-bottom: 10px; }
                .header td { text-align: center; font-size: 11pt; font-weight: bold; }
                .logo-cell { width: 20%; text-align: center; }
                .title-cell { width: 80%; text-align: left; padding-left: 10px; }
                .small-text { font-size: 8pt; }
                .section { background-color: #f0f0f0; font-weight: bold; padding: 3px; margin: 5px 0; }
                .table-padding > tbody > tr > td { padding: 2px; margin-bottom: 5px; }
            </style>
            
            <table class="header" border="0">
                <tr>
                    <td class="logo-cell">
                        <img src="'.$logoPath.'" width="80">
                    </td>
                    <td class="title-cell">
                        SUPREMO CONSELHO DO BRASIL DO GRAU 33<br>
                        PARA O R.:E.:A.:A.:<br>
                        Delegacia Litúrgica Sul-Paraná - 20.1 - CADASTRO.
                    </td>
                </tr>
            </table>

            <table border="1" cellpadding="2">
                <tr>
                    <td width="15%">Registro: '.$dados['id_registro'].'</td>
                    <td width="85%">Nome: '.$dados['cadastro'].'</td>
                </tr>
                <tr>
                    <td>IME: '.$dados['ime_num'].'</td>
                    <td>CPF: '.$dados['cic'].'</td>
                </tr>
                <tr>
                    <td>Nascimento: '.$dados['nascimento'].'</td>
                    <td>Naturalidade: '.$dados['cidade1'].'/'.$dados['estado1'].'</td>
                </tr>
                <tr>
                    <td>Nacionalidade: '.$dados['nacionalidade'].'</td>
                    <td>Profissão: '.$dados['profissao'].'</td>
                </tr>
                <tr>
                    <td colspan="2" class="section">Endereço</td>
                </tr>
                <tr>
                    <td colspan="2">'.$dados['endereco_residencial'].'</td>
                </tr>
                <tr>
                    <td>Bairro: '.$dados['bairro'].'</td>
                    <td>CEP: '.$dados['cep'].'</td>
                </tr>
                <tr>
                    <td>Cidade: '.$dados['cidade'].'</td>
                    <td>Estado: '.$dados['estado'].'</td>
                </tr>
                <tr>
                    <td colspan="2" class="section">Contatos</td>
                </tr>
                <tr>
                    <td>Telefone Residencial: '.$dados['telefone_residencial'].'</td>
                    <td>Telefone Comercial: '.$dados['telefone_comercial'].'</td>
                </tr>
                <tr>
                    <td colspan="2">Celular: '.$dados['celular'].'</td>
                </tr>
                <tr>
                    <td colspan="2" class="section">Dados Familiares</td>
                </tr>
                <tr>
                    <td>Estado Civil: '.$dados['estado_civil'].'</td>
                    <td>Número de Filhos: '.$dados['numero_filhos'].'</td>
                </tr>
                <tr>
                    <td>Nome do Pai: '.$dados['pai'].'</td>
                    <td>Nome da Mãe: '.$dados['mae'].'</td>
                </tr>
                <tr>
                    <td colspan="2">Cônjuge: '.$dados['esposa'].'</td>
                </tr>
                <tr>
                    <td>Nascimento do Cônjuge: '.$dados['nascida'].'</td>
                    <td>Data do Casamento: '.$dados['casamento'].'</td>
                </tr>
            </table>';

            $pdf->writeHTML($html, true, false, true, false, '');
            
            $nomeArquivo = 'cadastro_maconico_'.$dados['ime_num'].'.pdf';
            $caminho = 'public/pdfs/'.$nomeArquivo;
            
            Storage::put($caminho, $pdf->Output($nomeArquivo, 'S'));
            
            return Storage::url($caminho);
        } catch (\Exception $e) {
            \Log::error('Erro ao gerar PDF: ' . $e->getMessage());
            throw $e;
        }
    }
} 