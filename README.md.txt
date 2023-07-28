Introdu��o

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

Depois que essa estrutura � replicada, o Docker e o Docker Compose s�o instalados localmente e voc� pode simplesmente executar �docker-compose up -d� de a raiz do projeto para executar este projeto apontando seu navegador para http://localhost:8080 para ver o projeto em execu��o.

Composi��o do Docker:

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


Esse � um Dockerfile que define uma imagem Docker para um aplicativo PHP com Apache. As etapas incluem:

Definir a imagem base para php:7.4-apache
Ativar o m�dulo mod_rewrite do Apache
Atualizar e atualizar os pacotes do sistema operacional
Instalar os pacotes necess�rios, incluindo git, unzip e as depend�ncias necess�rias para os m�dulos PHP a serem instalados
Instalar m�dulos PHP usando docker-php-ext-install
Instalar o Composer
Definir o diret�rio de trabalho como /var/www/html
O arquivo .env cont�m as configura��es para o banco de dados, como nome do host, porta, nome do banco de dados e credenciais de login. A tabela "employees" � criada no banco de dados com campos para id, nome, data de nascimento, cpf, email, estado civil, data de cria��o e data de atualiza��o. A chave prim�ria � o campo "id" e h� �ndices exclusivos para os campos "cpf" e "email".


PHP CRUD aplica��o

Usaremos o seguinte aplicativo PHP para demonstrar tudo:

    � Employee.php - � uma classe PHP chamada Employee que define as opera��es CRUD (Create, Read, Update, Delete) para a tabela "employees" em um banco de dados.
    � Adicionar_Funcionario.php - Este script PHP processa um formul�rio enviado pelo usu�rio para adicionar um novo funcion�rio ao banco de dados MySQL. Ele valida os campos do formul�rio e os dados do CPF e do e-mail antes de inserir as informa��es do funcion�rio no banco de dados.
    � Atualizar_Funcionario.php - Este script em PHP tem como objetivo atualizar informa��es de um funcion�rio em um banco de dados.
    � Conexao_Banco_de_dados.MySql - � respons�vel por inserir um novo funcion�rio no banco de dados. Antes da inser��o, ele valida se todos os campos necess�rios foram preenchidos e se o CPF e o e-mail s�o v�lidos. Em seguida, ele executa uma consulta SQL para inserir os dados do funcion�rio no banco de dados e exibe uma mensagem de sucesso ou erro, dependendo do resultado da consulta. Por fim, ele fecha a conex�o com o banco de dados.
    � config.php - Estabelece uma conex�o com um banco de dados MySQL utilizando a extens�o PDO (PHP Data Objects) e define as constantes necess�rias para a conex�o com o banco de dados, como o nome do servidor (DB_HOST), n�mero da porta (DB_PORT), nome do banco de dados (DB_NAME), nome do usu�rio (DB_USER) e senha (DB_PASS).
    � Functions.php - Esse trecho de c�digo define uma classe chamada "Functions" que cont�m tr�s fun��es est�ticas: "validaCPF", "validaEmail" e "sanitize". A fun��o "validaCPF" recebe um CPF como par�metro e retorna verdadeiro se o CPF for v�lido e falso caso contr�rio. A fun��o "validaEmail" recebe um e-mail como par�metro e retorna verdadeiro se o e-mail for v�lido e falso caso contr�rio. A fun��o "sanitize" recebe uma entrada de usu�rio como par�metro e retorna uma vers�o sanitizada da entrada, removendo caracteres especiais e espa�os em branco desnecess�rios. A classe � definida dentro do namespace "App".
    � Index.php - cria a grade de front-end que exibe registros da tabela "funcion�rios"
    � Ler_Funcionario.php - Essa parte do c�digo recebe um par�metro "id" via GET, consulta o banco de dados para recuperar os dados de um funcion�rio com esse ID, verifica se o funcion�rio existe e, se existir, exibe suas informa��es na tela, incluindo nome, data de nascimento, CPF, e-mail e estado civil. Por fim, fecha a conex�o com o banco de dados.
    � Listar_Funcionarios.php - Essa parte do c�digo consulta os funcion�rios armazenados no banco de dados, verifica se existem funcion�rios cadastrados e, em seguida, exibe uma tabela HTML contendo as informa��es dos funcion�rios, incluindo os links de edi��o e exclus�o de cada um deles.



