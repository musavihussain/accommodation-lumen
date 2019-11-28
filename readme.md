# Accommodation

These APIs is designed in Lumen 6, to store accommodation data of users in mysql database.
The validation of data:
- A hotel name cannot contain the words ["Free", "Offer", "Book", "Website"] and it should be longer than 10 characters
- The rating MUST accept only integers, where rating is >= 0 and <= 5.
- The category can be one of [hotel, alternative, hostel, lodge, resort, guest-house] and it should be a string
- The location MUST be stored on a separate table.
- The zip code MUST be an integer and must have a length of 5.
- The image MUST be a valid URL
- The reputation MUST be an integer >= 0 and <= 1000.
- If reputation is <= 500 the value is red
- If reputation is <= 799 the value is yellow
- Otherwise the value is green
- The reputation badge is a calculated value that depends on the reputation
- The price must be an integer
- The availability must be an integer



## Usage
Installing the dependencies:

```
composer install
```


Change the .env.example to .env and modify it according your database details and then run below command to migrate the tables with seeds:

```
php artisan migrate --seed
```

Run the server

```
php -S localhost:8000 -t public
```


## Routes
Login page: 

```
localhost:8000/auth/login

Role: admin
{
	"email": "jonas@email.com",
    "password": "1234"
}

Role: saler
{
	"email": "maria@email.com",
    "password": "1234"
}

```

Create Accommodation:

```
localhost:8000/accommodation/createAccommodation
```
For using the accommodation you have to login with admin role and putting your token (as token) in header of your request.

Get all accommodations:
```
localhost:8000/accommodation/getAllAccommodation
```

Get single accommodation:

```
localhost:8000/accommodation/getSingleAccommodation
```

Retrieve information according to some filters:
- Retrieve my items with rating = X
- Retrieve my items located in X city
- Retrieve my items with X reputationBadge
- Retrieve my items with availability of more/less than X
- Retrieve my items with X category

```
localhost:8000/accommodation/filterAccommodation

{
	"rating": 3,
	"city" : "Hyderabad",
	"category" : "hotel",
	"reputation" : 400,
	"reputations_badge" : "red",
	"availability" : 23
}

```

Update the accommodation:

```
localhost:8000/accommodation/updateAccommodation

{
	"id" : 1,
	"name" : "change the name",
	"location_id" : 1,
	"city" : "Himali"
}

Note: you can add other field also.

```

Delete accommodation:

```
localhost:8000/accommodation/deleteAccommodation

{
	"id" : 1
}

```

For security purpose and changing the secret key:

```
localhost:8000/key
```


## Security Level

This app has designed in two level of security: 
1) Authentication: By using JWT.
2) Authorization: By custom middleware. If an user wants to check an item that is not of his property, this middleware will prevent to access it. Now only I considered it for creation of accommodation.

## Cache
The cache configuration is located in .env file. In this file you may specify which cache driver you would like used by default throughout your application. Lumen supports popular caching backends like Memcached and Redis out of the box. For larger applications, it is recommended that you use an in-memory cache such as Memcached or APC.


