# Music REST API

Created using Lumen (5.8.12) (Laravel Components 5.8.*) framework

## Getting Started

Implementation of CRUD (Create, Retrieve, Update, List and Delete a record)

### Prerequisites

- PHP 7.1.3 or greater
- MYSQL database

### Installing

As this is for local server testing only, you will need to update database information .env file 
if there is no .env file, rename the example.env to .env file and change the database settings
* Update information on these lines 
* DB_HOST=<host>
* DB_PORT=<port>
* DB_DATABASE=<database>
* DB_USERNAME=<username>
* DB_PASSWORD=<password>

Once the the database settings is updated, you will need to run the Artisan migration and seeding 
```
php artisan migrate --seed
```

