# Properties API


This repository holds an API built with Laravel for demonstration purposes. This API return all responses in JSON objects. It allows to create new users to whom will be associated 3 new properties which can be viewed and managed. See **Requests** to know more.



## Install & Run

	
Open the application directory in console and run the following commands:


###Migrations

```
php artisan migrate
```


###Seeds

```
php artisan db:seed --class=AddUsersProperties
```

###Run

```
php artisan serve
```

## Database

To configure database rename the file `.env.example` in the root directory to `.env`, then add your database parameters on this file.


## Requests


###Create User

**POST** `"YOUR ROOT"/api/createuser`

Parameters:

* name
* email
* password

	
###Login
	
**POST** `"YOUR ROOT"/api/login`
		
Parameters:

* email
* password

Note: This request will return a token.

	
###All Properties

**GET** `"YOUR ROOT"/api/properties/`
		
	
###Properties by User ID

**GET** `"YOUR ROOT"/api/properties/{id}`


###Properties by Radius

**GET** `"YOUR ROOT"/api/properties/{latitude}/{longitude}/{radius}/{unit?}`


###Update Property

**POST** `"YOUR ROOT"/api/properties/update/{id}/{field}/{value}`
		
Parameters: 

* api_token


## Map


To switch Properties requests between returning a map or a JSON object, the attribute's `$setMap` value in **PropertiesController** has to be changed to `true` or `false`.

	
