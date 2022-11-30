# My MINI XSS Validator

**"My MINI XSS Validator"** is a college project created by **Caio Ramalho (github.com/caiohenriqueramalho)** and **Fábio Batisteti**, for the third semester of the **System Analysis and Development** associate course of **UNIMAR** (Brazil).

As a solution, MINI's goal is to demonstrate a mean to validate inputs in order to avoid potential risks of injection attacks, mainly because of HTML tags or SQL clauses inside the input, and offer a simple code that can be imbued to other projects, as long as PHP is supported.

By being an API, MINI can demonstrate and log its validations and return in JSON format for the user to analyze.

# Dependancies

**PHP** 8+ (entire solution)
**Composer** 2.4+ (API solution)
**Laravel** 9+ (API solution)
**Docker** (for hosting database locally)

# Repository Structure Explanation

The repository is split in folders to better organize each function. Please, refer below to know each folder's content.

```
My MINI XSS Validator
|
│   README.md
│   compose.yaml    
│
└───API
|	└─── (...)
|	[The entire API, made in Laravel]
│
└───MINI
	└─── (...)
	[The validator solution, in pure PHP]
```

# Quick Setup

It is possible to clone the entire repository and get it to work by running these commands with the terminal at the desired directory:
```
git init;
git clone https://github.com/fbatisteti/XSS_Validator.git;
```
Then, duplicate the **.env.example** file and rename it **.env**.
After that, you can access the MySQL inside the container and create Mini's database within a Docker container.
```
docker-compose up -d;
docker exec -it my-mini-xss-validator_db_1 bash;
mysql -h 127.0.0.1 -u root -p;
password;
create database mini;
exit;
exit;
```
The following commands will install all dependancies. It will also create the database inside a Docker container and seed basic user information needed:
```
cd my-mini-xss-validator;
cd API;
composer i;
php artisan vendor:publish;
0;
php artisan jwt:secret;
php artisan migrate:fresh --seed;
```
Lastly, serve the API with:
```
php artisan serve;
```
In the terminal there will be a URL of where the API is listening (**http://127.0.0.1:8000/**).

# MINI Solution

By making use of root's MINI folder, you'll have the entire validation solution written in pure PHP.

The files **Html.php** and **Sql.php** contain the information that will be searched during validation. Each is presented differently, in order to better suit the returns. These two classes are used by the **SanitizerHtml.php** and **SanitizerSql.php** classes to perform each its own kind of validation. And both are combined in the **Sanitizer.php** class, and the sanitization method can be called with the **sanitize()** method, passing a string to be sanitized.

This **sanitize()** function will return an array containing PHP's basic sanitization, all potential HTML risks, and all potential SQL risks. Please note that PHP's basic sanitization does not treat for possible SQL risks.

# API Documentation

## Main Endpoint: .../api/mini/

- **GET method**
	- Can receive *form*, with any combination of the following
		- *uid* (type 'string', formatted as an UUID, i.e. 00000000-0000-0000-0000-000000000000)
		- *startDate* (type 'string', formatted as YYYY-MM-DD date)
		- *endDate* (type 'string', formatted as YYYY-MM-DD date)
	- Valid GET form:
>{
uid: "00000000-0000-0000-0000-000000000000",
startDate: "2022-01-01",
endDate: "2022-12-31"
}

- **POST method**
	- Expects *input* (type 'string')
	- Can receive *uid* (type 'string', formatted as an UUID, i.e. 00000000-0000-0000-0000-000000000000)
	- Valid POST body:
>{
	uid: "00000000-0000-0000-0000-000000000000",
	input: "Mini is the best!"
}

## Auth Endpoints

- **.../api/register/**
	- **POST method**
		- Expects *email* (type 'e-mail') and *password* (type 'string', at least 10 characters)
		- Will redirect to the *.../api/login/* after success
		-  Valid POST body:
>{
	email: example@mini.com,
	password: examplePassword
}

- **.../api/login/**
	- **POST method**
		- Expects *email* (type 'e-mail') and *password* (type 'string')
		- Returns an authentication token
		- Valid POST body:
>{
	email: example@mini.com,
	password: examplePassword
}

- **.../api/logout/**
	- **POST method**
		- Does *NOT* expects body
		- Expects header with *bearer token*

## Auxiliary Endpoints (not to be used)

- **.../api/usuarios/** | **.../api/requests/** | **.../api/logs/**
	- **GET method**
	- **POST method**
	- Since this was just for the creation process, only the HTTP methods above where implemented; these methods will be be disclosed

# Why validate for XSS?

Citing OWASP (Open Web Application Security Project), a nonprofit foundation that works to improve the security of software:

> "XSS attacks occur when an attacker uses a web application to send malicious code, generally in the form of a browser side script, to a different end user."
>
> -- <cite><OWASP (in https://owasp.org/www-community/attacks/xss/)/cite>

These attack occur when data is send to an application withouth enough validation of its safety, to be later reproduced to other users, triggering the attack effects. Since the end user have no way of checking if the information is to be trusted or not, since it all came from the same provider, it will be exposed to the attackers intentions, be them to collect, spread or misuse data.

If any kind of information is stored without validating, some of them might be scripts or SQL queries that, when run by the server, can cause malfunction, destruction of data or any other kind of events.

By validating entries, either by cleaning the data before using it (some languages even have in-built cleaners, like PHP) or preventing it from being used in some cases, one can make their web applications much safer for them and the end users.
