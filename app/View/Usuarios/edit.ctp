       <h2>Alteração do usuário</h2>
<?php
    echo $this->Form->create('Usuario', array('action' =>'edit', 'controller'=>'usuario',/*'enctype' => 'multipart/form-data',*/ 'type' => 'file'));
    echo $this->Form->input('nome');
    echo $this->Form->input('email', array('type'=>'email'));
    /*$this->Form->input('coluna da tabela', array('label' => 'Apresentacao no form'))
        */
    echo $this->Form->input('password', array('label' => 'Senha'), array('type'=>'password')); 
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo "<h1>Escolha a foto para o seu perfil: </h1>";
    echo $this->Form->file('Foto');
    echo $this->Form->submit('Salvar');
    echo $this->Form->end();
	
?>