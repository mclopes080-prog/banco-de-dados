# BRIEFING — Site Solutec Segurança Eletrônica
> Projeto novo do zero. Leia tudo antes de começar.

---

## Contexto

Criar um site para a empresa fictícia **Solutec Segurança Eletrônica**, que vende câmeras e equipamentos de segurança. O site deve atender **todos os critérios da rubrica acadêmica** (Modelagem BD, SO/Redes, Dev Web, Tech Forge) e ter o visual descrito abaixo.

Stack obrigatória: **PHP + MySQL + Bootstrap 5 + Apache (XAMPP)**

---

## Visual e Layout

### Header fixo
- Header fixo no topo (`position: fixed`) que permanece visível durante o scroll
- Logo "Solutec" no lado **esquerdo**
- Links de navegação no lado **direito**: Produtos, Sobre Nós, Contato (âncoras internas)
- Fundo escuro, estilo profissional

### Main — Seção de Produtos
- Grid de cards com os produtos cadastrados no banco
- Cada card: foto do produto (imagem placeholder ou real), nome e **preço logo abaixo**
- Dados vindos do banco via PDO + foreach
- Filtro por categoria (câmeras, alarmes, etc.) via GET — usando array de categorias, sem variáveis soltas
- Layout responsivo com Bootstrap (col-md-4 ou similar)

### Main — Seção "Sobre Nós"
- Seção com id="sobre-nos" para a âncora do menu funcionar
- Título "Sobre Nós"
- Texto descritivo sobre a Solutec (segurança eletrônica, câmeras, atendimento)
- Visual limpo, pode ter um ícone ou imagem decorativa ao lado

### Footer
- Fundo **preto**
- Texto centralizado: **"Desenvolvido por Matheus C. Lopes"**
- Simples, sem excesso

---

## Banco de Dados — `solutec_db`

### Tabelas (mínimo 3 + pivot N:N)

```sql
produtos
  id            INT PK AUTO_INCREMENT
  nome          VARCHAR(100)
  descricao     TEXT
  preco         DECIMAL(10,2)
  categoria     ENUM('Câmeras','Alarmes','Controle de Acesso','Monitoramento')
  imagem_url    VARCHAR(255)   -- URL de placeholder ou caminho local
  created_at    TIMESTAMP

clientes
  id            INT PK AUTO_INCREMENT
  nome          VARCHAR(100)
  email         VARCHAR(100)
  telefone      VARCHAR(20)
  created_at    TIMESTAMP

pedidos
  id            INT PK AUTO_INCREMENT
  cliente_id    INT FK → clientes.id
  data_pedido   DATE
  status        ENUM('Pendente','Confirmado','Cancelado')
  created_at    TIMESTAMP

pedido_produtos  ← pivot N:N
  id             INT PK AUTO_INCREMENT
  pedido_id      INT FK → pedidos.id
  produto_id     INT FK → produtos.id
  quantidade     INT DEFAULT 1
```

### Seed de dados

Inserir ao menos **8 produtos** com preços variados:
- Câmera IP Externa HD — R$299,90
- Câmera Dome Interna — R$189,90
- Kit 4 Câmeras + DVR — R$899,00
- Câmera 360° WiFi — R$349,90
- Alarme Residencial Completo — R$459,00
- Sensor de Presença — R$89,90
- Controle de Acesso Biométrico — R$599,00
- Central de Monitoramento — R$1.299,00

Para imagem_url, usar placeholders do serviço:
`https://placehold.co/400x300/1a1a2e/00ff88?text=Nome+do+Produto`
(substituir Nome+do+Produto pelo nome real com + no lugar dos espaços)

Inserir **3 clientes** fictícios e **2 pedidos** com itens na pivot.

---

## Estrutura de Pastas

```
/htdocs/solutec/
  .htaccess
  banco.sql
  index.php          ← página principal (header + produtos + sobre + footer)
  includes/
    db.php
    header.php       ← header fixo com nav direita
    footer.php       ← footer preto "Desenvolvido por Matheus C. Lopes"
  functions/
    calculos.php     ← funções obrigatórias da rubrica
  admin/
    index.php        ← dashboard simples (protegido)
    produtos.php     ← CRUD de produtos
    clientes.php     ← listagem de clientes
    pedidos.php      ← listagem de pedidos
```

