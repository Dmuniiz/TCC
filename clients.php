<?php
session_start();
if(!isset($_SESSION['User'])){
    header("Location: index.php");
    exit;
}
include_once "backend/includes/conexao.php";

//INSERT
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //client
    $name = $_POST["name"];
    $email = $_POST["email"];
    $tel = $_POST["tel"];
    $cpf = $_POST["cpf"];

    //adress
    $cep = $_POST["cep"];
    $city = $_POST["city"];

    $insert_query = "INSERT INTO client(name, email, tel, cpf, cep, city) 
    VALUES('$name', '$email', '$tel', '$cpf', '$cep', '$city')";

    if (mysqli_query($conn, $insert_query)) {
        header('Location: #');
    } else {
        header('Location: 404.php');
    }
}

//LIST
$select_list = "SELECT * FROM client";
$result_select = mysqli_query($conn, $select_list);

//SEARCH
if (!empty($_GET['search'])) {
    $data = $_GET['search'];
    $select_search = "SELECT * FROM client WHERE 
    id_client LIKE '%$data%' 
    OR name LIKE '%$data%' 
    OR email LIKE '%$data%'";
    $result_select = mysqli_query($conn, $select_search);
} else {
    $select_search = "SELECT * FROM client ORDER BY id_client DESC";
}

//DELETE
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $select = "SELECT * FROM client WHERE id_client='$id'";
    $result_select = $conn->query($select);

    if ($result_select->num_rows > 0) {
        $delete = "DELETE FROM client WHERE id_client=$id";
        if (mysqli_query($conn, $delete)) {
            header('Location: clients.php');
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

         <form method="POST" action="clients.php">
            <div>
               <input type="search" id="search" name="search" placeholder="Digite o termo:" style="width: 20rem"
                  class="form-control search-term">
            </div>

            <div>
               <button type="button" onclick="searchData()" class="btn btn-primary search-button">
                  <span class="material-icons-outlined">search</span>Pesquisar</button>
            </div>

            <div>
               <!-- Button trigger modal -->
               <button type="button" class="btn btn-success add-new" data-bs-toggle="modal"
                  data-bs-target="#windowModalAddNewClient">
                  <span class="material-icons-outlined">add</span>Novo
               </button>

               <!-- MODAL -->
               <div id="windowModalAddNewClient" class="modal fade">
                  <div class="modal-dialog">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h3 class="modal-title">Inserir Dados</h3>
                           <button type="button" class="btn btn-close" data-bs-dismiss="modal"><span
                                 class="material-icons-outlined">close</span>Fechar</button>
                        </div>
                        <div class="modal-body">
                           <form method="POST" action="clients.php">
                              <div class="form-row">
                                 <div class="col">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nome"
                                    pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" autocomplete="off" required>
                                 </div>
                                 <div class="col">
                                    <input type="email" class="form-control" id="email" name="email"
                                       placeholder="E-mail" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$"
                                       autocomplete="off" required>
                                 </div>
                              </div><br>
                              <div class="form-row">
                                 <div class="col">
                                    <input type="text" class="form-control" id="tel" name="tel" placeholder="Telefone"
                                       onkeyup="handlePhone(event)" maxlength="15" autocomplete="off" required>
                                 </div>
                                 <div class="col">
                                    <input type="text" class="form-control" id="cpf" name="cpf" onkeyup="mascara_cpf()"
                                       placeholder="CPF: xxx.xxx.xxx-xx" pattern="(\d{3}\.?\d{3}\.?\d{3}-?\d{2})"
                                       minlength="14" maxlength="14" autocomplete="off" required>
                                 </div>
                              </div><br>
                              <div class="form-row">
                                 <div class="col">

                                    <input type="text" class="form-control" id="cep" name="cep"
                                       placeholder="CEP: xxxxx-xxx" onkeyup="mascara_cep()" maxlength="9"
                                       pattern="(\d{5}-?\d{3})" autocomplete="off" required>
                                 </div>
                                 <div class="col">
                                    <input type="text" class="form-control" id="city" name="city" placeholder="Cidade"
                                       autocomplete="off" pattern="[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$" required>
                                 </div>
                              </div><br>
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
                     <th scope="col">ID</th>
                     <th scope="col">Cliente</th>
                     <th scope="col">E-mail</th>
                     <th scope="col">Telefone</th>
                     <th scope="col">Deletar</th>
                     <th scope="col">Editar</th>
                  </tr>
               </thead>
               <tbody class="">
                  <?php
                        while ($client_data = mysqli_fetch_assoc($result_select)) { ?>
                  <tr>
                     <td><?php echo $client_data['id_client']; ?></td>
                     <td><?php echo $client_data['name']; ?></td>
                     <td><?php echo $client_data['email']; ?></td>
                     <td><?php echo $client_data['tel']; ?></td>
                     <td scope="col" style="display:flex;">
                        <div>
                           <?php echo "<a href='clients.php?id=$client_data[id_client]'>" ?>
                           <button type="button" class="btn btn-sm btn-outline-danger"><span
                                 class="material-icons-outlined">delete</span></button>
                           </a>
                        </div>
                     </td>
                     <td scope="col">

                        <?php echo "<a href='edits/edit_client.php?id=$client_data[id_client]'>" ?>
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
      window.location = 'clients.php?search=' + search.value;
   }
   </script>

   <script src="js/format.js"></script>

</body>
</html>