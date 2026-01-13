```markdown
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

- ✅ [Docker Desktop](https://www.docker.com/products/docker-desktop/) (versão 20.10+)
- ✅ [Git](https://git-scm.com/downloads)
- ✅ Terminal/Prompt de comando

**Verifique a instalação:**
```bash
docker --version
docker compose version
git --version
```

## 🚀 Como executar o projeto

### Passo 1: Clone o repositório

```bash
git clone https://github.com/GabeeMoon/teste-tec-guimepa.git
cd teste-tec-guimepa
```

### Passo 2: Inicie o Docker Desktop

- Abra o **Docker Desktop** no Windows
- Aguarde até o ícone da baleia ficar estável no system tray
- Confirme que está rodando: `docker ps`

### Passo 3: Configure as credenciais do banco

⚠️ **IMPORTANTE:** Antes de subir os containers, verifique se o arquivo `app/config/database.php` está correto:

```php
<?php
$host = 'db';           // ✅ Nome do service no docker-compose
$dbname = 'crudphp';    // ✅ Nome do banco
$user = 'user';         // ✅ Usuário do MySQL
$pass = 'password';     // ✅ Senha do MySQL (deve ser 'password', não 'userpassword')

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com banco de dados: " . $e->getMessage());
}
```

### Passo 4: Suba os containers

```bash
docker compose up -d --build
```

Isso irá:
- 🔨 Construir a imagem PHP customizada
- 🚀 Iniciar o container da aplicação (porta 8000)
- 🗄️ Iniciar o container MySQL (porta 3306)
- 📊 Criar automaticamente o banco de dados `crudphp`
- 📋 Importar as tabelas `users` e `posts`

### Passo 5: Verifique se está rodando

```bash
docker compose ps
```

Deve exibir:
```
NAME                        STATUS
teste-tec-guimepa-app-1     Up
teste-tec-guimepa-db-1      Up
```

### Passo 6: Acesse a aplicação

Abra seu navegador em:

```
http://localhost:8000
```

🎉 **Pronto! A aplicação está rodando!**

---

## 🗄️ Banco de dados

### Estrutura

O banco possui duas tabelas principais:

#### Tabela `users`
```sql
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);
```

#### Tabela `posts`
```sql
CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  user_id INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### Credenciais de acesso

| Campo | Valor |
|-------|-------|
| **Host** | `db` (dentro do Docker) / `localhost` (fora do Docker) |
| **Porta** | `3306` |
| **Banco** | `crudphp` |
| **Usuário** | `user` |
| **Senha** | `password` |
| **Root Password** | `rootpassword` |

### Conectar via cliente MySQL (Workbench, DBeaver, etc)

```
Host: localhost
Port: 3306
Username: user
Password: password
Database: crudphp
```

### Acessar MySQL via terminal

```bash
docker compose exec db mysql -uuser -ppassword crudphp
```

---

## 📂 Estrutura do projeto

```
teste-tec-guimepa/
│
├── app/                              # Lógica da aplicação
│   ├── config/                       # Configurações
│   │   └── database.php              # ⚠️ Conexão com MySQL
│   ├── controllers/                  # Controladores (lógica de negócio)
│   └── views/                        # Templates HTML/PHP
│
├── public/                           # Pasta pública (DocumentRoot)
│   ├── index.php                     # Ponto de entrada da aplicação
│   ├── css/                          # Estilos
│   └── js/                           # Scripts JavaScript
│
├── Dockerfile                        # Configuração da imagem PHP
├── docker-compose.yml                # Orquestração dos containers
├── database.sql                      # Script de criação do banco
└── README.md                         # Este arquivo
```

---

## 🛠️ Comandos úteis

### Gerenciar containers

```bash
# Ver status
docker compose ps

# Ver logs em tempo real
docker compose logs -f

# Ver logs apenas da aplicação
docker compose logs -f app

# Ver logs apenas do banco
docker compose logs -f db

# Parar containers (mantém dados)
docker compose stop

# Iniciar containers parados
docker compose start

# Parar e remover containers (mantém volumes)
docker compose down

# Parar e remover TUDO (⚠️ apaga o banco!)
docker compose down -v
```

### Acessar containers

```bash
# Entrar no container PHP
docker compose exec app bash

# Entrar no container MySQL
docker compose exec db bash

# Executar comando SQL direto
docker compose exec db mysql -uuser -ppassword crudphp -e "SHOW TABLES;"
```

### Resetar o projeto

Se algo der errado, resete completamente:

