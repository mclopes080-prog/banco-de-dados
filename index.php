<?php
require_once 'includes/db.php';
require_once 'functions/calculos.php';

$categorias = ['Câmeras', 'Alarmes', 'Controle de Acesso', 'Monitoramento'];

$categoriaSelecionada = isset($_GET['categoria']) && in_array($_GET['categoria'], $categorias)
    ? $_GET['categoria']
    : '';

$precoMinimo = isset($_GET['preco_min']) && $_GET['preco_min'] !== ''
    ? max(0, (float)str_replace(',', '.', $_GET['preco_min']))
    : null;
$precoMaximo = isset($_GET['preco_max']) && $_GET['preco_max'] !== ''
    ? max(0, (float)str_replace(',', '.', $_GET['preco_max']))
    : null;

if ($precoMinimo !== null && $precoMaximo !== null && $precoMinimo > $precoMaximo) {
    [$precoMinimo, $precoMaximo] = [$precoMaximo, $precoMinimo];
}

$produtos = $pdo->query('SELECT * FROM produtos ORDER BY nome')->fetchAll(PDO::FETCH_ASSOC);

if ($categoriaSelecionada !== '') {
    $produtos = filtrarPorCategoria($produtos, $categoriaSelecionada);
}

$produtos = filtrarPorPreco($produtos, $precoMinimo, $precoMaximo);
$produtos = array_values($produtos);
$quantidadeProdutos = count($produtos);
$mediaPrecos = calcularMediaPrecos($produtos);

$queryCategoria = $categoriaSelecionada !== '' ? ['categoria' => $categoriaSelecionada] : [];
$queryPreco = array_filter([
    'preco_min' => $precoMinimo,
    'preco_max' => $precoMaximo,
], fn($valor) => $valor !== null);

function montarUrlFiltros(array $params = []): string
{
    $query = http_build_query(array_filter($params, fn($valor) => $valor !== null && $valor !== ''));

    return $query === '' ? 'index.php' : 'index.php?' . $query;
}

require_once 'includes/header.php';
?>

<!-- Seção Produtos -->
<section id="produtos" class="container py-5">
    <h2 class="mb-4 fw-bold">Produtos</h2>

    <!-- Filtro por categoria -->
    <div class="mb-4 d-flex flex-wrap gap-2">
        <a href="<?= montarUrlFiltros($queryPreco) ?>"
           class="btn btn-sm <?= $categoriaSelecionada === '' ? 'btn-dark' : 'btn-outline-dark' ?>">Todos</a>
        <?php foreach ($categorias as $cat): ?>
            <a href="<?= montarUrlFiltros(array_merge($queryPreco, ['categoria' => $cat])) ?>"
               class="btn btn-sm <?= $categoriaSelecionada === $cat ? 'btn-dark' : 'btn-outline-dark' ?>">
                <?= htmlspecialchars($cat) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Filtro por pre&ccedil;o -->
    <form method="get" action="index.php" class="card p-3 mb-4 shadow-sm">
        <?php if ($categoriaSelecionada !== ''): ?>
            <input type="hidden" name="categoria" value="<?= htmlspecialchars($categoriaSelecionada) ?>">
        <?php endif; ?>
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="preco_min" class="form-label">Pre&ccedil;o m&iacute;nimo</label>
                <input type="number"
                       min="0"
                       step="0.01"
                       id="preco_min"
                       name="preco_min"
                       class="form-control"
                       value="<?= $precoMinimo !== null ? htmlspecialchars((string)$precoMinimo) : '' ?>">
            </div>
            <div class="col-md-3">
                <label for="preco_max" class="form-label">Pre&ccedil;o m&aacute;ximo</label>
                <input type="number"
                       min="0"
                       step="0.01"
                       id="preco_max"
                       name="preco_max"
                       class="form-control"
                       value="<?= $precoMaximo !== null ? htmlspecialchars((string)$precoMaximo) : '' ?>">
            </div>
            <div class="col-md-6 d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-dark">Filtrar por pre&ccedil;o</button>
                <a href="<?= montarUrlFiltros($queryCategoria) ?>" class="btn btn-outline-secondary">Limpar pre&ccedil;o</a>
            </div>
        </div>
    </form>

    <p class="text-muted">
        <?= $quantidadeProdutos ?> produto(s) encontrado(s)
        <?php if ($quantidadeProdutos > 0): ?>
            | M&eacute;dia de pre&ccedil;o: R$ <?= number_format($mediaPrecos, 2, ',', '.') ?>
        <?php endif; ?>
    </p>

    <!-- Grid de produtos -->
    <?php if (empty($produtos)): ?>
        <p class="text-muted">Nenhum produto encontrado.</p>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($produtos as $produto): ?>
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= htmlspecialchars($produto['imagem_url']) ?>"
                             class="card-img-top"
                             alt="<?= htmlspecialchars($produto['nome']) ?>">
                        <div class="card-body">
                            <span class="badge bg-secondary mb-2"><?= htmlspecialchars($produto['categoria']) ?></span>
                            <h5 class="card-title"><?= htmlspecialchars($produto['nome']) ?></h5>
                            <p class="card-text text-success fw-bold fs-5">
                                R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<!-- Seção Sobre Nós -->
<section id="sobre-nos" class="py-5" style="background-color:#1a1a2e; color:#fff;">
    <div class="container">
        <h2 class="mb-4 fw-bold" style="color:#00ff88;">Sobre Nós</h2>
        <div class="row align-items-center">
            <div class="col-md-8">
                <p class="lead">
                    A Solutec Segurança Eletrônica nasceu com o objetivo de oferecer
                    soluções completas em segurança para residências e empresas.
                    Trabalhamos com os melhores equipamentos do mercado — câmeras de
                    vigilância, alarmes, controle de acesso e sistemas de monitoramento
                    remoto — para garantir a tranquilidade de nossos clientes.
                </p>
                <p>
                    Nossa equipe é especializada em instalação, configuração e suporte
                    técnico, atendendo desde pequenos comércios até grandes condomínios.
                    Qualidade, confiança e tecnologia de ponta: esse é o compromisso da Solutec.
                </p>
            </div>
            <div class="col-md-4 text-center">
                <span style="font-size:6rem;">🔒</span>
            </div>
        </div>
    </div>
</section>

<!-- Seção Contato (âncora) -->
<section id="contato" class="container py-5">
    <h2 class="mb-4 fw-bold">Contato</h2>
    <p class="text-muted">Entre em contato conosco pelo telefone <strong>(11) 3000-0000</strong> ou pelo e-mail <strong>contato@solutec.com.br</strong>.</p>
</section>

<?php require_once 'includes/footer.php'; ?>
