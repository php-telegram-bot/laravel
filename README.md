# Telegram Bot Package for Laravel 5.x

## Table of Contents
- [Installation](#installation)
- [Usage](#usage)
- [TODO](#todo)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)
- [Credits](#credits)

## Installation

Install this package through [Composer](https://getcomposer.org/).

Edit your project's `composer.json` file to require `longman/laravel-multilang`

Create *composer.json* file:
```json
{
    "name": "yourproject/yourproject",
    "type": "project",
    "require": {
        "php-telegram-bot/laravel": "~0.1"
    }
}
```
And run composer update

**Or** run a command in your command line:

    composer require php-telegram-bot/laravel

In Laravel 5.5 the service provider will automatically get registered. 
In older versions of the framework just add the service provider in `config/app.php` file:

```php
PhpTelegramBot\Laravel\PhpTelegramBotServiceProvider::class,
```

Copy the package config and migrations to your project with the publish command:

    php artisan vendor:publish --provider="PhpTelegramBot\Laravel\PhpTelegramBotServiceProvider"


After run migration command

    php artisan migrate

## Usage

You can inject `PhpTelegramBot\Laravel\PhpTelegramBotContract` in anywhere and use bot instance

For example:

```php
<?php
namespace App\Http\Controllers;

use PhpTelegramBot\Laravel\PhpTelegramBotContract;

class CustomController extends Controller
{
    public function handle(PhpTelegramBotContract $telegram_bot)
    {
        // Call handle method
        $telegram_bot->handle();
        
        // Or set webhook 
        $telegram_bot->setWebhook($hook_url);
        
        // Or handle telegram getUpdates request
        $telegram_bot->handleGetUpdates();
    }
}

```

More details about usage you can see on the PHP Telegram Bot docs: https://github.com/php-telegram-bot/core#instructions

## TODO

write more tests

## Troubleshooting

If you like living on the edge, please report any bugs you find on the
[php-telegram-bot/laravel issues](https://github.com/php-telegram-bot/laravel/issues) page.

## Contributing

Pull requests are welcome.
See [CONTRIBUTING.md](CONTRIBUTING.md) for information.

## License

Please see the [LICENSE](LICENSE.md) included in this repository for a full copy of the MIT license,
which this project is licensed under.

## Credits

- [Avtandil Kikabidze aka LONGMAN](https://github.com/akalongman)

Full credit list in [CREDITS](CREDITS)
