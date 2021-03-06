<?php
App::uses('AppModel', 'Model');

/**
 * LinhasTelefonica Model
 *
 * @property Associado $Associado
 */
class LinhasTelefonica extends AppModel
{

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Associado' => array(
            'className' => 'Associado',
            'foreignKey' => 'associado_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Operadora' => array(
            'className' => 'Operadora',
            'foreignKey' => 'operadora_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public $_schema = array(
        'associado_id' => array(
            'type' => 'integer',
            'null' => false,                        
        ),
        'data' => array(
            'type' => 'date',
            'null' => false,
        ),
        'devolucao' => array(
            'type' => 'date',
            'null' => false,
        ),
        'modo_id' => array(
            'type' => 'integer',
            'null' => false,                        
        ),
    );

    public function getModeList()
    {
        // this could be a find 'list' from
        // another model
        return array(            
            1 => 'Por Associado',
            2 => 'Por Número',
        );
    }
}
