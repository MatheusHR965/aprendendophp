<?php

$error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);

if (!$error) {   

    $error = 'Oops! An unknown error happened.';

}
    
// Inclua funções e conexões de banco de dados aqui. Ver 3.1. 

sec_session_start(); 

if(login_check($mysqli) == true) {

    // Adicione o conteúdo da sua página protegida aqui! 

} else {      
    echo 'Você não está autorizado a acessar essa página, favor fazer o login.';
}
?>

<!DOCTYPE html>
<html>    
<head>        

<meta charset="UTF-8">        
<title>Secure Login: Error</title>        
<link rel="stylesheet" href="styles/main.css" />    

</head>    
<body>        
    
<h1>There was a problem</h1>        

<p class="error"><?php echo $error; ?> </p>      

</body>
</html>