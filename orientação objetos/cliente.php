<?php

class cliente {

    private $id_cliente;
    private $nome_cli;
    private $cep;
    private $endereco;
    private $telefone;

    
    public function __construct($nome_cli, $cep, $endereco, $telefone) {
        $this->nome = $nome_cli;
        $this->cpf = $cpf;
        $this->endereco = $endereco;
        $this->telefone = $telefone;
      }
      function set_cliente($nome_cli) {
        $this -> name = $nome_cli;
      }
      function get_cliente() {
        return $this -> nome_cli;
      }
      function set_cep($cep) {
        $this -> cep = $cep;
      }
      function get_cep() {
        return $this -> $cep;
      }
      function set_endereco($endereco) {}
    }