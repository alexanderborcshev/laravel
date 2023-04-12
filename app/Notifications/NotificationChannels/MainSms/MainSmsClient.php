<?php

/**
 * Класс для работы с сервисом MainSms.ru
 */
namespace App\Notifications\NotificationChannels\MainSms;

class MainSmsClient
{
    const REQUEST_SUCCESS = 'success';

    protected ?string $project = null;
    protected ?string $key = null;
    protected int|bool $testMode = false;
    protected string $url= 'mainsms.ru/api/mainsms';
    protected ?array $response = null;
    protected string|bool $useSSL = false;

    /**
     * Конструктор
     *
     * @param string $project
     * @param string $key
     * @param bool|string $useSSL
     * @param bool|integer $testMode
     */
    public function __construct(string $project, string $key, bool|string $useSSL = false, bool|int $testMode = false)
    {
        $this->project = $project;
        $this->key = $key;
        $this->useSSL = $useSSL;
        $this->testMode = $testMode;
    }

    /**
     * Отправить SMS
     *
     * @param array|string $recipients
     * @param string $message
     * @param null $sender
     * @param null $run_at
     * @return boolean|integer
     * @deprecated
     */
    public function sendSMS(array|string $recipients, string $message, $sender = null, $run_at = null): bool|int
    {
        return $this->messageSend($recipients, $message, $sender, $run_at);
    }

    /**
     * Отправить Пакет SMS
     *
     * @param string $sender
     * @param array $messages [["id"=>$id, "phone"=>$phone, "text"=>$text], [...] , ... ]
     *
     * @return boolean|integer
     * @deprecated
     */
    public function sendBatch(string $sender, array $messages): bool|int
    {
        $params = array(
            'messages'       => $messages,
            'sender'        => $sender,
        );

        if ($this->testMode) {
            $params['test'] = 1;
        }

        $response = $this->makeBatchRequest('batch/send', $params);

        return $response['status'] == self::REQUEST_SUCCESS;
    }


    /**
     * Склейка параметров для формирования сигнатуры
     *
     * @param array $params
     *
     * @return array
     */

    protected function joinArrayBatchValues(array $params): array
    {
        $result = array();
        foreach ($params as $name => $value) {
            $result[$name] = is_array($value) ? join(',', ( is_array(array_values($value)[0]) ?  $this->joinArrayBatchValues($value) : $value)) : $value;
        }
        return $result;
    }


    /**
     * Отправить запрос с пакетом SMS
     *
     * @param string $function
     * @param array $params
     * @return mixed
     */

    protected function makeBatchRequest(string $function, array $params = array()): mixed
    {
        $params_for_sign = $this->joinArrayBatchValues($params);
        return $this->curlRequest($params_for_sign, $params, $function);
    }

    /**
     * Отменить запланированное сообщение
     *
     * @param array|string $messagesId
     *
     * @return boolean|array
     * @deprecated
     */
    public function cancelSMS(array|string $messagesId): bool|array
    {
        return $this->messageCancel($messagesId);
    }

    /**
     * Проверить статус доставки сообщений
     *
     * @param array|string $messagesId
     *
     * @return boolean|array
     * @deprecated
     */
    public function checkStatus(array|string $messagesId): bool|array
    {
        return $this->messageStatus($messagesId);
    }

    /**
     * Отправить SMS
     *
     * @param array|string $recipients
     * @param string $message
     * @param string $sender
     * @param null $run_at
     * @return bool
     */
    public function messageSend(array|string $recipients, string $message, string $sender, $run_at = null): bool
    {
        $params = array(
            'recipients'    => $recipients,
            'message'       => $message
        );

        if ($sender != null) {
            $params['sender'] = $sender;
        }

        if ($run_at != null) {
            $params['run_at'] = $run_at;
        }

        if ($this->testMode) {
            $params['test'] = 1;
        }
        else
        {
            if($this->isTestPhone($recipients)){
                $params['test'] = 1;
            }
        }

        $response = $this->makeRequest('message/send', $params);

        return $response['status'] == self::REQUEST_SUCCESS;
    }

    /**
     * Отмена запланированного сообщения
     *
     * @param array|string $messagesId
     * @return false|mixed
     */
    public function messageCancel(array|string $messagesId): mixed
    {
        if (! is_array($messagesId)) {
            $messagesId = array($messagesId);
        }

        $response = $this->makeRequest('message/cancel', array(
            'messages_id' => join(',', $messagesId),
        ));

        return $response['status'] == self::REQUEST_SUCCESS ? $response['messages'] : false;
    }

    /**
     * Проверить статус доставки сообщений
     *
     * @param array|string $messagesId
     * @return false|mixed
     */
    public function messageStatus(array|string $messagesId): mixed
    {
        if (! is_array($messagesId)) {
            $messagesId = array($messagesId);
        }

        $response = $this->makeRequest('message/status', array(
            'messages_id' => join(',', $messagesId),
        ));

        return $response['status'] == self::REQUEST_SUCCESS ? $response['messages'] : false;
    }

    /**
     * Запрос стоимости сообщения
     *
     * @param array|string $recipients
     * @param string $message
     * @return false|mixed
     */
    public function messagePrice(array|string $recipients, string $message): mixed
    {
        $response = $this->makeRequest('message/price', array(
            'recipients'    => $recipients,
            'message'       => $message,
        ));

        return $response['status'] == self::REQUEST_SUCCESS ? $response['price'] : false;
    }

    /**
     * Запрос информации о номерах
     *
     */
    public function phoneInfo($phones)
    {
        $response = $this->makeRequest('message/info', array(
            'phones'    => $phones
        ));

        return $response['status'] == self::REQUEST_SUCCESS ? $response['info'] : false;
    }


