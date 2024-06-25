<?php
    $host = "localhost";
    $user = "root";
    $pass = "Egv&2w6w2";
    $dbname = "controle_estoque";

    $conn = new mysqli($host, $user, $pass, $dbname);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

?>
