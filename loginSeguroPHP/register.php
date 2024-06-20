<?php

include_once 'includes/register.inc.php';
include_once 'includes/functions.php';

?>

<!DOCTYPE html>
<html>
<head>    

    <meta charset="UTF-8">
    <title>Secure Login: Registration Form</title>

    <script type="text/JavaScript" src="js/sha512.js"></script>
    <script type="text/JavaScript" src="js/forms.js"></script>
    <link rel="stylesheet" href="styles/main.css">

</head>
<body>

    <!-- Registration form to be output if the POST variables are not
    set or if the Registration script caused an error -->

<h1>Registre com a gente</h1>

<?php

if (!empty($error_msg)) {

    echo $error_msg;

}

?>
<ul>

    <li> Os nome de usuarios devem conter apenas digitos, letras maiusculas e minusculas e underlines("_") </li>

    <li>Emails devem seguir um formato valido para email.</li>
    <li>As senhas devem ter no minimo 6 caracteres.</li>
    <li>As senhas devem conter

<ul>
    <li>Pelo menos uma letra maiuscula (A..Z)</li>
    <li>Pelo menis uma letra minuscula (a..z)</li>
    <li>Pelo menos um numero (0..9)</li>
</ul>
    </li>

        <li>Sua senha deve conferir extamente</li>

</ul>

<form action="<?php echo esc_url($_SERVER['PHP_SELF']);?>" method="post" name="registration_form">

Username: 
<input type='text' name='username' id='username'/><br>

Email: 
<input type="text" name="email" id="email"/><br>

Password: 
<input type="password" name="password" id="password"/><br>

Confirm password: 
<input type="password" name="confirmpwd" id="confirmpwd"/><br>

<input type="button" value="Register" onclick="return regformhash(this.form, this.form.username, this.form.email, this.form.password, this.form.confirmpwd);">
        
</form>

<p>Return to the <a href="index.php">Login page</a>.</p>

</body>

</html>