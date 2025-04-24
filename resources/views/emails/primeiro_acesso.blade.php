<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nova Senha - Portal Delit Curitiba</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #8B0000;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
            background-color: #f9f9f9;
        }
        .credentials {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #8B0000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Portal Delit Curitiba</h1>
        </div>
        
        <div class="content">
            <p>Olá {{ $nome }},</p>
            
            <p>Sua senha foi atualizada com sucesso. Abaixo estão suas credenciais de acesso:</p>
            
            <div class="credentials">
                <p><strong>IME (CIM):</strong> {{ $ime }}</p>
                <p><strong>Nova Senha:</strong> {{ $senha }}</p>
            </div>
            
            <p>Para acessar o sistema, clique no botão abaixo:</p>
            
            <a href="{{ url('/login') }}" class="btn">Acessar o Portal</a>
            
            <p>Recomendamos que você altere sua senha após o primeiro acesso.</p>
            
            <p>Atenciosamente,<br>Equipe Delit Curitiba</p>
        </div>
        
        <div class="footer">
            <p>Este é um email automático, por favor não responda.</p>
            <p>© {{ date('Y') }} Portal Delit Curitiba. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html> 