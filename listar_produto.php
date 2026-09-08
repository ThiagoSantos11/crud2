<?php
require_once 'cadastro_produto.php';

$stmt = $pdo->query("SELECT * FROM produto ORDER BY code_prod DESC");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <div class="lista-card">

        <h1>Lista de Produtos</h1>

        <a href="index.php" class="btn-novo">
            + Novo Produto
        </a>

        <div class="tabela-container">

            <table>

                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome do Produto</th>
                        <th>Categoria</th>
                        <th>Quantidade</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (count($produtos) > 0): ?>

                    <?php foreach ($produtos as $p): ?>

                        <tr>

                            <td>
                                <?= $p['code_prod'] ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($p['nome_prod']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($p['cat_prod']) ?>
                            </td>

                            <td>
                                <?= $p['quant_prod'] ?>
                            </td>

                            <td>
                                R$ <?= number_format($p['valor_prod'], 2, ',', '.') ?>
                            </td>

                            <td>

                                <?php if ($p['status_prod'] == 'ativo'): ?>

                                    <span class="ativo">
                                        Ativo
                                    </span>

                                <?php else: ?>

                                    <span class="inativo">
                                        Inativo
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td class="acoes">

                                <a
                                    href="index.php?editar_id=<?= $p['code_prod'] ?>"
                                    class="btn-editar"
                                >
                                    Editar
                                </a>

                                <a
                                    href="cadastro_produto.php?acao=excluir&id=<?= $p['code_prod'] ?>"
                                    class="btn-excluir"
                                    onclick="return confirm('Tem certeza que deseja excluir este produto?');"
                                >
                                    Excluir
                                </a>

                                <?php if ($p['status_prod'] == 'ativo'): ?>

                                    <a
                                        href="cadastro_produto.php?acao=inativar&id=<?= $p['code_prod'] ?>"
                                        class="btn-inativar"
                                    >
                                        Inativar
                                    </a>

                                <?php else: ?>

                                    <a
                                        href="cadastro_produto.php?acao=ativar&id=<?= $p['code_prod'] ?>"
                                        class="btn-ativar"
                                    >
                                        Ativar
                                    </a>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="7">
                            Nenhum produto cadastrado.
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>
