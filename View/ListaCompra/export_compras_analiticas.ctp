<?php
/**
 * Export all member records in .xls format
 * with the help of the xlsHelper
 */

//declare the xls helper
$xls = new xlsHelper(new View(null));

//input the export file name
$xls->setHeader('ComprasPorAssociado' . date('Y_m_d'));

$xls->addXmlHeader();
$xls->setWorkSheetName('Compras por Associado.');
$xls->openRow();
$xls->writeString('Compras por Associado.');
$xls->closeRow();

//1st row for columns name
$xls->openRow();
$xls->writeString($compras[0]['Associado']['matricula'] . " - " . $compras[0]['Associado']['nome']);
$xls->closeRow();
$xls->openRow();
$xls->writeString('Convênio');
$xls->writeString('Valor');
$xls->writeString('Descrição');
$xls->closeRow();

//rows for data
foreach ($compras as $compra):

    $xls->openRow();
    $xls->writeString($compra['Convenio']['razaoSocial']);
    $xls->writeString($compra['Compra']['valor']);
    $xls->writeString($compra['Compra']['descricao']);
    $xls->closeRow();

endforeach;

$xls->openRow();
$xls->writeString('Total: ');
$xls->writeNumber($total);
$xls->closeRow();

$xls->addXmlFooter();
exit();
?>
