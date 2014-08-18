<!-- File: /app/View/Posts/edit.ctp -->

<h1>Edição de comentário</h1>
<?php
    echo $this->Form->create('Comentario', array('action' => 'edit'));
    echo $this->Form->input('comentario', array('rows' => '3'));
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('Salvar');