# User Registration task

The project was done using the PHP Laravel framework.

System Requirements:

- PHP >= 5.6.4
- OpenSSL PHP extension
- PDO PHP extension
- Mbstring PHP extension
- Tokenizer PHP extension
- Composer

Installation prerequisites:

- First copy or clone the project into your system.
- Create a mySQL database for the project.
- Copy the `.env.example` file and rename it to `.env` file. This is the configuration file.
- Change the options in it to match the settings on your system. That is, the database settings, the mail server settings, URL, etc.

Run the following in order:

- `composer install`
- `php artisan key:generate`
- `php artisan migrate --seed`

At this point, you should be all set and ready to go. The administrator account has already been created with the following details:

- **Username:** admin
- **Password:** secret

Thank you!