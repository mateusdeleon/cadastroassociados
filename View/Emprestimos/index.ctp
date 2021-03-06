<div class="emprestimos index">
    <h2><?php echo __('Emprestimos'); ?></h2>
    <table cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th><?php echo $this->Paginator->sort('id'); ?></th>
            <th><?php echo $this->Paginator->sort('titulo'); ?></th>
            <th><?php echo $this->Paginator->sort('associado_id'); ?></th>
            <th><?php echo $this->Paginator->sort('data'); ?></th>
            <th><?php echo $this->Paginator->sort('referencia'); ?></th>
            <th><?php echo $this->Paginator->sort('valor'); ?></th>
            <th><?php echo $this->Paginator->sort('observavao'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($emprestimos as $emprestimo): ?>
            <tr>
                <td><?php echo h($emprestimo['Emprestimo']['id']); ?>&nbsp;</td>
                <td><?php echo h($emprestimo['Emprestimo']['titulo']); ?>&nbsp;</td>
                <td>
                    <?php echo $this->Html->link($emprestimo['Associado']['nome'], array('controller' => 'associados', 'action' => 'view', $emprestimo['Associado']['id'])); ?>
                </td>
                <td><?php echo h($emprestimo['Emprestimo']['data']); ?>&nbsp;</td>
                <td><?php echo h($emprestimo['Emprestimo']['referencia']); ?>&nbsp;</td>
                <td><?php echo h($emprestimo['Emprestimo']['valor']); ?>&nbsp;</td>
                <td><?php echo h($emprestimo['Emprestimo']['observavao']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__('View'), array('action' => 'view', $emprestimo['Emprestimo']['id'])); ?>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $emprestimo['Emprestimo']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $emprestimo['Emprestimo']['id']), array(), __('Are you sure you want to delete # %s?', $emprestimo['Emprestimo']['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?>    </p>
    <div class="paging">
        <?php
        echo $this->Paginator->prev('< ' . __('Anterior   '), array('class' => 'btn btn-default',
                            'role' => 'button'), null, array('class' => 'btn btn-default disabled', 'role' => 'button'));
        echo $this->Paginator->numbers(array('separator' => '   '));
        echo $this->Paginator->next(__('   Próximo') . ' >', array('class' => 'btn btn-default',
                            'role' => 'button'), null, array('class' => 'btn btn-default disabled', 'role' => 'button'));
        ?>
    </div>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('New Emprestimo'), array('action' => 'add')); ?></li>
        <li><?php echo $this->Html->link(__('List Associados'), array('controller' => 'associados', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Associado'), array('controller' => 'associados', 'action' => 'add')); ?> </li>
    </ul>
</div>
