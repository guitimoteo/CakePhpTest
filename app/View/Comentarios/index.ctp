<!-- File: /app/View/Comentarios/index.ctp -->

<h1>Blog posts</h1>
<?php
echo $this->Html->link('Comente!', array('controller' => 'comentarios', 'action' => 'add'));
echo $this->Html->link('Log in', array('controller' => 'usuarios', 'action' => 'login'));
echo $this->Html->link('Cadastre-se', array('controller' => 'usuarios', 'action' => 'add'));
echo $this->Html->link('Log out', array('controller' => 'usuarios', 'action' => 'logout'));
?>
<table>
    <tr>
        <th>Id</th>
        <th>Usuário</th>
        <th>Comentário</th>
        <th>Criado</th>
        <th>Editado</th>
        <th>Ação</th>
    </tr>

    <!-- Listagem de todo o array de comentários -->

    <?php foreach ($comentarios as $comentario): ?>
    <tr>
        <td><?php echo $comentario['Comentario']['id']; ?></td>
        <td><?php echo $comentario['Comentario']['user']; ?></td>
        <td>
            <?php echo $this->Html->link($comentario['Comentario']['comentario'],
array('controller' => 'comentarios', 'action' => 'view', $comentario['Comentario']['id'])); ?>
        </td>
        <td><?php echo $comentario['Comentario']['created']; ?></td>
        <td><?php echo $comentario['Comentario']['modified']; ?></td>
        <td><?php echo $this->Html->link("edita",
array('controller' => 'comentarios', 'action' => 'edit', $comentario['Comentario']['id']));
                 echo "   "; 
                 echo $this->Form->postLink("deleta",
array('action' => 'delete', $comentario['Comentario']['id']),array('confirm' => 'Deletar o comentário?'));?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($comentario); ?>
</table>