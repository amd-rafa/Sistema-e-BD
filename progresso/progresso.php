<?php
session_start();

require_once('conexao.php');

$bancoDados = new db();
$link = $bancoDados->conecta_mysql();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$cd_usuar = $_SESSION['usuario'];

// Lógica para iniciar um curso
if (isset($_POST['iniciar_curso'])) {
    $id_curso = $_POST['curso_id'];
    $update_progresso_sql = "UPDATE in_progresso SET qt_iniciado = qt_iniciado + 1 WHERE cd_usuar = '$cd_usuar'";
    mysqli_query($link, $update_progresso_sql);
}

// Lógica para finalizar um curso
if (isset($_POST['finalizar_curso'])) {
    $id_curso = $_POST['curso_id'];
    $update_progresso_sql = "UPDATE in_progresso SET qt_final = qt_final + 1, qt_iniciado = qt_iniciado - 1 WHERE cd_usuar = '$cd_usuar'";
    mysqli_query($link, $update_progresso_sql);
}

// Lógica para inserir um comentário
if (isset($_POST['enviar_comentario'])) {
    $id_aula = $_POST['aula_id'];
    $ds_coment = $_POST['ds_coment'];

    $aula_curso_sql = "SELECT id_curso FROM in_aulas WHERE id_aula = '$id_aula'";
    $curso_resultado = mysqli_query($link, $aula_curso_sql);
    $id_curso = mysqli_fetch_assoc($curso_resultado)['id_curso'];

    $insert_comentario_sql = "INSERT INTO cm_coment (id_aula, cd_usuar, id_curso, ds_coment) VALUES ( '$id_aula', '$cd_usuar', '$id_curso', '$ds_coment')";
    mysqli_query($link, $insert_comentario_sql);
}

// Consultar informações de progresso
$progresso_sql = "SELECT * FROM in_progresso WHERE cd_usuar = '$cd_usuar' and (qt_iniciado or qt_final > 0)";
$progresso_resultado = mysqli_query($link, $progresso_sql);
$progresso = mysqli_fetch_assoc($progresso_resultado);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Progresso do Usuário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        h2 {
            margin-top: 20px;
        }

        form {
            margin: 20px 0;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #fff;
        }

        select {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            padding: 8px 12px;
            background-color: #007bff;
            border: none;
            border-radius: 3px;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        textarea {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
    </style>

</head>
<body>
    <h2>Seu Progresso</h2>
    <?php
    if ($progresso) {
        if ($progresso['qt_iniciado'] > 0 && $progresso['qt_final'] > 0) {
            echo "Cursos iniciados: {$progresso['qt_iniciado']}<br>";
            echo "Cursos finalizados: {$progresso['qt_final']}";
        } elseif ($progresso['qt_iniciado'] > 0) {
            echo "Apenas cursos iniciados: {$progresso['qt_iniciado']}";
        } elseif ($progresso['qt_final'] > 0) {
            echo "Apenas cursos finalizados: {$progresso['qt_final']}";
        } else {
            echo "Não há cursos iniciados/finalizados.";
        }
    } else {
        echo "Não há cursos iniciados/finalizados.";
    }
    ?>
    
    <h2>Iniciar Curso</h2>
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
    <button type="submit" name="iniciar_curso">Iniciar</button>
    </form>

    <h2>Finalizar Curso</h2>
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
        <button type="submit" name="finalizar_curso">Finalizar</button>

    </form>

    <h2>Enviar Comentário</h2>
    <form method="post">
    <select id="aula_id" name="aula_id" required>
        <?php
        $bancoDados = new db();
        $link = $bancoDados->conecta_mysql();

        $cd_usuar = $_SESSION['usuario'];
        $aula_sql = "SELECT id_aula, nm_aula FROM in_aulas WHERE id_aula IN (
            SELECT id_aula FROM in_inscricao WHERE cd_usuar = '$cd_usuar'
        )";

        $aula_resultado = mysqli_query($link, $aula_sql);

        while ($aula = mysqli_fetch_assoc($aula_resultado)) {
            echo "<option value='{$aula['id_aula']}'>{$aula['nm_aula']}</option>";
        }
        ?>
    </select>
    <br>
    <label for="ds_coment">Comentário:</label>
    <textarea name="ds_coment" required></textarea>
    <br>
    <button type="submit" name="enviar_comentario">Enviar</button>
</form>

<form action="POST">
    <a href="../login/dashboard.php">Voltar ao inicio.</a>
</form>

</body>
</html>
