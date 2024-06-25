<?php
include_once("/xampp/htdocs/PainelControle/backend/includes/conexao.php");

if (!empty($_GET['id'])) {
   $id = $_GET['id'];
   $select = "SELECT * FROM users WHERE id='$id'";
   $result_select = $conn->query($select);

   if ($result_select->num_rows > 0) {
      while ($edit_data = mysqli_fetch_assoc($result_select)) {
         $firstname = $edit_data['firstname'];
         $lastname = $edit_data['lastname'];
         $email = $edit_data['email'];
         $tel = $edit_data['tel'];
         $category = $edit_data['category'];
      }
   } else {
      header('Location: \PainelControle\usersadmin.php');
   }
} else {
   header('Location: \PainelControle\usersadmin.php');
}

if (isset($_POST['update'])) {
   $id = $_POST['id'];
   $firstname = $_POST['firstname'];
   $lastname = $_POST['lastname'];
   $email = $_POST['email'];
   $tel = $_POST['tel'];
   $category = $_POST['category'];

   $update = "UPDATE users SET 
   firstname='$firstname', 
   lastname='$lastname',
   email='$email', 
   tel='$tel', 
   category='$category'
   WHERE id='$id'";

   if (mysqli_query($conn, $update)) {
      header('Location: \PainelControle\usersadmin.php');
   } else {
      header('Location: 404.php');
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Edit Users</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <link rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
   <style>
   :root {
      --color-white: #fff;
      --color-white2: #f1f5f8;
      --color-red: #e63636;
      --color-dark1: #181818;
      --color-dark2: #1e1e1e;
      --color-purple1: #9333FF;
      --color-purple2: indigo;
      --color-blue: #0073e4;
      --color-gray: #666666;
   }

   * {
      margin: 0;
      padding: 0;
   }

   body {
      font-family: Arial, Helvetica, sans-serif;
      background-color: var(--color-white);
      color: var(--color-dark1);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #21232d;
   }

   .container {
      background-color: var(--color-white2);
      padding: 1rem;
      border-radius: 3.5rem;
      min-width: 10%;
      overflow: auto;
      width: 50%;
      border: 1px solid var(--color-gray);
   }

   h1 {
      margin-bottom: 1rem;
      text-align: center;
   }

   .container form {
      display: flex;
      flex-direction: column;
   }

   .form-control {
      padding: 8px 5px;
      outline: none;
      border-radius: 5px;
      background-color: var(--color-white);
      border: 1px solid var(--color-dark2);
      color: var(--color-dark1);
      width: 100%;
      transition: .3s;
   }

   .form-control:focus {
      border-color: var(--color-blue);
   }
   </style>
</head>

<body>
   <div class="container ">
      <form action="edit_users.php" method="POST">
         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <label> Nome </label>
               <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo $firstname ?>"
                  pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" autocomplete="off" required>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <label> Email </label>
               <input type="email" name="email" id="email" class="form-control" value="<?php echo $email ?>"
                  pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" autocomplete="off" required>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <label> Sobrenome </label>
               <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo $lastname ?>"
                  pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" autocomplete="off" required>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <label> Telefone </label>
               <input type="text" name="tel" id="tel" class="form-control" value="<?php echo $tel ?>"
                  onkeyup="handlePhone(event)" maxlength="15" autocomplete="off" required>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <select class="form-control form-select-lg" name="category" aria-label="">
                  <option selected>
                     <?php echo $category ?>
                  </option>
                  <option value="Desenvolvedor">Desenvolvedor</option>
                  <option value="Administrador">Administrador</option>
                  <option value="Funcionario">Funcionário</option>
               </select>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-6 offset-md-3  ">
               <input type="hidden" name="id" value="<?php echo $id ?>">
               <input type="submit" name="update" id="update" class="btn btn-success">
               <a href="\PainelControle\usersadmin.php" class="btn btn-outline-danger">Voltar</a>
            </div>
         </div>
      </form>
   </div>

   <script>
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