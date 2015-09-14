<?php
/**
 * Export all member records in .xls format
 * with the help of the xlsHelper
*/
//declare the xls helper
$xls= new xlsHelper(new View(null));

//input the export file name
$xls->setHeader('TodasComprasAnaliticas'.date('Y_m_d'));

$xls->addXmlHeader();
$xls->setWorkSheetName('Todas as compras analíticas por associados.');
$xls->openRow();
$xls->writeString('Todas as compras analíticas por associados.');
$xls->closeRow();

// Data
$assoc_tmp = $compras[0]['Associado']['nome'];
$count = Count($compras);
$i = 1;
$total = 0;
foreach($compras as $compra){
  $last_iteration = !(--$count); //boolean true/false
	if($assoc_tmp == $compra['Associado']['nome']){
    if(($i <> $count) && ($total == 0)){
      $xls->openRow();
      $xls->writeString("Associado: ".$compra['Associado']['nome']);
      $xls->closeRow();
      $xls->openRow();
      $xls->writeString('Matrícula');
      $xls->writeString('Descrição');
      $xls->writeString('Convênio');
      $xls->writeString('Valor');
      $xls->writeString('Observação');
      $xls->closeRow();
      $xls->openRow();
      $xls->writeString($compra['Associado']['matricula']);
      $xls->writeString($compra['Compra']['descricao']);
      $xls->writeString($compra['Convenio']['nomeDoGrupo']);
      $xls->writeString("R$ ".$compra['Compra']['valor']);
      $xls->writeString($compra['Compra']['observacao']);
      $xls->closeRow();
      $total += (float)$compra['Compra']['valor'];

    } elseif (($i <> $count) && ($total <> 0)){
        $xls->openRow();
        $xls->writeString($compra['Associado']['matricula']);
        $xls->writeString($compra['Compra']['descricao']);
        $xls->writeString($compra['Convenio']['nomeDoGrupo']);
        $xls->writeString("R$ ".$compra['Compra']['valor']);
        $xls->writeString($compra['Compra']['observacao']);
        $xls->closeRow();
        $total += (float)$compra['Compra']['valor'];

    } elseif ($i == $count)  {
        $xls->openRow();
        $xls->writeString($compra['Associado']['matricula']);
        $xls->writeString($compra['Compra']['descricao']);
        $xls->writeString($compra['Convenio']['nomeDoGrupo']);
        $xls->writeString("R$ ".$compra['Compra']['valor']);
        $xls->writeString($compra['Compra']['observacao']);
        $xls->closeRow();
        $total += (float)$compra['Compra']['valor'];
        $xls->openRow();
        $xls->writeString('Total: R$ ');
        $xls->writeNumber($total);
        $xls->closeRow();
    };
  };
  if($assoc_tmp <> $compra['Associado']['nome']){
    $xls->openRow();
    $xls->writeString('Total: R$ ');
    $xls->writeNumber($total);
    $xls->closeRow();
    $assoc_tmp = $compra['Associado']['nome'];
    $total = 0;

    $xls->openRow();
    $xls->writeString("Associado: ".$compra['Associado']['nome']);
    $xls->closeRow();
    $xls->openRow();
    $xls->writeString('Matrícula');
    $xls->writeString('Descrição');
    $xls->writeString('Convênio');
    $xls->writeString('Valor');
    $xls->writeString('Observação');
    $xls->closeRow();
    $xls->openRow();
    $xls->writeString($compra['Associado']['matricula']);
    $xls->writeString($compra['Compra']['descricao']);
    $xls->writeString($compra['Convenio']['nomeDoGrupo']);
    $xls->writeString("R$ ".$compra['Compra']['valor']);
    $xls->writeString($compra['Compra']['observacao']);
    $xls->closeRow();
		$total += (float)$compra['Compra']['valor'];

		if($last_iteration){
      $xls->openRow();
      $xls->writeString('Total: R$ ');
      $xls->writeNumber($total);
      $xls->closeRow();
		};
  };
	$i++;
};

$xls->addXmlFooter();
exit();
?>