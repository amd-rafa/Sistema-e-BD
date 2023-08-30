<?php
session_start();
require_once('conexao.php'); // Inclua o arquivo de conexão com o banco de dados

$bancoDados = new db();
$link = $bancoDados->conecta_mysql();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['inscrever'])) {
    $usuario_logado = $_SESSION['usuario'];
    $curso_id = $_POST['curso_id'];
    $aula_id = $_POST['aula_id'];

    // Recupere o email do usuário a partir do banco de dados
    $email_usuario_sql = "SELECT in_email FROM in_usuar WHERE cd_usuar = '$usuario_logado'";
    $email_usuario_resultado = mysqli_query($link, $email_usuario_sql);

    if ($email_usuario_resultado && mysqli_num_rows($email_usuario_resultado) > 0) {
        $email_usuario = mysqli_fetch_assoc($email_usuario_resultado)['in_email'];

        // Verifique se o usuário já está inscrito nesta aula
        $verifica_inscricao_sql = "SELECT * FROM in_inscricao WHERE cd_usuar = '$usuario_logado' AND id_aula = '$aula_id'";
        $verifica_inscricao_resultado = mysqli_query($link, $verifica_inscricao_sql);

        if (mysqli_num_rows($verifica_inscricao_resultado) > 0) {
            echo "Você já está inscrito nesta aula.";
        } else {
            $insere_inscricao_sql = "INSERT INTO in_inscricao (cd_usuar, id_curso, id_aula, in_email) VALUES ('$usuario_logado', '$curso_id', '$aula_id', '$email_usuario')";
            $insere_inscricao_resultado = mysqli_query($link, $insere_inscricao_sql);

            if ($insere_inscricao_resultado) {
                echo "Inscrição realizada com sucesso!";
            
                $verifica_progresso_sql = "SELECT * FROM in_progresso WHERE cd_usuar = '$usuario_logado'";
                $verifica_progresso_resultado = mysqli_query($link, $verifica_progresso_sql);
            
                if (mysqli_num_rows($verifica_progresso_resultado) > 0) {
                    // Atualizar o progresso existente
                    $update_progresso_sql = "UPDATE in_progresso SET qt_curso = qt_curso + 1 WHERE cd_usuar = '$usuario_logado'";
                    mysqli_query($link, $update_progresso_sql);
                } else {
                    // Inserir novo registro de progresso
                    $atualiza_progresso_sql = "INSERT INTO in_progresso (cd_usuar, qt_curso, qt_iniciado, qt_final) VALUES ('$usuario_logado', 1, 0, 0)";
                    mysqli_query($link, $atualiza_progresso_sql);
                }
            } else {
                echo "Erro ao realizar a inscrição: " . mysqli_error($link);
            }            
        }
    } else {
        echo "Erro ao recuperar o email do usuário: " . mysqli_error($link);
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscrição em Aulas</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<h1>Inscrição em Aulas</h1>
<form method="post">
    <label for="curso_id">Curso:</label>
    <select id="curso_id" name="curso_id" required>
        <!-- Carregar opções de cursos do banco de dados -->
        <?php
        $cursos_sql = "SELECT id_curso, nm_curso FROM in_cursos";
        $cursos_resultado = mysqli_query($link, $cursos_sql);

        while ($curso = mysqli_fetch_assoc($cursos_resultado)) {
            echo "<option value='{$curso['id_curso']}'>{$curso['nm_curso']}</option>";
        }
        ?>
    </select>

    <label for="aula_id">Aula:</label>
    <select id="aula_id" name="aula_id" required>
    </select>

    <script>
        document.getElementById('curso_id').addEventListener('change', function () {
            var cursoId = this.value;
            var aulaSelect = document.getElementById('aula_id');

            // Limpar as opções atuais
            aulaSelect.innerHTML = '';

            // Carregar as opções de aulas com base no curso escolhido
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'carrega_aula.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    aulaSelect.innerHTML = xhr.responseText;
                }
            };
            xhr.send('curso_id=' + encodeURIComponent(cursoId));
        });
    </script>

    <input type="submit" name="inscrever" value="Inscrever-se">
</form>

<a href="../login/dashboard.php">Voltar ao Inicio.</a>
</body>
</html>
