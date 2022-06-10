#Phalcon Test task

##Project Installation

###Step 1
In project folder after you've cloned repo go into the repository

```cd phalcon_test```

###Step 2
Install images via Docker

```docker-compose up -d```

###Step 3
Install required packages via Composer

```docker-compose exec app composer install```

###Step 4
Run initial migrations

```docker-compose exec app ./vendor/bin/phalcon migration run```