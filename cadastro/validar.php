<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cadastro</title>
	<link rel="stylesheet" href="./css/style.css">
	<link rel="stylesheet" href="./css/styval.css">
</head>

<body>

	<header>
		<h1>Agradecemos por seu Cadastro</h1>
		<h3> Pode iniciar sua inscrição em cursos do nosso ambiente.</h3>
	</header>
<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		require_once('conexao.php'); // Inclua o arquivo de conexão com o banco de dados
	
		$bancoDados = new db();
		$link = $bancoDados->conecta_mysql();
		
		// Recupere outros campos do formulário
		// ...

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

		
	
		mysqli_close($link);
	}
	
?>
	
	<section>
		<h2></h2><br><br>
		<a href="../index.php"> << Voltar ao Menu</a>

	<div class="login-buttons">
       <div class="signup-button">
   		 </div>
   
</div>

		<a href="../login/login.php"> << Login</a>
	</section>	

	<br>
	<footer>
		<h3>CONTATO: amanda12741@gmail.com</h3>
		<h3>Desenvolvido por Amanda Beltrão</h3>		
	</footer>

</body>
</html>	