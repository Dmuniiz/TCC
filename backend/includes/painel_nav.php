<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/sidebarnav.css">
    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>
<body>
      <!-- Header -->
      <header class="header">
        <div class="menu-icon" onclick="openSidebar()">
          <span class="material-icons-outlined">menu</span>
        </div>
        <div class="sidebar-brand">
          <span class="material-icons-outlined"></span>Motor Control
        </div>
      </header>
      <!-- End Header -->

      <!-- Sidebar -->
      <aside id="sidebar">
        <div class="sidebar-title">
          <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
        </div>

        <ul class="sidebar-list">
          <li class="sidebar-list-item">
            <a href="./dashboard.php">
              <span class="material-icons-outlined">dashboard</span> Dashboard
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="./clients.php">
              <span class="material-icons-outlined">fact_check</span> Clientes
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="./products.php">
              <span class="material-icons-outlined">token</span> Produtos
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="./requests.php">
              <span class="material-icons-outlined">shopping_cart</span> Pedidos 
            </a>
          </li>  
          <li class="sidebar-list-item">
            <a href="./usersadmin.php">
              <span class="material-icons-outlined">person</span> Usuários
            </a>
          </li> 
          <li class="sidebar-list-item">
            <a href="./provider.php">
              <span class="material-icons-outlined">real_estate_agent</span>Fornecedores
            </a>
          </li> 
          <li class="sidebar-list-item">
            <a href="/PainelControle/logout.php">
              <span class="material-icons-outlined">logout</span> Sair
            </a>
          </li>
        </ul>
      </aside>

    <script src="js/indexScriptPainelNav.js"></script>
</body>
</html>