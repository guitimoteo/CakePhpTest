<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsuariosController
 *
 * @author guilherme
 */
class UsuariosController extends AppController {
    public $helpers     = array('Html','Form');
    public $name        = 'Usuarios';
    public $components  = array('Session');
    function index(){
        //$this->set('usuarios', $this->Usuario->find('all'));
        $this->redirect(array('action' => 'index'));
    }
    
    //TODO: Verificar autorização específica de cada usuário
    /*
    public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow('add'); // Permitindo que os usuários se registrem
    // Basic setup
    $this->Auth->authenticate = array('Form');

    // Pass settings in
    $this->Auth->authenticate = array(
    'Basic' => array('usuario' => 'Member'),
    'Form' => array('usuario' => 'Member'));
}*/


 public function view($id = null) {
        $this->Usuario->id = $id;
        $this->set('usuario', $this->Usuario->read());
    }

    public function listing() {
        $this->set('usuarios', $this->Usuario->find('all')); // define uma variavel usuarios na view index
    }

    /**
     * Adiciona Usuários no banco de dados
     */
    function add() {
        if ($this->request->is('post')) {
            //Salvando a foto
            if (is_uploaded_file($this->request->data['Usuario']['Foto']['tmp_name'])) {
                $arquivo = fread(fopen($this->request->data['Usuario']['Foto']['tmp_name'], "r"), $this->request->data['Usuario']['Foto']['size']);
                $this->request->data['Usuario']['foto'] = $arquivo;
            }
            if ($this->Usuario->save($this->request->data)) {
                $this->Session->setFlash(__('Usuário salvo'), 'default', array('class' => 'success'));
                $this->redirect(array("controller" => "comentarios", 'action' => 'index'));
            }
        }
        $this->set('lable', '<br><h1>Cadastrar<h1><br>');
    }

    /**
     * Edita o usuário
     * @param type $id
     * @throws NotFoundException
     */
    public function edit($id = null) {
        $this->Usuario->id = $id;
        if (!$this->Usuario->exists()) {
            throw new NotFoundException(__('Usuário inválido'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Usuario->save($this->request->data)) {
                $this->Session->setFlash(__('Usuário salvo'));
                $this->redirect(array('controller' => 'comentarios', 'action' => 'index'));
            } else {
                $this->Session->setFlash(__('O usuario não pode ser salvo. Por favor, tente novamente.'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['Usuario']['password']);
        }
    }

    /**
     * Deleta o usuário no banco de dados
     * @param type $id
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     */
    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Usuario->id = $id;
        if (!$this->Usuario->exists()) {
            throw new NotFoundException(__('Usuário inválido'));
        }
        if ($this->Usuario->delete()) {
            $this->Session->setFlash(__('Usuário deletado'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Usuário não foi deletado'));
        $this->redirect(array('action' => 'index'));
    }

    public function login() {
        $this->set('title_for_layout', __('Log in'));
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->Session->setFlash(__('Usuário logado'), 'default', array('class' => 'success'));
                return $this->redirect(array('controller' => 'comentarios', 'action' => 'index'));
            } else {
                $this->Session->setFlash($this->Auth->authError, 'default', array(), 'auth');
                $this->redirect($this->Auth->loginAction);
            }
        }
    }

    public function logout() {
    $this->redirect($this->Auth->logout());
}
}