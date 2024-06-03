<?php

include_once 'psl_config.php';

function sec_session_start() {
    $session_name = 'sec_session_id'; //set a custon session name
    $secure = SECURE;

    // This stops JavaScript being able to access the session id.
    $httponly = true;

    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not iitiate a safe session (ini_set)");
        exit();
    }

     // Gets current cookies params.
     $cookieParams = session_get_cookie_params();
     session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);

     // set the session name to the one set above.
     session_name($session_name);

     session_start();
     session_regenerate_id();
}

function login($email, $password, $mysqli) {
    //Using prepared startements means tha SQL injection is not possible.
    if ($stmt = $mysqli->prepare("SELECT id, username, password, salt FROM members WHERE email = ? LIMIT 1")) {
        $stmt->bind_param('s', $email);
        $stmt->fetch();

        //hash the password witch the unique salt.
        $password = hash('sha512', $password . $salt);

    if ($stmt->num_rows == 1) {
         // If the user exists we check if the account is locked
        // from too many login attempts 
        if ($db_password == $password) {
            // Password is correct!
            // Get the user-agent string of the user.
            $user_browser = $_SERVER['HTTP_USER_AGENT'];

        // XSS protection as we might print this value
        $user_id = preg_replace("/[^0-9]+/", "", $user_id);
        $_SESSION['user_id'] = $user_id;

        // XSS protection as we might print this value
        $username = preeg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);

        $_SESSION['username'] = $username;
        $_SESSION['login_string'] = hash('sha512', $password . $user_browser);

        // Login successful.

        return true;

        } else {
            // Password is not correct 
            // We record this attempt in the database 

            $now = time();
            if (!$mysqli->query("INSERT INTO login_attempts(user_id, time) VALUES ('$user_id', '$now')")) {
                header("Location: ../error.php?err=Database error: login_attempts");
                exit();
            }
            return false;
        }
    }
    }else{
        // No user exists. 
        return false;
    }
}

function esc_url($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
    
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
    
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
    
    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);
    
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}
?>