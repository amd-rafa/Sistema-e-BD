<?php
require_once('conexao.php'); // Inclua o arquivo de conexão com o banco de dados

$bancoDados = new db();
$link = $bancoDados->conecta_mysql();

$cursoId = $_POST['curso_id'];

$aulas_sql = "SELECT id_aula, nm_aula FROM in_aulas WHERE id_curso = ?";
$stmt = mysqli_prepare($link, $aulas_sql);
mysqli_stmt_bind_param($stmt, "i", $cursoId);
mysqli_stmt_execute($stmt);
$aulas_resultado = mysqli_stmt_get_result($stmt);

$options = '';

if ($aulas_resultado) {
    while ($aula = mysqli_fetch_assoc($aulas_resultado)) {
        $options .= "<option value='{$aula['id_aula']}'>{$aula['nm_aula']}</option>";
    }
}

echo $options;
?>
