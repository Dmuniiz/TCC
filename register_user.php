<?php
session_start();
require_once "backend/includes/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $tel = $_POST["tel"];
    $category  = $_POST["category"];


    $insert_query = "INSERT INTO users(firstname, lastname, email, password, tel, category)
    VALUES ('$firstname','$lastname','$email','$password','$tel','$category')";

    if (mysqli_query($conn, $insert_query)) {
        header('Location: index.php');
    } else {
        header('Location: 404.php');
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="./css/formregister.css">
   <title>Formulário</title>
</head>

<body>
   <div class="container">
      <div class="form-image">
         <img src="./assets/imgs/undraw_shopping_re_3wst.svg" alt="">
      </div>
      <div class="form">
         <form method="POST" action="register_user.php">
            <div class="form-header">
               <div class="title">
                  <h1>Cadastre-se</h1>
               </div>
               <div class="login-button">
                  <a href="index.php">Voltar</a>
               </div>
            </div>

            <div class="input-group">
               <div class="input-box">
                  <label for="firstname">Primeiro Nome</label>
                  <input id="firstname" type="text" name="firstname" placeholder="Digite seu primeiro nome"
                     pattern="[aA-zZ]+$" autocomplete="off" required>
               </div>

               <div class="input-box">
                  <label for="lastname">Sobrenome</label>
                  <input id="lastname" type="text" name="lastname" placeholder="Digite seu sobrenome"
                     pattern="[aA-zZ]+$" autocomplete="off" required>
               </div>
               <div class="input-box">
                  <label for="email">E-mail</label>
                  <input id="email" type="email" name="email" placeholder="Digite seu e-mail"
                     pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" autocomplete="off" required>
               </div>

               <div class="input-box">
                  <label for="tel">Telefone</label>
                  <input id="tel" type="text" name="tel" placeholder="(xx) xxxxx-xxxx" onkeyup="handlePhone(event)"
                     maxlength="15" autocomplete="off" required>
               </div>

               <div class="input-box">
                   <label for="password">Senha</label>
                   <input id="password" type="password" name="password" placeholder="Digite sua senha" minlength="8"
                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" autocomplete="off" required>
                   <label for=""><i>(no mínimo uma M+m e 8 dígitos)</i></label>
                </div>

               <div class="input-box">
                  <select class="form-control form-select-lg" name="category" aria-label="" required>
                     <option selected>Nível de Acesso</option>
                     <option value="Desenvolvedor">Desenvolvedor</option>
                     <option value="Administrador">Administrador</option>
                     <option value="Funcionario">Funcionário</option>
                  </select>
               </div>

            </div>

            <div class="continue-button">
               <button type="submit">Continuar</button>
            </div>
         </form>
      </div>
   </div>
   <script type="text/javascript">
   //telefone
   const handlePhone = (event) => {
      let input = event.target
      input.value = phoneMask(input.value)
   }

   const phoneMask = (value) => {
      if (!value) return ""
      value = value.replace(/\D/g, '')
      value = value.replace(/(\d{2})(\d)/, "($1) $2")
      value = value.replace(/(\d)(\d{4})$/, "$1-$2")
      return value
   }
   </script>

</body>
</html>