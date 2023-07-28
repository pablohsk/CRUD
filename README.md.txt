Introdução

/CRUD/
??? apache
?   ??? apache_php.conf
?   ??? Dockerfile
??? Cache
?   ??? cbc42e4c979f69f0_0
?   ??? index-dir
?       ??? the-real-index
??? docker-compose.yml
??? Estado persistente da rede
??? php
?   ??? Dockerfile
??? public
?   ??? config.php
?   ??? Adicionar_funcionario.php
?   ??? Atualizar_funcionario.php
?   ??? Ler_Funcionario.php
?   ??? Listar_funcionario.php
?   ??? Employee.php
?   ?   ??? Conexao_Banco_de_dados.MySQL
?   ??? index.php
??? README.md

Depois que essa estrutura é replicada, o Docker e o Docker Compose são instalados localmente e você pode simplesmente executar ‘docker-compose up -d’ de a raiz do projeto para executar este projeto apontando seu navegador para http://localhost:8080 para ver o projeto em execução.

Composição do Docker:

FROM php:7.4-apache

# Enable mod_rewrite
RUN a2enmod rewrite

# Update packages
RUN apt-get update && apt-get upgrade -y

# Install necessary packages
RUN apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libpng-dev \
    libjpeg-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip mbstring intl exif pcntl bcmath gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www/html
arquivo .env assim:DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=employees
DB_USERNAME=root
DB_PASSWORD=root
A tabela criada no banco de dados em:CREATE TABLE employees (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    birthdate DATE NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    email VARCHAR(255) NOT NULL,
    marital_status ENUM('single', 'married', 'divorced', 'widowed') NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY cpf (cpf),
    UNIQUE KEY email (email)
);


Esse é um Dockerfile que define uma imagem Docker para um aplicativo PHP com Apache. As etapas incluem:

Definir a imagem base para php:7.4-apache
Ativar o módulo mod_rewrite do Apache
Atualizar e atualizar os pacotes do sistema operacional
Instalar os pacotes necessários, incluindo git, unzip e as dependências necessárias para os módulos PHP a serem instalados
Instalar módulos PHP usando docker-php-ext-install
Instalar o Composer
Definir o diretório de trabalho como /var/www/html
O arquivo .env contém as configurações para o banco de dados, como nome do host, porta, nome do banco de dados e credenciais de login. A tabela "employees" é criada no banco de dados com campos para id, nome, data de nascimento, cpf, email, estado civil, data de criação e data de atualização. A chave primária é o campo "id" e há índices exclusivos para os campos "cpf" e "email".


PHP CRUD aplicação

Usaremos o seguinte aplicativo PHP para demonstrar tudo:

    • Employee.php - é uma classe PHP chamada Employee que define as operações CRUD (Create, Read, Update, Delete) para a tabela "employees" em um banco de dados.
    • Adicionar_Funcionario.php - Este script PHP processa um formulário enviado pelo usuário para adicionar um novo funcionário ao banco de dados MySQL. Ele valida os campos do formulário e os dados do CPF e do e-mail antes de inserir as informações do funcionário no banco de dados.
    • Atualizar_Funcionario.php - Este script em PHP tem como objetivo atualizar informações de um funcionário em um banco de dados.
    • Conexao_Banco_de_dados.MySql - É responsável por inserir um novo funcionário no banco de dados. Antes da inserção, ele valida se todos os campos necessários foram preenchidos e se o CPF e o e-mail são válidos. Em seguida, ele executa uma consulta SQL para inserir os dados do funcionário no banco de dados e exibe uma mensagem de sucesso ou erro, dependendo do resultado da consulta. Por fim, ele fecha a conexão com o banco de dados.
    • config.php - Estabelece uma conexão com um banco de dados MySQL utilizando a extensão PDO (PHP Data Objects) e define as constantes necessárias para a conexão com o banco de dados, como o nome do servidor (DB_HOST), número da porta (DB_PORT), nome do banco de dados (DB_NAME), nome do usuário (DB_USER) e senha (DB_PASS).
    • Functions.php - Esse trecho de código define uma classe chamada "Functions" que contém três funções estáticas: "validaCPF", "validaEmail" e "sanitize". A função "validaCPF" recebe um CPF como parâmetro e retorna verdadeiro se o CPF for válido e falso caso contrário. A função "validaEmail" recebe um e-mail como parâmetro e retorna verdadeiro se o e-mail for válido e falso caso contrário. A função "sanitize" recebe uma entrada de usuário como parâmetro e retorna uma versão sanitizada da entrada, removendo caracteres especiais e espaços em branco desnecessários. A classe é definida dentro do namespace "App".
    • Index.php - cria a grade de front-end que exibe registros da tabela "funcionários"
    • Ler_Funcionario.php - Essa parte do código recebe um parâmetro "id" via GET, consulta o banco de dados para recuperar os dados de um funcionário com esse ID, verifica se o funcionário existe e, se existir, exibe suas informações na tela, incluindo nome, data de nascimento, CPF, e-mail e estado civil. Por fim, fecha a conexão com o banco de dados.
    • Listar_Funcionarios.php - Essa parte do código consulta os funcionários armazenados no banco de dados, verifica se existem funcionários cadastrados e, em seguida, exibe uma tabela HTML contendo as informações dos funcionários, incluindo os links de edição e exclusão de cada um deles.



