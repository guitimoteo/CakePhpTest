<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('AuthComponent', 'Controller/Component');
/**
 * Model de usuario
 *
 * @author guilherme
 */
class Usuario extends AppModel {
    public $name     = 'Usuario';
    public $validate = array(
        'nome' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'É necessário preencher o nome'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'É necessário preencher a senha'
            )
        ),
        'Email' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'É necessário preencher o email'
            )
        ),
        'email' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'É necessário preencher o email'
            )
        )
    );

    /**
     * Antes de salvar, criptografa a senha do usuario.
     * @param type $options
     * @return boolean
     */
    public function beforeSave($options = array()) {
        if (!empty($this->data['Usuario']['password'])) {
            $this->data['Usuario']['password'] = AuthComponent::password($this->data['Usuario']['password']);
        }
        return true;
    }
    
    public function isOwnedBy($comentario, $usuario) {
        return $this->field('id', array('id' => $comentario, 'user_id' => $usuario)) === $comentario;
    }

}
