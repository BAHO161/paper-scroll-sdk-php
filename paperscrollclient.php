<?php
/**
 * PaperScrollClient
 * @author nikitos42050 (Никита Давыдов) (https://vk.com/id107832372)
 * @version 0.4
 * @copyright Copyright (c) 2020 DavydovGame
 * @link Официальный репозиторий: https://github.com/nikitos42050/paper-scroll-sdk-php
 * По всем вопросам, можете обращаться ко мне в личные сообщения: https://vk.com/id107832372
 */

/**
* ПОДКЛЮЧЕНИЕ: require_once('paperscrollclient.php'); ИЛИ include_once('paperscrollclient.php');
* $paperscroll = new PaperScrollClient('ЗДЕСЬ УКАЗАТЬ ВАШ МЕРЧАНТ ID','ЗДЕСЬ УКАЗАТЬ ВАШ ТОКЕН');
*/
class PaperScrollClient {

	protected const API_HOST = 'https://paper-scroll.ru/api';
	private $merchant_id = "";
	private $token = "";

	public function __construct(int $merchant_id, string $token) {
	if(version_compare('7.0.0', phpversion()) === 1) {
	die('Ваша версия PHP устарела. Используйте PHP 7.0 и выше.');
	}
	$this->merchant_id = $merchant_id;
	$this->token = $token;
	}

/**
* Если сервер возвращает Вам 'status' == '2' (false) и пустоту, значит Вы неверно указали параметры.
* Проверить это можно примерно так: (ЭТОТ СЛУЧАЙ ВЕРНЕТ 1, то есть TRUE).
  $check = $ps->getTransfers('702842')['status'];
  if($da == '2') {
  $vk->sendMessage($peer_id, 'Сервер вернул статус false');
  return;
  }else{
  $vk->sendMessage($peer_id, $check);
  return;
  }
  }
* 
* А ЭТОТ СЛУЧАЙ ВЕРНЕТ 2, то есть false.
  $check = $ps->getTransfers('1')['status'];
  if($da == '2') {
  $vk->sendMessage($peer_id, 'Сервер вернул статус false');
  return;
  }else{
  $vk->sendMessage($peer_id, $check);
  return;
  }
  }
*
*/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////НАЧНЕМ//////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/**
* Функция getMerchants - возвращает информацию о магазинах по их идентификаторам.
* Вызывать метод можно так: $paperscroll->getMerchants('ID магазина')['response']['ТУТ ПАРАМЕТР, КОТОРЫЙ ВАМ НУЖЕН'];
* Параметры, которые можно получить: merchant_id || owner_id || group_id || name || avatar || balance || create_date
* group_id, name, avatar - могу вернуть NULL, если сообщество не привязано.
*
* Готовый вариант: $paperscroll->getMerchants('1')['response']['balance'];
*
* Когда 'status' == '2', то можно получить более подробную информацию о ошибке. ('status' == '2' ЭТО ТОЖЕ САМОЕ ЧТО 'status' == 'false')
* Для того, чтобы получить информацию о ошибке, нужно вызвать метод $paperscroll->editMerchant('ID магазина')['response']['error']['ПАРАМЕТР ОШИБКИ'];
* Параметры, которые можно получить: error_code || error_msg || error_text
*
* Готовый вариант получения ошибки:
* $paperscroll->getMerchants('1')['response']['error']['error_text'];
*
* ВНИМАНИЕ! Если ID мерчанта указан неверно, то 'status' == '2' и 'response' вернет пустоту.
*/

