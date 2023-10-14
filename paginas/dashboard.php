<?php
session_start();

$UserINPROF = false;

//if ($_SERVER["REQUEST_METHOD"] == "POST") {
   require_once('./web/conexao.php'); // Inclua o arquivo de conexão com o banco de dados

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
    <title>Meu Site</title>

    <link rel="shortcut icon" href="https://ambienteonline.uninga.br/pluginfile.php/1/theme_moove/favicon/1695711618/favicon.ico">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <link rel="stylesheet" href="./css/styledash.css">
</head>
<body>

<div class="header">
<header>
    <h1>Painel de Controle</h1>
    <p><?php   if ($UserINPROF) {
                echo "Bem-vindo Professor {$_SESSION['usuario']}!";
            } else {
                echo "Bem-vindo Aluno(a) {$_SESSION['usuario']}!";
            } ?></p>
</header>
</div>
<div class="container">


    <div class="control-panel-links">
        <a class="control-panel-link" href="../index.php">Início</a>
        <?php
            if ($UserINPROF) {
                echo "<a class='control-panel-link' href='./cursos.php'>Cadastro de Categorias, Curso e Aulas</a>";
            }
        ?>
        <a class="control-panel-link" href="./inscricao.php">Inscreva-se em Aulas</a>
        <a class="control-panel-link" href="./avalia.php">Avalie seu Curso</a>
        <a class="control-panel-link" href="./progresso.php">Veja seu progresso</a>
        <a class="control-panel-link" href="./emissao.php">Emita seu Certificado</a>
        <a class="control-panel-link logout-link" href="./web/main.php?logout=true">Logout</a>

    </div>
</div>

<footer>
		<h3>Centro Universitário Ingá - Uningá</h3>	
		<h4>Desenvolvido por Amanda Beltrão</h4><br>
        <p>&copy; 2023 Meu Site. Todos os direitos reservados.</p>

    </footer>

</body>
</html>
