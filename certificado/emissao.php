<?php
session_start();

require_once('conexao.php');

$bancoDados = new db();
$link = $bancoDados->conecta_mysql();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cursoSelecionado = $_POST["curso_id"];

    $usuario_logado = $_SESSION['usuario'];
    $user_sql = "SELECT nm_nome FROM in_usuar WHERE cd_usuar = '$usuario_logado'";
    $user_result = mysqli_query($link, $user_sql);
    $nm_user = mysqli_fetch_assoc($user_result)['nm_nome'];

    date_default_timezone_set('America/Sao_Paulo');

    $dataEmissao =  strftime("%d/%m/%Y");
    // Lógica para criar o certificado
    $insert_certificado_sql = "INSERT INTO in_certificado (cd_usuar, id_curso, dt_emi) VALUES ('$usuario_logado', '$cursoSelecionado', '$dataEmissao')";
    if (mysqli_query($link, $insert_certificado_sql)) {
        // Redirecionar para a página do certificado
        header("Location: certi.php?curso=$cursoSelecionado&data=$dataEmissao&user=$nm_user");
        exit();
    } else {
        echo "Erro ao emitir certificado: " . mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Emitir Certificado</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<p>Bem-vindo, <?php echo $_SESSION['usuario']; ?></p>
    <h2>Selecione o Curso para Emitir o Certificado</h2>
    <form method="post">
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
        <button type="submit">Emissão</button>
    </form>
</body>
</html>