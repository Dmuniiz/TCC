<?php
session_start();
if(!isset($_SESSION['User'])){
    header("Location: index.php");
    exit;
}
include_once "backend/includes/conexao.php";

//LIST
$select_list = "SELECT * FROM users";
$result_select = mysqli_query($conn, $select_list);

//DELETE
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $select = "SELECT * FROM users WHERE id='$id'";
    $result_select = $conn->query($select);

    if ($result_select->num_rows > 0) {
        $delete = "DELETE FROM users WHERE id=$id";
        if (mysqli_query($conn, $delete)) {
            header('Location: usersadmin.php');
        } else {
            header('Location: 404.php');
        }
    }
}

//SEARCH
if (!empty($_GET['search'])) {
    $data = $_GET['search'];
    $select_search = "SELECT * FROM users WHERE 
    category LIKE '%$data%' 
    OR firstname LIKE '%$data%' 
    OR email LIKE '%$data%'";
    $result_select = mysqli_query($conn, $select_search);
} else {
    $select_search = "SELECT * FROM users ORDER BY id DESC";
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

            <form method="POST" action="usersadmin.php">
                <div>
                    <input type="search" id="search" name="search" placeholder="Digite o termo:" style="width: 20rem" class="form-control search-term">
                </div>

                <div>
                    <button type="button" onclick="searchData()" class="btn btn-primary search-button">
                        <span class="material-icons-outlined">search</span>Pesquisar</button>
                </div>
            </form>

            <div class="box-table">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Perfil</th>
                            <th scope="col">Usuário</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Deletar</th>
                            <th scope="col">Editar</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php
                        while ($users_data = mysqli_fetch_assoc($result_select)) { ?>
                            <tr>
                                <td style="font-weight: bold"><?php echo $users_data['category']; ?></td>
                                <td><?php echo $users_data['firstname']; ?></td>
                                <td><?php echo $users_data['email']; ?></td>
                                <td scope="col" style="display:flex;">
                                    <div>
                                        <?php echo "<a href='usersadmin.php?id=$users_data[id]'>" ?>
                                            <button type="button" class="btn btn-sm btn-outline-danger"><span class="material-icons-outlined">delete</span></button>
                                        </a>
                                    </div>
                                </td>
                                <td scope="col">

                                    <?php echo "<a href='edits/edit_users.php?id=$users_data[id]'>" ?>
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
        var search = document.getElementById('form#search');

        function searchData() {
            window.location = 'usersadmin.php?search=' + search.value;
        }
        
        search.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                searchData();
            }
        })

    </script>

</body>
</html>