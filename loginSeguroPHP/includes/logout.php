<?php

include_once 'functions.php';

sec_session_start();

// Desfaz todos os valores da sessao
$_SESSION = array();

// obtem os parametros da sessao
$params = session_get_cookie_params();

// Deleta o cookie em uso.
setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

// Destroi a sessao

session_destroy();
header('Location: ../index.php');