# Telegram Bot Package for Laravel 6.x, 7.x, 8.x

[![Build Status](https://travis-ci.org/php-telegram-bot/laravel.svg?branch=master)](https://travis-ci.org/php-telegram-bot/laravel)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/php-telegram-bot/laravel/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/php-telegram-bot/laravel/?b=master)
[![Code Quality](https://img.shields.io/scrutinizer/g/php-telegram-bot/laravel/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/php-telegram-bot/laravel/?b=master)
[![Latest Stable Version](https://img.shields.io/packagist/v/php-telegram-bot/laravel.svg)](https://packagist.org/packages/php-telegram-bot/laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/php-telegram-bot/laravel.svg)](https://packagist.org/packages/php-telegram-bot/laravel)
[![Downloads Month](https://img.shields.io/packagist/dm/php-telegram-bot/laravel.svg)](https://packagist.org/packages/php-telegram-bot/laravel)
[![Minimum PHP Version](http://img.shields.io/badge/php-%3E%3D7.3-8892BF.svg)](https://php.net/)
[![License](https://img.shields.io/packagist/l/php-telegram-bot/laravel.svg)](https://github.com/php-telegram-bot/laravel/LICENSE.md)

This package helps easily integrate [PHP Telegram Bot](https://github.com/php-telegram-bot/core) library in Laravel application.

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

Edit your project's `composer.json` file to require `php-telegram-bot/laravel`

Create *composer.json* file:
```json
{
    "name": "yourproject/yourproject",
    "type": "project",
    "require": {
        "php-telegram-bot/laravel": "^1.0"
    }
}
```
And run composer update

**Or** run a command in your command line:

    composer require php-telegram-bot/laravel

Copy the package config and migrations to your project with the publish command:

    php artisan vendor:publish --provider="PhpTelegramBot\Laravel\ServiceProvider"

After run migration command

    php artisan migrate

In the config you have to specify your Telegram API Key.

## Usage

You can inject `PhpTelegramBot\Laravel\PhpTelegramBotContract` anywhere and use the bot instance.

For example:

```php
<?php

namespace App\Http\Controllers;

use PhpTelegramBot\Laravel\PhpTelegramBotContract;

class CustomController extends Controller
{
    public function handle(PhpTelegramBotContract $telegramBot)
    {
        // Call handle method
        $telegramBot->handle();
        
        // Or set webhook 
        $hookUrl = 'https://hook.url';
        $telegramBot->setWebhook($hookUrl);
        
        // Or handle telegram getUpdates request
        $telegramBot->handleGetUpdates();
    }
}
```

For more details about usage, see the PHP Telegram Bot docs: https://github.com/php-telegram-bot/core#instructions

## TODO

write more tests

## Troubleshooting

If you like living on the edge, please report any bugs you find on the [php-telegram-bot/laravel issues](https://github.com/php-telegram-bot/laravel/issues) page.

## Contributing

Pull requests welcome!

See [CONTRIBUTING.md](CONTRIBUTING.md) for information.

## License

Please see the [LICENSE](LICENSE.md) included in this repository for a full copy of the MIT license, which this project is licensed under.

## Credits

Credit list in [CREDITS](CREDITS)
