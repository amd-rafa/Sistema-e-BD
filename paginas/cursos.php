<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastrar Curso, Aula e Categoria</title>

    <link rel="shortcut icon" href="https://ambienteonline.uninga.br/pluginfile.php/1/theme_moove/favicon/1695711618/favicon.ico">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <link rel="stylesheet" href="./css/stylecat.css">
    
</head>
<body>
    
    <header>
        <h1>Página de cadastro de Categorias, Cursos e aulas</h1>
    </header>

<div class="categorias">
    <h2>Cadastrar Categoria</h2>
    <form method="post" action="./web/main.php">
        <label for="nome_categoria">Nome da Categoria:</label>
        <input type="text" id="nome_categoria" name="nome_categoria" required>
        <input type="submit" name="cadastrar_categoria" value="Cadastrar Categoria">
    </form>
</div>

<div class="cursos">
    <h2>Cadastrar Curso</h2>
<form method="post" action="./web/main.php">
    <label for="nome_curso">Nome do Curso:</label>
    <input type="text" id="nome_curso" name="nome_curso" required>

    <label for="descricao_curso">Descrição do Curso:</label>
    <textarea id="descricao_curso" name="descricao_curso" required></textarea>

    <label for="valor_curso">Valor do Curso:</label>
    <input type="number" id="valor_curso" name="valor_curso" required step="0.01">

    <label for="categoria_id">Categoria:</label>
    <select id="categoria_id" name="categoria_id" required>
        <!-- Carregar opções de categorias do banco de dados -->
        <?php
           require_once('./web/conexao.php'); 

           $bancoDados = new db();
           $link = $bancoDados->conecta_mysql();

        $categorias_sql = "SELECT id_cat, nm_categoria FROM ct_categoria";
        $categorias_resultado = mysqli_query($link, $categorias_sql);

        if (!$categorias_resultado) {
            echo "Erro ao executar consulta: " . mysqli_error($link);
        } else {
            while ($categoria = mysqli_fetch_assoc($categorias_resultado)) {
                echo "<option value='{$categoria['id_cat']}'>{$categoria['nm_categoria']}</option>";
            }
        }
        ?>
    </select>

    <input type="submit" name="cadastrar_curso" value="Cadastrar Curso">
</form>
    </div>

<div class="aulas">
<h2>Cadastrar Aula</h2>
<form method="post" action="./web/main.php">
    <label for="nome_aula">Nome da Aula:</label>
    <input type="text" id="nome_aula" name="nome_aula" required>

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
    
    <label for="conteudo_aula">Conteúdo da Aula:</label>
    <textarea id="conteudo_aula" name="conteudo_aula" required></textarea>

    <input type="submit" name="cadastrar_aula" value="Cadastrar Aula">
</form>
    </div>



<footer>
        <a href="./dashboard.php">Voltar ao Inicio</a>
		<h3>CONTATO: amanda12741@gmail.com</h3>
		<h3>Desenvolvido por Amanda Beltrão</h3>		
	</footer>

</body>
</html>
