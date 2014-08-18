<!-- File: /app/View/Posts/index.ctp 
POR ENQUANTO NO MOMENTO A INDEX SERA A PAGINA QUE LISTA TODOS OS USUARIOS
-->
<?php echo  $this->Html->link("Início", // link "inicio" com link para pagina que mostra todos os usuários
				array ('action' => 'index'));?><br>
				<?php echo  $this->Html->link("Login", // link "inicio" com link para pagina que mostra todos os usuários
				array ('action' => 'login'));?><br>
				<?php echo  $this->Html->link("Logout", // link "inicio" com link para pagina que mostra todos os usuários
				array ('action' => 'logout'));?><br>		
<p> <?php echo $this->Html->Link("Cadastrar", array('action' => 'add')); ?>

<br><br>
<h1>Usuarios</h1>
<table>
    <tr>
        <th>Id</th>
        <th>Nome</th>
        <th>Email</th>
		<th>Senha</th>
		<th>Foto</th>
    </tr>

    <!-- Aqui é onde nós percorremos nossa matriz $posts, imprimindo
         as informações dos posts -->

    <?php foreach ($usuarios as $usuario): ?>
    <tr>
        <td><?php echo $usuario['Usuario']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($usuario['Usuario']['nome'], // cria-se um link onde o primeiro argumento da função link é o nome do link, no caso o nome do usuario
				  	array('controller' => 'usuarios', 'action' => 'view', $usuario['Usuario']['id'])); // segundo argumento é o link em si, redireciona para a view do usuario em questao
				//echo $usuario['Usuario']['nome']; 
			?>
        </td>
        <td><?php echo $usuario['Usuario']['email']; ?></td>
		<td><?php echo $usuario['Usuario']['password']; ?></td>
		<td><?php echo $usuario['Usuario']['foto']; ?></td>
		
        <td>
            <?php  /* echo $this->Form->postLink(
                'Delete',
                array('action' => 'delete', $usuario['Usuario']['id']),
                array('confirm' => 'Deseja Realmente Deletar?')
            ) */ ?>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $usuario['Usuario']['id']));?>

        </td>
    </tr>
    <?php endforeach; ?>

</table>