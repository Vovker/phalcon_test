# Phalcon Test task

API - ``` localhost:8080```

PHP My Admin - ```localhost:800``` credentials: root:root

## Project Description

I decided to use Phalcon as a framework for developments, because you use it and if I'm developer fit to you, I should learn it the fastest way, so in this case, it's start learning earlier :) 
So I really like to deal with new technologies and I'm always open for new challenges :) 

I don't like some cases of this app, for example:

I'd prefer to cache MySql queries to check if the user exceeds the hourly limit of requests instead of sending a query to the DB on each creation of transaction, if I had more time I'd implement it with a cache lifetime of 3600 sec and count them

Another question about the DB structure, it was a bit weird for me to implement the structure for individual blocks of the app, but those are just my preferences :)

So and the main problem that maybe some old features are used, because my last experience with PHP was 2 years ago, and I may forget something

Anyway thanks for the task, it was interesting, and please leave feedback anyway  

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