	public function getMerchants(int $merchant_ids) {
	$body = "{\"merchant_ids\": [".$merchant_ids."]}";
	return $this->request('merchants.get', $body);
	}

/**
* Функция editMerchant - редактирует информацию о текущем магазине.
* Вызвать метод можно так: $paperscroll->editMerchant($name, $group_id, $link);
* Чтобы установить ваши значения для merchant, нужно выставить поля: name, group_id, link.
* ВНИМАНИЕ! После успешного выполнения возвращает TRUE.
* 
* Готовый варинт:
* $name = 'DavydovGame';
* $group_id = '185168281'; (УКАЗЫВАТЬ БЕЗ -)
* $link = 'https://pp.userapi.com/c858024/v858024194/355bc/xxH6Dx6p0bY.jpg';
* $paperscroll->editMerchant($name, $group_id, $link);
*
* Когда 'status' == '2', то можно получить более подробную информацию о ошибке. ('status' == '2' ЭТО ТОЖЕ САМОЕ ЧТО 'status' == 'false')
* Для того, чтобы получить информацию о ошибке, 
* нужно вызвать метод $paperscroll->editMerchant($name, $group_id, $link)['response']['error']['ПАРАМЕТР ОШИБКИ'];
* Параметры, которые можно получить: error_code || error_msg || error_text
*
* Готовый вариант получения ошибки:
* $paperscroll->editMerchant($name, $group_id, $link)['response']['error']['error_text'];
*/

	public function editMerchant(string $name, int $group_id, string $link) {
	$body = "{\"name\": \"{$name}\",\"group_id\": {$group_id},\"avatar\": \"{$link}\"}";
	return $this->request('merchants.edit', $body);
	}

/**
* Функция getUsers - возвращает информацию о пользователях по их идентификаторам.
* Вызвать метод можно так: $paperscroll->getUsers('ID пользователя')['response']['ТУТ ПАРАМЕТР, КОТОРЫЙ ВАМ НУЖЕН'];
* Параметры, которые можно получить: user_id || first_name || last_name || avatar || avatar_max || balance || improvements_sum || bonuses_sum
* 
* Готовый варинт:
* $paperscroll->getUsers('107832372')['balance'];
*
* Когда 'status' == '2', то можно получить более подробную информацию о ошибке. ('status' == '2' ЭТО ТОЖЕ САМОЕ ЧТО 'status' == 'false')
* Для того, чтобы получить информацию о ошибке, 
* нужно вызвать метод $paperscroll->getUsers('ID пользователя')['response']['error']['ПАРАМЕТР ОШИБКИ'];
* Параметры, которые можно получить: error_code || error_msg || error_text
*
* Готовый вариант получения ошибки:
* $paperscroll->getUsers('107832372')['response']['error']['error_text'];
*
* ВНИМАНИЕ! Если пользователь не заходил в игру ни разу, или не давал разрешение на просмотр профиля,
* то 'response' будет возвращать пустоту и 'status' == '2'.
*/

	public function getUsers(int $user_id) {
	$body = "{\"user_ids\": [{$user_id}]}";
	return $this->request('users.get', $body);
	}

/**
* Функция getUsersBalances - возвращает информацию о балансах пользователей по их идентификаторам.
* Вызвать метод можно так: $paperscroll->getUsersBalances('ID пользователя')['response']['ТУТ ПАРАМЕТР, КОТОРЫЙ ВАМ НУЖЕН'];
* Параметры, которые можно получить: user_id || balance
* 
* Готовый варинт:
* $paperscroll->getUsersBalances('107832372')['balance'];
*
* Когда 'status' == '2', то можно получить более подробную информацию о ошибке. ('status' == '2' ЭТО ТОЖЕ САМОЕ ЧТО 'status' == 'false')
* Для того, чтобы получить информацию о ошибке, 
* нужно вызвать метод $paperscroll->getUsersBalances('ID пользователя')['response']['error']['ПАРАМЕТР ОШИБКИ'];
* Параметры, которые можно получить: error_code || error_msg || error_text
*
* Готовый вариант получения ошибки: 
* $paperscroll->getUsersBalances('107832372')['response']['error']['error_text'];
*
* ВНИМАНИЕ! Если пользователь не заходил в игру ни разу, или не давал разрешение на просмотр профиля,
* то 'response' будет возвращать пустоту и 'status' == '2'.
*/

