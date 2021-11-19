# TO-DO
- ** Finish update and delete function **
- ** Based on this project, develop a library application to manage book which is rented by users (create at least 3 database tables) **


# IMPORTANT

## Setup project

### Make sure you have php7.3 in your env (You can skip mysql and php if you have [Xampp](https://www.apachefriends.org/index.html))
```sh
    php -v
```
** If NOT, check [here](https://www.php.net/manual/en/install.php) to install **

### Make sure you have composer in your computer
```sh
    composer -v
```
** If NOT, check [here](https://getcomposer.org/) to install **

### Make sure you have mysql in your computer
```sh
    mysql --version
```
** If NOT, check [here](https://dev.mysql.com/downloads/installer/) to install **

### Go to project directory and install vendor
```sh
    composer install
```

### install database by using the file database.sql
```sh
    mysql -u {mysql user} -p < database.sql
```

### run project
```sh
    php -S localhost:8081 index.php
```