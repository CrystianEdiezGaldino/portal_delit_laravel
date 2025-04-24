<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Realizado - Portal Delit Curitiba</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #960018;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .credentials {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            background-color: #960018;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Cadastro Realizado</h1>
        </div>
        
        <div class="content">
            <h2>Olá, {{ $dados['nome'] }}!</h2>
            <p>Seu cadastro no Portal Delit Curitiba foi realizado com sucesso.</p>
            
            <div class="credentials">
                <h3 style="color: #960018; margin-top: 0;">Seus dados de acesso:</h3>
                <p><strong>IME (CIM):</strong> {{ $dados['ime'] }}</p>
                <p><strong>Email:</strong> {{ $dados['email'] }}</p>
                <p><strong>Senha:</strong> {{ $dados['senha'] }}</p>
            </div>
            
            <p>Para acessar o sistema, clique no botão abaixo:</p>
            
            <a href="{{ route('login') }}" class="button">Acessar o Portal</a>
            
            <p style="margin-top: 20px;">
                <strong>Importante:</strong> Guarde estas informações em local seguro. 
                Recomendamos alterar sua senha após o primeiro acesso.
            </p>
        </div>
        
        <div class="footer">
            <p>Este é um e-mail automático, por favor não responda.</p>
            <p>© {{ date('Y') }} Portal Delit Curitiba - Todos os direitos reservados</p>
        </div>
    </div>
</body>
</html> 