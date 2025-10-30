# 🚀 Collaborative Management API

API RESTful para gerenciamento de projetos colaborativos, incluindo autenticação via **Laravel Sanctum**, controle de tarefas, comentários e tags.

Esta API **não possui frontend** — todas as requisições são feitas via **Postman** ou outro cliente HTTP.

---

## 🧩 Funcionalidades

- Registro e login de usuários com autenticação via token (Sanctum)
- CRUD completo de **projetos**
- CRUD completo de **tarefas**, vinculadas aos projetos
- CRUD completo de **comentários**, vinculados às tarefas
- CRUD completo de **tags** com vínculo em tarefas
- Controle de membros dentro dos projetos
- Rotas versionadas (`/api/v1`)
- Proteção por middleware `auth:sanctum`

---

## 🛠️ Requisitos

- **PHP** 8.1+
- **Composer**
- **MySQL** ou **MariaDB**
- **Postman** (para testes)
- (Opcional) XAMPP / WAMP / Laragon no Windows

---

## ⚙️ Instalação e Configuração

### 1️⃣ Clonar o repositório
```bash
git clone <[https://github.com/mitaloammon/CollaborativeManagementApp]>
cd <CollaborativeManagementApp>
```

### 2️⃣ Instalar dependências
```bash
composer install
```

### 3️⃣ Configurar o ambiente
```bash
cp .env.example .env
```

Edite o arquivo `.env` e configure o banco de dados:
```env
APP_NAME="CollaborativeManagement"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=collab_db
DB_USERNAME=root
DB_PASSWORD=
```

> Crie o banco `collab_db` no MySQL antes de continuar.

### 4️⃣ Gerar chave da aplicação
```bash
php artisan key:generate
```

### 5️⃣ Instalar e configurar o Sanctum
```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

Verifique se o model `User` possui o trait:
```php
use Laravel\Sanctum\HasApiTokens;
```

---

## 🧱 Estrutura de diretórios

```
app/
 ├── Http/
 │   ├── Controllers/
 │   │   ├── AuthController.php
 │   │   ├── ProjectController.php
 │   │   ├── TaskController.php
 │   │   ├── CommentController.php
 │   │   └── TagController.php
 │   └── Middleware/
 ├── Models/
 │   ├── User.php
 │   ├── Project.php
 │   ├── Task.php
 │   ├── Comment.php
 │   └── Tag.php
routes/
 └── api.php
database/
 ├── migrations/
 └── seeders/
```

---

## 🧰 Migrações e Seeds

### Criar as tabelas
```bash
php artisan migrate
```

### (Opcional) Popular com dados de teste
```bash
php artisan db:seed
```

### Recriar tudo do zero
```bash
php artisan migrate:fresh --seed
```

---

## 🚀 Executando o Servidor

```bash
php artisan serve
```

A API estará disponível em:
```
http://127.0.0.1:8000
```

---

## 🧪 Testando a API (Postman)

**Base URL:**
```
http://127.0.0.1:8000/api/v1
```

### 🔹 Registro
`POST /register`

**Body JSON:**
```json
{
  "name": "Name Exemple",
  "email": "name@example.com",
  "password": "123456",
  "password_confirmation": "123456"
}
```

---

### 🔹 Login
`POST /login`

**Body JSON:**
```json
{
  "email": "name@example.com",
  "password": "123456"
}
```

**Resposta esperada:**
```json
{
  "token": "1|VYdXxZr6A2..."
}
```

Guarde o token retornado e use-o nos headers das próximas requisições:

```
Authorization: Bearer <SEU_TOKEN>
Accept: application/json
```

---

### 🔹 Logout
`POST /logout`

---

### 🔹 Projetos
- `GET /projects` — listar
- `POST /projects` — criar
- `GET /projects/{id}` — exibir
- `PUT /projects/{id}` — atualizar
- `DELETE /projects/{id}` — excluir

**Exemplo de criação:**
```json
{
  "name": "Projeto Exemplo",
  "description": "Sistema de gestão colaborativa"
}
```

---

### 🔹 Tarefas
- `POST /projects/{project_id}/tasks`
- `GET /projects/{project_id}/tasks`
- `GET /tasks/{id}`
- `PUT /tasks/{id}`
- `DELETE /tasks/{id}`

---

### 🔹 Comentários
- `POST /tasks/{task_id}/comments`
- `GET /tasks/{task_id}/comments`

---

### 🔹 Tags
- `POST /tags` — criar tag
- `POST /tasks/{task_id}/tags/{tag_id}` — vincular tag a uma tarefa
- `DELETE /tasks/{task_id}/tags/{tag_id}` — remover vínculo

---

## 🧩 Rotas disponíveis

Liste todas as rotas registradas:
```bash
php artisan route:list --path=api
```

---

## 🧼 Limpeza e cache

```bash
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan optimize:clear
```

---

## 📜 Licença
Este projeto é distribuído sob a licença **MIT**.

---

## 👨‍💻 Autor
**Mitalo Ammon Rodrigues Ribeiro**  
Desenvolvedor Júnior — Salvador, Bahia  
📧 [mitaloammon@hotmail.com]  
💼 [https://www.linkedin.com/in/mitalo-ammon/]
