<?php
require_once __DIR__ . '/includes/template.php';
require_once __DIR__ . '/data/products.php';

render_header('Solutec');
?>

<main>
    <section class="hero" id="inicio">
        <div class="hero-copy">
            <p class="eyebrow">Loja virtual de seguranca eletronica</p>
            <h1>Solutec</h1>
            <p>
                Cameras, alarmes e solucoes de acesso para casas, lojas e pequenos negocios.
                Escolha os produtos, simule seu carrinho e fale com a equipe para fechar o pedido.
            </p>
            <div class="hero-actions">
                <a class="button primary" href="#produtos">Ver produtos</a>
                <a class="button ghost" href="#contato">Solicitar orcamento</a>
            </div>
        </div>

        <div class="hero-panel" aria-label="Resumo de seguranca">
            <div class="status-card">
                <span>Monitoramento</span>
                <strong>24h</strong>
            </div>
            <div class="status-grid">
                <span>Residencial</span>
                <span>Comercial</span>
                <span>Controle remoto</span>
                <span>Instalacao</span>
            </div>
        </div>
    </section>

    <section class="section split" id="quem-somos">
        <div>
            <p class="eyebrow">Quem somos</p>
            <h2>Seguranca simples de comprar e facil de acompanhar.</h2>
        </div>
        <p>
            A Solutec atende clientes que procuram equipamentos de seguranca eletronica
            com boa relacao custo-beneficio. A proposta da loja e organizar cameras,
            alarmes e acessorios em um catalogo claro, com contato rapido para orcamento.
        </p>
    </section>

    <section class="section stats" aria-label="Diferenciais">
        <article>
            <strong>6</strong>
            <span>produtos iniciais no catalogo</span>
        </article>
        <article>
            <strong>3</strong>
            <span>categorias para filtragem</span>
        </article>
        <article>
            <strong>100%</strong>
            <span>layout responsivo para celular</span>
        </article>
    </section>

    <section class="section products-section" id="produtos">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Catalogo</p>
                <h2>Produtos em destaque</h2>
            </div>
            <label class="search-box">
                <span>Buscar</span>
                <input type="search" id="productSearch" placeholder="camera, alarme, sensor">
            </label>
        </div>

        <div class="filters" aria-label="Filtros de produtos">
            <?php foreach ($categories as $key => $label): ?>
                <button class="filter-button <?= $key === 'todos' ? 'active' : '' ?>" type="button" data-filter="<?= $key ?>">
                    <?= htmlspecialchars($label) ?>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="product-grid" id="productGrid">
            <?php foreach ($products as $product): ?>
                <article class="product-card" data-category="<?= htmlspecialchars($product['category']) ?>" data-name="<?= htmlspecialchars(strtolower($product['name'] . ' ' . $product['description'])) ?>">
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" loading="lazy">
                    <div class="product-content">
                        <span class="badge"><?= htmlspecialchars($product['badge']) ?></span>
                        <h3><?= htmlspecialchars($product['name']) ?></h3>
                        <p><?= htmlspecialchars($product['description']) ?></p>
                        <ul>
                            <?php foreach ($product['features'] as $feature): ?>
                                <li><?= htmlspecialchars($feature) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="product-footer">
                            <strong><?= money($product['price']) ?></strong>
                            <button class="cart-button" type="button" data-product="<?= htmlspecialchars($product['name']) ?>">Adicionar</button>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="section services" id="servicos">
        <div>
            <p class="eyebrow">Servicos</p>
            <h2>Da escolha do equipamento ao pos-venda.</h2>
        </div>
        <div class="service-list">
            <article>
                <h3>Venda consultiva</h3>
                <p>Indicacao de produtos de acordo com o ambiente e a necessidade do cliente.</p>
            </article>
            <article>
                <h3>Instalacao</h3>
                <p>Organizacao do pedido para instalacao de cameras, sensores e centrais.</p>
            </article>
            <article>
                <h3>Suporte</h3>
                <p>Atendimento para configuracao basica e acompanhamento apos a compra.</p>
            </article>
        </div>
    </section>

    <section class="section contact" id="contato">
        <div>
            <p class="eyebrow">Contato</p>
            <h2>Monte seu pedido</h2>
            <p>Itens no carrinho: <strong id="cartCount">0</strong></p>
        </div>
        <form class="contact-form" method="post" action="#">
            <label>
                Nome
                <input type="text" name="nome" placeholder="Seu nome">
            </label>
            <label>
                Telefone
                <input type="tel" name="telefone" placeholder="(00) 00000-0000">
            </label>
            <label>
                Interesse
                <select name="interesse">
                    <option>Cameras</option>
                    <option>Alarmes</option>
                    <option>Controle de acesso</option>
                    <option>Projeto completo</option>
                </select>
            </label>
            <label>
                Mensagem
                <textarea name="mensagem" rows="4" placeholder="Descreva o ambiente que precisa proteger"></textarea>
            </label>
            <button class="button primary" type="submit">Enviar solicitacao</button>
        </form>
    </section>
</main>

<?php render_footer(); ?>
