<?php
session_start();

require_once('./web/conexao.php');

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

    // Consultar a quantidade total de cursos inscritos
    $query_total_cursos = "SELECT qt_curso FROM in_progresso WHERE cd_usuar = '$cd_usuar'";
    $result_total_cursos = mysqli_query($link, $query_total_cursos);
    $row_total_cursos = mysqli_fetch_assoc($result_total_cursos);
    $qt_cursos_inscritos = $row_total_cursos['qt_curso'];

    // Consultar a quantidade de cursos já iniciados
    $query_cursos_iniciados = "SELECT qt_iniciado FROM in_progresso WHERE cd_usuar = '$cd_usuar'";
    $result_cursos_iniciados = mysqli_query($link, $query_cursos_iniciados);
    $row_cursos_iniciados = mysqli_fetch_assoc($result_cursos_iniciados);
    $qt_cursos_iniciados = $row_cursos_iniciados['qt_iniciado'];

    if ($qt_cursos_iniciados < $qt_cursos_inscritos) {
        // Atualize a quantidade de cursos iniciados
        $update_progresso_sql = "UPDATE in_progresso SET qt_iniciado = qt_iniciado + 1 WHERE cd_usuar = '$cd_usuar'";
        mysqli_query($link, $update_progresso_sql);
    } else {
        echo "Você já iniciou todos os cursos inscritos.";
    }
}


// Lógica para finalizar um curso
if (isset($_POST['finalizar_curso'])) {
    $id_curso = $_POST['curso_id'];

     // Consultar a quantidade total de cursos inscritos
     $query_total_cursos = "SELECT qt_curso FROM in_progresso WHERE cd_usuar = '$cd_usuar'";
     $result_total_cursos = mysqli_query($link, $query_total_cursos);
     $row_total_cursos = mysqli_fetch_assoc($result_total_cursos);
     $qt_cursos_inscritos = $row_total_cursos['qt_curso'];

      // Consultar a quantidade de cursos já finalizados
    $query_cursos_finalizados = "SELECT qt_final FROM in_progresso WHERE cd_usuar = '$cd_usuar'";
    $result_cursos_finalizados = mysqli_query($link, $query_cursos_finalizados);
    $row_cursos_finalizados = mysqli_fetch_assoc($result_cursos_finalizados);
    $qt_cursos_finalizados = $row_cursos_finalizados['qt_final'];

    
    if ($qt_cursos_finalizados < $qt_cursos_inscritos) {
        // Atualize a quantidade de cursos finalizados
        $update_progresso_sql = "UPDATE in_progresso SET qt_final = qt_final + 1, qt_iniciado = qt_iniciado - 1 WHERE cd_usuar = '$cd_usuar'";
        mysqli_query($link, $update_progresso_sql);
    } else {
        echo "Você já finalizou todos os cursos inscritos.";
    }
     
    
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
    <link rel="shortcut icon" href="https://ambienteonline.uninga.br/pluginfile.php/1/theme_moove/favicon/1695711618/favicon.ico">
    <link rel="stylesheet" href="./css/styleprog.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header>
        <h2>Seu Progresso</h2>
        <div id="progressoGrafico" style="display: flex; justify-content: center; align-items: center; height: 200px;">>
    <canvas id="progressoGraficoCanvas"></canvas>
</div>

        <?php
        if ($progresso) {
            if ($progresso['qt_iniciado'] > 0 && $progresso['qt_final'] > 0) {
                echo "Cursos iniciados: {$progresso['qt_iniciado']}<br>";
                echo "Cursos finalizados: {$progresso['qt_final']}<br>";
                echo "Cursos incristos: {$progresso['qt_curso']}";
            } elseif ($progresso['qt_iniciado'] > 0) {
                echo "Apenas cursos iniciados: {$progresso['qt_iniciado']}<br>";
                echo "Cursos incristos: {$progresso['qt_curso']}";
            } elseif ($progresso['qt_final'] > 0) {
                echo "Apenas cursos finalizados: {$progresso['qt_final']}<br>";
                echo "Cursos incristos: {$progresso['qt_curso']}";
            } else {
                echo "Não há cursos iniciados/finalizados. <br>";
                echo "Cursos incristos: {$progresso['qt_curso']}";
            }
        } else {
            echo "Não há cursos iniciados/finalizados.";
        }
        ?>
    </header>

    <div class="inicio">
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
    </div>

    <div class="finaliza">
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
    </div>

    <div class="comentario">
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
    </div>

    <footer>
        <a href="./dashboard.php">Voltar ao Inicio</a>
        <h3>CONTATO: amanda12741@gmail.com</h3>
        <h3>Desenvolvido por Amanda Beltrão</h3>
    </footer>

        <script>
            // Certifique-se de que o progresso esteja disponível no seu código PHP
            <?php
            if ($progresso) {
                $cursosIniciados = $progresso['qt_iniciado'];
                $cursosFinalizados = $progresso['qt_final'];
                $cursosInscritos = $progresso['qt_curso'];
            } else {
                $cursosIniciados = 0;
                $cursosFinalizados = 0;
                $cursosInscritos = 0;
            }
            ?>
            var cursosIniciados = <?php echo $cursosIniciados; ?>;
            var cursosFinalizados = <?php echo $cursosFinalizados; ?>;
            var cursosInscritos = <?php echo $cursosInscritos; ?>;

            var ctx = document.getElementById('progressoGraficoCanvas').getContext('2d');
            var progressoGrafico = new Chart(ctx, {
                type: 'bar', // Tipo de gráfico de barras
                data: {
                    labels: ['Cursos Inscritos','Cursos Iniciados', 'Cursos Finalizados'],
                    datasets: [{
                        label: 'Progresso do Usuário',
                        data: [<?php echo $cursosInscritos; ?>,<?php echo $cursosIniciados; ?>, <?php echo $cursosFinalizados; ?>],
                        backgroundColor: [
                            'rgba(222,184,135, 0.2)', // Cor da borda da barra de cursos finalizados
                            'rgba(75, 192, 192, 0.2)', // Cor da barra de cursos iniciados
                            'rgba(255, 99, 132, 0.2)', // Cor da barra de cursos finalizados
                        ],
                        borderColor: [
                            'rgba(222,184,135)', // Cor da borda da barra de cursos finalizados
                            'rgba(75, 192, 192, 1)', // Cor da borda da barra de cursos iniciados
                            'rgba(255, 99, 132, 1)', // Cor da borda da barra de cursos finalizados
                            
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
</body>
</html>
