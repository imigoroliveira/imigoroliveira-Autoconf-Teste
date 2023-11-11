# AutoConf Veículos - README

Este repositório contém o código-fonte de uma aplicação baseada no Laravel, utilizando Docker para facilitar a configuração e execução. A seguir, explicação resumida da arquitetura do aplicativo:

## Estrutura do Projeto

O projeto é organizado com a seguinte estrutura:

- `laravel-app/`: Contém o código-fonte do aplicativo Laravel.
- `docker-compose.yml`: Define a configuração dos serviços Docker para a aplicação.
- Outros arquivos e diretórios típicos de um projeto Laravel.

## Serviços Docker

O aplicativo utiliza três serviços Docker:

1. **laravel-docker:**
   - **Imagem:** A imagem é construída com base no Dockerfile no diretório atual (`.`).
   - **Volumes:** O código-fonte do Laravel é montado no caminho `/var/www/html`.
   - **Portas:** O aplicativo Laravel é exposto na porta `9000`.
   - **Usuário:** Define o usuário dentro do contêiner como "www-data:www-data".

2. **mysql_db:**
   - **Imagem:** Utiliza a imagem oficial do MySQL.
   - **Variáveis de Ambiente:** Configura a senha do root e o nome do banco de dados.
   - **Portas:** Mapeia a porta `3306` do contêiner para a máquina host.

3. **phpmyadmin:**
   - **Imagem:** Utiliza a imagem oficial do phpMyAdmin.
   - **Portas:** O phpMyAdmin é exposto na porta `9001`.

## Instruções de Execução

Para rodar a aplicação, execute o seguinte comando no terminal na raiz do projeto:

```bash
docker-compose build
