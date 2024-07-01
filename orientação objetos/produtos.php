<?php

class produtos() {

    private $id_produto;
    private $nome_produto;
    private $preco_produto;
    private $quant_unid;
    private $unid_estoque;

    public function __construct($nome_produto, $preco_produto, $quant_unid, $unid_estoque) {
        $this->nome_produto = $nome_produto;
        $this->preco_produto = $preco_produto;
        $this->quant_unid = $quant_unid;
        $this->unid_estoque = $unid_estoque;
      }

      function set_private($nome_produto, $preco_produto, $quant_unid, $telefone) {
        return $this->private;
      }
}