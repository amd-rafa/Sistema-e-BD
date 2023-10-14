<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Inscrições</title>

	<link rel="shortcut icon" href="https://ambienteonline.uninga.br/pluginfile.php/1/theme_moove/favicon/1695711618/favicon.ico">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

	<link rel="stylesheet" href="./css/stylecad.css">
	
</head>
	<body>
	<header>
		<h1>Plataforma de Aprendizadao Online</h1>
		<h3>Cadastro de usuários</h3>
	</header>

    <div  id="area" class="box">

		<h2>Preencha os campos abaixo e cadastre-se</h2>
        <div>
		<form action="./web/main.php" method="post" id="usuario" target="" class= "formulario">

			<label for="usuario">Usuário</label><br>
			<input type="text" id="usuario" name="usuario" placeholder="Crie um Usuário">
			<br><br>
            <label for="nome">Nome Completo</label><br>
			<input type="text" id="nome" name="nome" placeholder="Nome completo">
			<br><br>
            <label for="data">Data de nascimento</label><br>
			<input type="date" id="data" name="data" placeholder="Data de nascimento">
			<br><br>
            <div class="radio-container">
                <label class="radio-label" for="sexo">Sexo:</label>
                <input class="radio-input" type="radio" name="sexo" value="Masculino">Masculino <span class="radio-input"></span>
                <input class="radio-input" type="radio" name="sexo" value="Feminino"> Feminino <span class="radio-input"></span>
                <input class="radio-input" type="radio" name="sexo" value="Outro"> Outro <span class="radio-input"></span>
            </div>

            <br><br>
			<label for="email">E-Mail</label><br>
			<input type="email" id="email" name="email" placeholder="Digite seu e-mail">
			<br><br>
			<label for="senha">Senha</label><br>
			<input type="password" id="senha" name="senha" placeholder="Crie uma senha"><br><br>

			<div class="radio-container">
                <label class="radio-label" for="prof">Seu usuário será?</label>
                <input class="radio-input" type="radio" name="prof" value="Aluno">Aluno <span class="radio-input"></span>
                <input class="radio-input" type="radio" name="prof" value="Professor"> Professor <span class="radio-input"></span>
            </div>
			<br>
            <input type="submit" name="cadastrar_usuario">
</div>
		</form>
</div>

	</section>
	<br>
	<footer>
		<h3>CONTATO: amanda12741@gmail.com</h3>
		<h3>Desenvolvido por Amanda Beltrão</h3>		
	</footer>

</body>
</html>