# php-calendar-api

Short example of how to make an API on PHP code

## Download
```
git clone https://github.com/colas-sebastien/php-calendar-api.git
cd php-calendar-api
```
## Run with Docker Compose
```
docker-compose up
```
## Run with Heroku
```
heroku login
heroku create
git push heroku master
heroku ps:scale web=1
heroku open
```
## Test it
To test you application you need to make an HTTP GET request on /calendar/YYYY/MM where YYYY is the year on 4 digits and MM is the mont on 2 digits.

