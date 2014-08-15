<!-- File: /app/View/Comentarios/add.ctp -->

<h1>Adiciona um comentário</h1>
<?php
echo $this->Form->create('Comentario');
echo $this->Form->input('comentario', array('rows' => '3'));
echo $this->Form->end('Salvar');
