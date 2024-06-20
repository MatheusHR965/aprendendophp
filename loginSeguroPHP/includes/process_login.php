<?php

include_once 'db_connect.php';
include_once 'functions.php';

sec_session_start(); // Nossa segurança personalizada para iniciar uma sessao php.

if (isset($_POST['email'], $_POST['p'])) {

$email = $_POST['email'];
$password = $_POST['p']; // The Hashed password.

if (login($email, $password, $mysqli) == true) {

// Login com sucesso
header('Location: ../protected_page.php');

} 

else {

// Falha de Login
header('Location: ../index.php?error=1');

}
} 

else {

// As variaveis POST corretas nao foram enviadas para esta pagina.
echo 'Invalid Request';

}