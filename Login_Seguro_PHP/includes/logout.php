<?php

include_once 'includes/functions.php';

sec_session_start();

//Desfaz todos os valores sessão 

$_SESSION = array();

//Obtem os parametros da sessão

$params = session_get_cookie_params();

// Deleta o cookie em uso. 

setcookie(session_name(), '', time() - 42000, $params["patch"], $params["domain"], $params["secure"], $params["httponly"]);

// Destrói a sessão 

$session_destroy();
header('Location:../index.php');