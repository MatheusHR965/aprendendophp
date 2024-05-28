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

    if($stmt = $mysqli->prepare("SELECT id, username, password, salt 
    FROM members WHERE email = ? LIMIT 1")) {

        $stmt->bind_param('s', $email);// Relaciona  "$email" ao parâmetro.
        $stmt->execute(); // Executa a tarefa estabelecida.
        $stmt->store_result();

        //obtem variaveis a partir dos resultados.

        $stmt->bind_result($user_id, $username, $db_password, $salt);
        $stmt->fetch();

        //Faz o hash da senha com um salt exclusivo.

        $password=hash('sha512', $password . $salt);

        if ($stmt->num_rows==1){
            //caso o usuario exista, conferimos se a conta está bloqueada.
            //devido ao limite de tentativas de login ter sido ultrapassada

            if (checkbrute($user_id, $mysqli)==true) {
                // A conta está bloqueada
                //Envia um email ao usuario informado que esta bloqueada

                return false(falso);
            }
            else {
                //Verifica se a senha confere com o que esta no banco de dados
                //A senha do usuario é enviada.

                if($db_password == $password) {
                    //A senha esta correta!
                    //obtem o string usuário-agente do usuario.

                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    //proteção XSS conforme imprimimos este valor 

                    $user_id = preg_replace("/[^a-zA-ZO-9_\-]+/",
                                    "",
                                    $username);
                $_SESSION['username'] = $username;
                $_SESSION['login_string']=hash('sha512',
                    $password . $user_browser);

                return true;

                }
            }

        } else {
            //tall usuário não existe
            return false;
        }
        //registrar a hora atual 
        $now = time();

        //todas as tentativas de login são contadas dentro do intervalo das ultimas 2 horas.

        $valid_attempts = $now - (2*60*60);

        if ($stmt = $mysqli -> prepare("SELECT time FROM login_attempts <code><pre> 
        WHERE user_id = ? AND time > '$valid_attempts'")) {

            $stmt -> bind_param('i',$user_id);

        //execute a tarefa pré-estabelecida.
        $stmt->execute();
        $stmt->store_result();

        //se houver mais do que 5 tentativas fracassadas de login

        if ($stmt -> num_rows > 5) {

            return true;
        
        } else {

            return false;
        }

        function login_check($mysqli) {

            //Verificar se todas as variaveis das sesssoe foram definidas 
        
            if(isset($_SESSION['user_id'],
            $_SESSION['username'],
            $_SESSION['login_string'])) {
        
            $user_id = $_SESSION['user_id'];
            $login_string = $_SESSION['login_string'];
            $username = $_SESSION['username'];
        
            //pega a string do usuario
        
            $user_browser = $_SERVER['HTTP_USER_AGENT'];
        
            if($stmt = $mysqli -> prepare("SELECT password FROM members WHERE id = ? LIMIT 1")) {
                //Atribui "$user_id" ao parâmetro.
        
                $stmt->bind_param('i', $user_id);
                $stmt->execute(); //Execute o prepare query
                $stmt->store_result();
        
                if($stmt->num_rows == 1) {
        
                    //Caso o usuario exista, pega variaveis a partir do resultado.
        
                $stmt -> bind_result($password);
        
                $stmt -> fetch();
                $login_check = hash('sha512', $password. $user_browser);

                if($login_check == $login_string) {
                    //Login Pronto!!
                    return true;
                    
                } else {
                    //Não foi logado
                    return false;
                }
        
                } else {
                    //Não foi logado
                    return false;
                }
            } else {
                //Não foi logado
                return false;
            }
            } else {
                //Não foi logado
                return false;
            }
        } 
        }
     }
}

function esc_url($url) {

    if('' == $url) {

        return $url;

    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

    $strip = array('%0d', '%0a', '%0D', '%0A');
    while($count) {
        $url = str_replace($strip,'',$url, $count);
    }

    $url = str_replace(';//','://',$url);

    $url = htmlentities($url);

    $url = str_replace('&amp;',$url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0]!=='/') {
        //Estamos interessados somente em links relacionados provenientes de $_SERVER['PHP_SELF']

        return '';

    }else {
        return $url;
    }
}
?>