<?php
session_start();
require_once "backend/includes/conexao.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
    <link rel="stylesheet" href="./css/formlogin.css">
    </link>
    <script src=""></script>
</head>

<body>
    <div class="container">
        <div class="left">
            <img src="./assets/imgs/logo-removebg-preview.png" alt="logo" class="logo"><br>
            <h2>Faça o seu cadastro ou login para entrar no sistema.</h2>
        </div>
        <div>
            <form method="post" action="testlogin.php">
                <div class="box-inputs">
                    <input type="email" placeholder="E-mail do Usuário" name="email" id="email" autocomplete="off" required>
                    <input type="password" placeholder="Senha" name="password" id="password" autocomplete="off" required>
                </div>
                <div class="box-btn">
                    <div>
                        <button type="submit" class="btn-entry">Entrar</button>
                    </div><br>
                    <p>
                        Faça o seu registro caso não seja cadastrado!
                    </p>
                    <div>
                        <center><button type="submit" class="btn-new-acc" style="cursor:unset;" ><a href="register_user.php" style="text-decoration:none; color:white;">Cadastrar-se</a></button></center>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>