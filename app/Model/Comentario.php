<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Model do comentário
 *
 * @author guilherme
 */
class Comentario extends AppModel{
    public $name        = 'Comentario';
       public $validate = array(
           'comentario' => array(
            'rule' => 'notEmpty'
        )
    );
       /**
        * Verifica se o poste pertence ao usuário
        * @param type $post
        * @param type $user
        * @return type
        */
       public function isOwnedBy($post, $user) {
                return $post == $this->field('id', array('id' => $post, 'user_id' => $user));
	}
}
