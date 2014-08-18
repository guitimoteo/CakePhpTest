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
    public $components  = array('Session');
    public $helpers     = array('Html','Form','Session');
    public $name        = 'Usuarios';
    function index(){
        CakeLog::write('info','UsuariosController index()');
        $this->set('usuarios', $this->Usuario->find('all'));
//        $this->redirect(array('action' => 'index'));
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
        CakeLog::write('info','UsuariosController edit('.$id.')');
        $this->Usuario->id = $this->Auth->user('id');
        if (!$this->Usuario->exists()) {
            CakeLog::write('info','!$this->Usuario->exists()');
            throw new NotFoundException(__('Usuário inválido'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if (is_uploaded_file($this->request->data['Usuario']['Foto']['tmp_name'])) {
                $arquivo = fread(fopen($this->request->data['Usuario']['Foto']['tmp_name'], "r"), $this->request->data['Usuario']['Foto']['size']);
                $this->request->data['Usuario']['foto'] = $arquivo;
            }
            if ($this->Usuario->save($this->request->data)) {
                CakeLog::write('info','edit(), $this->Usuario->save($this->request->data)');
                $this->Session->setFlash(__('Usuário salvo'));
                $this->redirect(array('controller' => 'comentarios', 'action' => 'index'));
            } else {
                $this->Session->setFlash(__('O usuario não pode ser salvo. Por favor, tente novamente.'));
            }
        } else {
            CakeLog::write('info', 'edit, unset($this->request->data["Usuario"]["password"]);');
            $this->request->data = $this->Usuario->read(null, $id);
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
        CakeLog::write('info','delete('.$id.')');
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Usuario->id = $id;
        if (!$this->Usuario->exists()) {
            CakeLog::write('info','!$this->Usuario->exists()');
            throw new NotFoundException(__('Usuário inválido'));
        }
        if ($this->Usuario->delete()) {
            CakeLog::write('info','$this->Usuario->delete()');
            $this->Session->setFlash(__('Usuário deletado'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Usuário não foi deletado'));
        $this->redirect(array('action' => 'index'));
    }
/**
 * Função para autenticação do usuário
 * @return type
 */
    public function login() {
        CakeLog::write('info','UsuariosController login()');
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
/**
 * Função para finalizar a autenticação do usuário da sessão
 */
    public function logout() {
    $this->redirect($this->Auth->logout());
}
}