	public function getUsersBalances(int $user_id) {
	$body = "{\"user_ids\": [{$user_id}]}";
	return $this->request('users.getBalances', $body);
	}

/**
* Функция createTransfer - запускает выполнение нового перевода.
* Вызвать метод можно так: $paperscroll->createTransfer($to_id, $object, $object_id, $amount);
* Чтобы совершить перевод, нужно выставить свои параметры to_id, object, object_id, amount.
* ВНИМАНИЕ! После успешного выполнения возвращает TRUE.
* Поле $object может принимать несколько значений: balance || disinfectants || items
* Поле $object_id может содержать ID предмета, НО при $object = balance, поле $object_id должно быть 0. 
* При переводе баланса, сумма ($amount) должна быть указана в тыс. долях, в остальных случаях - нет.
*
* Также можно получить обратно параметры.
* Параметры, которые можно получить: transfer_id || external_id || owner_id || peer_id || is_initiator ||
* payload || type || object_type || object_type_id || amount || create_date
*
* Готовый варинт для получения параметров:
* $paperscroll->createTransfer('107832372', 'balance', '0', '1000')['response']['transfer_id'];
*
* Готовый варинт для перевода баланса:
* $paperscroll->createTransfer('107832372', 'balance', '0', '1000');
* 
* Готовый вариант для перевода, например, средства защиты (В этом случае - маски):
* $paperscroll->createTransfer('107832372', 'disinfectants', '1', '1');
*
* Когда 'status' == '2', то можно получить более подробную информацию о ошибке. ('status' == '2' ЭТО ТОЖЕ САМОЕ ЧТО 'status' == 'false')
* Для того, чтобы получить информацию о ошибке, 
* нужно вызвать метод $paperscroll->createTransfer($to_id, $object, $object_id, $amount)['response']['error']['ПАРАМЕТР ОШИБКИ'];
* Параметры, которые можно получить: error_code || error_msg || error_text
*
* Готовый вариант получения ошибки: 
* $paperscroll->createTransfer('107832372', 'balance', '0', '1000')['response']['error']['error_text'];
*/

	public function createTransfer(int $to_id, string $object, int $object_id, int $amount) {
	$body = "{\"peer_id\": {$to_id},\"object_type\": \"{$object}\",\"object_type_id\": {$object_id},\"amount\": {$amount}}";
	return $this->request('transfers.create', $body);
	}

/**
* Функция getTransfers - возвращает список переводов по их идентификаторам.
* Вызвать метод можно так: $paperscroll->getTransfers('ID перевода')['response']['ТУТ ПАРАМЕТР, КОТОРЫЙ ВАМ НУЖЕН'];
* Параметры, которые можно получить: transfer_id || external_id || owner_id || peer_id || is_initiator ||
* payload || type || object_type || object_type_id || amount || create_date
*
* Готовый варинт:
* $paperscroll->getTransfers('702842')['response']['transfer_id'];
*
* Когда 'status' == '2', то можно получить более подробную информацию о ошибке. ('status' == '2' ЭТО ТОЖЕ САМОЕ ЧТО 'status' == 'false')
* Для того, чтобы получить информацию о ошибке, 
* нужно вызвать метод $paperscroll->getTransfers('ID перевода')['response']['error']['ПАРАМЕТР ОШИБКИ'];
* Параметры, которые можно получить: error_code || error_msg || error_text
*
* Готовый вариант получения ошибки: 
* $paperscroll->getTransfers('ID перевода')['response']['error']['error_text'];
*
* ВНИМАНИЕ! Если ID платежа указан неверно, то 'status' == '2' и 'response' вернет пустоту.
*/

