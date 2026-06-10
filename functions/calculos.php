<?php

function calcularSubtotal(array $produtos): float
{
    $total = 0.0;
    foreach ($produtos as $p) {
        $total += $p['preco'] * $p['quantidade'];
    }
    return $total;
}

function aplicarDesconto(float $total, float $percentual): float
{
    return $total - ($total * $percentual / 100);
}

function filtrarPorCategoria(array $produtos, string $categoria): array
{
    return array_filter($produtos, fn($p) => $p['categoria'] === $categoria);
}

function filtrarPorPreco(array $produtos, ?float $precoMinimo, ?float $precoMaximo): array
{
    return array_filter($produtos, function ($p) use ($precoMinimo, $precoMaximo) {
        $preco = (float)$p['preco'];

        if ($precoMinimo !== null && $preco < $precoMinimo) {
            return false;
        }

        if ($precoMaximo !== null && $preco > $precoMaximo) {
            return false;
        }

        return true;
    });
}

function calcularMediaPrecos(array $produtos): float
{
    if (empty($produtos)) {
        return 0.0;
    }

    $total = array_reduce($produtos, fn($soma, $p) => $soma + (float)$p['preco'], 0.0);

    return $total / count($produtos);
}

function validarProdutos(array $produtos): bool
{
    if (empty($produtos)) {
        return false;
    }
    foreach ($produtos as $p) {
        if ($p['preco'] < 0) {
            return false;
        }
    }
    return true;
}

function produtoMaisCaro(array $produtos): array
{
    return array_reduce($produtos, function ($carry, $item) {
        return ($carry === null || $item['preco'] > $carry['preco']) ? $item : $carry;
    }, null) ?? [];
}
