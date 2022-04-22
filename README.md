<h3 align="center">
  :whale2: Projeto para estudo
</h3>

## O que é nessesario para rodar a aplicação ?

Para rodar o projeto você precisará do [docker](https://www.docker.com) e [docker-compose](https://docs.docker.com/compose/) instalados no seu computador, e tambem é preciso estar tem um sistema que tenha suporte a <strong>Makefile</strong> e a scripts de <strong>bash</strong>.

- url base da api = [localhost](http://localhost:8000/);
- url da documentação do swagger = [swagger](http://localhost:8000/doc);
- url da documentação do postman = [postman](https://documenter.getpostman.com/view/7588133/Uyr7Hyng);


<h3 align="center">
  Usuario já cadastrado no sistema
</h3>

Como o sistema necessita de um login para poder ser acessado ele já vem com um usuario adm cadastrado, segue os dados do usuario para login:

#### Username: claudio@gmail.com
#### Password: 123


## Como usar ?

- Fazer o setup do projeto : Esse comando alem do setup vai rodar as migrations, os testes e abrir uma aba no seu navegador com o swagger do projeto :blush:.
```
 make startup
```

- Depois rodar as migrations
```
 make migrate
```

- Para rodar os testes
```
 make test
```
