# Phalcon Test task

## Project Description

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
