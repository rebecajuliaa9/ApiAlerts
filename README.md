## Documentação da API

Essa API realiza o cadastro de usuários e alertas. 

#### CREATE USER

```http
  POST/auth/create
```
Essa rota é reponsável por criar usuários.

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `name` | `string` | **Obrigatório**. Nome do usuário |
| `email` | `string` | **Obrigatório**. Email do usuário precisa ser único. |
| `type_user` | `boolean` | **Obrigatório**. Tipo do usuário, 0 é comum e 1 é admin |
| `password` | `string` | **Obrigatório**. Senha do usuário |

#### LOGIN USER

```http
  POST/auth/login
```
Essa rota é reponsável por autenticar usuários.

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `email`      | `string` | **Obrigatório**. Email de acesso do usuário |
| `password`      | `string` | **Obrigatório**. Senha de acesso do usuário |

#### Exemplo de HTTP 200

##### Body da requisição

```http
{
    "email" : "admin@admin1",
    "password" : "12345678"
}
```

##### Resposta

```http
{
    "data": {
        "token": "10|5dv8mU1iapXNWnzfkkPRZbymnUz532GKRMkqCKUC"
    },
    "message": "Usuário logado com sucesso"
}
```

#### Exemplo de HTTP 401

##### Body da requisição

```http
{
    "email" : "admin",
    "password" : "12345678"
}
```
##### Resposta

```http
{
    "message" : "Credencial Inválida."
}
```
#### Exemplo de HTTP 422

##### Body da requisição

```http
{
    "email" : "admin@admin1",
    "password" : ""
}
```
##### Resposta da requisição

```http
{
    "message": "The given data was invalid.",
    "errors": {
        "password": [
            "The password field is required."
        ]
    }
}
```

#### LOGOUT USER

```http
  POST/auth/logout
```
Essa rota realizar o logout do usuário e para 
acessar é necessário estar autenticado.

#### Exemplo de HTTP 200
#### Header da requisição
```http
{
    "token" : "12|rtBuAvLQ6XHa0neGpCUsQGhEsJnEup1eCU5fY0l"
}
```

##### Body da requisição

```http
{
    "email" : "admin@admin8",
    "password" : "12345678",
}
```

##### Resposta da requisição

```http
{
    "message": "Usuário deslogado com sucesso"
}
```
#### Exemplo de HTTP 401
#### Header da requisição
```http
{
    "token" : ""
}
```
##### Body da requisição
```http
{
    "email" : "admin@admin8",
    "password" : "12345678",
}
```

##### Resposta da requisição
```http
{
    "message": "Unauthenticated."
}
```

#### INDEX ALERT

```http
  GET/alerts
```
Rota utilizada para retornar todos os alertas cadastrados, 
essa rota só se torna acessível com usuários autenticados,
caso contrário ela retorna um 401.

#### Exemplo de HTTP 200
##### Header da requisição
```http
{
    "token" : "9|4xTlOdUIfwmPJQWWdUca6YbEpus2Lc1pez5lISfz"
}
```
##### Resposta da requisição
```http
[
    [
        {
            "id": 12,
            "title": "Segunda tarefa alterada",
            "description": "é uma tarefa a ser fazer",
            "created_at": "2022-03-21T01:54:22.000000Z",
            "updated_at": "2022-03-21T01:54:22.000000Z"
        }
    ]
]
```

#### Exemplo de HTTP 401
##### Header da requisição
```http
{
    "token": ""
}

```
##### Resposta da requisição
```http
{
    "message": "Unauthenticated."
}
```

#### STORE ALERT

```http
  POST/alerts
```
Rota utilizada para cadastrar alertas, para o cadastro precisa ser
um usuário autenticado caso contrário ele retorna um 401.

#### Exemplo de HTTP 200


| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `title`      | `string` | **Obrigatório**. Título do alerta |
| `description`| `string` | **Obrigatório**. Descrição do alerta |

##### Header da requisição
```http
{
    "token": "9|4xTlOdUIfwmPJQWWdUca6YbEpus2Lc1pez5lISfz"
}
```

##### Body da requisição
```http
{
    {
    "title": "Segunda tarefa alterada",
    "description": "é uma tarefa a ser fazer"
    }
}
```

##### Resposta da requisição
```http

    {
        "title": "Segunda tarefa alterada",
        "description": "é uma tarefa a ser fazer",
        "updated_at": "2022-03-21T02:06:34.000000Z",
        "created_at": "2022-03-21T02:06:34.000000Z",
        "id": 13
    }
]
```


#### Exemplo de HTTP 422
##### Header da requisição
```http
{
    "token": "9|4xTlOdUIfwmPJQWWdUca6YbEpus2Lc1pez5lISfz"
}

```
##### Body da requisição
```http
{
    {
    "title": "",
    "description": "é uma tarefa a ser fazer"
    }
}
```

