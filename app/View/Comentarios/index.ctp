<!-- File: /app/View/Comentarios/index.ctp -->

<h1>Blog posts</h1>
<?php
echo $this->Html->link('Add Post', array('controller' => 'comentarios', 'action' => 'add'));
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

    <!-- Here is where we loop through our $comentarios array, printing out comentarios info -->

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