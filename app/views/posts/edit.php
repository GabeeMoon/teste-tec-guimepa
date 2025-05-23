<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Editar Postagem</title>
</head>
<body>
    <h2>Editar Postagem</h2>
    <form method="POST" action="?page=edit&id=<?php echo $post['id']; ?>">
        <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required /><br><br>
        <textarea name="content" rows="5" cols="30" required><?php echo htmlspecialchars($post['content']); ?></textarea><br><br>
        <button type="submit">Atualizar</button>
    </form>
    <a href="?page=posts">Cancelar</a>
</body>
</html>
