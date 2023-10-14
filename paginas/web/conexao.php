<?php
   	
	class db {

			private $host = 'localhost';

			private $usuario = 'root';

			private $senha = '';

			private $database = 'aprendizado_on';

			public function conecta_mysql(){

				$con = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database);
				
				return $con;}

	}


?>