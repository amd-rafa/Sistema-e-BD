<?php
session_start();
require_once('./web/conexao.php'); 

$bancoDados = new db();
$link = $bancoDados->conecta_mysql();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Emitir Certificado</title>

    <link rel="shortcut icon" href="https://ambienteonline.uninga.br/pluginfile.php/1/theme_moove/favicon/1695711618/favicon.ico">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <link rel="stylesheet" href="./css/styleemit.css">
</head>
<body>
    <header>
    <h1>Emissão de Certificado  </h1>
    <p>Bem-vindo, <?php echo $_SESSION['usuario']; ?></p>
    </header>

    <div class="certificado">
    <h2>Selecione o Curso para Emitir o Certificado</h2>
    <form method="post" action="./web/main.php">
        <select id="curso_id" name="curso_id" required>
            <?php
            $cd_usuar = $_SESSION['usuario'];
            $cursos_sql = "SELECT id_curso, nm_curso FROM in_cursos WHERE id_curso IN (
                SELECT id_curso FROM in_inscricao WHERE cd_usuar = '$cd_usuar'
            )";

            $cursos_resultado = mysqli_query($link, $cursos_sql);

            while ($curso = mysqli_fetch_assoc($cursos_resultado)) {
                echo "<option value='{$curso['id_curso']}'>{$curso['nm_curso']}</option>";
            }
            ?>
        </select>
        <input type="submit" name="emitir_certi" value="Emitir">
    </form>
        </div>
    <footer>
        <a href="./dashboard.php">Voltar ao Inicio</a>
		<h3>CONTATO: amanda12741@gmail.com</h3>
		<h3>Desenvolvido por Amanda Beltrão</h3>		
	</footer>
</body>
</html>