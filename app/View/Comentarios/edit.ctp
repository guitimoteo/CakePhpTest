<!-- File: /app/View/Comentarios/edit.ctp -->

<h1>Edição de comentário</h1>
<?php
    echo $this->Form->create('Usuario', array('action' => 'edit'));
    echo $this->Form->input('usuario', array('rows' => '3'));
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('Salvar');