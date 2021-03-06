<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Associados Controller
 *
 * @property Associado $Associado
 * @property PaginatorComponent $Paginator
 */
class AssociadosController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    public $paginate = array(
        // other keys here.
        //'limit' => 30,
        //'maxLimit' => 1000,
        'order' => array(
            'Associado.nome' => 'asc'
        )
    );

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->Associado->recursive = 0;
        $this->Paginator->settings = $this->paginate;
        $this->set('associados', $this->Paginator->paginate());
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
        if (!$this->Associado->exists($id)) {
            throw new NotFoundException(__('Associado inválido.'));
        }
        $options = array('conditions' => array('Associado.' . $this->Associado->primaryKey => $id));
        $this->set('associado', $this->Associado->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        $model = ClassRegistry::init('Associado');

        if ($this->request->is('post')) {
            $this->Associado->create();
            $data = $this->request->data;

            $dataDeAdmissao = $data['Associado']['dataDeAdmissao'];
            $data['Associado']['dataDeAdmissao'] = revertDate($dataDeAdmissao);
            $dataDesligamento = $data['Associado']['dataDesligamento'];
            $data['Associado']['dataDesligamento'] = revertDate($dataDesligamento);
            $dataDeNascimento = $data['Associado']['dataDeNascimento'];
            $data['Associado']['dataDeNascimento'] = revertDate($dataDeNascimento);

            $data['Associado']['mensalidade'] = $data['Associado']['salario'] * 0.09;

            if ($this->Associado->save($data)) {
                $this->Session->setFlash(__('Registro inserido com sucesso.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Não foi possível inserir o registro. Favor, tente novamente.'));
            }
        }
        $cargos = $this->Associado->Cargo->find('list', array('order' => 'nome ASC'));
        $areas = $this->Associado->Area->find('list', array('order' => 'nome ASC'));
        $ativos = $model->getAtivo();
        $sexos = $model->getSexo();
        $estadocivils = $model->getEstadocivil();
        $filhos = $model->getFilhos();
        $this->set(compact('cargos', 'areas', 'ativos', 'sexos', 'estadocivils', 'filhos'));
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
        $model = ClassRegistry::init('Associado');

        if (!$this->Associado->exists($id)) {
            throw new NotFoundException(__('Associado inválido'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $data = $this->request->data;
            $dataDeAdmissao = $data['Associado']['dataDeAdmissao'];
            $data['Associado']['dataDeAdmissao'] = revertDate($dataDeAdmissao);
            $dataDesligamento = $data['Associado']['dataDesligamento'];
            $data['Associado']['dataDesligamento'] = revertDate($dataDesligamento);
            $dataDeNascimento = $data['Associado']['dataDeNascimento'];
            $data['Associado']['dataDeNascimento'] = revertDate($dataDeNascimento);

            $data['Associado']['mensalidade'] = $data['Associado']['salario'] * 0.09;

            if ($this->Associado->save($data)) {
                $this->Session->setFlash(__('Alteração realizada com sucesso..'));
                //return $this->redirect(array('action' => 'index'));
                return $this->redirect($this->referer());
            } else {
                $this->Session->setFlash(__('Não foi possível realizar a alteração. Favor, tente novamente.'));
            }
        } else {
            $options = array('conditions' => array('Associado.' . $this->Associado->primaryKey => $id));
            $associadosTmp = $this->Associado->find('first', $options);

            $dataDeAdmissao = $associadosTmp['Associado']['dataDeAdmissao'];
            $associadosTmp['Associado']['dataDeAdmissao'] = revertDate($dataDeAdmissao);
            $dataDesligamento = $associadosTmp['Associado']['dataDesligamento'];
            $associadosTmp['Associado']['dataDesligamento'] = revertDate($dataDesligamento);
            $dataDeNascimento = $associadosTmp['Associado']['dataDeNascimento'];
            $associadosTmp['Associado']['dataDeNascimento'] = revertDate($dataDeNascimento);

            $this->request->data = $associadosTmp;
        }
        $cargos = $this->Associado->Cargo->find('list', array('order' => 'nome ASC'));
        $areas = $this->Associado->Area->find('list', array('order' => 'nome ASC'));
        $ativos = $model->getAtivo();
        $sexos = $model->getSexo();
        $estadocivils = $model->getEstadocivil();
        $filhos = $model->getFilhos();
        $this->set(compact('cargos', 'areas', 'ativos', 'sexos', 'estadocivils', 'filhos'));
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
        $this->Associado->id = $id;
        if (!$this->Associado->exists()) {
            throw new NotFoundException(__('Associado inválido.'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Associado->delete()) {
            $this->Session->setFlash(__('Registro removido com sucesso.'));
        } else {
            $this->Session->setFlash(__('Não foi possível remover o registro. Favor, tente novamente.'));
        }
        //return $this->redirect(array('action' => 'index'));
        return $this->redirect($this->referer());
    }

    public function listaAniversario($id = null)
    {
        $data = date("m");
        $options = array('conditions' => array("strftime('%m', Associado.dataDeNascimento)" => $data));
        $aniversariantes = $this->Associado->find('all', $options);
        $this->set(compact('aniversariantes'));
    }

    public function todosAssociados()
    {
        $this->Associado->recursive = 0;
        $this->Paginator->settings = $this->paginate;
        $this->set('associados', $this->Paginator->paginate());
    }

    public function search()
    {
        //$this->isAdmin();
        $associado = $this->request->data;
        if (!empty($associado)) {
            $result = $this->Associado->find('all', array('conditions' => array('Associado.nome LIKE' => "%" . $associado['Associado']['Busca'] . "%")));
            $this->Paginator->settings = $this->paginate;
            $this->set('result', $this->Paginator->paginate());
        } else {
            $this->redirect(array('controller' => 'associado', 'action' => 'index'));
        }
    }

}

function revertDate($date)
{
    if ($date != '') {
        $dates = explode('-', $date);
        $datesTmp[0] = $dates[2];
        $datesTmp[1] = $dates[1];
        $datesTmp[2] = $dates[0];
        return join('-', $datesTmp);
    }
    return $date;
}
