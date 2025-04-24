# Portal DELIT - Laravel

Este é um projeto desenvolvido em Laravel para o Portal DELIT.

## Requisitos

- PHP >= 8.1
- Composer
- MySQL
- Node.js e NPM
- Git

## Configuração do Ambiente

1. Clone o repositório:
```bash
git clone https://github.com/CrystianEdiezGaldino/portal_delit_laravel.git
cd portal_delit_laravel
```

2. Instale as dependências do PHP:
```bash
composer install
```

3. Instale as dependências do JavaScript:
```bash
npm install
```

4. Copie o arquivo .env.example para .env:
```bash
cp .env.example .env
```

5. Configure o arquivo .env com suas credenciais de banco de dados:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

6. Gere a chave da aplicação:
```bash
php artisan key:generate
```

7. Execute as migrações do banco de dados:
```bash
php artisan migrate
```

8. Compile os assets:
```bash
npm run dev
```

## Comandos Úteis

### Desenvolvimento
- Iniciar o servidor de desenvolvimento:
```bash
php artisan serve
```

- Compilar assets em modo de desenvolvimento:
```bash
npm run dev
```

- Compilar assets em modo de produção:
```bash
npm run build
```

### Manutenção
- Limpar cache:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

- Limpar cache de configuração:
```bash
php artisan config:clear
```

- Limpar cache de rotas:
```bash
php artisan route:clear
```

- Limpar cache de views:
```bash
php artisan view:clear
```

- Limpar todos os caches:
```bash
php artisan optimize:clear
```

### Banco de Dados
- Executar migrações:
```bash
php artisan migrate
```

- Reverter última migração:
```bash
php artisan migrate:rollback
```

- Reverter todas as migrações:
```bash
php artisan migrate:reset
```

- Executar seeders:
```bash
php artisan db:seed
```

## Estrutura do Projeto

- `app/` - Contém a lógica principal da aplicação
- `config/` - Arquivos de configuração
- `database/` - Migrações e seeders
- `public/` - Arquivos públicos (assets, uploads)
- `resources/` - Views, assets não compilados
- `routes/` - Definição de rotas
- `storage/` - Arquivos de cache, logs, etc.
- `tests/` - Testes automatizados

## Contribuição

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/nova-feature`)
3. Faça commit das suas alterações (`git commit -m 'Adiciona nova feature'`)
4. Faça push para a branch (`git push origin feature/nova-feature`)
5. Abra um Pull Request

## Licença

Este projeto está sob a licença [MIT](LICENSE).
