<?php

class pedidos {

    private $id_pedido;
    private $nome_cli;
    private $endereco;
    private $valor_total;
    private $data_entrega;

    public function __construct($nome_cli, $endereco, $valor_total, $data_entrega) {
        $this->nome_cli = $nome_cli;
        $this->endereco = $endereco;
        $this->valor_total = $valor_total;
        $this->data_entrega = $data_entrega;
      }
      function set_compras($nome_cli, $endereco, $valor_total, $data_entrega) {
        return $this->compras;
      }
}