	public function getTransfers(int $id) {
	$body = "{\"transfer_ids\": [{$id}]}";
	return $this->request('transfers.get', $body);
	}

/**
* Функция getHistoryTransfers - возвращает список последних переводов.
* Вызвать метод можно так: $paperscroll->getHistoryTransfers()['response']['ТУТ ПАРАМЕТР, КОТОРЫЙ ВАМ НУЖЕН'];
* Параметры, которые можно получить: transfer_id || external_id || owner_id || peer_id || is_initiator ||
* payload || type || object_type || object_type_id || amount || create_date
*
* По умолчанию я сделал 1 платёж, если кому-то нужно получать 2+, свяжитесь со мной, чтобы узнать как это сделать.
* Я в ВК: https://vk.com/id107832372
*
* Готовый варинт:
* $paperscroll->getHistoryTransfers()['response']['transfer_id'];
*
* Когда 'status' == '2', то можно получить более подробную информацию о ошибке. ('status' == '2' ЭТО ТОЖЕ САМОЕ ЧТО 'status' == 'false')
* Для того, чтобы получить информацию о ошибке, 
* нужно вызвать метод $paperscroll->getHistoryTransfers()['response']['error']['ПАРАМЕТР ОШИБКИ'];
* Параметры, которые можно получить: error_code || error_msg || error_text
*
* Готовый вариант получения ошибки: 
* $paperscroll->getHistoryTransfers()['response']['error']['error_text'];
*
* ВНИМАНИЕ! Если ID платежа указан неверно, то 'status' == '2' и 'response' вернет пустоту.
*/

	public function getHistoryTransfers(int $offfset = 1, int $limit = 1) {
	$body = "{\"filter\": \"all\",\"offfset\": {$offfset},\"limit\": {$limit}}";
	return $this->request('transfers.getHistory', $body);
	}

/**
* Функция getWebhook - возвращает информацию о текущем установленном сервере или ошибку при его отсутствии.
* Вызвать метод можно так: $paperscroll->getWebhook()['response']['ТУТ ПАРАМЕТР, КОТОРЫЙ ВАМ НУЖЕН'];
* Параметры, которые можно получить: webhook_id || merchant_id || events || secret || create_date
*
* Готовый варинт:
* $paperscroll->getWebhook()['response']['webhook_id'];
*
* Когда 'status' == '2', то можно получить более подробную информацию о ошибке. ('status' == '2' ЭТО ТОЖЕ САМОЕ ЧТО 'status' == 'false')
* Для того, чтобы получить информацию о ошибке, 
* нужно вызвать метод $paperscroll->getWebhook()['response']['error']['ПАРАМЕТР ОШИБКИ'];
* Параметры, которые можно получить: error_code || error_msg || error_text
*
* Готовый вариант получения ошибки: 
* $paperscroll->getWebhook()['response']['error']['error_text'];
*/

	public function getWebhook() {
	return $this->requestq('webhooks.get');
	}

/**
* Функция createWebhook - настраивает Webhook для отправки уведомлений о событиях.
* Вызвать метод можно так: $paperscroll->createWebhook($url)['response']['ТУТ ПАРАМЕТР, КОТОРЫЙ ВАМ НУЖЕН'];
* Параметры, которые можно получить: webhook_id || merchant_id || url || secret || create_date
*
* Готовый варинт:
* $url = 'https://example.com/webhook';
* $paperscroll->createWebhook($url)['response']['webhook_id'];
*
* Когда 'status' == '2', то можно получить более подробную информацию о ошибке. ('status' == '2' ЭТО ТОЖЕ САМОЕ ЧТО 'status' == 'false')
* Для того, чтобы получить информацию о ошибке, 
* нужно вызвать метод $paperscroll->createWebhook($url)['response']['error']['ПАРАМЕТР ОШИБКИ'];
* Параметры, которые можно получить: error_code || error_msg || error_text
*
* Готовый вариант получения ошибки: 
* $paperscroll->createWebhook($url)['response']['error']['error_text'];
*/

