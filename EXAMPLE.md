## Example ##


1- After adding the package and setting everything up, create a controller, for example `TelegramController.php` in your `app/Http/Controllers` directory and put this in it:

```
<?php
namespace App\Http\Controllers;

use PhpTelegramBot\Laravel\PhpTelegramBotContract;

class TelegramController extends Controller {
    public function set(PhpTelegramBotContract $telegram_bot) {
        return $telegram_bot->setWebhook(url(config('phptelegrambot.bot.api_key') . '/hook'));
    }

    public function hook(PhpTelegramBotContract $telegram_bot) {
        $telegram_bot->handle();
    }
}
```

2- Now you need to write routes for these actions. so open your `web.php` and write:
```
$router->group(['prefix' => config('phptelegrambot.bot.api_key')], function() use ($router) {
    $router->get('set', 'TelegramController@set');
    $router->post('hook', 'TelegramController@hook');
});
```
We prefix all routes with the long API key that BotFather has given us to make the `hook` url secure and to ensure the incoming requests are from no one but Telegram.

3- Go to `https://yoursite.com/[YOUR BOT API KEY]/set`
You should see the success message.

4- Create a directory for your commands. It can be anywhere, for example `app/Telegram/Commands/[CommandNameCommand].php` would be nice.

This is an example `StartCommand.php`:
```
<?php
namespace Longman\TelegramBot\Commands\SystemCommands;

use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Request;

class StartCommand extends SystemCommand {
	protected $name = 'start';
	protected $usage = '/start';

	public function execute()
	{
		$message = $this->getMessage();

        	$chat_id = $message->getChat()->getId();
        	$text    = 'Hi! Welcome to my bot!';

        	$data = [
            		'chat_id' => $chat_id,
            		'text'    => $text,
        	];

        	return Request::sendMessage($data);
	}
}
```
5- The last thing you need to do is to add your custom commands directory to the bot's config. so open `config/phptelegrambot.php` and add the commands directory to the array:

```
...
'commands' => [
        'before'  => true,
        'paths'   => [
            base_path('/app/Telegram/Commands')
        ],
        'configs' => [
            // Custom commands configs
        ],
],
...
```


That's it.
