    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobtoDraft:400,100,300,500,700,900">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

        <link rel="shortcut icon" href="https://ambienteonline.uninga.br/pluginfile.php/1/theme_moove/favicon/1695711618/favicon.ico">
        <script src="https://unpkg.com/@phosphor-icons/web"></script>

        <link rel="stylesheet" href="./css/stylelogin.css">

    </head>
    <body class="login">
    <div class="pen-tittle">
        <br>
    </div>

    <div class="container">
        <div class="card"></div>
        <div class="card">
            <h1 class="title">Login</h1>
            <form  action="./web/main.php" method="post"> 
                <div class="input-container">
                <label for="usuario">Username</label>
                    <input  type="text" id="usuario" name="usuario" required="required"/>
                    <div class="bar"></div>
                </div>
                <div class="input-container">
                    <label for="senha">Password</label>
                    <input type="password" id="senha" name="senha" required="required">
                    <div class="bar"></div>
                </div>
            <div class="button-container" >
            <input type="submit" name="login_php" value="Login">
            </div>

            <div class="footer"><a href="../index.php"> <i class="ph ph-arrow-line-left"> MENU </i> </a></div>
            </form>
            

        </div>


    </body>
    </html>
