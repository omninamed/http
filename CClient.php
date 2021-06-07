<?php

namespace Http;

require_once 'services/api/Http/IClient.php';
require_once 'services/api/Http/IRequest.php';
require_once 'services/api/Http/CResponse.php';

/**
 * Реализация интерфейса IClient
 * Представляет HTTP клиент.
 * Все set-методы возвращают $this
 */
class CClient implements IClient
{
    /**
     * Дескриптор cURL или CurlHandle (PHP >= 8.0)
     * @var resource|CurlHandle
     */
    protected $http = false;

    /**
     * Тайм-аут для фазы подключения в секундах.
     * @var int
     */
    protected $connect_timeout = 30;

    /**
     * Тайм-аут для фазы выполнения запроса в секундах.
     * @var int
     */
    protected $request_timeout = 30;

    /**
     * Конструктор.
     */
    public function __construct ( )
    {
        $this->http = curl_init ( );
    }

    /**
     * Устанавливает тайм-ауты для фаз подключения и выполнения запроса.
     * @param int $connect Тайм-аут для фазы подключения в секундах.
     * @param int $request Тайм-аут для фазы выполнения запроса в секундах.
     * @return $this
     */
    public function setTimeouts ( int $connect, int $request )
    {
        $this->setConnectTimeout ( $connect );
        $this->setRequestTimeout ( $request );
        return $this;
    }

    /**
     * Устанавливает тайм-аут для фазы подключения в секундах.
     * @param int $timeout Тайм-аут для фазы подключения в секундах.
     * @return $this
     */
    public function setConnectTimeout ( int $timeout )
    {
        if ( $timeout < 5 )
            $this->connect_timeout = 5;
        else if ( $timeout > 60 )
            $this->connect_timeout = 60;
        else
            $this->connect_timeout = $timeout;
        return $this;
    }

    /**
     * Устанавливает тайм-аут для фазы выполнения запроса в секундах.
     * @param int $timeout Тайм-аут для фазы выполнения запроса в секундах.
     * @return $this
     */
    public function setRequestTimeout ( int $timeout )
    {
        if ( $timeout < 5 )
            $this->request_timeout = 5;
        else if ( $timeout > 60 )
            $this->request_timeout = 60;
        else
            $this->request_timeout = $timeout;
        return $this;
    }

    /**
     * Отправляет подготовленный HTTP запрос.
     * @param \Http\IRequest $request Подготовленный запрос.
     * @return \Http\IResponse Результат запроса.
     */
    public function sendRequest ( IRequest $request ) : IResponse
    {
        $user_agent = $_SERVER [ 'HTTP_USER_AGENT' ] ?? 'php http client v1.0';

        $response_headers = [ ];

        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_HEADERFUNCTION => function ( $http, $header ) use ( &$response_headers )
            {
                $length = strlen ( $header );
                $header = explode ( ':', $header, 2 );
                if ( count ( $header ) >= 2 )
                    $response_headers [ trim ( $header [ 0 ] ) ] = [ trim ( $header [ 1 ] ) ];
                return $length;
            },
            CURLOPT_USERAGENT => $user_agent,
            CURLOPT_CONNECTTIMEOUT => $this->connect_timeout,
            CURLOPT_TIMEOUT => $this->request_timeout,
            CURLOPT_CUSTOMREQUEST => $request->getMethod ( ),
            CURLOPT_URL => $request->getUri ( ),
            ];

        if ( $body = $request->getBody ( ) )
            $options += [ CURLOPT_POSTFIELDS => $body ];

        $headers = [ ];

        if ( $temp = $request->getHeaders ( ) )
            foreach ( $temp as $name => $values )
                $headers [ ] = $name . ': ' . implode ( ', ', $values );

        if ( $headers )
            $options += [ CURLOPT_HTTPHEADER => $headers ];

        curl_setopt_array ( $this->http, $options );

        $result = curl_exec ( $this->http );

        $response = new CResponse ( curl_getinfo ( $this->http, CURLINFO_HTTP_CODE ), $result );
        $response->setHeaders ( $response_headers );

        curl_reset ( $this->http );

        return $response;
    }
}
