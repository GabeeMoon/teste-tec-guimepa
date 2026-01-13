# 🐳 Projeto CRUD PHP - Docker Environment

Aplicação CRUD desenvolvida com **PHP 8.0**, **MySQL 8.0** e **Apache**, totalmente dockerizada para facilitar o desenvolvimento e deploy.

---

## 🚀 Tecnologias Utilizadas

- **PHP 8.0** (Imagem oficial com Apache)
- **MySQL 8.0**
- **Docker** & **Docker Compose**
- **PDO** (Conexão segura com banco de dados)
- **Apache Mod Rewrite** (Ativado para rotas amigáveis)

---

## 📋 Pré-requisitos

Para rodar este projeto, você precisa ter instalado:

- [Docker Engine](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

---

## 🔧 Como Executar o Projeto

Siga os passos abaixo para subir o ambiente de desenvolvimento:

### 1. Clonar o repositório

```bash
git clone [https://github.com/GabeeMoon/teste-tec-guimepa.git](https://github.com/GabeeMoon/teste-tec-guimepa.git)
cd teste-tec-guimepa
```

### 2. Subir os containers

Este comando irá baixar as imagens, construir o Dockerfile e iniciar os serviços:

```bash
docker compose up -d --build
```

### 3. Aguardar o Banco de Dados

> **Nota:** Na primeira execução, o MySQL pode levar de 15 a 30 segundos para inicializar e importar o arquivo `database.sql`.

### 4. Acessar a aplicação

Abra seu navegador e acesse:

**[http://localhost:8000](http://localhost:8000)**

---

## 🛢️ Configuração do Banco de Dados

Para conectar o PHP ao MySQL dentro do ambiente Docker, utilize as seguintes credenciais (já configuradas no `docker-compose.yml`):

| Parâmetro | Valor |
| :--- | :--- |
| **Host** | `db` |
| **Database** | `crudphp` |
| **Usuário** | `user` |
| **Senha** | `password` |
| **Porta Interna** | `3306` |

### Exemplo de Conexão PDO (PHP)

```php
$host = 'db'; // O nome do serviço no docker-compose é o host
$db   = 'crudphp';
$user = 'user';
$pass = 'password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
```

---

## 📂 Estrutura de Arquivos

```text
.
├── app/                  # Lógica da aplicação (Controllers, Models)
├── public/               # Document Root (index.php, css, js, images)
├── database.sql          # Script de inicialização do banco
├── docker-compose.yml    # Orquestração dos serviços
├── Dockerfile            # Configuração da imagem PHP
└── README.md             # Documentação do projeto
```

> **Atenção:** O `Dockerfile` está configurado para usar a pasta `/public` como DocumentRoot do Apache. Certifique-se de que seu `index.php` esteja dentro de `./public`.

---

## 🛠️ Comandos Úteis

**Ver logs em tempo real:**
```bash
docker compose logs -f
```

**Parar os containers:**
```bash
docker compose down
```

**Acessar o terminal do container PHP:**
```bash
docker compose exec app bash
```

**Acessar o MySQL via terminal:**
```bash
docker compose exec db mysql -uuser -ppassword crudphp
```

---

## ⚠️ Solução de Problemas

### Porta 8000 em uso
Se a porta 8000 estiver ocupada, altere no arquivo `docker-compose.yml`:
```yaml
ports:
  - "8080:80" # Mapeia a porta 8080 do host para a 80 do container
```

### Erro de Conexão com o Banco
Se receber erro de conexão, verifique se o container do banco está saudável:
```bash
docker compose ps
```
Se precisar resetar o banco de dados completamente (apagar dados e recriar):
```bash
docker compose down -v
docker compose up -d --build
```

---

## 👤 Autor

**Gabriel Moon**

- Github: [@GabeeMoon](https://github.com/GabeeMoon)

---

## 📄 Licença

Este projeto é de código aberto.
