# version: '3.8'

services:
  app:
    build: .
    ports:
      - "8000:80"
    volumes:
      - ./:/var/www/html
    depends_on:
      - db

db:
    image: mysql:8.0
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: rootpassword
      MYSQL_DATABASE: crudphp
      MYSQL_USER: user
      MYSQL_PASSWORD: password
    ports:
      - "3306:3306"
    volumes:
      - dbdata:/var/lib/mysql
      - ./database.sql:/docker-entrypoint-initdb.d/database.sql

volumes:
  dbdata:

DOCKERFILE
FROM php:8.0-apache

RUN docker-php-ext-install pdo pdo_mysql

# Copia todo o código para /var/www/html

COPY ./app /var/www/html/app
COPY ./public /var/www/html/public

# Configura o DocumentRoot para a pasta public

RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Ativa rewrite e restart apache

RUN a2enmod rewrite

WORKDIR /var/www/html/public

EXPOSE 80


# Projeto CRUD PHP - Teste Técnico

Aplicação CRUD para gestão de postagens com PHP puro, MySQL 8.0, Docker e Docker Compose.

---

## Tecnologias

- PHP 8.0
- MySQL 8.0
- Apache
- Docker + Docker Compose

---

## Requisitos

- Docker instalado
- Docker Compose instalado (ou plugin `docker compose`)

---

## Como executar

### 1) Clonar o repositório

git clone https://github.com/GabeeMoon/teste-tec-guimepa.git
cd teste-tec-guimepa

### 2) Subir os containers

docker compose up -d --build

Ou se usar `docker-compose` legado:


docker-compose up -d --build



### 3) Aguardar inicialização do MySQL

O banco de dados será criado automaticamente. O arquivo `database.sql` é executado na primeira inicialização do container MySQL.

Aguarde cerca de 10-15 segundos para o MySQL ficar pronto.

### 4) Acessar a aplicação

Abra o navegador em:

http://localhost:8000


---

## Estrutura do projeto


teste-tec-guimepa/
├── app/                   # Código da aplicação (controllers, models, views)
├── public/                # Pasta pública (index.php, assets)
├── database.sql           # Script SQL (executado automaticamente)
├── docker-compose.yml     # Orquestração dos containers
├── Dockerfile             # Imagem PHP customizada
└── README.md              # Este arquivo


---

## Credenciais do banco de dados

Para conectar sua aplicação PHP ao MySQL, use:

- **Host:** `db`
- **Database:** `crudphp`
- **Usuário:** `user`
- **Senha:** `password`
- **Porta interna:** `3306`

**Exemplo de conexão PDO (PHP):**

<?php
$host = 'db';
$dbname = 'crudphp';
$user = 'user';
$pass = 'password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>

---

## Comandos úteis

### Ver logs dos containers


docker compose logs -f


### Parar os containers (mantém dados)

docker compose down

### Parar e remover volumes (reset total do banco)

docker compose down -v


### Reconstruir após alterações no Dockerfile

docker compose up -d --build


### Acessar o container da aplicação PHP

```bash
docker compose exec app bash
```


### Acessar o MySQL via terminal

```bash
docker compose exec db mysql -uuser -ppassword crudphp
```

Ou como root:

```bash
docker compose exec db mysql -uroot -prootpassword crudphp
```


---

## Solução de problemas

### Porta 8000 já está em uso

Edite `docker-compose.yml` e altere a porta:

```yaml
ports:
  - "8001:80"  # Mude 8000 para outra porta disponível
```

Depois recrie:

```bash
docker compose down
docker compose up -d --build
```


### Porta 3306 já está em uso (MySQL local rodando)

Se você tem MySQL instalado localmente, altere a porta publicada:

```yaml
ports:
  - "3307:3306"  # Mude 3306 para 3307
```


### Erro de conexão com banco de dados

Verifique se os containers estão rodando:

```bash
docker compose ps
```

Aguarde alguns segundos para o MySQL inicializar completamente. Verifique os logs:

```bash
docker compose logs db
```


### Banco de dados não foi criado automaticamente

Se o volume já existia de uma execução anterior, o script `database.sql` não executa novamente. Para forçar reset:

```bash
docker compose down -v
docker compose up -d --build
```


---

## Autor

**Gabriel Moon** - [GabeeMoon](https://github.com/GabeeMoon)

---

## Licença

Este projeto foi desenvolvido como teste técnico.

```

***

**PRONTO PARA USO**. Copie todo o conteúdo acima e substitua o README.md atual do repositório.```