##### Resposta da requisição
```http
{
    "message": "The given data was invalid.",
    "errors": {
        "title": [
            "The title field is required."
        ]
    }
}
```
#### Exemplo HTTP 500

Se por algum motivo o alerta passar pelas request mas não conseguir
ser criado ele retorna um HTTP 500.


#### SHOW ALERT

```http
  GET/alerts/{id}
```
Rota utilizada para mostrar alertas específicos de acordo com o id,
para ter acesso a essa rota o usuário precisa ser 
autenticado caso contrário ele retorna um 401.

#### Exemplo de HTTP 200
##### Header da requisição
```http
{
    "token": "9|4xTlOdUIfwmPJQWWdUca6YbEpus2Lc1pez5lISfz"
}
```
##### Rota da requisição
```http
http://127.0.0.1:8000/api/alerts/13
```

##### Resposta da requisição
```http
[
    [
        {
            "id": 13,
            "title": "Segunda tarefa alterada",
            "description": "é uma tarefa a ser fazer",
            "created_at": "2022-03-21T02:06:34.000000Z",
            "updated_at": "2022-03-21T02:06:34.000000Z"
        }
    ]
]
```


#### Exemplo de HTTP 404
##### Header da requisição
```http
{
    "token": "9|4xTlOdUIfwmPJQWWdUca6YbEpus2Lc1pez5lISfz"
}

```
##### Rota da requisição
```http
http://127.0.0.1:8000/api/alerts/1
```

##### Resposta da requisição
```http
{
    "message": "Não conseguimos encontrar esse alerta"
}
```

#### UPDATE ALERT

```http
  PUT|PATCH /alerts/{id}
```
Rota utilizada para atualizar alerta de acordo com o id,
para ter acesso a essa rota o usuário precisa ser 
autenticado caso contrário ele retorna um 401.

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `title`      | `string` | **Obrigatório**. Título do alerta |
| `description`| `string` | **Obrigatório**. Descrição do alerta |

#### Exemplo de HTTP 200
##### Header da requisição
```http
{
    "token": "9|4xTlOdUIfwmPJQWWdUca6YbEpus2Lc1pez5lISfz"
}
```
##### Body da requisição
```http
{
    {
    "title": "Teste",
    "description": "Teste"
    }
}

```

##### Resposta da requisição
```http
[
    {
        "id": 13,
        "title": "Teste",
        "description": "Teste",
        "created_at": "2022-03-21T02:06:34.000000Z",
        "updated_at": "2022-03-21T11:28:24.000000Z"
    }
]
```


#### Exemplo de HTTP 422
##### Header da requisição
```http
{
    "token": "9|4xTlOdUIfwmPJQWWdUca6YbEpus2Lc1pez5lISfz"
}

```
##### Body da requisição
```http
{
    {
    "title": "",
    "description": ""
    }
}
```

##### Resposta da requisição
```http
{
    "message": "The given data was invalid.",
    "errors": {
        "title": [
            "The title field is required."
        ],
        "description": [
            "The description field is required."
        ]
    }
}
```

#### Exemplo de HTTP 404
##### Header da requisição
```http
{
    "token": "9|4xTlOdUIfwmPJQWWdUca6YbEpus2Lc1pez5lISfz"
}

```
##### Body da requisição
```http
{
    {
    "title": "Teste 2",
    "description": "Teste 2"
    }
}
```

##### Resposta da requisição
```http
{
    "message": "Não conseguimos encontrar esse alerta"
}
```


#### DELETE ALERT

```http
  DELETE/alerts/{id}
```
Rota utilizada para deletar alerta de acordo com o id,
para ter acesso a essa rota o usuário precisa ser 
autenticado caso contrário ele retorna um 401.

#### Exemplo de HTTP 200
##### Header da requisição
```http
{
    "token": "9|4xTlOdUIfwmPJQWWdUca6YbEpus2Lc1pez5lISfz"
}
```

##### Rota da requisição
```http

http://127.0.0.1:8000/api/alerts/1

```
##### Resposta da requisição 

{
    "message": "O alerta foi excluído com sucesso"
}


#### Exemplo de HTTP 404
##### Header da requisição
```http
{
    "token": "9|4xTlOdUIfwmPJQWWdUca6YbEpus2Lc1pez5lISfz"
}

```
##### Rota da requisição
```http

http://127.0.0.1:8000/api/alerts/12

```

##### Resposta da requisição
```http
{
    "message": "Não foi possivel encontrar o alerta"
}
```
### Dúvidas
Qualquer dúvida contactar o email rebecajuliaa9@gmail.com
