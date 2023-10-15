<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscrição em Aulas</title>

    <link rel="shortcut icon" href="https://ambienteonline.uninga.br/pluginfile.php/1/theme_moove/favicon/1695711618/favicon.ico">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <link rel="stylesheet" href="./css/styleinc.css">
    
</head>
<body>
    <header>
    <h1>Inscrição em Aulas</h1>
    </header>


<div class="inscricao">
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
        document.getElementById('curso_id').addEventListener('change', function () {
            var cursoId = this.value;
            var aulaSelect = document.getElementById('aula_id');

            // Limpar as opções atuais
            aulaSelect.innerHTML = '';

            // Carregar as opções de aulas com base no curso escolhido
            var xhr = new XMLHttpRequest();
            xhr.open('POST', './web/carrega_aula.php', true);
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
</div>

<footer>
        <a href="./dashboard.php">Voltar ao Inicio</a>
		<h3>CONTATO: amanda12741@gmail.com</h3>
		<h3>Desenvolvido por Amanda Beltrão</h3>		
	</footer>

</body>
</html>
