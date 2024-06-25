<?php
include_once("/xampp/htdocs/PainelControle/backend/includes/conexao.php");

if (!empty($_GET['id'])) {
   $id = $_GET['id'];
   $select = "SELECT * FROM request WHERE id_req='$id'";
   $result_select = $conn->query($select);

   if ($result_select->num_rows > 0) {
      while ($edit_data = mysqli_fetch_assoc($result_select)) {
         $number_req = $edit_data["number_req"];
         $city = $edit_data["city"];
         $amount_piece = $edit_data["amount_piece"];
         $amount_product = $edit_data["amount_product"];
         $value_order  = $edit_data["value_order"];
         $status  = $edit_data["status"];
      }
   } else {
      header('Location: \PainelControle\requests.php');
   }
} else {
   header('Location: \PainelControle\requests.php');
}

if (isset($_POST['update'])) {
   $id = $_POST['id'];
   $number_req = $_POST["number-req"];
   $city = $_POST["city"];
   $amount_piece = $_POST["amount-piece"];
   $amount_product = $_POST["amount-product"];
   $value_order  = $_POST["value-order"];
   $status  = $_POST["status"];

   $update = "UPDATE request SET 
   number_req='$number_req', 
   value_order='$value_order', 
   amount_piece='$amount_piece', 
   amount_product='$amount_product', 
   city='$city', 
   status='$status' 
   WHERE id_req='$id'";

   if (mysqli_query($conn, $update)) {
      header('Location: \PainelControle\requests.php');
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
   <title>Edit Fornecedor</title>
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
      <form action="edit_req.php" method="POST">
         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <label> N° Pedido </label>
               <input type="number" name="number-req" id="number-req" class="form-control" autocomplete="off"
                  value="<?php echo $number_req ?>" required>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <label> Cidade/UF </label>
               <input type="text" name="city" id="city" class="form-control" autocomplete="off"
                  value="<?php echo $city ?>" pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" required>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <label> Valor do Pedido (R$) </label>
               <input type="text" name="value-order" id="value-order" class="form-control" autocomplete="off"
                  onkeyup="k(this);" value="<?php echo $value_order ?>" required>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <label> Produtos </label>
               <input type="number" name="amount-product" id="amount-product" class="form-control" autocomplete="off"
                  value="<?php echo $amount_product ?>" required>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <label> Quantidade de Peças</label>
               <input type="number" name="amount-piece" id="amount-piece" class="form-control" autocomplete="off"
                  value="<?php echo $amount_piece ?>" required>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <label> Status </label>
               <select class="form-control form-select-lg" name="status" id="status">
                  <option selected><?php echo $status ?></option>
                  <option value="Aguardando">Aguardando</option>
                  <option value="Pendente">Pendente</option>
                  <option value="Despachado">Despachado</option>
                  <option value="Devolvido">Devolvido</option>
                  <option value="Cancelado">Cancelado</option>
               </select>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-6 offset-md-3  ">
               <input type="hidden" name="id" value="<?php echo $id ?>">
               <input type="submit" name="update" id="update" class="btn btn-success">
               <a href="\PainelControle\requests.php" class="btn btn-outline-danger">Voltar</a>
            </div>
         </div>
      </form>
   </div>

   <script>
   //valores
   function k(i) {
      var v = i.value.replace(/\D/g, '');
      v = (v / 100).toFixed(2) + '';
      v = v.replace(".", ",");
      v = v.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
      i.value = v;
   }
   </script>

</body>
</html>