<?php
include_once("/xampp/htdocs/PainelControle/backend/includes/conexao.php");

if (!empty($_GET['id'])) {
   $id = $_GET['id'];
   $select = "SELECT * FROM products WHERE id_product='$id'";
   $result_select = $conn->query($select);

   if ($result_select->num_rows > 0) {
      while ($edit_data = mysqli_fetch_assoc($result_select)) {
         $product = $edit_data['product'];
         $price = $edit_data['price'];
         $amount = $edit_data['amount'];
         $status = $edit_data['status'];
         $category = $edit_data['category'];
      }
   } else {
      header('Location: \PainelControle\products.php');
   }
} else {
   header('Location: \PainelControle\products.php');
}

if (isset($_POST['update'])) {
   $id = $_POST['id'];
   $product = $_POST['product'];
   $price = $_POST['price'];
   $amount = $_POST['amount'];
   $category = $_POST['category'];
   $status = $_POST['status'];

   $update = "UPDATE products SET 
   product='$product', 
   price='$price', 
   amount='$amount', 
   category='$category', 
   status='$status' 
   WHERE id_product='$id'";

   if (mysqli_query($conn, $update)) {
      header('Location: \PainelControle\products.php');
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
   <title>Edit Produto</title>
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
      <form action="edit_product.php" method="POST">
         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <label> Nome do Produto </label>
               <input type="text" name="product" id="product" class="form-control" value="<?php echo $product ?>"
                  autocomplete="off" required>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <label> Preço </label>
               <input type="text" name="price" id="price" class="form-control" onkeyup="k(this);"
                  value="<?php echo $price ?>" autocomplete="off" required>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <label> Quantidade </label>
               <input type="number" name="amount" id="amount" class="form-control" value="<?php echo $amount ?>"
                  autocomplete="off" required>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-6 offset-md-3">
               <select class="form-control form-select-lg" name="status" id="status">
                  <option selected><?php echo $status ?></option>
                  <option value="Ativo">Ativo</option>
                  <option value="Inativo">Inativo</option>
               </select>
            </div><br>
            <div class="col-md-6 offset-md-3">
               <select class="form-control form-select-lg" name="category" id="category">
                  <option selected><?php echo $category ?></option>
                  <?php 
                        $select_option = "SELECT DISTINCT category FROM products";
                        $result_select_option = mysqli_query($conn, $select_option);
                        while ($product_option = mysqli_fetch_assoc($result_select_option)) {
                  ?>
                  <option><?php echo $product_option['category']; ?></option>
                  <?php } ?>
               </select>
            </div>
         </div>
         <div class="form-group">
            <div class="col-md-6 offset-md-3  ">
               <input type="hidden" name="id" value="<?php echo $id ?>">
               <input type="submit" name="update" id="update" class="btn btn-success">
               <a href="\PainelControle\products.php" class="btn btn-outline-danger">Voltar</a>
            </div>
         </div>
      </form>
   </div>

   <script type="text/javascript">
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