---

## Funções obrigatórias em `functions/calculos.php`

```php
// Recebe array de produtos com 'preco' e 'quantidade', retorna subtotal
function calcularSubtotal(array $produtos): float

// Recebe subtotal e percentual, retorna valor com desconto aplicado
function aplicarDesconto(float $total, float $percentual): float

// Recebe array de produtos e string categoria, retorna subconjunto filtrado
function filtrarPorCategoria(array $produtos, string $categoria): array

// Valida array: false se vazio ou se houver preço negativo
function validarProdutos(array $produtos): bool

// Recebe array de produtos, retorna o de maior preço
function produtoMaisCaro(array $produtos): array
```

---

## Regras Técnicas Obrigatórias (rubrica)

1. **`.htaccess`** na raiz:
   ```apache
   Options -Indexes
   ```

2. **Porta 8080** — documentar no README que o `httpd.conf` deve ter `Listen 8080`

3. **DNS local** — documentar no README: adicionar `127.0.0.1 solutec.local` no arquivo hosts

4. **IP fixo do banco** — `db.php` com constante `DB_HOST` configurável

5. **Separação app/banco** — documentar no README arquitetura de 2 máquinas

---

## index.php — Comportamento

A página principal deve funcionar em **arquivo único** com âncoras internas:

```
#produtos  → seção dos cards de produto
#sobre-nos → seção Sobre Nós
```

Fluxo da página:
1. Inclui header.php (fixo no topo)
2. Seção `#produtos`: busca do banco, filtra por categoria se `$_GET['categoria']` existir, renderiza cards Bootstrap
3. Seção `#sobre-nos`: texto institucional da Solutec
4. Inclui footer.php

---

## Texto para a seção "Sobre Nós"

```
A Solutec Segurança Eletrônica nasceu com o objetivo de oferecer 
soluções completas em segurança para residências e empresas. 
Trabalhamos com os melhores equipamentos do mercado — câmeras de 
vigilância, alarmes, controle de acesso e sistemas de monitoramento 
remoto — para garantir a tranquilidade de nossos clientes.

Nossa equipe é especializada em instalação, configuração e suporte 
técnico, atendendo desde pequenos comércios até grandes condomínios. 
Qualidade, confiança e tecnologia de ponta: esse é o compromisso da Solutec.
```

---

## Entregáveis Finais

- [ ] `index.php` com header fixo, grid de produtos, sobre nós e footer
- [ ] `banco.sql` com CREATE TABLE + INSERTs de seed (8 produtos, 3 clientes, pedidos)
- [ ] `includes/header.php` — fixo, nav à direita
- [ ] `includes/footer.php` — preto, "Desenvolvido por Matheus C. Lopes"
- [ ] `includes/db.php` — PDO com constante DB_HOST
- [ ] `functions/calculos.php` — 5 funções com parâmetros + return
- [ ] `admin/` — páginas protegidas com session
- [ ] `.htaccess` — Options -Indexes
- [ ] `README.md` — instruções de instalação, porta 8080, DNS local

---

## Resumo dos Critérios da Rubrica Atendidos

| Critério | Onde está |
|---|---|
| DER | banco.sql (MySQL Workbench gera o visual) |
| 3+ tabelas | produtos, clientes, pedidos, pedido_produtos |
| Chaves primárias | todos os ids |
| Chave estrangeira | pedidos.cliente_id, pedido_produtos.* |
| N:N | pedido_produtos (pivot) |
| Options -Indexes | .htaccess |
| Porta 8080 | httpd.conf (documentado no README) |
| DNS local | hosts (documentado no README) |
| IP fixo banco | db.php DB_HOST |
| 2 máquinas | arquitetura no README |
| Layout PHP dinâmico | index.php com produtos do banco |
| Template PHP | header.php + footer.php com include |
| Bootstrap 3+ | Navbar, Cards, Badge/filtro |
| Conexão BD | db.php PDO |
| Dados na tela | produtos via fetchAll + foreach |
| IF/FOREACH | filtro de categoria, validação |
| Arrays estruturados | array de categorias sem variáveis soltas |
| Funções lógica | calculos.php |
| Parâmetros + return | todas as funções |
| Filtro em array | filtrarPorCategoria() |
| Validação if/else | validarProdutos() |
