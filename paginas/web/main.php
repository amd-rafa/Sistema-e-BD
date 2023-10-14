<?php
session_start();
// Conexão com o banco de dados
require_once('./conexao.php'); 

$bancoDados = new db();
$link = $bancoDados->conecta_mysql();

    //Cadastrar usuário
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cadastrar_usuario'])) {

		$usuario = $_POST['usuario'];

		$nome = $_POST['nome'];

		$data = $_POST['data'];
		
		$sexo = $_POST['sexo'];

		$email = $_POST['email'];

		$senha = $_POST['senha'];

		$senhaSegura = password_hash($senha, PASSWORD_BCRYPT);

		$prof = $_POST['prof'];

		if ($sexo === "Feminino") {
			$sexo = "F";
		} elseif ($sexo === "Masculino") {
			$sexo = "M";
		} else {
			$sexo = "O";
		}

		if ($prof === "Professor") {
			$sqlP = "INSERT INTO in_prof (cd_usuar, nm_prof, dt_nasci)
					VALUES ('$usuario', '$nome', '$data')";
			
			$result = mysqli_query($link, $sqlP);

			if ($result) {
				echo "Cadastro realizado como Professor com sucesso!<br>";
			} else {
				echo "Erro ao cadastrar: " . mysqli_error($link);
			}
					
		}

			// Inserir informações na tabela in_usuar
		$sql = "INSERT INTO in_usuar (cd_usuar, nm_nome, dt_nascimento, sexo, senha, in_email)
					VALUES ('$usuario', '$nome', '$data', '$sexo',	 '$senhaSegura', '$email')";
		
		
	
		$resultado = mysqli_query($link, $sql);
	
		if ($resultado) {
			echo "Cadastro realizado como usuário com sucesso!<br>";
		} else {
			echo "Erro ao cadastrar: " . mysqli_error($link);
		}
	
	}

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

    header("Location: ../cursos.php"); // Redirecione para a página de cursos
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

    header("Location: ../cursos.php"); // Redirecione para a página de dashboard
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

    header("Location: ../cursos.php"); // Redirecione para a página de dashboard
}

//Insrecver-se
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

    header("Location: ../inscricao.php"); // Redirecione para a página de inscricao
}

//Avaliar cursos
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

    header("Location: ../avalia.php"); // Redirecione para a página de avaliação
}


//Emissão Certificado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['emitir_certi'])) {
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
        header("Location: ../certi.php?curso=$cursoSelecionado&data=$dataEmissao&user=$nm_user");
        exit();
    } else {
        echo "Erro ao emitir certificado: " . mysqli_error($link);
    }
}


//Login
if ($_SERVER["REQUEST_METHOD"] == "POST"  && isset($_POST['login_php'])) {


    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM in_usuar WHERE cd_usuar = '$usuario'";
    $resultado = mysqli_query($link, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $linha = mysqli_fetch_assoc($resultado);
                // Verifique a senha usando password_verify
        if (password_verify($senha, $linha['senha'])) {
            $_SESSION['usuario'] = $linha['cd_usuar'];
            header("Location: ../dashboard.php"); // Redirecione para a página de dashboard
        } else {
            $mensagem = "Senha incorreta. Tente novamente $usuario";
        }       
    } else {
        $mensagem = "Usuário não encontrado.";
    }
}

//Logout
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['logout'])) {
    session_start();
    session_destroy();
    header("Location: ../login.php");
}

// Fechar a conexão
mysqli_close($link);
?>