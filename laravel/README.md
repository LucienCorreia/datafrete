### Como subir

Para subir tudo rode o comando `docker compose --env-file=./docker.env up` dentro da pasta do projeto
Rodar as migrations com o comando: `docker compose run --rm artisan php artisan migrate`
Na pasta `files` tem dois arquivos CSV para testar, sendo um com poucos registros e outros com muitos

### Tecnologias

- PHP
- Laravel
- Bootstrap
- Redis
- Nginx
- Postgres
- Docker (com o docker-composer junto)

### Estratégia de importaão em massa

- Cada linha do arquivo csv vira um job intervalado em 1seg entre cada um para evitar o bloquei da API externa
- Os retornos são mantidos em cache no redis para evitar consultas repetidas na API e diminiur o tempo de execução do job

### Biblotecas PHP utilizadas

Foram utilizadas bibliotecas para agilizar algumas coisas no projeto

- GuzzleHttp: já vem instalada por conta que o Laravel utiliza ela, foi utilizada para deixar a implementação do curl do PHP
- League\Csv: Para facilitar a manipulação do arquivo CSV

### Problemas que podem ocorrer

Por ser ambiente de desenvolvimento se tem bind de volumes entre o host e o container docker, o projeto está configurado para salvar os logs em arquivos, ter cache e outras coisas com manipulação de arquivos dentro do container, pode ocorrer erro de permissão, para resolver é só dar permissão total pra pasta do erro pela máquina host (não dentro do container)
