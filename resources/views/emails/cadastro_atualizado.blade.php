<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cadastro Atualizado - Portal DelitCuritiba</title>
</head>
<body>
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
        <h2 style="color: #333;">Olá {{ $nome }},</h2>
        
        <p>Seu cadastro foi atualizado/criado com sucesso no Portal DelitCuritiba.</p>
        
        <p>Para ter acesso ao sistema, você precisa:</p>
        
        <ol>
            <li>Acessar o link: <a href="http://portal.delitcuritiba.org/" style="color: #0066cc;">http://portal.delitcuritiba.org/</a></li>
            <li>Clicar em "Primeiro Acesso"</li>
            <li>Informar seu IME: <strong>{{ $ime }}</strong></li>
            <li>Informar seu CPF</li>
        </ol>
        
        <p>Após essas etapas, você receberá uma senha de acesso por email.</p>
        
        <p>Atenciosamente,<br>
        Equipe Portal DelitCuritiba</p>
        
        <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
        
        <p style="font-size: 12px; color: #666;">
            Este é um email automático, por favor não responda.
        </p>
    </div>
</body>
</html> 