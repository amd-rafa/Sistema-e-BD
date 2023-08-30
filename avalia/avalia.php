<?php
session_start();
require_once('conexao.php'); // Inclua o arquivo de conexão com o banco de dados

$bancoDados = new db();
$link = $bancoDados->conecta_mysql();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['avaliar_curso'])) {
    $usuario_logado = $_SESSION['usuario'];
    $curso_id = $_POST['curso_id'];
    $aula_id = $_POST['aula_id'];
    $estrelas = $_POST['estrelas'];
    $avalia = $_POST['opiniao'];

    // Verifique se o usuário já avaliou este curso/aula
    $verifica_avaliacao_sql = "SELECT * FROM in_avalia WHERE cd_usuar = '$usuario_logado' AND id_curso = '$curso_id' AND id_aula = '$aula_id'";
    $verifica_avaliacao_resultado = mysqli_query($link, $verifica_avaliacao_sql);

    if (mysqli_num_rows($verifica_avaliacao_resultado) > 0) {
        echo "Você já avaliou este curso/aula.";
    } else {
        // Obtém o id_prof da aula
        $professor_sql = "SELECT id_prof FROM in_aulas WHERE id_aula = '$aula_id'";
        $professor_resultado = mysqli_query($link, $professor_sql);
        $id_professor = mysqli_fetch_assoc($professor_resultado)['id_prof'];

        $insere_avaliacao_sql = "INSERT INTO in_avalia (cd_usuar, id_aula, id_curso, id_prof, estrela, ds_avalia) VALUES ('$usuario_logado', '$curso_id', '$aula_id', '$id_professor', '$estrelas', '$avalia')";
        $insere_avaliacao_resultado = mysqli_query($link, $insere_avaliacao_sql);

        if ($insere_avaliacao_resultado) {
            echo "Avaliação registrada com sucesso!";
        } else {
            echo "Erro ao registrar a avaliação: " . mysqli_error($link);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Avaliar Curso</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        /* Estilos para as estrelas de avaliação */
        .stars {
            display: inline-block;
            margin: 0 auto;
        }

        .star {
            font-size: 24px;
            cursor: pointer;
        }

        .star:hover {
            color: orange;
        }
    </style>
</head>
<body>
<h1>Avaliar Curso</h1>
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
</form>

<label for="aula_id">Aula:</label>
<select id="aula_id" name="aula_id" required>
</select>

<script>
document.getElementById('curso_id').addEventListener('change', function() {
    var cursoId = this.value;
    var aulaSelect = document.getElementById('aula_id');
    
    // Limpar as opções atuais
    aulaSelect.innerHTML = '';

    // Carregar as opções de aulas com base no curso escolhido
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'carrega_aula.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            aulaSelect.innerHTML = xhr.responseText;
        }
    };
    xhr.send('curso_id=' + encodeURIComponent(cursoId));
});
</script>



    <div class="stars">
        <span class="star" data-rating="1">★</span>
        <span class="star" data-rating="2">★</span>
        <span class="star" data-rating="3">★</span>
        <span class="star" data-rating="4">★</span>
        <span class="star" data-rating="5">★</span>
    </div>

    <label for="opiniao">Opinião:</label>
    <textarea id="opiniao" name="opiniao" required></textarea>

    <input type="hidden" name="estrelas" id="estrelas" value="0">
    <input type="submit" name="avaliar_curso" value="Avaliar Curso">
</form>

<script>
    // Script para manipular a avaliação com estrelas
    const stars = document.querySelectorAll('.star');
    const estrelasInput = document.getElementById('estrelas');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const rating = star.getAttribute('data-rating');
            estrelasInput.value = rating;
            stars.forEach(s => s.style.color = 'black');
            for (let i = 0; i < rating; i++) {
                stars[i].style.color = 'orange';
            }
        });
    });
</script>

<a href="../login/dashboard.php">Voltar ao Inicio</a>

</body>
</html>
