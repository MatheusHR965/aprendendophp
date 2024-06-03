<?php

include_once 'includes/db_connect.php';

include_once 'includes/functions.php';

sec_session_start();

?>

<!DOCTYPE html>
<html>    
<head>     

<meta charset="UTF-8">        
<title>Secure Login: Protected Page</title>        
<link rel="stylesheet" href="styles/main.css" /> 

</head>    

<body>
    
<?php if (login_check($mysqli) == true): ?>

<p> Welcome <?php echo htmlentities($_SESSION['username']); ?>!</p>            

<p>

</p>            
<p>Return to <a href="index.php"> login page </a>
</p>

<?php else : ?>            
    
    <p> <span class="error"> Você não tem autorização para acessar esta página. </span> 
Please <a href="index.php">login</a>.            

</p>

<?php endif; ?>    

</body>

</html>