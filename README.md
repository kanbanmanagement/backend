# backend
Project management web application

## How to use it

### Install with composer

```
$ composer install
```

## Api Request

#### LoginController

```
http://kanban.dev/login        - METHOD GET
```
```
http://kanban.dev/login/verify - METHOD POST; FORMAT JSON; PARAM name, pass
```
```
http://kanban.dev/login/forgot - METHOD POST; FORMAT JSON; PARAM email
```

#### RegisterController

```
http://kanban.dev/register        - METHOD GET
```
```
http://kanban.dev/register/create - METHOD POST; FORMAT JSON; PARAM name, username, password, email, email_confirmation
```
