<?php
session_start();
if (!isset($_SESSION['admin'])) { header('Location: index.php'); exit; }

require_once '../includes/db.php';

$pedidos = $pdo->query('
    SELECT p.id, p.data_pedido, p.status, c.nome AS cliente
    FROM pedidos p
    JOIN clientes c ON c.id = p.cliente_id
    ORDER BY p.data_pedido DESC
')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Admin — Pedidos</title>
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
    <h2 class="mb-4">Pedidos</h2>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr><th>#</th><th>Cliente</th><th>Data</th><th>Status</th></tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['cliente']) ?></td>
                <td><?= date('d/m/Y', strtotime($p['data_pedido'])) ?></td>
                <td>
                    <?php
                    $cores = ['Pendente' => 'warning', 'Confirmado' => 'success', 'Cancelado' => 'danger'];
                    $cor = $cores[$p['status']] ?? 'secondary';
                    ?>
                    <span class="badge bg-<?= $cor ?>"><?= $p['status'] ?></span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
