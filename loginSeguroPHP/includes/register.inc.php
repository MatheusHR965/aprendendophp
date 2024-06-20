<?php

include_once 'db_connect.php';
include_once 'psl_config.php';

$erro_msg = "";

if (isset($_POST['username'],$_POST['email'], $_POST['p'])) {
// Limpa  e valida os dados passados em

$username = filter_input(INPUT_POST,'username', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST,'email', FILTER_SANITIZE_STRING);
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
    
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    // Email invalido

    $erro_msg = '<p class = "error">O endereço de email digitado não é valido</p>';

}

$password = filter_input(INPUT_POST,'p', FILTER_SANITIZE_STRING);

if (strlen($password) != 128) {

    // A senha com hash deve ter 128 caracteres.
    // Caso contrario, algo muito estranho esta acontecendo

    $error_msg .='<p class="error">Invalid password configuration.</p>';
}

// O nome de usuario e a validade da senha foram conferidas no lado cliente.
// Nao deve haver problemas nesse passo ja que ninguem ganha
// violando essas regras.
//

$prep_stmt = "SELECT id FROM members WHERE email = ? LIMIT 1";
$stmt = $mysqli->prepare($prep_stmt);


if ($stmt) {

    $stmt->bind_param('s',$email);
    $stmt->execute();
    $stmt->store_result();

if ($stmt->num_rows == 1) {

    // Um usuario com esse email ja existe
    $error_msg .= '<p class="error">um ususario com este email ja existe.</p>';

}
} 

else {

    $error_msg .= '<p class="error">Database error</p>';

}

// Lista de tarefas:
// Precisamos bolar soluçoes para quando o usuario não tem
// direito a se registrar, verificando que tipo de usuario esta tentando
// realizar a operação.


if (empty($erro_msg)) {

    // Crie um salt aleatorio
    $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), true));


    // Crie uma senha com salt
    $password = hash('sha512',$password. $random_salt);

    // Inserir o novo usuario no banco de dados
if ($insert_stmt = $mysqli->prepare("INSERT INTO members (username, email, password, salt) VALUES (?,?,?,?)")) {

$insert_stmt->bind_param('ssss', $username, $email, $password, $random_salt);

    // Executar a tarefa pre-estabelecida.

    if (!$insert_stmt->execute()) {

    header('Location: ../error.php?err=Registration failure: INSERT');

    }
}

header('Location: ./register_success.php');

}
}