<?php
App::uses('AppController', 'Controller');

/**
 * Convenios Controller
 *
 * @property Convenio $Convenio
 * @property PaginatorComponent $Paginator
 */
class ConveniosController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    public $paginate = array(
        'order' => array(
            'Convenio.razaoSocial' => 'asc'
        )
    );

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->Convenio->recursive = 0;
        $this->Paginator->settings = $this->paginate;
        $this->set('convenios', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null)
    {
        if (!$this->Convenio->exists($id)) {
            throw new NotFoundException(__('Convênio inválido.'));
        }
        $options = array('conditions' => array('Convenio.' . $this->Convenio->primaryKey => $id));
        $this->set('convenio', $this->Convenio->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        $model = ClassRegistry::init('Convenio');

        if ($this->request->is('post')) {
            $this->Convenio->create();
            if ($this->Convenio->save($this->request->data)) {
                $this->Session->setFlash(__('Registro inserido com sucesso.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Não foi possível inserir o registro. Favor, tente novamente.'));
            }
        }
        $status = $model->getStatus();
        $this->set(compact('status'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null)
    {
        $model = ClassRegistry::init('Convenio');        
        
        if (!$this->Convenio->exists($id)) {
            throw new NotFoundException(__('Convênio inválido.'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Convenio->save($this->request->data)) {
                $this->Session->setFlash(__('Alteração realizada com sucesso.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Não foi possível realizar a alteração. Favor, tente novamente.'));
            }
        } else {
            $options = array('conditions' => array('Convenio.' . $this->Convenio->primaryKey => $id));
            $this->request->data = $this->Convenio->find('first', $options);
        }

        $status = $model->getStatus();
        $this->set(compact('status'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null)
    {
        $this->Convenio->id = $id;
        if (!$this->Convenio->exists()) {
            throw new NotFoundException(__('Convênio inválido.'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Convenio->delete()) {
            $this->Session->setFlash(__('Registro removido com sucesso.'));
        } else {
            $this->Session->setFlash(__('Não foi possível remover o registro. Favor, tente novamente.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
}
