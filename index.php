<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastro de Produtos</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">

        <div class="card">

            <h1>Cadastro de Produtos</h1>

            <form action="cadastro_produto.php" method="POST">

                <label for="nome_prod">Nome do Produto:</label>

                <input
                    type="text"
                    id="nome_prod"
                    name="nome_prod"
                    placeholder="Digite o nome do produto"
                    required
                >

                <label for="cat_prod">Categoria do Produto:</label>

                <select id="cat_prod" name="cat_prod" required>

                    <option value="eletronico">
                        Eletrônico
                    </option>

                    <option value="vestuario">
                        Vestuário
                    </option>

                    <option value="decoracao">
                        Decoração
                    </option>

                </select>

                <label for="quant_prod">Quantidade:</label>

                <input
                    type="number"
                    id="quant_prod"
                    name="quant_prod"
                    placeholder="Digite a quantidade do produto"
                    min="0"
                    required
                >

                <label for="valor_prod">Valor do Produto:</label>

                <input
                    type="number"
                    id="valor_prod"
                    name="valor_prod"
                    placeholder="Digite o preço do produto"
                    step="0.01"
                    min="0"
                    required
                >

                <button type="submit" class="btn-cadastrar">
                    Cadastrar
                </button>

            </form>

            <a href="listar_produto.php" class="btn-listar">
                Lista de Produtos
            </a>

        </div>

    </div>

</body>

</html>