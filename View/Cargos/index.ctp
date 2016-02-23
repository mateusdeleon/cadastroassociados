<br>
<?php
echo $this->Html->link(
    'Cadastrar um novo cargo',
    array(
        'controller' => 'Cargos',
        'action' => 'add',
        'full_base' => true
    ),
    array(
        'class' => 'btn btn-success',
        'role' => 'button'
    )
);
?>
<br>
<br>
<div class="panel panel-default">
    <div class="panel-heading">
        Cargos
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                <tr>
                    <th><?php echo $this->Paginator->sort('nome'); ?></th>
                    <th><?php echo $this->Paginator->sort('valorAlmoço', 'Valor do almoço'); ?></th>
                    <th class="actions"><?php echo __('Gerenciamento'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($cargos as $cargo): ?>
                    <tr class="odd gradeX">
                        <td><?php echo h($cargo['Cargo']['nome']); ?>&nbsp;</td>
                        <?php $this->Number->addFormat('BRL', array('before' => 'R$', 'thousands' => '.', 'decimals' => ','));
                        $valor = $this->Number->currency($cargo['Cargo']['valorAlmoço'], 'BRL');
                        ?>
                        <td><?php echo h($valor); ?>&nbsp;</td>
                        <td class="actions">
                            <?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $cargo['Cargo']['id']),
                                array('class' => 'btn btn-warning btn-sm', 'role' => 'button')); ?>
                            <?php echo $this->Form->postLink(__('Apagar'), array('action' => 'delete', $cargo['Cargo']['id']),
                                array('class' => 'btn btn-danger btn-sm', 'role' => 'button'), __('Você tem certeza que deseja remover %s?',
                                    $cargo['Cargo']['nome'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.panel-body -->
</div>
<p>
    <?php
    echo $this->Paginator->counter(array(
        'format' => __('Página {:page} de {:pages}, exibindo {:current} registros de {:count} no total, registro inicial {:start}, registro final {:end}')
    ));
    ?>
</p>
<div class="paging">
    <?php
    echo $this->Paginator->prev('< ' . __('Anterior '), array(), null, array('class' => 'prev disabled'));
    echo $this->Paginator->numbers(array('separator' => ' '));
    echo $this->Paginator->next(__(' Próximo') . ' >', array(), null, array('class' => 'next disabled'));
    ?>
</div>
