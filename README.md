# backend
Project management web application

## How to use it

### Install with composer

```
$ composer install
```
## Methods
### LoginController
### indexAction
Used to render form 

URI | Method 
--- | --- |
`/login` | `GET` |

#### Response
###### Successfull
`Status: 200`

```js
{
    "response": {
        "user": "Użytkownik",
        "password": "Hasło",
        "forgot": "Przypomnij hasło",
        "submit": "Zaloguj"
    },
    "error": false,
    "status": 200
}
```
### verifyAction
Used to verify user data

URI | Method | Payload
--- | --- | ---
`/login/verify` | `POST` | `{"username": "john","password": "doe123"}`

#### Parameters
Name | Type | Description
--- | --- | ---
`username` | `string` | Username provided by user
`password` | `string` | Password provided by user

#### Response
###### Successfull
`Status: 200`

```js
{
  "response": true,
  "error": false,
  "status": 200
}
```
###### Unsuccessfull
`Status: 401`

```js
{
  "response": false,
  "error": true,
  "status": 401
}
```
### forgotPasswordAction
Used for the password reminder

URI | Method | Payload
--- | --- | ---
`/login/forgot` | `POST` | `{"email": "johndoe@domain.com"}`

#### Parameters
Name | Type | Description
--- | --- | ---
`email` | `string` | E-mail provided by user

#### Response
###### Successfull
`Status: 200`

```js
{
  "response": "Wysłaliśmy Ci e-mail z instrukcją jak ustawić nowe hasło",
  "error": false,
  "status": 200
}
```
###### Unsuccessfull
`Status: 422`

```js
{
  "response": "Podane dane są niepoprawne",
  "error": true,
  "status": 422
}
```
### RegisterController
### indexAction
Used to render form 

URI | Method 
--- | --- |
`/register` | `GET` |

#### Response
###### Successfull
`Status: 200`

```js
{
    "response": {
        "name": "Imię i nazwisko",
        "username": "Użytkownik",
        "password": "Hasło",
        "email": "Adres e-mail",
        "email_confirmation": "Potwierdzenie adresu e-mail"
    },
    "error": false,
    "status": 200
}
```
### createUserAction
Used for create user

URI | Method | Payload
--- | --- | ---
`/register/create` | `POST` | `{"name":"John Doe", "username":"john", "password": "doe123", "email": "johndoe@domain.com", "email_confirmation" : "johndoe@domain.com"}`

#### Parameters
Name | Type | Description
--- | --- | ---
`name` | `string` | Firstname provided by user
`username` | `string` | Username provided by user
`password` | `string` | Password provided by user
`email` | `string` | E-mail provided by user
`email_confirmation` | `string` | E-mail confirm provided by user

#### Response
###### Successfull
`Status: 200`

```js
{
  "response": true,
  "error": false,
  "status": 200
}
```
###### Unsuccessfull
`Status: 422`

```js
{
  "response": [/* list of \Slimvc\Validator errors */],
  "error": true,
  "status": 422
}
```
