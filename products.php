<?php
session_start();
include_once "backend/includes/conexao.php";

//INSERT
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   $product = $_POST["product"];
   $price = $_POST["price"];
   $amount = $_POST["amount"];
   $category = $_POST["select-category"];
   $status = $_POST["status"];

   $insert_query = "INSERT INTO products(product, price, amount, category, status) 
    VALUES('$product', '$price', '$amount', '$category', '$status')";

   if (mysqli_query($conn, $insert_query)) {
      header('Location: #');
   } else {
      header('Location: 404.php');
   }
}

//LIST
$select_list = "SELECT * FROM products";
$result_select = mysqli_query($conn, $select_list);

//SEARCH
if (!empty($_GET['search'])) {
   $data = $_GET['search'];
   $select_search = "SELECT * FROM products WHERE 
   product LIKE '%$data%' 
   OR amount LIKE '%$data%' 
   OR status LIKE '%$data%' 
   OR category LIKE '%$data%'";
   $result_select = mysqli_query($conn, $select_search);
} else {
   $select_search = "SELECT * FROM products ORDER BY id_product DESC";
}

//DELETE
if (!empty($_GET['id'])) {
   $id = $_GET['id'];
   $select = "SELECT * FROM products WHERE id_product='$id'";
   $result_select = $conn->query($select);

   if ($result_select->num_rows > 0) {
      $delete = "DELETE FROM products WHERE id_product=$id";
      if (mysqli_query($conn, $delete)) {
         header('Location: products.php');
      } else {
         header('Location: 404.php');
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Dashboard</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <link rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
   <link rel="stylesheet" href="css/stylescrud.css">
</head>

<body>
   <div class="grid-container">
      <?php include('backend/includes/painel_nav.php'); ?>
      <main class="main-container">
         <p>Digite o termo abaixo e selecione uma opção para sua consulta</p>

         <form method="POST" action="products.php">
            <div>
               <input type="search" id="search" name="search" placeholder="Digite o termo:" style="width: 20rem"
                  class="form-control search-term">
            </div>

            <div class="modal-new-category">
               <button type="button" name="button-new-category" id="button-new-category"
                  class="btn btn-warning search-button" onclick="sendOption()">
                  <span class="material-icons-outlined">add</span>Nova Categoria
               </button>

            </div>

            <div>
               <button type="button" onclick="searchData()" class="btn btn-primary search-button">
                  <span class="material-icons-outlined">search</span>Pesquisar</button>
            </div>


            <div class="modal-new">
               <button type="button" class="btn btn-success add-new" data-bs-toggle="modal"
                  data-bs-target="#windowModalAddNewClient">
                  <span class="material-icons-outlined">add</span>Novo
               </button>

               <div id="windowModalAddNewClient" class="modal fade">
                  <div class="modal-dialog">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h3 class="modal-title">Inserir Dados</h3>
                           <button type="button" class="btn btn-close" data-bs-dismiss="modal"><span
                                 class="material-icons-outlined">close</span>Fechar</button>
                        </div>
                        <div class="modal-body">
                           <form method="POST" action="products.php">
                              <div class="form-row">
                                 <div class="col">
                                    <input type="text" class="form-control" id="product" name="product"
                                       placeholder="Nome do Produto"
                                       pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" autocomplete="off" required>
                                 </div>
                                 <div class="col">
                                    <input type="text" class="form-control" id="price" name="price"
                                       placeholder="Preço do Produto" onkeyup="k(this);" autocomplete="off" required>
                                 </div>
                              </div><br>
                              <div class="form-row">
                                 <div class="col">
                                    <select class="form-control form-select-lg" name="status" id="status" required>
                                       <option selected>Status</option>
                                       <option value="Ativo">Ativo</option>
                                       <option value="Inativo">Inativo</option>
                                    </select>
                                 </div>
                                 <div class="col">
                                    <select class="form-control form-select-lg" name="select-category"
                                       autocomplete="off" id="select-category">
                                       <?php 
                                          $select_option = "SELECT DISTINCT category FROM products";
                                          $result_select_option = mysqli_query($conn, $select_option);
                                          while ($product_option = mysqli_fetch_assoc($result_select_option)) {
                                       ?>
                                       <option><?php echo $product_option['category']; 
                                          if($product_option['category'] == 'null'){
                                             echo '';
                                          }
                                       ?></option>
                                       <?php } ?>
                                    </select>
                                 </div>
                              </div><br>
                              <div class="form-row">
                                 <div class="col">
                                    <input type="number" class="form-control" id="amount" name="amount"
                                       placeholder="Quantidade do Produto" autocomplete="off" required>
                                 </div>
                              </div>
                           </form>
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-info"><span class="material-icons-outlined">token</span>
                              Cadastrar</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

         </form>

         <div class="box-table">
            <table class="table">
               <thead class="thead-light">
                  <tr>
                     <th scope="col">Produto</th>
                     <th scope="col">Categoria</th>
                     <th scope="col">Preço</th>
                     <th scope="col">Status</th>
                     <th scope="col">Quantidade</th>
                     <th scope="col">Deletar</th>
                     <th scope="col">Editar</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  while ($product_data = mysqli_fetch_assoc($result_select)) { ?>
                  <tr>
                     <td><?php echo $product_data['product']; ?></td>
                     <td><?php echo $product_data['category']; ?></td>
                     <td><?php echo $product_data['price']; ?></td>
                     <td><?php 
                              if($product_data['status'] == "Ativo") { 
                                 echo "<span style='color: green;text-transform: uppercase;'>Ativo</span>";
                              }else{
                                 echo "<span style='color: red;text-transform: uppercase;'>Inativo</span>";
                              }
                           ?>
                     </td>
                     <td><?php echo $product_data['amount']; ?></td>
                     <td scope="col" style="display:flex;">
                        <div>
                           <?php echo "<a href='products.php?id=$product_data[id_product]'>" ?>
                           <button type="button" class="btn btn-sm btn-outline-danger"><span
                                 class="material-icons-outlined">delete</span></button>
                           </a>
                        </div>
                     </td>
                     <td scope="col">
                        <?php echo "<a href='edits/edit_product.php?id=$product_data[id_product]'>" ?>
                        <button class='btn btn-sm btn-warning'>
                           <span class='material-icons-outlined'>edit</span>
                        </button>
                        </a>
                     </td>
                  </tr>
                  <?php } ?>
               </tbody>
            </table>
         </div>
      </main>
   </div>


   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
   </script>

   <script type="text/javascript">
   var search = document.getElementById('search');

   search.addEventListener("keydown", function(event) {
      if (event.key === "Enter") {
         searchData();
      }
   })

   function searchData() {
      window.location = 'products.php?search=' + search.value;
   }


   function sendOption() {
      var option = prompt("Insira o nome da nova categoria: ")

      var newOption = document.createElement('option');
      var optionTextNode = document.createTextNode(option);

      newOption.appendChild(optionTextNode)
      newOption.setAttribute('value', option);
      newOption.setAttribute.value = option

      var select = document.getElementById('select-category');
      select.appendChild(newOption)

      if (newOption == null) {
         newOption = ''
      }
   }
   </script>
   <script src="js/format.js"></script>
</body>
</html>