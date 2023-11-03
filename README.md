<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Hotel Management System

This is a system developed in Laravel that allows the company to manage the information of the hotels it has, including basic tax data and the assignment of room types to each hotel.


## Main Features

- Hotel Entry: The system allows you to enter detailed information about the company's hotels. This includes the following data:

   - Name of the hotel
   - Address
   - Tributary information

 - Assignment of Room Types: Hotel managers can assign different room types to each hotel. The available room types are:

   - Standard
   - Junior
   - suite room

- Accommodation Validation: The system performs validations to ensure that appropriate accommodations are assigned for each room type. The rules are the following:

    - If the room type is Standard, only Single or Double accommodations are allowed.
    - If the room type is Junior, only Triple or Quadruple accommodations are allowed.
    - If the room type is Suite, Single, Double or Triple accommodations are allowed.

## Criterios de Aceptación

The system meets the following acceptance criteria:

- Number of Configured Rooms: The system does not allow you to configure more rooms than the hotel allows.
- Unique Hotels: Duplicate hotels are not allowed in the database.
- Unique Room Types and Accommodations per Hotel: Duplicate room types or accommodations cannot be assigned to the same hotel.
- Catalog Data Management: It is not necessary to have administrators to manage catalog data such as cities, room types or accommodations. The system is responsible for maintaining this data automatically.
- Compatibility with Different Screen Sizes: The system has been designed with compatibility with different screen sizes in mind, including 15 and 13 inch laptops.

## System Requirements

Make sure you have the following requirements in your development environment:

- PHP >= 8
- Laravel >= 8
- MySQL or any other supported database management system
- Modern web browsers for optimal user experience

## Installation and Use
- Clone the repository from GitHub:

      git clone https://github.com/tu-usuario/tu-repositorio.git

- Install dependencies using Composer:
      
      composer install
- Copy the example configuration file and configure your environment:

      cp .env.example .env

- Run the migrations and seeds to create the database tables and add sample data:

      php artisan migrate --seed

- Start the development server:

      php artisan serve

- Abra su navegador y acceda al sistema en http://localhost:8000.

## ENDPOINT

### CITY
### create
- type POST
- Athorization Bearer Token
- type POST
- link  http://localhost:8000/api/citys
- request    

      {
        "name":"BOGOTA",
        "state": true
      }

### allCity
- type GET
- link  http://localhost:8000/api/cityssl
### byCity
- type GET
- Athorization Bearer Token
- link  http://localhost:8000/api/citys/{id}
### deleteCity
- type DELETE
- Athorization Bearer Token
- link  http://localhost:8000/api/citys/{id}

### updateCity
- type PATCH
- Athorization Bearer Token
- link  http://localhost:8000/api/citys/{id}
- request    

      {
        "name":"BOGOTA",
        "state": true
      }
### TYPE ROOM
### create
- type POST
- Athorization Bearer Token
- link  http://localhost:8000/api/typerooms
- request    

      {
        "type":"ESTANDAR",
        "state": true
      }

### allCity
- type GET
- link  http://localhost:8000/api/typeroomssl
### byCity
- type GET
- Athorization Bearer Token
- link  http://localhost:8000/api/typerooms/{id}
### deleteCity
- type DELETE
- Athorization Bearer Token
- link  http://localhost:8000/api/typerooms/{id}

### updateCity
- type PATCH
- Athorization Bearer Token
- link  http://localhost:8000/api/typerooms/{id}
- request    

      {
        "type":"BOGOTA",
        "state": true
      }
### ADCCOMMODATION
### create
- type POST
- Athorization Bearer Token
- link  http://localhost:8000/api/accommodations
- request    

      {
        "name":"SENCILLA",
        "state": true
      }

### allCity
- type GET
- link  http://localhost:8000/api/accommodationssl
### byCity
- type GET
- Athorization Bearer Token
- link  http://localhost:8000/api/accommodations/{id}
### deleteCity
- type DELETE
- Athorization Bearer Token
- link  http://localhost:8000/api/accommodations/{id}

### updateCity
- type PATCH
- Athorization Bearer Token
- link  http://localhost:8000/api/accommodations/{id}
- request    

      {
        "name":"SENCILLA",
        "state": true
      }  
### HOTEL
### create
- type POST
- Athorization Bearer Token
- link  http://localhost:8000/api/hotels
- request    

        {
            "name":"paula",
            "city_id":1,
            "address":"ca54654",
            "nit":"465789",
            "max_rooms":45,
            "state":"1"
        }
### allCity
- type GET
- Athorization Bearer Token
- link  http://localhost:8000/api/hotels
### byCity
- type GET
- Athorization Bearer Token
- link  http://localhost:8000/api/hotels/{id}
### deleteCity
- type DELETE
- Athorization Bearer Token
- link  http://localhost:8000/api/hotels/{id}

### updateCity
- type PATCH
- Athorization Bearer Token
- link  http://localhost:8000/api/hotels/{id}
- request    

        {
            "name":"paula",
            "city_id":1,
            "address":"ca54654",
            "nit":"465789",
            "max_rooms":45,
            "state":"1"
        }
### ROOMS
### create
- type POST
- Athorization Bearer Token
- link  http://localhost:8000/api/rooms
- request    

        {
            "amount":10,
            "typeRoom_id":1,
            "accommodation_id":1,
            "hotel_id":1,
            "state": true
        }
### allCity
- type GET
- Athorization Bearer Token
- link  http://localhost:8000/api/rooms
### byCity
- type GET
- Athorization Bearer Token
- link  http://localhost:8000/api/rooms/{id}
### deleteCity
- type DELETE
- Athorization Bearer Token
- link  http://localhost:8000/api/rooms/{id}

### updateCity
- type PATCH
- Athorization Bearer Token
- link  http://localhost:8000/api/rooms/{id}
- request    

        {
            "amount":10,
            "typeRoom_id":1,
            "accommodation_id":1,
            "hotel_id":1,
            "state": true
        }
## Contribute
If you would like to contribute to this project, please feel free to open issues or submit pull requests in the GitHub repository.

 
## License
This project is licensed under the MIT License. See the LICENSE file for more details.