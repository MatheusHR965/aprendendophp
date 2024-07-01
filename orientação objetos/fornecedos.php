<?php

class fornecedor {
    private $id_fornecedor;
    private $nome_fornecedor;
    private $contato;
    private $endereco;
    private $cnpj;


public function __construct($nome_fornecedor, $contato, $endereco, $cnpj) {
    $this->nome_fornecedor = $nome_fornecedor;
    $this->contato = $contato;
    $this->endereco = $endereco;
    $this->cnpj = $cnpj;
  }
  function set_forne($nome_fornecedor, $contato, $endereco, $cnpj) {
    return $this->private;
  }
}
