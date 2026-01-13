# 📝 Projeto CRUD PHP - Teste Técnico

Sistema de gerenciamento de postagens (CRUD) desenvolvido com **PHP 8.0**, **MySQL 8.0** e **Apache**, containerizado com **Docker**.

---

## 📋 Sobre o projeto

Aplicação web que permite:
- ✅ Criar, listar, editar e deletar **postagens**
- ✅ Gerenciar **usuários** do sistema
- ✅ Relacionamento entre usuários e postagens
- ✅ Interface web responsiva
- ✅ Containerização completa com Docker

---

## 🛠️ Tecnologias utilizadas

- **Backend:** PHP 8.0
- **Banco de dados:** MySQL 8.0
- **Servidor web:** Apache 2.4
- **Containerização:** Docker + Docker Compose
- **Arquitetura:** MVC (Model-View-Controller)

---

## 📦 Pré-requisitos

Antes de começar, certifique-se de ter instalado:

- ✅ Docker Desktop (versão 20.10+)
- ✅ Git
- ✅ Terminal/Prompt de comando

Verifique a instalação:
```bash
docker --version
docker compose version
git --version
```

---

## 🚀 Como executar o projeto

### Passo 1: Clonar o repositório

```bash
git clone https://github.com/GabeeMoon/teste-tec-guimepa.git
cd teste-tec-guimepa
```

### Passo 2: Iniciar o Docker Desktop

- Abra o Docker Desktop no Windows
- Aguarde até o ícone da baleia ficar estável
- Confirme que está rodando: `docker ps`

### Passo 3: Verificar configuração do banco

Arquivo: `app/config/database.php`

```php
<?php
$host = 'db';
$dbname = 'crudphp';
$user = 'user';
$pass = 'password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com banco de dados: " . $e->getMessage());
}
```

### Passo 4: Subir os containers

```bash
docker compose up -d --build
```

Isso irá:
- Construir a imagem PHP
- Subir o container da aplicação na porta 8000
- Subir o MySQL na porta 3306
- Criar o banco `crudphp`
- Importar `database.sql`

### Passo 5: Verificar status

```bash
docker compose ps
```

### Passo 6: Acessar a aplicação

Abra o navegador em:

```
http://localhost:8000
```

---

## 🗄️ Banco de dados

Tabelas principais:

### users
```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);
```

### posts
```sql
CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  user_id INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

Credenciais:
- Host: db (de dentro dos containers) / localhost (de fora)
- Porta: 3306
- Banco: crudphp
- Usuário: user
- Senha: password

---

## 📂 Estrutura do projeto

```
teste-tec-guimepa/
│
├── app/
│   ├── config/
│   │   └── database.php
│   ├── controllers/
│   └── views/
│
├── public/
│   └── index.php
│
├── Dockerfile
├── docker-compose.yml
├── database.sql
└── README.md
```

---

## 🛠️ Comandos úteis

Status dos containers:
```bash
docker compose ps
```

Logs gerais:
```bash
docker compose logs -f
```

Logs da aplicação:
```bash
docker compose logs -f app
```

Logs do banco:
```bash
docker compose logs -f db
```

Entrar no container PHP:
```bash
docker compose exec app bash
```

Entrar no container MySQL:
```bash
docker compose exec db bash
```

Parar containers (mantém dados):
```bash
docker compose stop
```

Subir novamente:
```bash
docker compose start
```

Remover containers (mantém dados):
```bash
docker compose down
```

Remover tudo (inclusive banco):
```bash
docker compose down -v
```

---

## Solução de problemas

- Erro de acesso negado para o usuário `user`:
  - Verificar se `app/config/database.php` está com `$pass = 'password';`

- Porta 8000 em uso:
  - Editar `docker-compose.yml` e mudar `"8000:80"` para outra porta

- Docker não conecta no engine:
  - Abrir o Docker Desktop antes de rodar `docker compose up`

---

## Autor

Gabriel Moon - https://github.com/GabeeMoon
