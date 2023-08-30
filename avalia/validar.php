<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cadastro</title>
</head>

<body>

	<header>
		<h1>Agradecemos por seu Cadastro</h1>
		<h3> Pode iniciar sua inscrição em cursos do nosso ambiente.</h3>
	</header>
<?php
	
	require_once('conexao.php');

		$usuario = $_POST['usuario'];

		$nome = $_POST['nome'];

		$data = $_POST['data'];
		
		$sexo = $_POST['sexo'];

		$email = $_POST['email'];

		$senha = $_POST['senha'];

		if ($sexo === "Feminino") {
			$sexo = "F";
		} elseif ($sexo === "Masculino") {
			$sexo = "M";
		} else {
			$sexo = "O";
		} 

	$bancoDados = new db();

	$link = $bancoDados-> conecta_mysql();
	
	$sql = "insert into in_usuar (cd_usuar, nm_nome, dt_nascimento, sexo, senha, in_email) values ('$usuario','$nome', '$data', '$sexo', '$email', '$senha')";

	mysqli_query($link, $sql);
?>
	
	<section>
		<h2></h2><br><br>
		<a href="index.php"> << Voltar</a>
	</section>

	<br>
	<footer>
		<h3>CONTATO: amanda12741@gmail.com</h3>
		<h3>Desenvolvido por Amanda Beltrão</h3>		
	</footer>

</body>
</html>	