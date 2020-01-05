## Programa para mercado 

    Desenvolva um programa para um mercado que permita o cadastro dos produtos, dos tipos de cada produto, dos valores percentuais de imposto dos tipos de produtos, a tela de venda, onde será informado os produtos e quantidades adquiridos, o sistema deve apresentar o valor de cada item multiplicado pela quantidade adquirida e a quantidade pago de imposto em cada item, um totalizador do valor da compra e um totalizador do valor dos impostos.
    
    O sistema deve ser desenvolvido utilizando as seguintes tecnologias:  
    ·         PHP 5   
    ·         Banco de dados PostgreSQL versão 9.4    
    
    Quaisquer dúvidas sobre a especificação do programa a ser desenvolvido, podem ser questionados por e-mail. Evitar o uso de framework PHP.   
    
    Deverão ser enviados para análise:   
    ·         O sistema no formato ZIP para realizar o deploy no servidor de aplicação.   
    ·         O banco de dados utilizado.   
    ·         Os detalhes de configuração do banco de dados, como o nome de usuário e senha, o nome do alias do banco de dados e informações adicionais para validarmos o aplicativo.

## Como executar este projeto

#### Requisitos
* executar projeto em um OS Linux
* instalar corretamente Docker e Docker-Compose
    * links:
        * https://runnable.com/docker/install-docker-on-linux
        * https://phoenixnap.com/kb/install-docker-compose-ubuntu

#### Passos para rodar
* clonar repositório: ``git clone git@github.com:andreluizlunelli/softexpert-recruiting-test.git``
* vá para pasta: ``cd softexpert-recruiting-test``
* subir containers: ``docker-compose up``
* instalar pacotes: ``docker-compose run app composer install --ignore-platform-reqs
``
* criar banco de dados: ``docker-compose run database createdb -p 5432 -h database app``
* criar estrutura do banco de dados: ``docker-compose run app vendor/bin/doctrine orm:schema-tool:create ``
    * [opcional] output dump: ``docker-compose run app vendor/bin/doctrine orm:schema-tool:create --dump-sql``

#### Descrição projeto

Esse repositório se divide em dois projetos `/app` e `/front-end`.

O projeto `/app` representa o back-end, um sistema Rest que sem a utilização de frameworks full-stack implementa o CRUD de produtos e tipos de produto 
persistidos na base.

O projeto `/front-end` representa as telas do sistema onde é dividido em páginas html e lógica de apresentação e
manipulação de dados com ES6 dentro de ``/front-end/public/src``.
 
O PHP só foi utilizado para fazer include de html's repetitivos, mas poderia ser utilizado qualquer outra
implementação: Angular, Reack ou Vue.js

Detalhes de configuração do banco de dados: ``/app/config/.env``

#### Coleção de requisições no Postman
[requisições](https://www.getpostman.com/collections/463ec97b796f015db9d2) (https://www.getpostman.com/collections/463ec97b796f015db9d2)
