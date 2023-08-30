<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Redireciona para a página de login se não estiver logado
    exit();
}



$UserINPROF = false;

//if ($_SERVER["REQUEST_METHOD"] == "POST") {
   require_once('conexao.php'); // Inclua o arquivo de conexão com o banco de dados

    $bancoDados = new db();
    $link = $bancoDados->conecta_mysql();

    $User = $_SESSION['usuario'];
    $sql = "SELECT * FROM IN_PROF where CD_USUAR = '$User'";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $UserINPROF = true;
    }
    else {
        $UserINPROF = false;
  
      }     
// }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel</title>
    <style>
        /* styledash.css */

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

h1 {
    background-color: #007bff;
    color: #fff;
    padding: 10px;
    text-align: center;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

p {
    margin-bottom: 20px;
}

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

.panel {
    border: 1px solid #ccc;
    background-color: #fff;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

    </style>
</head>
<body>  

<h1>Painel de Controle</h1>
<p>Bem-vindo, <?php echo $_SESSION['usuario']; ?></p>

<a href="../index.php"> Inicio </a><br><br>

<?php

    if ($UserINPROF)  {
        echo "Bem-vindo Professor!<br>";
        echo "<a href='../categorias/cursos.php'> Cadastro de Categorias, Curso e Aulas</a><br>";

    }

     else  {
        echo "Bem-vindo Aluno!<br>";
    }
 ?>

    <a href="../inscricao/inscricao.php">Inscreva-se em Aulas</a><br>
    <a href="../avalia/avalia.php">Avalie seu Curso.</a><br>
    <a href="../progresso/progresso.php">Veja seu progresso.</a><br><br>
    <a href="../certificado/emissao.php">Emita seu Certificado.</a><br><br>

<a href="logout.php">Logout</a>

</body>
</html>
