<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class M_email extends CI_Model {

    public function __construct() {
        parent::__construct();
      }

    public function enviar_email($destinatario, $assunto, $corpo, $html = true) {
        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.titan.email';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'no-reply@delitcuritiba.org';
            $mail->Password   = ")['D!0b%lZm3<DQ";
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->CharSet    = 'UTF-8';
            
            // Remetente e destinatário
            $mail->setFrom('no-reply@delitcuritiba.org', 'Delit Curitiba');
            $mail->addAddress($destinatario);
            
            // Conteúdo do e-mail
            $mail->isHTML($html);
            $mail->Subject = $assunto;
            
            if ($html) {
                $mail->Body = $this->template_email($corpo);
                $mail->AltBody = strip_tags($corpo);
            } else {
                $mail->Body = $corpo;
            }
            
            $mail->send();
            return true;
        } catch (Exception $e) {
            log_message('error', 'Erro ao enviar e-mail: ' . $mail->ErrorInfo);
            return false;
        }
    }

    private function template_email($conteudo) {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Portal Delit Curitiba</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #960018; padding: 20px; text-align: center; }
                .header img { max-width: 150px; }
                .content { padding: 20px; background-color: #f9f9f9; }
                .footer { padding: 20px; text-align: center; font-size: 12px; color: #777; }
                .button { 
                    display: inline-block; 
                    padding: 10px 20px; 
                    background-color: #960018; 
                    color: white !important; 
                    text-decoration: none; 
                    border-radius: 5px; 
                    margin: 15px 0;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <img src="https://delitcuritiba.org/wp-content/uploads/2024/08/logo150x150-1.png" 
                         alt="Logo Delit Curitiba" style="max-width: 150px;">
                    <h2 style="color: #ffffff; margin-top: 10px;">Portal Delit Curitiba</h2>
                </div>
                <div class="content">
                    ' . $conteudo . '
                </div>
                <div class="footer">
                    © ' . date('Y') . ' Delit Curitiba. Todos os direitos reservados.<br>
                    <small>Este é um e-mail automático, por favor não responda.</small>
                </div>
            </div>
        </body>
        </html>';
    }
}