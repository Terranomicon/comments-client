comments-client
-------------------------
Установка:
```
{
    "require": {
        "terranomicon/comments-client": "dev-master"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/Terranomicon/comments-client"
        }
    ]
}
```
composer install
___
Тестирование:
```
make tests
```
Использование:
```php

<?php

require 'vendor/autoload.php';
$client = new Client\CommentClient();

try {
// Получить все комментарии
    $comments = $client->getComments();

// Создать комментарий
    $client->createComment('Vi', 'Hi Jackie!');

// Обновить комментарий
    $client->updateComment('1', 'Dmitrii', 'Cant write tests yet');

} catch (Exception $e) {
    new \RuntimeException($e->getMessage());
}

```
