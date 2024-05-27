<?php

include_once 'psl_config.php';

function sec_session_start() {
    $session_name='sec_session_id';

    $secure = SECURE;

    // Isso impede que o JavaScript possa acessar a identificação da sessão.

    $httponly = true;

    // Assim você força a sessão a usar apenas cookies. 

    if (ini_set('session.use_only_cookies', 1)===FALSE) {
        header("Location:../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }

    // Obtém params de cookies atualizados.

    $cookieparams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
    $cookieParams["path"],
    $cookieParams["domain"],
    $secure,
    $httponly);

    // Estabelece o nome fornecido acima como o nome da sessão.

    session_name($session_name);
    session_start();   // Inicia a sessão PHP
    session_regenerate_id(); // Recupera a sessão e deleta a anterior. 
}

function login ($email,$password,$mysqli) {
    // Usando definições pré-estabelecidas significa que a injeção de SQL (um tipo de ataque) não é possível. 

    if($stmt = $mysqli->prepare("SELECT id, username, password"))
}

?>