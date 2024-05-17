<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD com PHP, de forma simples e fácil</title>
</head>
<body>
<form action="<?=$_SERVER["PHP_SELF"]?>"method="POST">
    nome:<br/>
    <input type="text" name="nome" placeholder="QUAL SEU NOME?"></br></br>
    E-mail:<br/>
    <input type="email" name="email" placeholder="QUAL SEU EMAIL?"></br></br>
    Cidade:<br/>
    <input type="text" name="cidade" placeholder="QUA SUA CIDADE?"><br/><br/>
    UF:<br/>
    <input type="text" name="uf" size="2" placeholder="UF"> 
    <br/><br/>
    <input type="hidden" values="<$id==-1>" name="id">
    <button type="submit"><?=($id==-1)?"Cadastrar":"Salvar"?></button>


    <br>
    <br>
    <table width="400px" border="0" cellspacing="0">
    <tr>
    <td><strong>#</strong></td>
    <td><strong>Nome</strong></td>
    <td><strong>Email</strong></td>
    <td><strong>Cidade</strong></td>
    <td><strong>UF</strong></td>
    <td><strong>#</strong></td>
    </tr>

    <?php
    $result = $obj_mysqli -> query("SELECT * FROM 'cliente'");
    while ($aux_query = $result -> fetch_assoc())
    {
        echo ' <tr>';
        echo ' <td>' .$aux_query["id"]. '</td>';
        echo ' <td>' .$aux_query["nome"]. '</td>';
        echo ' <td>'.$aux_query["Email"].'</td>';
        echo ' <td>'.$aux_query["Cidade"].'</td>';
        echo ' <td>'.$aux_query["UF"].'</td>';
        echo'  <td><a href="'.$_SERVER["PHP_SELF"].'?id='.$aux_query["Id"].'">Editar</a></td>';
        echo ' </tr>';
    }
    ?>
    </table>

    <?php

$obj_mysql = new mysqli("120.0.0.1", "root", "", "tutocrudphp");

if($obj_mysqli->connect_errno)
{
    echo "Ocorre um erro de conexão com o banco de dados. ";
    exit;
}

mysqli_set_charset($obj_mysqli, 'utf8');

//Incluímos um código aqui...
$id = -1;
$nome = "";
$email = "";
$cidade = "";
$uf = "";


//Validade a existencia dos dados
if(isset($_POST["nome"]) && isset($_POST["email"]) && isset($_POST["cidade"]) && isset($_POST["uf"]))
{
    if(empty($_POST["email"]))
        $erro = "Campo e-mail obrigatório";
    else
    {

        //Alteramos aqui também.
        //Agora, o $id, pode vir com o valor -1, que nos indica novo registro, 
        //ou, vir com um valor diferente de -1, ou seja, 
                //o código do registro no banco, que nos indica alteração dos dados.
        $id = $_POST["id"];
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $cidade = $_POST["cidade"];
        $uf = $_POST["uf"];

        //Se o id for -1, vamos realizar o cadastro ou alteração dos dados enviados.

        if($id == -1)
        {
        $stmt = $obj_mysqli -> prepare("INSERT INTO 'cliente' ('nome','email','cidade','uf') VALUES (?,?,?,?)");
        $stmt->bind_param('ssss',$nome,$email,$cidade,$uf);
       
        if(!$stmt -> execute())
        {
            $erro = $stmt -> error;
        }
        else
        {
            header("Location:cadas.php")
            exit;
        }
    }
    
    }
//se não, vamos realizar a alteraçao dos dados,
    //porém, vamos nos certificar que o valor passado no $id, seja válido para nosso caso

    else{
    if(is_numeric($id)) && $id >= 1)
        
    }
?>

<?
    if(isset(erro))
        echo '<div style="color:#F00">'. erro. '</div><br/><br/>';
    else
    if(isset($sucesso))
        echo '<div style="color:#00f">'. $sucesso '</div><br/><br/>';
?>


</form>
</body>
</html>

