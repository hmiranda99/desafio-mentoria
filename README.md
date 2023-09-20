<div align="center">

[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=hmiranda99_desafio-mentoria&metric=vulnerabilities)](https://sonarcloud.io/summary/new_code?id=hmiranda99_desafio-mentoria)
[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=hmiranda99_desafio-mentoria&metric=bugs)](https://sonarcloud.io/summary/new_code?id=hmiranda99_desafio-mentoria)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=hmiranda99_desafio-mentoria&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=hmiranda99_desafio-mentoria)
[![Code Smells](https://sonarcloud.io/api/project_badges/measure?project=hmiranda99_desafio-mentoria&metric=code_smells)](https://sonarcloud.io/summary/new_code?id=hmiranda99_desafio-mentoria)
[![Lines of Code](https://sonarcloud.io/api/project_badges/measure?project=hmiranda99_desafio-mentoria&metric=ncloc)](https://sonarcloud.io/summary/new_code?id=hmiranda99_desafio-mentoria)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=hmiranda99_desafio-mentoria&metric=coverage)](https://sonarcloud.io/summary/new_code?id=hmiranda99_desafio-mentoria)
[![Duplicated Lines (%)](https://sonarcloud.io/api/project_badges/measure?project=hmiranda99_desafio-mentoria&metric=duplicated_lines_density)](https://sonarcloud.io/summary/new_code?id=hmiranda99_desafio-mentoria)

</div>

<br>

<div align="center">
 
# Desafio mentoria 
  
</div>
  
<h3>
<details>

   <summary>
     <b> 📘 Sumário </b> 
   </summary>

   <br>

  [Sobre](#--sobre-o-desafio) <br>
  [Skills necessárias](#-skills-necessárias) <br>
  [Modelagem de dados](#-modelagem-de-dados) <br>
  [Primeiros passos](#-primeiros-passos) <br>

</details>
</h3>


##

### <div> 🧩 Sobre o desafio</div>
Para esse desafio foi desenvolvida uma API escalável que tem como objetivo realizar transferências bancárias entre dois tipos de usuários, comuns e lojistas. 

##

<div>
  
### 🚀 Skills necessárias
<img src="https://img.shields.io/badge/PHP 8.1-777BB4?style=for-the-badge&logo=php&logoColor=white">
<img src="https://img.shields.io/badge/MySQL 8.0-005C84?style=for-the-badge&logo=mysql&logoColor=white">
<img src="https://img.shields.io/badge/Laravel 9.3.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white">
<img src="https://img.shields.io/badge/Nginx 1.21.6-009639?style=for-the-badge&logo=nginx&logoColor=white">
<img src="https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white">
<img src="https://img.shields.io/badge/RabbitMQ 3.7-FF6600.svg?style=for-the-badge&logo=RabbitMQ&logoColor=white">
<img src="https://img.shields.io/badge/supervisor-004088.svg?style=for-the-badge">
<img src="https://img.shields.io/badge/SonarCloud-F3702A.svg?style=for-the-badge&logo=SonarCloud&logoColor=white">
<img src="https://img.shields.io/badge/GitHub%20Actions-2088FF.svg?style=for-the-badge&logo=GitHub-Actions&logoColor=white">
</div>

##
  
<div>

### ⚠️ Regras do desafio
Temos 2 tipos de usuários, os comuns e lojistas, ambos têm carteira com dinheiro e realizam transferências entre eles. Vamos nos atentar somente ao fluxo de transferência entre dois usuários.

Requisitos:

- Para ambos tipos de usuário, precisamos do Nome Completo, CPF, e-mail e Senha. CPF/CNPJ e e-mails devem ser únicos no sistema. Sendo assim, seu sistema deve permitir apenas um cadastro com o mesmo CPF ou endereço de e-mail.

- Usuários podem enviar dinheiro (efetuar transferência) para lojistas e entre usuários.

- Lojistas só recebem transferências, não enviam dinheiro para ninguém.

- Validar se o usuário tem saldo antes da transferência.

- Antes de finalizar a transferência, deve-se consultar um serviço autorizador externo, use este mock para simular (https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6).

- A operação de transferência deve ser uma transação (ou seja, revertida em qualquer caso de inconsistência) e o dinheiro deve voltar para a carteira do usuário que envia.

- No recebimento de pagamento, o usuário ou lojista precisa receber notificação (envio de email, sms) enviada por um serviço de terceiro e eventualmente este serviço pode estar indisponível/instável. Use este mock para simular o envio (http://o4d9z.mocklab.io/notify).

- Este serviço deve ser RESTFul.

##
### 🎯 Modelagem de dados
<img width="784" alt="Captura de Tela 2022-04-05 às 10 21 25" src="https://user-images.githubusercontent.com/79329906/162442432-1faa2ec4-3e95-4ea7-80ce-276232aa0d81.png">

</div>

##
### ⭐ Fluxograma 
<img width="784" src="https://github.com/hmiranda99/desafio-mentoria/assets/79329906/5ee2dd61-fd56-41ff-ac0e-8b6ffa12eee2">

  
##
### 🔗 URLs importantes
🫀 Health check: [http://localhost:65080/health](http://localhost:65080/health) <br>
📖 Documentação: [http://localhost:65080/api/documentation](http://localhost:65080/api/documentation) <br>
:shipit: Documentação JSON: [http://localhost:65080/docs](http://localhost:65080/api/documentation) <br>
🐰 RabitMQ: [http://localhost:15672](http://localhost:15672)

##
### 📚 Libs
- [x] Health check <br>
- [x] Swagger <br>
- [x] PHPCs <br>
- [x] PHPUnit <br>

##
### 👨🏻‍💻 Primeiros passos

Para subir o container
```
docker-compose up -d
```
Ver se os cantainers estão de pé
```
docker-compose ps
```
Entrar no container
```
docker exec -it desafio_php sh
```
Rodar as migrations
```
php artisan migrate
```
Rodar os seeders
```
php artisan db:seed
```

##
### 🐰 RabitMQ
URL
```
http://localhost:15672
```
Username e Password
```
guest
```

##
### 🧪 Testes
```
composer phpunit
```

##
### :construction: Gerar Swagger
```
php artisan l5-swagger:generate
```

##
### :bowtie: Melhorias de projeto
- Logs para monitoramento
- Interfaces entre camadas

