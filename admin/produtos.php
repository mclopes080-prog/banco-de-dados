<?php
session_start();
if (!isset($_SESSION['admin'])) { header('Location: index.php'); exit; }

require_once '../includes/db.php';

// Excluir
if (isset($_GET['excluir'])) {
    $stmt = $pdo->prepare('DELETE FROM produtos WHERE id = ?');
    $stmt->execute([(int)$_GET['excluir']]);
    header('Location: produtos.php');
    exit;
}

// Salvar (inserir ou editar)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $campos = [
        $_POST['nome'],
        $_POST['descricao'],
        (float)str_replace(',', '.', $_POST['preco']),
        $_POST['categoria'],
        $_POST['imagem_url'],
    ];
    if (!empty($_POST['id'])) {
        $campos[] = (int)$_POST['id'];
        $pdo->prepare('UPDATE produtos SET nome=?, descricao=?, preco=?, categoria=?, imagem_url=? WHERE id=?')
            ->execute($campos);
    } else {
        $pdo->prepare('INSERT INTO produtos (nome, descricao, preco, categoria, imagem_url) VALUES (?,?,?,?,?)')
            ->execute($campos);
    }
    header('Location: produtos.php');
    exit;
}

// Editar: carregar dados
$editando = null;
if (isset($_GET['editar'])) {
    $stmt = $pdo->prepare('SELECT * FROM produtos WHERE id = ?');
    $stmt->execute([(int)$_GET['editar']]);
    $editando = $stmt->fetch(PDO::FETCH_ASSOC);
}

$produtos = $pdo->query('SELECT * FROM produtos ORDER BY nome')->fetchAll(PDO::FETCH_ASSOC);
$categorias = ['Câmeras', 'Alarmes', 'Controle de Acesso', 'Monitoramento'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Admin — Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">Solutec Admin</a>
        <a href="index.php?sair=1" class="btn btn-danger btn-sm">Sair</a>
    </div>
</nav>
<div class="container py-4">
    <h2 class="mb-4">Produtos</h2>

    <form method="post" class="card p-4 mb-4">
        <h5><?= $editando ? 'Editar Produto' : 'Novo Produto' ?></h5>
        <input type="hidden" name="id" value="<?= $editando['id'] ?? '' ?>">
        <div class="row g-2">
            <div class="col-md-6">
                <input type="text" name="nome" class="form-control" placeholder="Nome" required
                       value="<?= htmlspecialchars($editando['nome'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <input type="text" name="preco" class="form-control" placeholder="Preço (ex: 299.90)" required
                       value="<?= $editando['preco'] ?? '' ?>">
            </div>
            <div class="col-md-3">
                <select name="categoria" class="form-select" required>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= $cat ?>" <?= ($editando['categoria'] ?? '') === $cat ? 'selected' : '' ?>>
                            <?= $cat ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12">
                <textarea name="descricao" class="form-control" placeholder="Descrição" rows="2"><?= htmlspecialchars($editando['descricao'] ?? '') ?></textarea>
            </div>
            <div class="col-12">
                <input type="text" name="imagem_url" class="form-control" placeholder="URL da imagem"
                       value="<?= htmlspecialchars($editando['imagem_url'] ?? '') ?>">
            </div>
        </div>
        <div class="mt-3">
            <button class="btn btn-dark"><?= $editando ? 'Salvar alterações' : 'Adicionar' ?></button>
            <?php if ($editando): ?>
                <a href="produtos.php" class="btn btn-secondary ms-2">Cancelar</a>
            <?php endif; ?>
        </div>
    </form>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr><th>#</th><th>Nome</th><th>Categoria</th><th>Preço</th><th>Ações</th></tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['nome']) ?></td>
                <td><?= htmlspecialchars($p['categoria']) ?></td>
                <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                <td>
                    <a href="?editar=<?= $p['id'] ?>" class="btn btn-sm btn-outline-dark">Editar</a>
                    <a href="?excluir=<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger"
                       onclick="return confirm('Excluir?')">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
