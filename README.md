# Plataforma de Simulados para o ENEM - Seletiva São Paulo Skills #17

![Logo do Projeto](https://www.fundacaojau.edu.br/imagens/noticias/254/a3a09b4a1050f06496c49f5e733b5715.jpg)

Este projeto é a implementação de uma API para uma plataforma de simulados para o ENEM, desenvolvida como parte da seletiva da São Paulo Skills, na modalidade Tecnologias Web #17.

## Descrição

A API da nossa plataforma de simulados para o ENEM foi projetada para oferecer funcionalidades robustas e seguras, facilitando a integração e o uso de suas principais operações.

## Funcionalidades

A API pode ser acessada a partir do endereço `http://servidor/TP_PHP/api` e possui as seguintes funcionalidades:

- **Registro do usuário**
- **Login/Logout**
- **Criação e correção de provas**

## Requisitos de Segurança

Todas as funcionalidades, exceto **registro** e **login**, devem ser protegidas por tokens de autenticação disponíveis apenas para clientes logados. O envio do token deve ser incluído nos **headers** do request, e todas as respostas da API devem estar no formato **JSON**.

## Endpoints

A seguir, os principais endpoints da API:

1. **POST /registro**  
   Registro de um novo usuário.

2. **POST /login**  
   Realiza o login do usuário e retorna um token de autenticação.

3. **GET /logout**  
   Realiza o logout do usuário, invalidando o token.

4. **POST /prova**  
   Criação de uma nova prova para o usuário logado.

5. **POST /prova/{id}/finalizar**  
   Correção de uma prova realizada pelo usuário.

6. **POST /prova/{id}**  
   Selecionar a prova pelo id.

## Tecnologias Utilizadas

- **Laravel 11**: Framework PHP para o desenvolvimento da API.
- **Laravel Sanctum**: Para autenticação via token.
- **MySQL**: Banco de dados relacional para persistência de dados.

![PHP Badge](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel Badge](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white) 
![MySQL Badge](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white) 

## Instruções de Instalação

1. Clone este repositório:
   ```bash
   git clone https://github.com/JoaoLopes-DEV22/prova-seletiva-spskills.git
