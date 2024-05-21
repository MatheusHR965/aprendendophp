<?php
$obj_mysqli = new mysqli("127.0.0.1","root","","tutocrudphp");

if($obj_mysqli->connect_errno)
{
    echo "Ocorreu um erro na conexão com o bloco de dados.";
    exit;
}

//Validação das informações do banco de dados
if(isset($_POST["nome_prod"]) && isset($_POST["marca"]) && isset($_POST["unidade"]) && isset($_POST["imposto"]))
{
    if(empty($_POST["nome_prod"])) {
    $erro = "PREENCHA ESTE CAMPO"; }

else

    if(empty($_POST["marca"])) {
    $erro = "PREENCHA ESTE CAMPO"; }

    else
    {
    //vai realizar o cadastro.

      $id_produto = $_POST["id"];
      $Nome = $_POST["nome_prod"];
      $Marca = $_POST["marca"];
      $Unidade = $_POST["unidade"];
      $Imposto = $_POST["imposto"];

    
        if ($id_produto == -1)
        {
            $stmt =  $obj_mysqli -> prepare ("INSERT INTO `produtos` (`Nome`, `Marca`, `Unidade`, `Imposto`) VALUES (?,?,?,?)");
            $stmt -> bind_param('ssssi', $Nome, $Marca, $Unidade, $Imposto, $id_produto);
        }


    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<form action="<?=$_SERVER["PHP_SELF"]?>" method="POST">

    Nome do produto: <br>
    <input type="text" name="nome_prod" placeholder="Nome do produto"> <br><br>
    Marca do produto: <br>
    <input type="text" name="marca" placeholder="Marca do produto"> <br><br>
    Quantas unidade: <br>
    <input type="number" name="unidade" placeholder="Unidades"> <br><br>
    Inposto do produto: <br>
    <input type="text" name="imposto" placeholder="Imposto pelo produto"> <br><br>
    <input type="hidden"value="-1"name="id" >
    <button type="submit"> REGISTRA </button>

    
</form>

</body>
</html>