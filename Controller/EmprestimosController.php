<?php
App::uses('AppController', 'Controller');

/**
 * Emprestimos Controller
 *
 * @property Emprestimo $Emprestimo
 * @property PaginatorComponent $Paginator
 */
class EmprestimosController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->Emprestimo->recursive = 0;
        $this->set('emprestimos', $this->Paginator->paginate());
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
        if (!$this->Emprestimo->exists($id)) {
            throw new NotFoundException(__('Invalid emprestimo'));
        }
        $options = array('conditions' => array('Emprestimo.' . $this->Emprestimo->primaryKey => $id));
        $this->set('emprestimo', $this->Emprestimo->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->Emprestimo->create();
            if ($this->Emprestimo->save($this->request->data)) {
                $this->Session->setFlash(__('The emprestimo has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The emprestimo could not be saved. Please, try again.'));
            }
        }
        $associados = $this->Emprestimo->Associado->find('list');
        $this->set(compact('associados'));
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
        if (!$this->Emprestimo->exists($id)) {
            throw new NotFoundException(__('Invalid emprestimo'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Emprestimo->save($this->request->data)) {
                $this->Session->setFlash(__('The emprestimo has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The emprestimo could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Emprestimo.' . $this->Emprestimo->primaryKey => $id));
            $this->request->data = $this->Emprestimo->find('first', $options);
        }
        $associados = $this->Emprestimo->Associado->find('list');
        $this->set(compact('associados'));
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
        $this->Emprestimo->id = $id;
        if (!$this->Emprestimo->exists()) {
            throw new NotFoundException(__('Invalid emprestimo'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Emprestimo->delete()) {
            $this->Session->setFlash(__('The emprestimo has been deleted.'));
        } else {
            $this->Session->setFlash(__('The emprestimo could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
}
