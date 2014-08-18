<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ComentariosController
 *
 * @author guilherme
 */
class ComentariosController extends AppController{
    public $name        = 'Comentarios';
    public $components  = array('Session');
    public $helpers     = array('Html','Form', 'Session');
    function index() {
        $this->loadModel('Usuario');
        CakeLog::write('info','ComentariosController index()');
        $this->set('comentarios', $this->Comentario->find('all'));
        $this->paginate['Comentario']['limit'] = 10;
        $this->set('comentarios', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Comentario invalido'));
        }
        $comentario = $this->Comentario->findById($id);
        if (!$comentario) {
            throw new NotFoundException(__('Post invalido'));
        }
        $this->set('comentario', $comentario);
    }

    /**
     * Adiciona comentários
     * @return type
     */
    function  add(){
        if($this->Auth->user()==null){
            $this->Session->setFlash(__('Por favor, identifique-se'));
            $this->redirect(array('controller' => 'usuarios','action' => 'login'));
        }
        if($this->request->is('post')){
            $this->Comentario->create();
            $this->request->data['Comentario']['user_id'] = $this->Auth->user('id'); // Autentica o usuario
            $this->request->data['Comentario']['user']    = $this->Auth->user('nome');
            if($this->Comentario->save($this->request->data)){
                $this->Session->setFlash(__('Comentário salvo'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Não foi possível adicionar o seu post'));
        }
    }
    
    /**
     * Edição de comentários
     * @param type $id
     */
    function edit($id = null) {
        CakeLog::write('info','ComentariosController edit('.$id.')');
        $this->Comentario->id = $id;
//        Substitui a authorização por Acl
        if($this->isAuthorized($this->Auth->user())===false){
            $this->Session->setFlash('Este não é o seu comentário');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('get')) {
            $this->request->data = $this->Comentario->read();
        } else {
            if ($this->Comentario->save($this->request->data)) {
                $this->Session->setFlash(__('O seu comentário foi atualizado'));
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    /**
     * Deleta o comentário
     * @param type $id
     * @throws MethodNotAllowedException
     */
    function delete($id) {
        CakeLog::write('info','ComentariosController delete('.$id.')');
        if($this->isAuthorized($this->Auth->user())===false){
            $this->Session->setFlash('Este não é o seu comentário');
            $this->redirect(array('action' => 'index'));
        }
        if (!$this->request->is('post')) {
            $this->log('!$this->request->is(post)');
            throw new MethodNotAllowedException();
        }
        if ($this->Comentario->delete($id)) {
            $this->Session->setFlash('Comentário excluído');
            $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * Verifica se o usuário é o autor do comentário, ou se é um o administrador da página.
     * @param type $usuario ($this->Auth->user())
     * @return boolean
     */
    public function isAuthorized($usuario=null) {
    CakeLog::write('info','ComentariosController isAuthorized('.$usuario.')');
    if (!parent::isAuthorized($usuario)) {
        if ($this->action === 'add') {
            // Todos os usuários registrados podem criar posts
            return true;
        }
        if (in_array($this->action, array('edit', 'delete'))) {
            $postId = (int) $this->request->params['pass'][0];
            return $this->Comentario->isOwnedBy($postId, $usuario['id']);
        }
    }
    return true;
}
    
}