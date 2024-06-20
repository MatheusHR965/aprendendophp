<?php

include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();

if (login_check($mysqli) == true) {

    $logged = 'in';

} 
else {

$logged = 'out';

}

?>

<!DOCTYPE html>
<html>
 <head>

    <title>Secure Login: Log In</title>
    <link rel="stylesheet" href="styles/main.css" />

    <script type="text/JavaScript" src="js/sha512.js"></script>
    <script type="text/JavaScript" src="js/forms.js"></script>

</head>
<body>

<?php

    if(isset($_GET['error'])) {

    echo '<p class= "error">Erro ao fazer o login!</p>';

    }

?>

<form action="includes/process_login.php" method="post" name="login_form">

    email: <input type="text" name="email" />

    Password: <input type="password" name="password"id="password"/>

    <input type="button" value="Login" onclick="formhash(this.form, this.form.password);" />

</form>

    <p>Se voce não tem uma conta, por favor <a href="register.php"> register </a></p>
    <p>Se voce acabou, por favor <a href="includes/logout.php"> log out </a></p>
    <p>Seu Status atualmente <?php echo $logged ?> . </p>

</body>
</html>