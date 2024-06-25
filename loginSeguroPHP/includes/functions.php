<?php

include_once 'psl_config.php';

function sec_session_start()
{

$session_name = 'sec_session_id'; // estabeleça um nome personalizado para a sessao

$secure = SECURE;

//isso impede que o javascript possa acessar a identificação da sessão.

$httponly = true;

// Assim voce força a sessão a usar apenas cookies.

if (ini_set('session.use_only_cookies',1) === FALSE) {

    header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
    exit();

}

// Obtem params de cookies atualizados.

$cookieParams = session_get_cookie_params();

session_set_cookie_params($cookieParams["lifetime"],

    $cookieParams["path"],
    $cookieParams["domain"],
    $secure,
    $httponly);

// estabelece o nome fornecido acima como o nome da sessão.

    session_name($session_name);
    session_start(); //Inicia a sessão PHP
    session_regenerate_id(); //recupera a sessao e deleta a anterior.

}

function login($email, $password, $mysqli){

// usando definiçoes pré-estabelecidas significa qua a injeção de sql
//(um tipo de ataque) não é possivel.

if($stmt = $mysqli->prepare("SELECT id, username, password, salt FROM members WHERE email = ? LIMIT 1")){

    $stmt->bind_param("s", $email); // relaciona "$email" ao parametro.
    $stmt->execute(); //executa a tarefa estabelecida
    $stmt->store_result();

// obtem variaveis a partir dos resultados.

    $stmt->bind_result($user_id, $username, $db_password, $salt);
    $stmt->fetch();

// faz o hash da senha com um salt exclusivo.
    $password = hash('sha512', $password .$salt);
    if ($stmt->num_rows == 1) {

        // caso o usuario exista, conferimos se a conta esta bloqueada
        // devido ao limite de tentativas de login ter sido ultrapassado

    if (checkbrute($user_id, $mysqli) == true) {

        // a conta esta bloqueada
        //envia um email ao usuario informado que a conta esta bloqueada

    return false;

    } 

    else{

        // Verifica se a senha confere com o que consta no banco de dados
         // a senha do usuario é enviada.

    if ($db_password == $password) {
     // a senha esta correta!
    // obtem o string usuario-agente do usuario.

        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        // proteção XSS conforme imprimimos este valor

        $user_id = preg_replace("/[^0-9]+/", "",$user_id);

        $_SESSION['user_id'] = $user_id;

        // proteção XSS conforme imprimimos este valor

        $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);

        $_SESSION["username"] = $username;

        $_SESSION['login_string'] = hash('sha512', $password .$user_browser);

        // Login concluido com sucesso.
        return true;

        }
        else {
            // A senha não esta correta 
            // Registramos essta tentativa no banco de dados
            $now = time();
            $mysqli->query("INSERT INTO login_attempts(user_id, time) values ('$user_id', '$now')");
            return false;
            }
        }

        }
        
        else {

        // Tal usuário não existe.
         return false;

        }
    }
}

function checkbrute($user_id, $mysqli) {

// Registra a hora atual

$now = time();

// Todas as tentativas de login são contadas dentro do intervalo das últimas 2 horas

$valid_attempts = $now - (2 * 60 * 60);

if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) {
    $stmt->bind_param('i', $user_id);

    // executa a tarefa pré-estabelecida.

    $stmt->execute();
    $stmt->store_result();

    // se houve mais do que 5 tentativas fracassadas de login
    if ($stmt->num_rows > 5) {

        return true;
        } 

        else {

            return false;

        }
    }
}

function login_check($mysqli) {

// Verifica se todas as variaveis das sessoes foram definidas

if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {

    $user_id = $_SESSION['user_id'];
    $login_string = $_SESSION['login_string'];
    $username = $_SESSION['username'];

    // Pega a string do usuario.
    $user_browser= $_SERVER['HTTP_USER_AGENT'];

    if ($stmt = $mysqli->prepare("SELECT password FROM members WHERE id = ? LIMIT 1")) {

        // Atribui "$user_id" ao parametro.

        $stmt->bind_param('i', $user_id);
        $stmt->execute(); //Executa uma query
        $stmt->store_result();

    if ($stmt->num_rows == 1) {

        // Caso o usuario exista, pega variaveis a partir do resultado.
    $stmt->bind_result($password);
                
    $stmt->fetch();

        $login_check = hash('sha512',$password.$user_browser);

    if ($login_check == $login_string) {

    // Logado!!!
    return true;

    } 
    else {
                    
        // Nao foi logado
        return false;

    }
    } 
    
    else {

    // Nao foi logado
    return false;

    } 
    } 
    
    else {

        // Nao foi logado

        header("Location: ../error.php?err=Database error: cannot prepare statement");
        exit();

        } 
    } 
    
    else {

        //Nao foi logado
        return false;

    }
}

function esc_url($url) {

if ('' == $url) {

    return $url;

}

$url =  preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

$strip = array('%0d','%0a','%0D','%0A');
$url = (string) $url;


   $count = 1;
while ($count) {

    $url = str_replace($strip, "",$url,$count);

}

$url = str_replace(';//','://', $url);

$url = htmlentities($url);


$url = str_replace('&amp;', '&#038;', $url);
$url = str_replace("'", '&#039;', $url);

if ($url[0] !== '/') {

// Estamos interessados em links relacionados provenientes de 
 // $_SERVER['PHP_SELF']

return '';

    } 

    else {

    return $url;

    }
}