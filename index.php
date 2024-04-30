<?php
        echo "<h1> Ola Mundo </h1>";

        $name = $_POST ['name'];
        $email = $_POST ['email'];
        $password = $_POST ['senha'];
        $livro = $_POST ['livro'];
        $avaliacao = $_POST ['avaliacao'];

        
        echo $name;

        echo '<p> SEU EMAIL É </p>';
        echo $email;

        echo '<p> SUA SENHA É </p>';
        echo $password;
        
        echo '<p>LIVRO SELECIONADO </p>';
        echo $livro;

        echo '<p> AVALIAÇÃO FOI </p>';
        echo $avaliacao;

?>
