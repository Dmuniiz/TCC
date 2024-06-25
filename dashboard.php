<?php
session_start();
if(!isset($_SESSION['User'])){
   header("Location: index.php");
   exit;
}
require_once "backend/includes/conexao.php";


//CLIENT
$select_count_client = "SELECT COUNT(id_client) AS qnt_client FROM client";
$count_client = mysqli_query($conn, $select_count_client);
$res_client = mysqli_fetch_assoc($count_client);

//USERS
$select_count_user = "SELECT COUNT(id) AS qnt_users FROM users";
$count_user = mysqli_query($conn, $select_count_user);
$res_user = mysqli_fetch_assoc($count_user);

//CLIENT
$select_count_provider = "SELECT COUNT(id_provider) AS qnt_provider FROM providers";
$count_provider = mysqli_query($conn, $select_count_provider);
$res_provider = mysqli_fetch_assoc($count_provider);

//REQ
$select_count_req = "SELECT COUNT(id_req) AS qnt_req FROM request";
$count_req = mysqli_query($conn, $select_count_req);
$res_req = mysqli_fetch_assoc($count_req);

//PRODUCTS
$select_count_product = "SELECT COUNT(id_product) AS qnt_product FROM products";
$count_product = mysqli_query($conn, $select_count_product);
$res_product = mysqli_fetch_assoc($count_product);

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width,initial-scale=1.0">
   <title>Admin Dashboard</title>

   <!-- Montserrat Font -->
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

   <!-- Material Icons -->
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="./css/dashboard.css">
</head>

<body>
   <div class="grid-container">
      <?php include('backend/includes/painel_nav.php'); ?>
      <!-- Main -->
      <main class="main-container">
         <div class="main-title">
            <p class="font-weight-bold">PAINEL DE CONTROLE</p>
         </div>

         <div class="main-cards">

            <div class="card">
               <div class="card-inner">
                  <p class="text-primary">Clientes</p>
                  <span class="material-icons-outlined text-blue">inventory_2</span>
               </div>
               <span class="text-primary font-weight-bold"><?php echo $res_client['qnt_client']; ?></span>
            </div>

            <div class="card">
               <div class="card-inner">
                  <p class="text-primary">Produtos</p>
                  <span class="material-icons-outlined text-orange">add_shopping_cart</span>
               </div>
               <span class="text-primary font-weight-bold"><?php echo $res_product['qnt_product']; ?></span>
            </div>

            <div class="card">
               <div class="card-inner">
                  <p class="text-primary">Pedidos</p>
                  <span class="material-icons-outlined text-green">shopping_cart</span>
               </div>
               <span class="text-primary font-weight-bold"><?php echo $res_req['qnt_req']; ?></span>
            </div>

            <div class="card">
               <div class="card-inner">
                  <p class="text-primary">Usuários</p>
                  <span class="material-icons-outlined text-red">person</span>
               </div>
               <span class="text-primary font-weight-bold"><?php echo $res_user['qnt_users']; ?></span>
            </div>

            <div class="card">
               <div class="card-inner">
                  <p class="text-primary">Fornecedores</p>
                  <span class="material-icons-outlined text-purple">real_estate_agent</span>
               </div>
               <span class="text-primary font-weight-bold"><?php echo $res_provider['qnt_provider']; ?></span>
            </div>
         </div>
      </main>
      <!-- End Main -->
   </div>
</body>
</html>