<?php
session_start();

if (!isset($_SESSION['admin'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['senha'] === 'solutec123') {
            $_SESSION['admin'] = true;
        } else {
            $erro = 'Senha incorreta.';
        }
    }
    if (!isset($_SESSION['admin'])) {
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Admin — Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark d-flex align-items-center justify-content-center" style="min-height:100vh">
<div class="card p-4" style="width:320px">
    <h5 class="mb-3">Admin Solutec</h5>
    <?php if (isset($erro)): ?>
        <div class="alert alert-danger py-1"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>
    <form method="post">
        <input type="password" name="senha" class="form-control mb-3" placeholder="Senha" required>
        <button class="btn btn-dark w-100">Entrar</button>
    </form>
</div>
</body>
</html>
<?php
        exit;
    }
}

if (isset($_GET['sair'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Admin — Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand fw-bold">Solutec Admin</span>
        <div>
            <a href="produtos.php" class="btn btn-outline-light btn-sm me-2">Produtos</a>
            <a href="clientes.php" class="btn btn-outline-light btn-sm me-2">Clientes</a>
            <a href="pedidos.php" class="btn btn-outline-light btn-sm me-2">Pedidos</a>
            <a href="?sair=1" class="btn btn-danger btn-sm">Sair</a>
        </div>
    </div>
</nav>
<div class="container py-5">
    <h2>Dashboard</h2>
    <p class="text-muted">Bem-vindo ao painel administrativo da Solutec.</p>
    <div class="row g-3">
        <div class="col-md-4">
            <a href="produtos.php" class="btn btn-dark w-100 py-4 fs-5">Gerenciar Produtos</a>
        </div>
        <div class="col-md-4">
            <a href="clientes.php" class="btn btn-secondary w-100 py-4 fs-5">Ver Clientes</a>
        </div>
        <div class="col-md-4">
            <a href="pedidos.php" class="btn btn-secondary w-100 py-4 fs-5">Ver Pedidos</a>
        </div>
    </div>
</div>
</body>
</html>