    /**
     * Запросить баланс
     *
     */
    public function userBalance()
    {
        $response = $this->makeRequest('message/balance');
        return $response['status'] == self::REQUEST_SUCCESS ? $response['balance'] : false;
    }

    /**
     * Запросить баланс
     *
     */
    public function getBalance()
    {
        return $this->userBalance();
    }


    /**
     * Отправить запрос
     *
     * @param string $function
     * @param array $params
     * @return mixed
     */
    protected function makeRequest(string $function, array $params = array()): mixed
    {
        $params = $this->joinArrayValues($params);
        return $this->curlRequest($params, $params, $function);
    }

    protected function joinArrayValues($params): array
    {
        $result = array();
        foreach ($params as $name => $value) {
            $result[$name] = is_array($value) ? join(',', ( is_array(array_values($value)[0]) ?  $this->joinArrayValues($value) : $value)) : $value;
        }
        return $result;
    }


    /**
     * Установить адрес шлюза
     *
     * @param string $url
     * @return void
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }


    /**
     * Получить адрес сервера
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Добавить группу
     *
     * @param string $name
     * @return boolean
     */
    public function groupAdd(string $name): bool
    {
        $params = array(
            'name'    => $name
        );

        if ($this->testMode) {
            $params['test'] = 1;
        }

        $response = $this->makeRequest('group/create', $params);

        return $response['status'] == self::REQUEST_SUCCESS;
    }


    /**
     * Удалить группу
     *
     * @param $id
     * @return boolean
     */
    public function groupRemove($id): bool
    {
        $params = array( 'id' => $id );

        if ($this->testMode) {
            $params['test'] = 1;
        }

        $response = $this->makeRequest('group/remove', $params);

        return $response['status'] == self::REQUEST_SUCCESS;
    }


    /**
     * Получить список групп
     *
     * @param null $type
     * @return boolean
     */
    public function groupGetAll($type = null): bool
    {
        $params = array();

        if ($type != null) {
            $params['type'] = $type;
        }

        if ($this->testMode) {
            $params['test'] = 1;
        }

        $response = $this->makeRequest('group/list', $params);

        return $response['status'] == self::REQUEST_SUCCESS;
    }

    /**
     * Добавить контакт
     *
     * @param array|string $phone
     * @param string $group
     * @param string|null $lastname
     * @param string|null $firstname
     * @param string|null $patronymic
     * @param string|null $birthday
     * @param string|null $param1
     * @param string|null $param2
     *
     * @return boolean
     */
    public function contactAdd(array|string $phone, string $group, string $lastname = null, string $firstname = null, string $patronymic = null, string $birthday = null, string $param1 = null, string $param2 = null): bool
    {
        $params = array(
            'phone'    => $phone,
            'group'    => $group
        );

        if ($lastname != null) {
            $params['lastname'] = $lastname;
        }

        if ($firstname != null) {
            $params['firstname'] = $firstname;
        }

        if ($patronymic != null) {
            $params['patronymic'] = $patronymic;
        }

        if ($param1 != null) {
            $params['param1'] = $param1;
        }

        if ($param2 != null) {
            $params['param2'] = $param2;
        }

        if ($this->testMode) {
            $params['test'] = 1;
        }

        $response = $this->makeRequest('contact/create', $params);

        return $response['status'] == self::REQUEST_SUCCESS;
    }



    /**
     * Удалить контакт
     *
     * @param array|string $phone
     * @param string|null $group
     *
     * @return boolean
     */
    public function contactRemove(array|string $phone, string $group = null): bool
    {
        $params = array( 'phone' => $phone );

        if ($group != null) {
            $params['group'] = $group;
        }

        if ($this->testMode) {
            $params['test'] = 1;
        }

        $response = $this->makeRequest('contact/remove', $params);

        return $response['status'] == self::REQUEST_SUCCESS;
    }



    /**
     * Получить контакт
     *
     * @param array|string $phone
     *
     * @return boolean
     */
    public function contactGet(array|string $phone): bool
    {
        $params = array( 'phone' => $phone );

        if ($this->testMode) {
            $params['test'] = 1;
        }

        $response = $this->makeRequest('contact/exists', $params);

        return $response['status'] == self::REQUEST_SUCCESS;
    }

    /**
     * Возвращает ответ сервера последнего запроса
     *
     * @return array|null
     */
    public function getResponse(): ?array
    {
        return $this->response;
    }


    /**
     * Сгенерировать подпись
     *
     * @param array $params
     * @return string
     */
    protected function generateSign(array $params): string
    {
      $params['project'] = $this->project;
      ksort($params);
      return md5(sha1(join(';', array_merge($params, Array($this->key)))));
    }

    protected function isTestPhone($phone): bool
    {
        if(preg_match('/^790000000\d|79000000\d{2}$/', $phone)) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * @param array $params_for_sign
     * @param array $params
     * @param string $function
     * @return mixed
     */
    protected function curlRequest(array $params_for_sign, array $params, string $function): mixed
    {
        $sign = $this->generateSign($params_for_sign);
        $params = array_merge(array('project' => $this->project), $params);

        $url = ($this->useSSL ? 'https://' : 'http://') . $this->url . '/' . $function;
        $post = http_build_query(array_merge($params, array('sign' => $sign)), '', '&');

        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            if ($this->useSSL) {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            }
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($ch);
            curl_close($ch);
        } else {
            $context = stream_context_create(array(
                'http' => array(
                    'method' => 'POST',
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'content' => $post,
                    'timeout' => 10,
                ),
            ));
            $response = file_get_contents($url, false, $context);
        }
        return $this->response = json_decode($response, true);
    }
}