	public function createWebhook(string $url) {
	$body = "{\"url\": \"{$url}\",\"events\": [\"transfer_new\"]}";
	return $this->request('webhooks.create', $body);
	}

/**
* Функция deleteWebhook - удялает текущий используемый сервер.
* Вызвать метод можно так: $paperscroll->deleteWebhook();
* ВНИМАНИЕ! Если привязанного адреса нет, то 'status' == '2'.
*
* Готовый варинт:
* $paperscroll->deleteWebhook();
*
* Когда 'status' == '2', то можно получить более подробную информацию о ошибке. ('status' == '2' ЭТО ТОЖЕ САМОЕ ЧТО 'status' == 'false')
* Для того, чтобы получить информацию о ошибке, 
* нужно вызвать метод $paperscroll->deleteWebhook()['response']['error']['ПАРАМЕТР ОШИБКИ'];
* Параметры, которые можно получить: error_code || error_msg || error_text
*
* Готовый вариант получения ошибки: 
* $paperscroll->deleteWebhook()['response']['error']['error_text'];
*/

	public function deleteWebhook() {
	return $this->requestq('webhooks.delete');
	}

/**
* Функция getLogsWebhook - возвращает информацию о последних 20 ошибках при отправке событий.
* Вызвать метод можно так: $paperscroll->getLogsWebhook()['response'];
* ВНИМАНИЕ! Если ошибок нет, то 'response' будет возвращать пустоту.
* Если ошибка есть, то ответ будет примерно такой: "15.06.2020 08:00:00 — 404 Not found".
*
* Готовый варинт:
* $paperscroll->getLogsWebhook()['response'];
*
* Когда 'status' == '2', то можно получить более подробную информацию о ошибке. ('status' == '2' ЭТО ТОЖЕ САМОЕ ЧТО 'status' == 'false')
* Для того, чтобы получить информацию о ошибке, 
* нужно вызвать метод $paperscroll->getLogsWebhook()['response']['error']['ПАРАМЕТР ОШИБКИ'];
* Параметры, которые можно получить: error_code || error_msg || error_text
*
* Готовый вариант получения ошибки: 
* $paperscroll->getLogsWebhook()['response']['error']['error_text'];
*/

	public function getLogsWebhook() {
	return $this->requestq('webhooks.getLogs');
	}

/**
* Функция request и requestq используются для запросов к API.
*/
	private function request($method,$body) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, self::API_HOST.'/'.$method);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  	"Content-Type: application/json",
	"Authorization: Basic ".base64_encode($this->merchant_id.':'.$this->token)));
	$response = curl_exec($ch);
	$info = curl_getinfo($ch);
	$error = curl_error($ch);
	curl_close($ch);
	if($error) {
	return ['status' => false, 'error' => $error];
	} else {
	$response = json_decode($response, true);
	$check = !isset($response['response'][0]);
	if($check) {
	var_dump(['status' => 2, 'response' => isset($response['response']) ? $response['response'] : $response]);
	return ['status' => 2, 'response' => isset($response['response']) ? $response['response'] : $response];
	} else {
	var_dump(['status' => 1, 'response' => $response['response'][0]]);
	return ['status' => 1, 'response' => $response['response'][0]];
	}
	}
	}

	private function requestq($method) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, self::API_HOST.'/'.$method);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  	"Content-Type: application/json",
	"Authorization: Basic ".base64_encode($this->merchant_id.':'.$this->token)));
	$response = curl_exec($ch);
	$info = curl_getinfo($ch);
	$error = curl_error($ch);
	curl_close($ch);
	if($error) {
	return ['status' => 2, 'error' => $error];
	} else {
	$response = json_decode($response, true);
	$check = !isset($response['response']);
	if($check) {
	var_dump(['status' => 2, 'response' => isset($response['response']) ? $response['response'] : $response]);
	return ['status' => 2, 'response' => isset($response['response']) ? $response['response'] : $response];
	} else {
	var_dump(['status' => 1, 'response' => $response['response']]);
	return ['status' => 1, 'response' => $response['response']];
	}
	}
	}
}
