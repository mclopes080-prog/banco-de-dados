<?php

function money(float $value): string
{
    return 'R$ ' . number_format($value, 2, ',', '.');
}

function render_header(string $title = 'Solutec'): void
{
    ?>
    <!doctype html>
    <html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= htmlspecialchars($title) ?> | Seguranca eletronica</title>
        <link rel="preconnect" href="https://images.unsplash.com">
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <header class="site-header">
            <a class="brand" href="#inicio" aria-label="Solutec inicio">
                <span class="brand-mark">S</span>
                <span>
                    <strong>Solutec</strong>
                    <small>cameras e alarmes</small>
                </span>
            </a>

            <button class="menu-toggle" type="button" aria-label="Abrir menu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <nav class="main-nav" aria-label="Navegacao principal">
                <a href="#quem-somos">Quem somos</a>
                <a href="#produtos">Produtos</a>
                <a href="#servicos">Servicos</a>
                <a href="#contato">Contato</a>
            </nav>
        </header>
    <?php
}

function render_footer(): void
{
    ?>
        <footer class="site-footer">
            <div>
                <strong>Solutec</strong>
                <p>Loja virtual de cameras, alarmes e controle de acesso.</p>
            </div>
            <p>Projeto academico de Banco de Dados - Sprint inicial.</p>
        </footer>
        <script src="assets/js/script.js"></script>
    </body>
    </html>
    <?php
}
