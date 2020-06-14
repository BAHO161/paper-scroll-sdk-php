# PaperScroll SDK для PHP 7.0+
**PaperScroll SDK для PHP 7.0+** простая реализация методов API PaperScroll

![PaperScroll PHP](https://img.shields.io/badge/Paper%20Scroll%20PHP-0.1-purple.svg?style=flat-square)
![PHP 7.0.0+](https://img.shields.io/badge/PHP-7.0.0+-yellow.svg?style=flat-square)
![license: MIT](https://img.shields.io/badge/License-MIT-red.svg)

**Полезные ссылки:**

[![DavydovGame](https://img.shields.io/badge/DavydovGame-orange.svg?style=flat-square)](https://vk.com/davydovgame)
[![HorseRaces](https://img.shields.io/badge/HorseCoin-green.svg?style=flat-square)](https://vk.com/horsecoin)
[![Я во ВКонтакте](https://img.shields.io/badge/VK-blue.svg?style=flat-square)](https://vk.com/id107832372)

[![CoinGames](https://img.shields.io/badge/CoinGames-yellow.svg?style=flat-square)](https://vk.com/vkcoin_games)
[![PaperScroll](https://img.shields.io/badge/PaperScroll-green.svg?style=flat-square)](https://vk.com/paper_scroll)
[![PLAY](https://img.shields.io/badge/PLAY-orange.svg?style=flat-square)](https://vk.com/app7420483)

[Документация PaperScroll API](https://paperscroll.docs.apiary.io)

### Установка

Пример:
```php
require_once('paperscrollclient.php'); 
ИЛИ
include_once('paperscrollclient.php');


$paperscroll = new PaperScrollClient('merchant_id','token');
Готовый вариант:
$paperscroll = new PaperScrollClient('128','wU6GlVB0yCnbZb1UBEp1YY2LBaRurCwCpzZdblZ6slFpjIOCbH70AhGaEdi2KG');
```

| Параметр     | Тип    | Обязательно?      | Описание                                             |
|--------------|--------|-------------------|------------------------------------------------------|
| merchant_id  | int    | **да**            | merchant_id - идентификатор магазина                 |
| token        | string | **да**            | token - секретный ключ, полученный при создании      |
```php
ВНИМАНИЕ! Для использования, у Вас также должно быть установлено расширение cURL.
```

## Формат ответа
При вызове любого метода API возвращается массив с двумя полями - true или false.

| Поле         | Тип    |  Описание                                                                          |
|--------------|--------|------------------------------------------------------------------------------------|
| status       | bool   | `true` - успешно. `false` - произошла ошибка.                                      |
| response     | array  | Возвращает массив, содержащий ответ от API, только если `status` == `true`.        |
| error        | string | Возвращает строку с ошибкой cURL, только если `status` == `false`.                 |

## Получение информации о магазине, по его индификатору.
Пример:
```php
$paperscroll->getMerchants('ТУТ ИД МАГАЗИНА')['response']['ТУТ ПАРАМЕТР, КОТОРЫЙ ВАМ НУЖЕН'];
Список параметров, которые можно получить: merchant_id || owner_id || group_id || name || avatar || balance || create_date
group_id, name, avatar - могу вернуть NULL, если сообщество не привязано.

Например:
$paperscroll->getMerchants('1')['response']['balance'];

Остальные методы также подробно описаны в самом коде.
```

### Методы SDK

|       API Метод           |       Метод в коде       |
|---------------------------|--------------------------|
| merchants.get             | getMerchants             |
| merchants.edit            | editMerchant             |
| users.get                 | getUsers                 |
| users.getBalances         | getUsersBalances         |
| transfers.create          | createTransfer           |
| transfers.get             | getTransfers             |
| transfers.getHistory      | getHistoryTransfers      |
| storage.getDisinfectants  | getDisinfectantsStorage  |
| storage.getItems          | getItemsStorage          |
| webhooks.get              | getWebhook               |
| webhooks.create           | createWebhook            |
| webhooks.delete           | deleteWebhook            |
| webhooks.getLogs          | getLogsWebhook           |

### Баги и PR
Репозиторий открыт для изменений! Если вы заметили какую-то ошибку связанную с кодом, откройте ***Issue*** и если знаете, как эту ошибку решить, открывайте ***Pull Request***
