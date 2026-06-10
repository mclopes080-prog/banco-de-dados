<?php
session_start();
if (!isset($_SESSION['admin'])) { header('Location: index.php'); exit; }

require_once '../includes/db.php';

$clientes = $pdo->query('SELECT * FROM clientes ORDER BY nome')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Admin — Clientes</title>
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
    <h2 class="mb-4">Clientes</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr><th>#</th><th>Nome</th><th>E-mail</th><th>Telefone</th><th>Cadastro</th></tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $c): ?>
            <tr>
                <td><?= $c['id'] ?></td>
                <td><?= htmlspecialchars($c['nome']) ?></td>
                <td><?= htmlspecialchars($c['email']) ?></td>
                <td><?= htmlspecialchars($c['telefone']) ?></td>
                <td><?= date('d/m/Y', strtotime($c['created_at'])) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
