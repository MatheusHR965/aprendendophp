[16:50] JOAO VITOR PEREIRA DE FREITAS CORREA
<?php

require_once 'connect.php';
require_once 'header.php';

 
 
if( empty($_POST['nome']) || empty($_POST['tele_cli']) || empty($_POST['endereco']) || empty($_POST['cpf']) ) {
{
    echo "Preencha todos os campos";
}
else{
 
    $nome = $_POST['nome'];
    $tele_Cli     = $_POST['tele_Cli'];
    $endereco      = $_POST['endereco'];
    $cpf      = $_POST['cpf'];
    $sql = "UPDATE users SET nome='{$nome}', tele_Cli = '{$tele_Cli}', endereco = '{$endereco}', cpf = '{$cpf}' WHERE Cli_id=". $_POST['Cli_id'];
 

if( $con->query($sql) === TRUE ){
        echo "<div class='alert alert-success'>Usuário adicionado com sucesso</div>";
        }
        else{

        echo "<div class='alert alert-danger'>Error: houve um erro ao adicionar um novo usuário</div>";

        }
        }
    }
    ?>
    <div class="row">
    <div class="col-md-6 col-md-offset-3">
            <div class="box">

                    <h3><i class="glyphicon glyphicon-plus"></i>&nbsp;Add New User</h3>
                    <form action="" method="POST">
                            <label for="firstname">Firstname</label>
                            <input type="text" id="firstname" name="firstname" class="form-control"><br>

                            <label for="lastname">Lastname</label>
                            <input type="text" name="lastname" id="lastname" class="form-control"><br>

                            <label for="address">Address</label>
                            <textarea rows="4" name="address" class="form-control"></textarea><br>

                            <label for="contact">Contact</label>
                            <input type="text" name="contact" id="contact" class="form-control"><br>
                            <br>
                            <input type="submit" name="addnew" class="btn btn-success" value="Add New">
                    </form>
            </div>
    </div>
    </div>
</div>

<?php
require_once 'footer.php';