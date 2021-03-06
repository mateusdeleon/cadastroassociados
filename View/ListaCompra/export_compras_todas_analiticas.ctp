<?php
/**
 * Export all member records in .xls format
 * with the help of the xlsHelper
 */
//declare the xls helper
$xls = new xlsHelper(new View(null));

//input the export file name
$xls->setHeader('TodasComprasAnaliticas' . date('d-m-Y'));

$xls->addXmlHeader();
$xls->setWorkSheetName('Todas as compras analíticas por associados.');
$xls->openRow();
$xls->writeString('Todas as compras analíticas por associados.');
$xls->closeRow();

// Data
$assoc_tmp = $compras[0]['Associado']['nome'];
$count = Count($compras);
$total = 0;
$i = 1;
foreach ($compras as $compra) {
    $last_iteration = !(--$count); //boolean true/false
    if ($assoc_tmp == $compra['Associado']['nome']) {
        if (($i <> $count) && ($total == 0)) {
            $xls->openRow();
            $xls->writeString($compra['Associado']['matricula'] . " - " . $compra['Associado']['nome']);
            $xls->closeRow();
            $xls->openRow();
            $xls->writeString('Convênio');
            $xls->writeString('Valor');
            $xls->writeString('Descrição');
            $xls->closeRow();
            $xls->openRow();
            $xls->writeString($compra['Convenio']['nomeDoGrupo']);
            $this->Number->addFormat('BRL', array('before'=> 'R$', 'thousands' => '.', 'decimals' => ','));
		        $valor = $this->Number->currency($compra['Compra']['valor'],'BRL' );
            $xls->writeString($valor);
            $xls->writeString($compra['Compra']['descricao']);
            $xls->closeRow();
            $total += $compra['Compra']['valor'];

        } elseif (($i <> $count) && ($total <> 0)) {
            $xls->openRow();
            $xls->writeString($compra['Convenio']['nomeDoGrupo']);
            $this->Number->addFormat('BRL', array('before'=> 'R$', 'thousands' => '.', 'decimals' => ','));
  		      $valor = $this->Number->currency($compra['Compra']['valor'],'BRL' );
            $xls->writeString($valor);
            $xls->writeString($compra['Compra']['descricao']);
            $xls->closeRow();
            $total += $compra['Compra']['valor'];

        } elseif ($i == $count) {
            $xls->openRow();
            $xls->writeString($compra['Convenio']['nomeDoGrupo']);
            $this->Number->addFormat('BRL', array('before'=> 'R$', 'thousands' => '.', 'decimals' => ','));
  		      $valor = $this->Number->currency($compra['Compra']['valor'],'BRL' );
            $xls->writeString($valor);
            $xls->writeString($compra['Compra']['descricao']);
            $xls->closeRow();
            $total += $compra['Compra']['valor'];
            $xls->openRow();
            $xls->writeString('Total: ');
            $this->Number->addFormat('BRL', array('before'=> 'R$', 'thousands' => '.', 'decimals' => ','));
				    $total = $this->Number->currency($total,'BRL' );
            $xls->writeString($total);
            $xls->closeRow();
        };
    };
    if ($assoc_tmp <> $compra['Associado']['nome']) {
        $xls->openRow();
        $xls->writeString('Total: ');
        $this->Number->addFormat('BRL', array('before'=> 'R$', 'thousands' => '.', 'decimals' => ','));
        $total = $this->Number->currency($total,'BRL' );
        $xls->writeString($total);
        $xls->closeRow();
        $assoc_tmp = $compra['Associado']['nome'];
        $total = 0;

        $xls->openRow();
        $xls->writeString($compra['Associado']['matricula'] . " - " . $compra['Associado']['nome']);
        $xls->closeRow();
        $xls->openRow();
        $xls->writeString('Convênio');
        $xls->writeString('Valor');
        $xls->writeString('Descrição');
        $xls->closeRow();
        $xls->openRow();
        $xls->writeString($compra['Convenio']['nomeDoGrupo']);
        $this->Number->addFormat('BRL', array('before'=> 'R$', 'thousands' => '.', 'decimals' => ','));
        $valor = $this->Number->currency($compra['Compra']['valor'],'BRL' );
        $xls->writeString($valor);
        $xls->writeString($compra['Compra']['descricao']);
        $xls->closeRow();
        $total += $compra['Compra']['valor'];

        if ($last_iteration) {
            $xls->openRow();
            $xls->writeString('Total: ');
            $this->Number->addFormat('BRL', array('before'=> 'R$', 'thousands' => '.', 'decimals' => ','));
            $total = $this->Number->currency($total,'BRL' );
            $xls->writeString($total);
            $xls->closeRow();
        };
    };
    $i++;
};

$xls->addXmlFooter();
exit();
?>
