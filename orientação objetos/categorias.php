<?php

class categorias {
    private $codDaCategoria;
    private $nomeCategoria;
    private $descricao;
    private $figura

public function __construct($nome_fornecedor, $contato, $endereco, $cnpj) {
    $this->nome_fornecedor = $nome_fornecedor;
    $this->contato = $contato;
    $this->endereco = $endereco;
    $this->cnpj = $cnpj;
  }
  function get_private() {
    return $this->name;
  }
  function get_color() {
    return $this->color;
  }
}