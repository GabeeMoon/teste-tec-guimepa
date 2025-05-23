<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title><?php echo htmlspecialchars($post['title']); ?></title>
</head>
<body>
    <h2><?php echo htmlspecialchars($post['title']); ?></h2>
    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
    <small>Postado por <?php echo htmlspecialchars($post['name']); ?></small><br><br>
    <a href="?page=posts">Voltar</a>
</body>
</html>
