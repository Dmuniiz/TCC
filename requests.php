<?php
session_start();
if(!isset($_SESSION['User'])){
   header("Location: index.php");
   exit;
}
include_once "backend/includes/conexao.php";

//INSERT
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   $number_req = $_POST["number-req"];
   $city = $_POST["city"];
   $amount_piece = $_POST["amount-piece"];
   $amount_product = $_POST["amount-product"];
   $value_order  = $_POST["value-order"];
   $status  = $_POST["status"];

   $insert_query = "INSERT INTO request (number_req, city, amount_piece, amount_product, value_order, status) 
   VALUES('$number_req', '$city', '$amount_piece', '$amount_product', '$value_order', '$status')";

   if (mysqli_query($conn, $insert_query)) {
      header('Location: #');
   } else {
      header('Location: 404.php');
   }
}

//LIST
$select_list = "SELECT * FROM request";
$result_select = mysqli_query($conn, $select_list);

//SEARCH
if (!empty($_GET['search'])) {
   $data = $_GET['search'];
   $select_search = "SELECT * FROM request WHERE 
   id_req LIKE '%$data%' 
   OR number_req LIKE '%$data%' 
   OR city LIKE '%$data%' 
   OR status LIKE '%$data%' 
   OR value_order LIKE '%$data%'" ;
   $result_select = mysqli_query($conn, $select_search);
} else {
   $select_search = "SELECT * FROM request ORDER BY id_req DESC";
}

//DELETE
if (!empty($_GET['id'])) {
   $id = $_GET['id'];
   $select = "SELECT * FROM request WHERE id_req='$id'";
   $result_select = $conn->query($select);

   if ($result_select->num_rows > 0) {
      $delete = "DELETE FROM request WHERE id_req=$id";
      if (mysqli_query($conn, $delete)) {
         header('Location: requests.php');
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
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
   <link rel="stylesheet" href="css/stylescrud.css">
</head>

<body>
   <div class="grid-container">
      <?php include('backend/includes/painel_nav.php'); ?>
      <main class="main-container">
         <p>Digite o termo abaixo e selecione uma opção para sua consulta</p>

         <form method="POST" action="requests.php">
   
            <div class="status-select-category">
               <select class="form-control form-select-lg select-category" style="width: 20rem" name="status" id="status">
                  <option value="" selected>Selecionar Remessa</option>
                  <option value="Pendente">Pendente</option>
                  <option value="Aguardando">Aguardando</option>
                  <option value="Despachado">Despachado</option>
                  <option value="Devolvido">Devolvido</option>
                  <option value="Cancelado">Cancelado</option>
               </select>
            </div>

            <div>
               <button type="button" onclick="searchData()" class="btn btn-primary search-button">
                  <span class="material-icons-outlined">search</span>Pesquisar</button>
            </div>


            <div class="modal-new">
               <button type="button" class="btn btn-success add-new" data-bs-toggle="modal" data-bs-target="#windowModalAddNewClient">
                  <span class="material-icons-outlined">add</span>Novo
               </button>

               <div id="windowModalAddNewClient" class="modal fade">
                  <div class="modal-dialog">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h3 class="modal-title">Inserir Dados</h3>
                           <button type="button" class="btn btn-close" data-bs-dismiss="modal"><span class="material-icons-outlined">close</span>Fechar</button>
                        </div>
                        <div class="modal-body">
                           <form method="POST" action="requests.php">
                              <div class="form-row">
                                 <div class="col">
                                    <input type="number" class="form-control" id="number-req" name="number-req" placeholder="N°Pedido" autocomplete="off" required>
                                 </div>
                              </div><br>
                              <div class="form-row">
                                 <div class="col">
                                    <input type="number" class="form-control" id="amount-product" name="amount-product" placeholder="Quantidade de Produtos" autocomplete="off" required>
                                 </div>
                                 <div class="col">
                                    <input type="number" class="form-control" id="amount-piece" name="amount-piece" placeholder="Quantidade de Peças" autocomplete="off" required>
                                 </div>
                              </div><br>
                              <div class="form-row">
                                 <div class="col">
                                    <input type="text" class="form-control" id="city" name="city" placeholder="Cidade/UF" pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" autocomplete="off" required>
                                 </div>
                                 <div class="col">
                                    <input type="text" class="form-control" id="value-order" name="value-order" placeholder="Valor do Pedido(R$)" onkeyup="k(this);" autocomplete="off" required>
                                 </div>
                              </div><br>

                              <div class="form-row">
                                 <div class="col">
                                    <select class="form-control form-select-lg" name="status" id="status">
                                       <option selected>Selecionar Remessa</option>
                                       <option value="Aguardando">Aguardando</option>
                                       <option value="Pendente">Pendente</option>
                                       <option value="Despachado">Despachado</option>
                                       <option value="Devolvido">Devolvido</option>
                                       <option value="Cancelado">Cancelado</option>
                                    </select>
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
                     <th scope="col">N°Pedido</th>
                     <th scope="col">Valor do Pedido</th>
                     <th scope="col">Cidade/UF</th>
                     <th scope="col">Status</th>
                     <th scope="col">Deletar</th>
                     <th scope="col">Editar</th>
                  </tr>
               </thead>
               <tbody>
                  <!--modal BODY-->
                  <?php
                  while ($req_data = mysqli_fetch_assoc($result_select)) { ?>
                     <tr>
                        <td><?php echo $req_data['number_req']; ?></td>
                        <td><?php echo $req_data['value_order']; ?></td>
                        <td><?php echo $req_data['city']; ?></td>
                        <td><?php
                              if ($req_data['status'] == "Aguardando") {
                                 echo "<span style='color: green;text-transform: uppercase;'>Aguardando</span>";
                              } elseif ($req_data['status'] == "Pendente") {
                                 echo "<span style='color: orange;text-transform: uppercase;'>Pendente</span>";
                              } elseif ($req_data['status'] == "Despachado") {
                                 echo "<span style='color: purple;text-transform: uppercase;'>Despachado</span>";
                              } elseif ($req_data['status'] == "Devolvido") {
                                 echo "<span style='color: blue;text-transform: uppercase;'>Devolvido</span>";
                              } elseif ($req_data['status'] == "Cancelado") {
                                 echo "<span style='color: red;text-transform: uppercase;'>Cancelado</span>";
                              }
                              ?>
                        </td>
                        <td scope="col" style="display:flex;">
                           <div>
                              <?php echo "<a href='requests.php?id=$req_data[id_req]'>" ?>
                              <button type="button" class="btn btn-sm btn-outline-danger"><span class="material-icons-outlined">delete</span></button>
                              </a>
                           </div>
                        </td>
                        <td scope="col">
                           <?php echo "<a href='edits/edit_req.php?id=$req_data[id_req]'>" ?>
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


   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
   </script>

   <script type="text/javascript">
      var select = document.getElementById('status')

      select.addEventListener('keydown', function(event){
            searchData();
      })

      function searchData() {
         window.location = 'requests.php?search=' + select.value;
      }



   </script>
   <script src="js/format.js"></script>

</body>
</html>