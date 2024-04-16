# Vendus REST API

This a RESTful API based in Laravel and in MySQL where we have three resources (Partners, Suppliers and Customers) all of them have CRUD operations. More details can be found in the documentation

## Prerequisites
Before you begin, ensure you have met the following requirements:

- PHP >= 8
- Composer
- MySQL
- Laravel

You also need to have Laravel installed. If you don't have Laravel installed, you can follow the installation instructions here: [Laravel Installation Guide](https://laravel.com/docs/11.x/installation).

## Installation

To install the API, follow these steps:

1. Clone the repository:

``` bash
git clone https://github.com/rfcmarques/vendus-res-api.git
```

2. Navigate to the project directory:

``` bash
cd vendus-rest-api
```

3. Copy the .env.example file to .env and update the environment variables according to your database configuration:

``` bash
cp .env.example .env
```

4. Install dependencies:

``` bash
composer install
```

5. Run the database migrations and seed the database with dummy data:

``` bash
php artisan migrate:fresh --seed
```

## Running the API
To start the server, run the following command:

``` bash
php artisan serve
```

The API will be available at [http://localhost:8000](http://localhost:8000). You can access the API documentation at [/api/documentation](http://localhost:8000/api/documentation). There you will find all the information that you need about the API

## Testing
You can test the API directly on the documentation or if you prefer you can use tools like Postman or cURL to make requests to endpoints and verify the responses.