```bash
docker compose down -v
docker compose up -d --build
```

---

## ⚠️ Solução de problemas

### ❌ Erro: "Access denied for user 'user'@'172.18.0.3'"

**Causa:** Senha incorreta no `app/config/database.php`

**Solução:** Edite o arquivo e certifique-se de que a senha é `password` (não `userpassword`):

```php
$pass = 'password';  // ✅ CORRETO
```

---

### ❌ Erro: "Porta 8000 já está em uso"

**Solução:** Mude a porta no `docker-compose.yml`:

```yaml
services:
  app:
    ports:
      - "8080:80"  # Mude para 8080 ou outra porta livre
```

Depois:
```bash
docker compose down
docker compose up -d --build
```

---

### ❌ Erro: "Cannot connect to MySQL"

**Solução 1:** Aguarde o MySQL inicializar (15-30 segundos após `docker compose up`)

```bash
docker compose logs db | grep "ready for connections"
```

**Solução 2:** Recrie os containers:

```bash
docker compose down -v
docker compose up -d --build
```

---

### ❌ Erro: "The system cannot find the file specified" (pipe/dockerDesktopLinuxEngine)

**Causa:** Docker Desktop não está rodando

**Solução:** 
1. Abra o Docker Desktop
2. Aguarde o ícone ficar estável
3. Execute `docker ps` para confirmar
4. Rode novamente `docker compose up -d --build`

---

### ❌ Página branca no navegador

**Verificações:**

1. Logs do PHP:
```bash
docker compose logs app
```

2. Permissões dos arquivos:
```bash
docker compose exec app ls -la /var/www/html/
```

3. Teste a conexão com o banco:
```bash
docker compose exec db mysql -uuser -ppassword crudphp -e "SELECT 1;"
```

---

## 🔧 Configurações técnicas

### Dockerfile

```dockerfile
FROM php:8.0-apache
RUN docker-php-ext-install pdo pdo_mysql
COPY ./app /var/www/html/app
COPY ./public /var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite
WORKDIR /var/www/html/public
EXPOSE 80
```

### docker-compose.yml

- **Versão:** 3.8
- **Services:** `app` (PHP 8.0 + Apache) e `db` (MySQL 8.0)
- **Porta app:** 8000 → 80
- **Porta MySQL:** 3306 → 3306
- **Volume app:** Bind mount (hot reload)
- **Volume db:** Named volume `dbdata` (persistente)
- **Inicialização automática:** `database.sql` via `/docker-entrypoint-initdb.d/`

---

## 📝 Funcionalidades

- ✅ Listar todas as postagens
- ✅ Criar nova postagem
- ✅ Editar postagem existente
- ✅ Deletar postagem
- ✅ Gerenciar usuários
- ✅ Banco de dados persistente
- ✅ Hot reload (alterações no código refletem imediatamente)

---

## 🧪 Testando o projeto

### Verificar conexão com banco

```bash
docker compose exec db mysql -uuser -ppassword crudphp -e "SELECT 1;"
```

Deve retornar:
```
+---+
| 1 |
+---+
| 1 |
+---+
```

### Listar tabelas criadas

```bash
docker compose exec db mysql -uuser -ppassword crudphp -e "SHOW TABLES;"
```

Deve retornar:
```
+-------------------+
| Tables_in_crudphp |
+-------------------+
| posts             |
| users             |
+-------------------+
```

---

## 👤 Autor

**Gabriel Moon**  
📧 GitHub: [@GabeeMoon](https://github.com/GabeeMoon)

---

## 📄 Licença

Projeto desenvolvido como teste técnico.

---

## ✅ Checklist de execução

- [ ] Docker Desktop instalado e rodando
- [ ] Repositório clonado
- [ ] Arquivo `app/config/database.php` com senha correta (`password`)
- [ ] Executou `docker compose up -d --build` sem erros
- [ ] `docker compose ps` mostra 2 containers "Up"
- [ ] Acessou `http://localhost:8000` com sucesso
- [ ] Tabelas `users` e `posts` foram criadas
- [ ] CRUD funciona corretamente

Se todos os itens estão ✅, o projeto está rodando perfeitamente! 🎉

---

## 🆘 Suporte

Se encontrar problemas:

1. Verifique os logs: `docker compose logs -f`
2. Confirme credenciais do banco em `app/config/database.php`
3. Teste conexão: `docker compose exec db mysql -uuser -ppassword crudphp -e "SELECT 1;"`
4. Recrie os containers: `docker compose down -v && docker compose up -d --build`
```
