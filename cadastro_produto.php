<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "produtos_db";

$conn = new mysqli($servidor, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome_prod = $_POST["nome_prod"];
    $cat_prod = $_POST["cat_prod"];
    $quant_prod = $_POST["quant_prod"];
    $valor_prod = $_POST["valor_prod"];

    $sql = "INSERT INTO produto
            (nome_prod, cat_prod, quant_prod, valor_prod, status_prod)
            VALUES (?, ?, ?, ?, 'ativo')";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssid",
        $nome_prod,
        $cat_prod,
        $quant_prod,
        $valor_prod
    );

    if ($stmt->execute()) {

        header("Location: listar_produto.php");
        exit();

    } else {

        echo "Erro ao cadastrar produto: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>