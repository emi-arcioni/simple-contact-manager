# LaunchCart Challenge by Emilio Arcioni

## Development environment
    - PHP 7.3.8
    - MySQL 8
    - MacOS Catalina

## Installation

- Clone GIT repository into a local folder, for instance **launchcart-challenge**
- Run Composer Install
    - <code>launchcart-challenge$ composer install</code>
- Update .env file with your local MySQL connection parameters
- Run Artisan Migrate
    - <code>launchcart-challenge$ php artisan migrate</code>
- Start local server
    - <code>launchcart-challenge$ php artisan serve</code>
- Open your browser at http://127.0.0.1:8000