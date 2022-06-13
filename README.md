# Phalcon Test task

API - ``` localhost:8080```

PHP My Admin - ```localhost:800``` credentials: root:root

## Project Description

I've decided to use Phalcon as a framework for developments, because you're using it and if I'll fit you as a developer, anyway I should learn it in the fastest way, so in this case, it's start learning earlier :) 
So I really like having a meet with new technologies and always open for new challenges :) 

I really don't like some cases of this app, for example:

I'll prefer caching of MySql queries to check if user exceed hourly limitations of requests instead of make a request to the DB on each creation of transaction, if I had more time I'll realize it with cache 3600 sec lifetime and count it

Another question about DB structure, it was a bit strange for me to implement structure for separated block of the app, but it's only my preferences :)

So and the main problem that maybe will cause some old features used, because my last experience with PHP was 2 years ago, and I may forget smth

Anyway thanks for the task, it was interesting, and leave please feed back anyway  

## Project Installation

### Step 1
In project folder after you've cloned repo go into the repository

```cd phalcon_test```

### Step 2
Install images via Docker

```docker-compose up -d```

### Step 3
Install required packages via Composer

```docker-compose exec app composer install```

### Step 4
Run initial migrations

```docker-compose exec app ./vendor/bin/phalcon migration run```

## Functional testing

With empty transactions table in DB run the following command to start testing

```docker-compose exec app ./vendor/bin/phpunit ./application ```

P.S.
To coverage the all app - so long process. 
In this case

Implemented only 3 tests:

| Test Name                        | Description                                                                                                                                        |
|----------------------------------|----------------------------------------------------------------------------------------------------------------------------------------------------|
| Wrong method                     | For example to create a new transaction implemented POST request. In test we are trying access this endpoint via GET and get 404 (Not Found) error |
| Success transaction creating     | Usual flow with test data to create a new transaction                                                                                              |
| Success transaction confirmation | Usual flow                                                                                                                                         |

# Endpoints

## Create new transaction

POST ``/transaction``

### Request body
| Param            | Type          | Description                                 |
|------------------|---------------|---------------------------------------------|
| user_id          | integer       | User's ID who creates transaction           |
| details          | string        | Transaction description                     |
| receiver_account | string        | Bank account number (like IBAN)             |
| receiver_name    | string        | Bank account holder name (ex. Steve Jonson) |
| amount           | float/integer | Charge amount                               |
| currency         | string        | International currency code (ex. USD, EUR)  |

### Response example
```json
{
    "code": 200,
    "message": "OK",
    "data": {
        "transaction_id": "1"
    }
}
```

## Confirm transaction

POST ``/transaction/confirm/:user_id``

### Request body
| Query param      | Type          | Description                                     |
|------------------|---------------|-------------------------------------------------|
| user_id          | integer       | User's ID who's transaction should be completed |

| Param            | Type          | Description                                     |
|------------------|---------------|-------------------------------------------------|
| auth_token       | string        | Token from 2FA app                              |


### Response example
```json
{
  "code": 200,
  "message": "OK",
  "data": {
    "transaction_id": "1",
    "details": "Test transaction",
    "receiver_account": "IBAN1234123412341234",
    "receiver_name": "Test Test",
    "amount": 100,
    "fee": 10,
    "status": "completed"
  }
}
```
