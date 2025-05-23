<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Cadastro</title>
</head>
<body>
    <h2>Cadastro</h2>
    <form method="POST" action="?page=register">
        <input type="text" name="name" placeholder="Nome" required /><br><br>
        <input type="email" name="email" placeholder="Email" required /><br><br>
        <input type="password" name="password" placeholder="Senha" required /><br><br>
        <button type="submit">Cadastrar</button>
    </form>
    <p>Já tem conta? <a href="?page=login">Faça login</a></p>
</body>
</html>
