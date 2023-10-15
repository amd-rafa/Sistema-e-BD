<?php
session_start();


require_once('./web/conexao.php');

$bancoDados = new db();
$link = $bancoDados->conecta_mysql();


if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$curso = $_GET["curso"];
$curso_sql = "SELECT nm_curso FROM in_cursos WHERE id_curso = '$curso'";
$curso_resultado = mysqli_query($link, $curso_sql);
$nome_curso = mysqli_fetch_assoc($curso_resultado)['nm_curso'];


$dataEmissao = $_GET["data"];

$nomeUsuario = $_GET['user']; 


?>

<!DOCTYPE html>
<html>
<head>

    <link rel="shortcut icon" href="https://ambienteonline.uninga.br/pluginfile.php/1/theme_moove/favicon/1695711618/favicon.ico">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <link rel="stylesheet" href="./css/stylecertif.css">
    
    <title>Certificado</title>
</head>
<body>
    <header>
        <h1>Certificado</h1>
    </header>
        <div class="certificado">
        <h3>Certificamos que</h3>
        <br>
        <p><?php echo $nomeUsuario; ?></p>
        <br>
        <h3>Concluiu com sucesso o curso</h3>
        <h2><?php echo $nome_curso; ?></h2>
       <h3>No dia: <p> <?php echo $dataEmissao; ?></p></h3>
        
    </div>

    
    <footer>
        <a href="./dashboard.php">Voltar ao Inicio</a>
		<h3>CONTATO: amanda12741@gmail.com</h3>
		<h3>Desenvolvido por Amanda Beltrão</h3>		
	</footer>

   
</body>
</html>
