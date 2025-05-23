<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Postagens</title>
</head>
<body>
    <h2>Postagens</h2>
    <p>Olá, <?php echo htmlspecialchars($_SESSION['user']['name']); ?> | <a href="?page=logout">Sair</a></p>

    <h3>Criar nova postagem</h3>
    <form method="POST" action="?page=posts">
        <input type="text" name="title" placeholder="Título" required /><br><br>
        <textarea name="content" placeholder="Conteúdo" rows="5" cols="30" required></textarea><br><br>
        <button type="submit">Publicar</button>
    </form>

    <h3>Lista de Postagens</h3>
    <?php if (count($posts) === 0): ?>
        <p>Nenhuma postagem encontrada.</p>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
                <h4><?php echo htmlspecialchars($post['title']); ?></h4>
                <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                <small>Por: <?php echo htmlspecialchars($post['name']); ?></small><br>
                <a href="?page=show&id=<?php echo $post['id']; ?>">Ver</a>
                <?php if ($post['user_id'] == $_SESSION['user']['id']): ?>
                    | <a href="?page=edit&id=<?php echo $post['id']; ?>">Editar</a>
                    | <a href="?page=delete&id=<?php echo $post['id']; ?>" onclick="return confirm('Excluir esta postagem?')">Excluir</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
