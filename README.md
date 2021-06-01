<h1 align="center">TCC SENAI</h1>
<h2 align="center">Sistema de reserva de veículos</h2>

## :bookmark_tabs: Sobre

Este repositório tem como finalidade gerenciar o código e a documentação do **sistema de gerenciamento de veículos**, um trabalho de conclusão de curso desenvolvido pelos alunos **Gabriel, Gustavo, Luís e Vanderlei**, do curso de desenvolvimento de sistemas aplicado pelo Serviço Nacional de Aprendizagem Industrial (SENAI).

O sistema tem o objetivo de gerenciar entrada e saída de veículos disponíveis em uma empresa, onde os usuários podem reservar um horário para usar os carros empresariais.

## :adult: Tipos de usuários

Tendo em vista o gerenciamento administrativo dos superiores, o sistema disponibiliza dois tipos de usuários:

- Usuário comum

    Capaz de utilizar as funcionalidades mais primitivas do sistema, como reservar horários para usar os veículos disponíveis, acessar histórico de reservas, cancelar reservas, dentre outros.

    Esse tipo de usuário precisa ser previamente cadastrado por um administrador.

- Administrador

    Possui todas as responsabilidades de um usuário comum, porém, possui privilégios adicionais como cadastrar usuários, cadastrar veículos, dentre outros.

## :gear: Funcionamento da aplicação

### Login :door:

Para acessar as funcionalidades do sistema, o usuário deve estar previamente cadastrado e realizar o processo de login, que consiste dos campos **CPF** e **Senha**.

<p align="center"><img src="./Projeto/images/demo-login.gif" alt="Exemplo Login" /></p>

### Cadastro :clipboard:

O sistema permite a criação, edição e exclusão de dados do sistema, que são:

- Veículos (Modelo, placa e proprietário)
- Usuários (Nome, CPF, Departamento, Status e Senha)

<p align="center"><img src="./Projeto/images/demo-usuarios.jpg" alt="Exemplo cadastro de usuário" /></p>

### Reserva de veículos :car:

Refere-se a principal funcionalidade do sistema, onde o sistema exibe uma lista com os veículos e os horários em que se encontra disponível ou não para reserva. O usuário pode então selecionar um horário válido e reservar o veículo para uso, registrando o destino e quem utilizará o veículo.

<p align="center"><img src="./Projeto/images/demo-reserva.gif" alt="Exemplo cadastro de reserva" /></p>

### Histórico :clock3:

Todos os usuários podem também acessar seu histórico de reserva, que mostra todas as reservas utilizadas pelo usuário, contendo informações como destino, horário, dentre outros.

Usuários do tipo "administrador" podem ainda verificar o histórico de todos os usuários.

## :computer: Tecnologias usadas

- HTML5
- CSS3
- JavaScript
- PHP
- MySQL
- Materialize CSS
