<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "produtos_db";

$conn = new mysqli($servidor, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro na conexão com o banco: " . $conn->connect_error);
}

if (isset($_GET["excluir"])) {

    $codigo = $_GET["excluir"];

    $sql = "DELETE FROM produto WHERE code_prod = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $codigo);

    $stmt->execute();

    $stmt->close();

    header("Location: listar_produto.php");
    exit();
}

if (isset($_GET["inativar"])) {

    $codigo = $_GET["inativar"];

    $sql = "UPDATE produto
            SET status_prod = 'inativo'
            WHERE code_prod = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $codigo);

    $stmt->execute();

    $stmt->close();

    header("Location: listar_produto.php");
    exit();
}

if (isset($_GET["ativar"])) {

    $codigo = $_GET["ativar"];

    $sql = "UPDATE produto
            SET status_prod = 'ativo'
            WHERE code_prod = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $codigo);

    $stmt->execute();

    $stmt->close();

    header("Location: listar_produto.php");
    exit();
}

if (isset($_POST["editar"])) {

    $codigo = $_POST["code_prod"];
    $nome = $_POST["nome_prod"];
    $categoria = $_POST["cat_prod"];
    $quantidade = $_POST["quant_prod"];
    $valor = $_POST["valor_prod"];

    $sql = "UPDATE produto
            SET nome_prod = ?,
                cat_prod = ?,
                quant_prod = ?,
                valor_prod = ?
            WHERE code_prod = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssidi",
        $nome,
        $categoria,
        $quantidade,
        $valor,
        $codigo
    );

    $stmt->execute();

    $stmt->close();

    header("Location: listar_produto.php");
    exit();
}

$produto_editar = null;

if (isset($_GET["editar"])) {

    $codigo_editar = $_GET["editar"];

    $sql = "SELECT * FROM produto WHERE code_prod = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $codigo_editar);

    $stmt->execute();

    $resultado_editar = $stmt->get_result();

    $produto_editar = $resultado_editar->fetch_assoc();

    $stmt->close();
}

$sql = "SELECT * FROM produto ORDER BY code_prod DESC";

$resultado = $conn->query($sql);

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lista de Produtos</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <div class="container">

        <div class="lista-card">

            <h1>Lista de Produtos</h1>

            <a href="index.php" class="btn-novo"> + Novo Produto</a>

            <?php if ($produto_editar) { ?>

                <div class="editar-box">

                    <h2>Editar Produto</h2>

                    <form method="POST" action="listar_produto.php">

                        <input type="hidden" name="code_prod" value="<?= $produto_editar["code_prod"] ?>">

                        <label for="nome_prod"> Nome do Produto:</label>

                        <input type="text" id="nome_prod" name="nome_prod" value="<?= htmlspecialchars($produto_editar["nome_prod"]) ?>" required>

                        <label for="cat_prod"> Categoria:</label>

                        <select id="cat_prod" name="cat_prod" required>

                            <option value="eletronico" <?= $produto_editar["cat_prod"] == "eletronico" ? "selected" : "" ?>>
                                Eletrônico
                            </option>

                            <option
                                value="vestuario"
                                <?= $produto_editar["cat_prod"] == "vestuario" ? "selected" : "" ?>
                            >
                                Vestuário
                            </option>

                            <option
                                value="decoracao"
                                <?= $produto_editar["cat_prod"] == "decoracao" ? "selected" : "" ?>
                            >
                                Decoração
                            </option>

                        </select>

                        <label for="quant_prod">
                            Quantidade:
                        </label>

                        <input
                            type="number"
                            id="quant_prod"
                            name="quant_prod"
                            value="<?= $produto_editar["quant_prod"] ?>"
                            min="0"
                            required
                        >

                        <label for="valor_prod">
                            Valor:
                        </label>

                        <input
                            type="number"
                            id="valor_prod"
                            name="valor_prod"
                            value="<?= $produto_editar["valor_prod"] ?>"
                            step="0.01"
                            min="0"
                            required
                        >

                        <button
                            type="submit"
                            name="editar"
                            class="btn-salvar"
                        >
                            Salvar Alterações
                        </button>

                        <a
                            href="listar_produto.php"
                            class="btn-cancelar"
                        >
                            Cancelar
                        </a>

                    </form>

                </div>

            <?php } ?>

            <div class="tabela-container">

                <table>

                    <thead>

                        <tr>

                            <th>
                                Código
                            </th>

                            <th>
                                Nome do Produto
                            </th>

                            <th>
                                Categoria
                            </th>

                            <th>
                                Quantidade
                            </th>

                            <th>
                                Valor
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Ações
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php

                        if ($resultado->num_rows > 0) {

                            while ($produto = $resultado->fetch_assoc()) {

                        ?>

                            <tr>

                                <td>
                                    <?= $produto["code_prod"] ?>
                                </td>


                                <td>
                                    <?= htmlspecialchars($produto["nome_prod"]) ?>
                                </td>

                                <td>

                                    <?php

                                    if ($produto["cat_prod"] == "eletronico") {

                                        echo "Eletrônico";

                                    } elseif ($produto["cat_prod"] == "vestuario") {

                                        echo "Vestuário";

                                    } elseif ($produto["cat_prod"] == "decoracao") {

                                        echo "Decoração";

                                    }

                                    ?>

                                </td>


                                <!-- QUANTIDADE -->

                                <td>
                                    <?= $produto["quant_prod"] ?>
                                </td>


                                <!-- VALOR -->

                                <td>

                                    R$

                                    <?= number_format(
                                        $produto["valor_prod"],
                                        2,
                                        ",",
                                        "."
                                    ) ?>

                                </td>


                                <!-- STATUS -->

                                <td>

                                    <?php

                                    if ($produto["status_prod"] == "ativo") {

                                    ?>

                                        <span class="ativo">
                                            Ativo
                                        </span>

                                    <?php

                                    } else {

                                    ?>

                                        <span class="inativo">
                                            Inativo
                                        </span>

                                    <?php

                                    }

                                    ?>

                                </td>


                                <!-- AÇÕES -->

                                <td class="acoes">


                                    <!-- EDITAR -->

                                    <a
                                        href="listar_produto.php?editar=<?= $produto["code_prod"] ?>"
                                        class="btn-editar"
                                    >
                                        Editar
                                    </a>


                                    <!-- EXCLUIR -->

                                    <a
                                        href="listar_produto.php?excluir=<?= $produto["code_prod"] ?>"
                                        class="btn-excluir"
                                        onclick="return confirm('Deseja realmente excluir este produto?')"
                                    >
                                        Excluir
                                    </a>


                                    <?php

                                    if ($produto["status_prod"] == "ativo") {

                                    ?>

                                        <!-- INATIVAR -->

                                        <a
                                            href="listar_produto.php?inativar=<?= $produto["code_prod"] ?>"
                                            class="btn-inativar"
                                            onclick="return confirm('Deseja realmente inativar este produto?')"
                                        >
                                            Inativar
                                        </a>

                                    <?php

                                    } else {

                                    ?>

                                        <!-- ATIVAR -->

                                        <a
                                            href="listar_produto.php?ativar=<?= $produto["code_prod"] ?>"
                                            class="btn-ativar"
                                        >
                                            Ativar
                                        </a>

                                    <?php

                                    }

                                    ?>

                                </td>

                            </tr>

                        <?php

                            }

                        } else {

                        ?>

                            <tr>

                                <td colspan="7">
                                    Nenhum produto cadastrado.
                                </td>

                            </tr>

                        <?php

                        }

                        ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</body>

</html>

<?php

$conn->close();

?>