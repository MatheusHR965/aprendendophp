<?php

$error = filter_input(INPUT_GET,'err',$filter = FILTER_SANITIZE_STRING);

if (! $error) {

$error = 'Oops! An unknown error happend.';

}

?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">

    <title>Secure Login: Error</title>
    
    <link rel="stylesheet" href="style/main.css" />

</head>
<body>

    <h1>Este é o problema</h1>

    <p class="error"><?php echo $error; ?></p>

</body>
</html>