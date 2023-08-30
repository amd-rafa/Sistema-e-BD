<?php
session_start();
// Conexão com o banco de dados
require_once('conexao.php'); // Substitua pela sua configuração de conexão

$bancoDados = new db();
$link = $bancoDados->conecta_mysql();

// Cadastrar Categoria
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cadastrar_categoria'])) {
    $nome_categoria = $_POST['nome_categoria'];

    $sql = "INSERT INTO ct_categoria (nm_categoria, qt_curso) VALUES ('$nome_categoria', 0)";
    $resultado = mysqli_query($link, $sql);

    if ($resultado) {
        echo "Categoria cadastrada com sucesso!";
    } else {
        echo "Erro ao cadastrar categoria: " . mysqli_error($link);
    }
}

// Cadastrar Curso
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cadastrar_curso'])) {
    $nome_curso = $_POST['nome_curso'];
    $descricao_curso = $_POST['descricao_curso'];
    $valor_curso = $_POST['valor_curso'];
    $categoria_id = $_POST['categoria_id'];

    $sql = "INSERT INTO in_cursos (nm_curso, id_cat, in_descri, vl_valor ) VALUES ('$nome_curso', '$categoria_id', '$descricao_curso', $valor_curso)";
    $resultado = mysqli_query($link, $sql);

    if ($resultado) {
        // Atualizar a quantidade de cursos na categoria
        $update_sql = "UPDATE ct_categoria SET qt_curso = qt_curso + 1 WHERE id_cat = '$categoria_id'";
        mysqli_query($link, $update_sql);

        echo "Curso cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar curso: " . mysqli_error($link);
    }
}


// Cadastrar Aula
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cadastrar_aula'])) {
    $nome_aula = $_POST['nome_aula'];
    $curso_id = $_POST['curso_id'];
    $conteudo_aula = $_POST['conteudo_aula'];

    // Obter o ID do professor logado
    $usuario_logado = $_SESSION['usuario'];
    $professor_sql = "SELECT id_prof FROM IN_PROF WHERE cd_usuar = '$usuario_logado'";
    $professor_resultado = mysqli_query($link, $professor_sql);
    $id_professor = mysqli_fetch_assoc($professor_resultado)['id_prof'];

    $sql = "INSERT INTO in_aulas (nm_aula, id_curso, id_prof, ds_conteudo) VALUES ('$nome_aula', '$curso_id', '$id_professor', '$conteudo_aula')";
    $resultado = mysqli_query($link, $sql);

    if ($resultado) {
        echo "Aula cadastrada com sucesso!";
    } else {
        echo "Erro ao cadastrar aula: " . mysqli_error($link);
    }
}


// Fechar a conexão
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastrar Curso, Aula e Categoria</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <h1>Cadastrar Categoria</h1>
    <form method="post">
        <label for="nome_categoria">Nome da Categoria:</label>
        <input type="text" id="nome_categoria" name="nome_categoria" required>
        <input type="submit" name="cadastrar_categoria" value="Cadastrar Categoria">
    </form>

    <h1>Cadastrar Curso</h1>
<form method="post">
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
           require_once('conexao.php'); 

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


<h1>Cadastrar Aula</h1>
<form method="post">
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

<a href="../login/dashboard.php">Voltar ao Inicio</a>


</body>
</html>
