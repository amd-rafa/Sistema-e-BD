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
    
    <title>Certificado</title>
    <style>
       body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        .certificado {
            border: 2px solid #000;
            padding: 20px;
            width: 400px;
            text-align: center;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }
        .nome-usuario {
            font-weight: bold;
            margin: 10px 0;
        }
        footer {
            text-align: center;
            margin-top: 500px;
            padding: 50px;
        }
        footer a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="certificado">
        <h3>Certificamos que</h3>
        <br><br><br>
        <p><?php echo $nomeUsuario; ?></p>
        <br><br><br>
        <h3>Concluiu com sucesso o curso</h3>
        <h2><?php echo $nome_curso; ?></h2>
       <h3>No dia: <p> <?php echo $dataEmissao; ?></p></h3>
        
    </div>

    <footer>
    <a href="./dashboard.php">Voltar ao inicio</a>
    </footer>

   
</body>
</html>
