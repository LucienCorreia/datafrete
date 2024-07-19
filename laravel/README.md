### Como subir

Para subir tudo rode o comando `docker compose up` dentro da pasta do projeto
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
- Os retornos são mantidos em cache no redis para evitar consultas repetidas na API e diminiur o tempo de execuão da task

### Biblotecas PHP utilizadas

Foram utilizadas bibliotecas para agilizar algumas coisas no projeto

- GuzzleHttp: já vem instalada por conta que o Laravel utiliza ela, foi utilizada para deixar a implementação do curl do PHP
- League\Csv: Para facilitar a manipulação do arquivo CSV
