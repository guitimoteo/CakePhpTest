<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Comentario
 *
 * @author gregory
 */
class Comentario extends AppModel{
    public $name        = 'Comentario';
       public $validate = array(
           'comentario' => array(
            'rule' => 'notEmpty'
        )
    );
       public function isOwnedBy($post, $user) {
                $returnId = $this->field('id', array('id' => $post, 'user_id' => $user));
		CakeLog::write('debug', 'Comentario isOwnedBy('.$post.', '.$user.') === '.$returnId.'');
                return $returnId  === $post;
	}
}
