<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Avaliar Curso</title>

    <link rel="shortcut icon" href="https://ambienteonline.uninga.br/pluginfile.php/1/theme_moove/favicon/1695711618/favicon.ico">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    
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
<form method="post" action="./web/main.php">
    <label for="curso_id">Curso:</label>
    <select id="curso_id" name="curso_id" required>
        <!-- Carregar opções de cursos do banco de dados -->
        <?php
         require_once('./web/conexao.php'); 

         $bancoDados = new db();
         $link = $bancoDados->conecta_mysql();

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
document.getElementById('curso_id').addEventListener('change', function() {
    var cursoId = this.value;
    var aulaSelect = document.getElementById('aula_id');
    
    // Limpar as opções atuais
    aulaSelect.innerHTML = '';

    // Carregar as opções de aulas com base no curso escolhido
    var xhr = new XMLHttpRequest();
    xhr.open('POST', './web/carrega_aula.php', true);
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

<a href="./dashboard.php">Voltar ao Inicio</a>

</body>
</html>
