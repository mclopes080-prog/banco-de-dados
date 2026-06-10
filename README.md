# Solutec Segurança Eletrônica

Site acadêmico construído com PHP + MySQL + Bootstrap 5 + Apache (XAMPP).

## Instalação

### 1. Banco de dados
1. Abra o phpMyAdmin (`http://localhost/phpmyadmin`)
2. Importe o arquivo `banco.sql`
3. O banco `solutec_db` será criado automaticamente com todas as tabelas e dados

### 2. Porta 8080
No arquivo `C:\xampp\apache\conf\httpd.conf`, altere:
```
Listen 80
```
para:
```
Listen 8080
```
Reinicie o Apache. O site ficará disponível em `http://localhost:8080/solutec/`.

### 3. DNS local (`solutec.local`)
Edite o arquivo de hosts:
- Windows: `C:\Windows\System32\drivers\etc\hosts`
- Linux/Mac: `/etc/hosts`

Adicione a linha:
```
127.0.0.1 solutec.local
```
Com a porta 8080, acesse via `http://solutec.local:8080/solutec/`.

### 4. Conexão com o banco
Edite `includes/db.php` e ajuste a constante `DB_HOST` conforme o IP do servidor de banco:
```php
define('DB_HOST', '127.0.0.1'); // ou IP da máquina do banco
```

## Arquitetura de 2 máquinas
- **Máquina 1 (App):** Apache + PHP rodando o site
- **Máquina 2 (BD):** MySQL Server acessível pelo IP fixo configurado em `DB_HOST`

Em produção, altere `DB_HOST` para o IP fixo da máquina do banco.

## Acesso Admin
URL: `/solutec/admin/`  
Senha padrão: `solutec123`

## Estrutura
```
solutec/
  .htaccess           — Options -Indexes
  banco.sql           — CREATE + INSERTs
  index.php           — página principal
  includes/
    db.php            — conexão PDO
    header.php        — navbar fixa
    footer.php        — rodapé
  functions/
    calculos.php      — 5 funções lógicas
  admin/
    index.php         — login + dashboard
    produtos.php      — CRUD de produtos
    clientes.php      — listagem de clientes
    pedidos.php       — listagem de pedidos
```
