<?php
include_once("/xampp/htdocs/PainelControle/backend/includes/conexao.php");

if (!empty($_GET['id'])) {
     $id = $_GET['id'];
     $select = "SELECT * FROM client WHERE id_client='$id'";
     $result_select = $conn->query($select);

     if ($result_select->num_rows > 0) {
          while ($edit_data = mysqli_fetch_assoc($result_select)) {
               $name = $edit_data['name'];
               $email = $edit_data['email'];
               $tel = $edit_data['tel'];
               $cpf = $edit_data['cpf'];
               $cep = $edit_data['cep'];
               $city = $edit_data['city'];
          }
     } else {
          header('Location: \PainelControle\clients.php');
     }
}else{
     header('Location: \PainelControle\clients.php');
}

if (isset($_POST['update'])) {
     $id = $_POST['id'];
     $name = $_POST['name'];
     $email = $_POST['email'];
     $tel = $_POST['tel'];
     $cpf = $_POST['cpf'];
     $cep = $_POST['cep'];
     $city = $_POST['city'];

     $update = "UPDATE client SET 
     name='$name', 
     email='$email', 
     tel='$tel', 
     cpf='$cpf', 
     cep='$cep', 
     city='$city' 
     WHERE id_client='$id'";

     if (mysqli_query($conn, $update)) {
          header('Location: \PainelControle\clients.php');
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
   <title>Edit Cliente</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
      <form action="edit_client.php" method="POST">
         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <label> Nome </label>
               <input type="text" name="name" id="name" class="form-control" value="<?php echo $name ?>"
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
               <label> City </label>
               <input type="text" name="city" id="city" class="form-control" value="<?php echo $city ?>"
                  autocomplete="off" required>
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
               <label> CPF </label>
               <input type="text" name="cpf" id="cpf" class="form-control" value="<?php echo $cpf ?>"
                  onkeyup="mascara_cpf()" pattern="(\d{3}\.?\d{3}\.?\d{3}-?\d{2})" minlength="14" maxlength="14"
                  autocomplete="off" required>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <label> CEP </label>
               <input type="text" name="cep" id="cep" class="form-control" onkeyup="mascara_cep()"
                  value="<?php echo $cep ?>" maxlength="9" autocomplete="off" required>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-6 offset-md-3  ">
               <input type="hidden" name="id" value="<?php echo $id ?>">
               <input type="submit" name="update" id="update" class="btn btn-success">
               <a href="\PainelControle\clients.php" class="btn btn-outline-danger">Voltar</a>
            </div>
         </div>
      </form>
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
   //valores
   function k(i) {
      var v = i.value.replace(/\D/g, '');
      v = (v / 100).toFixed(2) + '';
      v = v.replace(".", ",");
      v = v.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
      i.value = v;
   }

   //cnpj
   document.getElementById('cnpj').addEventListener('input', function(e) {
      var x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,3})(\d{0,3})(\d{0,4})(\d{0,2})/);
      e.target.value = !x[2] ? x[1] : x[1] + '.' + x[2] + '.' + x[3] + '/' + x[4] + (x[5] ? '-' + x[5] : '');
   });


   //cpf
   function mascara_cpf() {
      var cpf = document.getElementById('cpf')
      if (cpf.value.length == 3 || cpf.value.length == 7) {
         cpf.value += "."
      } else if (cpf.value.length == 11) {
         cpf.value += "-"
      }
   }

   //cep
   function mascara_cep() {
      var cep = document.getElementById('cep')
      if (cep.value.length == 5) {
         cep.value += "-"
      }
   }
   </script>

</body>
</html>