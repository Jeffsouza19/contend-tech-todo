# Contend Tech - TODO List

Uma aplicação de lista de tarefas (To-Do List) robusta e moderna, construída com o framework Laravel. O projeto segue as melhores práticas de desenvolvimento, focando em código limpo, testável e de fácil manutenção.

## ✨ Features

- **Autenticação de Usuário:** Sistema completo de registro, login e logout com **Laravel Breeze**.
- **Gerenciamento de Tarefas:** Funcionalidade CRUD (Criar, Ler, Atualizar, Deletar) completa para tarefas.
- **Status de Tarefas:** Alterne facilmente o status de uma tarefa entre "Pendente" e "Concluída".
- **Interface Responsiva:** UI limpa e amigável construída com **Tailwind CSS** e componentes **Blade**.
- **Exclusão Segura:** Utiliza **Soft Deletes** para que as tarefas possam ser recuperadas se necessário.
- **Pronto para API:** Autenticação via token com **Laravel Sanctum** já configurada.
- **Auditoria:** Rastreamento de alterações nos modelos com o pacote `owen-it/laravel-auditing`.

## 🚀 Tecnologias e Serviços

Este projeto utiliza um conjunto de ferramentas modernas para garantir a qualidade e a eficiência do desenvolvimento.

- **Framework:** Laravel 12
- **PHP:** Versão 8.3+
- **Frontend:** Tailwind CSS, Alpine.js (via Blade UI Kit)
- **Ícones:** Blade Heroicons
- **Banco de Dados:** SQLite (padrão), com suporte para MySQL e PostgreSQL.

### Ferramentas de Qualidade de Código

- **Laravel Pint:** Para formatação e padronização automática do estilo de código PHP.
- **Larastan (PHPStan):** Para análise estática de código, ajudando a encontrar bugs antes da execução.
- **Rector:** Para refatoração e atualização automatizada do código para novas versões e melhores práticas.

### Ambiente de Desenvolvimento

- **Docker:** O projeto está preparado para ser executado em contêineres, garantindo consistência entre ambientes.
- **Laravel Sail:** Uma interface de linha de comando para interagir com o ambiente de desenvolvimento Docker padrão do Laravel.

## ⚙️ Instalação e Configuração Local

Siga os passos abaixo para configurar o ambiente de desenvolvimento localmente.

### Pré-requisitos

- PHP 8.3+
- Composer
- Node.js & NPM
- Docker (se for usar o Sail)

### Passos

1.  **Clone o repositório:**
    ```bash
    git clone https://github.com/seu-usuario/contend-tech-todo.git
    cd contend-tech-todo
    ```

2.  **Instale as dependências:**
    ```bash
    composer install
    npm install
    ```

3.  **Configure o ambiente:**
    Copie o arquivo de exemplo `.env.example` para criar seu próprio arquivo de configuração `.env`.
    ```bash
    cp .env.example .env
    ```

4.  **Gere a chave da aplicação:**
    ```bash
    php artisan key:generate
    ```

5.  **Configure o Banco de Dados:**
    Abra o arquivo `.env` e configure suas credenciais de banco de dados. Por padrão, o projeto usa **SQLite**, que não requer configuração adicional.

    **Para SQLite (padrão):**
    ```dotenv
    DB_CONNECTION=sqlite
    # O arquivo do banco de dados será criado automaticamente em database/database.sqlite
    ```

    **Para MySQL:**
    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=todo_app
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6.  **Execute as Migrations:**
    Este comando criará todas as tabelas necessárias no banco de dados.
    ```bash
    php artisan migrate
    ```
    Para iniciar a tabela com dados ficticios para teste execute o comando:
    ```bash
    php artisan migrate --seed
    ```
    Caso já tenha rodado as migrates e queira apenas popular o banco de dados com dados fictícios, execute:
    ```bash
    php artisan db:seed
    ```
    O usuário padrão criado pelo seeder é:
    - **Email:** `teste@teste.com`
    - **Senha:** `password`

## ▶️ Executando a Aplicação

1.  **Inicie os servidores:**
    O projeto possui um script conveniente no `composer.json` para iniciar o servidor PHP e o Vite (para o frontend) simultaneamente.
    ```bash
    composer run dev
    ```

2.  **Acesse a aplicação:**
    Abra seu navegador e acesse: http://127.0.0.1:8000

## 🛠️ Comandos Úteis

- **Executar Testes (Pest):**
  ```bash
  php artisan test
  ```

- **Verificar Estilo de Código (Pint):**
  ```bash
  ./vendor/bin/pint --test
  ```

- **Corrigir Estilo de Código (Pint):**
  ```bash
  ./vendor/bin/pint
  ```

- **Análise Estática (Larastan):**
  ```bash
  ./vendor/bin/phpstan analyse
  ```

- **Refatoração (Rector):**
  Para simular as alterações (dry run):
  ```bash
  ./vendor/bin/rector process --dry-run
  ```
  Para aplicar as alterações:
  ```bash
  ./vendor/bin/rector process
  ```

## 🔑 Dados de Acesso

1.  Para começar, acesse a página de registro: http://127.0.0.1:8000/register.
2.  Crie uma nova conta de usuário.
3.  Após o login, você será redirecionado para o painel de tarefas.
