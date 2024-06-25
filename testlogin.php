<?php
session_start();
if (!isset($_POST["submit"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
  //entry
  include_once "backend/includes/conexao.php";
  $email = $_POST["email"];
  $password = $_POST["password"];

  $sql = ("SELECT * FROM users WHERE email ='$email' and password ='$password'");
  $result = $conn->query($sql);

  if (mysqli_num_rows($result) < 1) {
    header("Location: index.php");
  } else {
    $dados = mysqli_fetch_array($result);
    $_SESSION['CodUser'] = $dados['id'];
    $_SESSION['User'] = $dados['firstname'];
    header('Location: dashboard.php');
  }
} else {
  //entry
  header('Location: index.php');
}
