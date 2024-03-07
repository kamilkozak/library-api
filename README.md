# Library API

## Installation

To get the project up and running, you should start by cloning the repository.
Running the command below will clone the repository and change to the new directory:
```
git clone https://github.com/kamilkozak/library-api.git
cd library-api
```

Next, you should install all of the project dependencies via Composer:
```
composer install
```

Next, copy the .env.example file to a new file named .env in the project root:
```
cp .env.example .env
```

Then, generate application key:
```
php artisan key:generate
```

Now, you can create an SQLite database file. In your terminal type:
```
touch database/database.sqlite
```

To start the development server that allows local testing, use the following command:
```
php artisan serve
```

Once the SQLite database file is created, run the migrations with seeders:
```
php artisan migrate:fresh --seed
```

Testing:
```
php artisan test
```

## API Endpoints

### Books Endpoints
```GET /api/v1/books```
You can filter using query string e.g. ```?filter[title]=value```. Available filters are title, author, client.first_name, client.last_name

```GET /api/v1/books/{id}```

```PUT /api/v1/books/{id}/borrow```
The request body should look like: ```{ "client_id": 1 }```

```PUT /api/v1/books/{id}/return```

### Clients Endpoints

```GET /api/v1/clients```

```GET /api/v1/clients/{id}```

```POST /api/v1/clients```
The request body should look like ```{ "first_name": "John", "last_name": "Doe" }```

```DELETE /api/v1/clients/{id}```

Replace {id} with actual ids.

Prepend these URLs with  http://127.0.0.1:8000
