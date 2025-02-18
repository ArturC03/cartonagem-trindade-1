<?php
include('config.inc.php');

if (isset($_SESSION['username'])) {
	header('Location: index.php');
}else{
	if (!isset($_POST['submit'])){
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/login.css">
            <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

            <title>Login</title>
        </head>
        <body>
            <div class="container">
                <div class="content">
                    <h2>Trindade</h2>
                    <div class="text-sci">
                        <h2>Bem-vindo! <br><span>À nossa página.</span></h2>
                        <p>Aqui pode visualizar todos os dados necessários para o controlo de qualidade e monitorização dos produtos. </p>
                    </div>
                </div>
                
                <div class="line"></div>
                
                <div class="logreg-box flip-box" >
                    <div class="flip-box-inner" id="flipboxinner">

                        <div class="form-box login flip-box-front active" id="login">
                            <img class="logotrindade"src="images/trindade.png" alt="">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">                    
                                
                                <h2>Login</h2>
                                <div class="input-box">
                                    <span class="icon"><i class='bx bxs-user-circle'></i></span>
                                    <input type="email" name="username" placeholder=" " required>
                                    <label>Email</label>
                                </div>
                                
                                <div class="input-box">
                                    <span class="icon"><i class='bx bxs-lock-alt'></i></span>
                                    <input type="password" name="password" placeholder=" " required>
                                    <label>Password</label>
                                </div>
                                
                                
                                <button type="submit" class="btn" name="submit" value="Login">Iniciar Sessão</button>
                                
                                <button type="button" onclick="recuperarPass()" class="link">Esqueceste-te da tua password?</button>                    
                            </form>
                        </div>
                        
                        <div class="form-box login flip-box-back" id="recuperarPass">
                            <img class="logotrindade"src="images/trindade.png" alt="">
                            <form autocomplete="off" action="send_link.php" method="post">
                                
                                <h2>Recuperar Password</h2>
                                
                                <div class="text-sci">
                                    
                                    <p>Insere o teu e-mail para recuperares a tua conta.</p>
                                </div>
                                
                                <div class="input-box">
                                    <span class="icon"><i class='bx bxs-user-circle'></i></span>
                                    <input type="email" placeholder=" " required>
                                    <label>Email</label>
                                </div>
                                
                                <button type="submit" class="btn">Recuperar Password</button>
                            </form>
                            <button type="button" onclick="voltarLogin()" class="link">Voltar</button>
                        </div>
                    </div>
                </div>
            </div>
            
            
            
        </body>
        <script src="js/login.js"></script>
        </html>
    <?php
	} else {
		$username = $_POST['username'];
		$pass = $_POST['password'];

		$password = sha1($pass);

		$result = my_query("SELECT * from users WHERE email LIKE '{$username}' AND password LIKE '{$password}' LIMIT 1;");

		if (!count($result) == 1) {
			header("location:login.php?msg=failed");

		} else {
			$_SESSION['username']=$result[0]['email'];
			header('location: home.php');
		}
	}
}
?>