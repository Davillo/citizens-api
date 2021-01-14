#API Cidadãos

Ferramentas utilizadas
- Lumen PHP Micro Framework
- Insomnia
- MySQL

## Instalação
- Clonar o repositório e entrar no diretório do mesmo pelo terminal
- Rodar o comando "composer install" para baixar todas as dependências do projeto
- Rodar o comando "php artisan migrate" para criar as tabelas do banco de dados
- Importar a documentação contida em no diretório /docs do projeto no Insomnia REST Client
- Copiar e colar o conteudo do arquivo .env.example para o .env e configurar um banco de dados MySQL com as credenciais, porta e etc.

## Rotas da API
- /citizens (GET) - Retorna todos os cidadãos. 
O query param national_registry filtra um cidadão pelo seu CPF.

- /citizens/{ID} (GET) - Retorna os dados de um cidadão pelo seu ID.

- /citizens/{ID} (DELETE) - Exclui um cidadão pelo seu ID.

- /citizens (POST) - Cadastra um cidadão com nome, sobrenome, cpf, email, celular, e CEP para buscar o endereço no VIACEP. 

##Testes
Rode o comando ./vendor/bin/phpunit dentro do diretório do projeto para rodar os testes de integração da API

Comando para cadastrar um cidadão via linha de comando:
php artisan citizen:create --name=Davillo --last_name=Aurélio --national_registry=26326216079 --email=davillo.dev@gmail.com --zip_code=63119300 --celphone=63119300
