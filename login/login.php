<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Reset de estilos para garantir uma base consistente */
body, h1, h2, h3, p, a, label, input {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

/* Estilos globais da página */
body {
    background-color: #f5f5f5;
    color: #333;
}

.container {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

h1 {
    font-size: 24px;
    margin-bottom: 20px;
    text-align: center;
}

form {
    text-align: center;
}

label {
    display: block;
    margin-bottom: 5px;
}

input {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #fff;
}

p {
    color: red;
    margin-top: -10px;
    margin-bottom: 10px;
    text-align: left;
}

input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 10px 15px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

a {
    display: block;
    text-align: center;
    margin-top: 20px;
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>



<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('conexao.php'); // Inclua o arquivo de conexão com o banco de dados

    $bancoDados = new db();
    $link = $bancoDados->conecta_mysql();

    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM in_usuar WHERE cd_usuar = '$usuario'";
    $resultado = mysqli_query($link, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $linha = mysqli_fetch_assoc($resultado);
                // Verifique a senha usando password_verify
        if (password_verify($senha, $linha['senha'])) {
            $_SESSION['usuario'] = $linha['cd_usuar'];
            header("Location: dashboard.php"); // Redirecione para a página de dashboard
        } else {
            $mensagem = "Senha incorreta. Tente novamente $usuario";
        }
    } else {
        $mensagem = "Usuário não encontrado.";
    }

    mysqli_close($link);
}
?>

<form method="post" action="">
    <h1>Login</h1>

    <br><br>

    <label for="usuario">Usuário:</label>
    <input type="text" id="usuario" name="usuario" required><br><br>
    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" required><br><br>

    <?php
    if (isset($mensagem)) {
        echo "<p style='color: red;'>$mensagem</p>";
    }
    ?>

    <input type="submit" value="Login">

    <br><br>
    <a href="../index.php"> Voltar ao Menu. </a>

</form>



</body>
</html>
