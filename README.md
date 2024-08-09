# Laravel11-travelplans
API to manage travel plans
Pre-requisites: Wamp || Mysql + PHP8.2 + Apache2 installed in your system

Clone the repository:
git clone https://github.com/YuriRdrdV/Laravel11-travelplans

Navigate to the project root directory:
cd 'project-root-directory'

Install the dependencies:
composer install

Update the .env file with your database details:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

Run the migrations:
php artisan migrate

Start the development server:
php artisan serve

Hint: Running a PHP server is a way to test the application, but deploying it in a production environment requires a MySQL server running with the database credentials specified in the .env file. You also need to have PHP version 8.2 running, as well as Apache2 installed as the web server, with a properly configured .conf file that includes the correct paths to the application.

API list Curl

Register API - register users and generate token  
curl --location '127.0.0.1:8000/api/register' \
--form 'name="Johnny"' \
--form 'email="johnny@mail.com"' \
--form 'password="12345678"' \
--form 'c_password="12345678"'

Login API - login retrieves the token
curl --location '127.0.0.1:8000/api/login' \
--form 'email="johnny@mail.com"' \
--form 'password="12345678"'

API - Search all
curl --location '127.0.0.1:8000/api/travelplans' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer '

API - Search by id
curl --location '127.0.0.1:8000/api/travelplans/1' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer '

API - Delete by id
curl --location --request DELETE '127.0.0.1:8000/api/travelplans/4' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer '

API - Create
curl --location '127.0.0.1:8000/api/travelplans' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer ' \
--form 'title="Viagem do usuário 2"' \
--form 'description="Nado sincronizado no rio Sena"' \
--form 'date="10/08/2025"' \
--form 'location="Paris - FRA "'

API - Edit by id
curl --location --request PUT '127.0.0.1:8000/api/travelplans/4' \
--header 'Authorization: Bearer ' \
--header 'Content-Type: application/json' \
--data '{
    "title": "Updated Title",
    "description": "Updated description",
    "date": "2024-08-07",
    "location": "Updated Location"
}'
