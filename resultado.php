<?php
$data = $_POST['data'];

$dataAtual = new DateTime();
$dataComparada = new DateTime($data);

$diferenca = $dataAtual->diff($dataComparada);
$diferencaDias = $diferenca->days;

$diferencaAnos = $diferenca->y;
$diferencaMeses = $diferenca->y * 12 + $diferenca->m;

echo "Diferença em dias: $diferencaDias";
echo '<br>';
echo "Diferença em anos: $diferencaAnos";
echo '<br>';
echo "Diferença em meses: $diferencaMeses";

?>
