# Blog

## About the project

This is a professional blog presenting myself as a developper. 
It consists of 
-   the section visible for all users - homepage with contact form, list of all blogposts and blogpot page
-   the comment section which can only be used by registered users
-   the admin section which is only accessible by the admin - page for new blogpost creation, pages to modify and/or delete a blogpost, admin dashboard with comment management


## Prerequisites

 -  PHP 7 or higher
 -  Mysql
 -  Composer

## Installation

### Clone the repo

```
$ git clone https://github.com/AnaMltk/Blog.git
$ composer update
```

### Edit config.ini file.
``` 
[database]
db_name     = ''
db_user     = ''
db_password = ''
[SMTP]
smtp_user_name = 'nobody@nowhere.com'
smtp_password = ''
smtp_address = ''
smtp_port = ''
```
For **database** connection, assign the values to **db_name**, **db_user** and **db_password**.

For **smtp** connection, assign the values to **smtp_user_name**, **smtp_password**, **smtp_address** and **smtp_port**.
