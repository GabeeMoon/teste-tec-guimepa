<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="?page=login">
        <input type="email" name="email" placeholder="Email" required /><br><br>
        <input type="password" name="password" placeholder="Senha" required /><br><br>
        <button type="submit">Entrar</button>
    </form>
    <p>Não tem conta? <a href="?page=register">Cadastre-se</a></p>
</body>
</html>
