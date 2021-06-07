<?php

namespace Http;

require_once 'services/api/Http/IRequest.php';
require_once 'services/api/Http/CMessage.php';

/**
 * Реализация интерфейса IRequest
 * Представляет HTTP запрос.
 * Все set-методы возвращают $this
 */
class CRequest extends CMessage implements IRequest, \JsonSerializable
{
    /**
     * Метод запроса.
     * @var string
     */
    protected $method;

    /**
     * URI запроса.
     * @var string
     */
    protected $uri;

    /**
     * Конструктор.
     * @param string $method Регистрозависимая строка определяющая метод запроса.
     * @param string $uri URI запроса.
     * @param array $headers Массив заголовков запроса.
     * @param string $body Тело запроса.
     */
    public function __construct ( string $method, string $uri, array $headers = [ ], string $body = '' )
    {
        parent::__construct ( $body, $headers );

        $this->setUri ( $uri )->setMethod ( $method );
    }

    /**
     * Устанавливает метод запроса.
     * @param string $method Регистрозависимая строка определяющая метод запроса.
     */
    public function setMethod ( string $method )
    {
        $this->method = $method;
        return $this;
    }

    /**
     * Возвращает метод запроса.
     * @return string Метод запроса ('GET', 'POST' и т.д.)
     */
    public function getMethod ( ) : string
    {
        return $this->method;
    }

    /**
     * Устанавливает URI запроса.
     * @param string $uri URI запроса.
     */
    public function setUri ( string $uri )
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * Возвращает URI запроса.
     * @return string URI запроса.
     */
    public function getUri ( ) : string
    {
        return $this->uri;
    }

    /**
     * Возвращает данные, которые могут быть сериализованы функцией json_encode(),
     *     которые являются значением любого типа, кроме resource.
     * @return mixed Данные для сериализации функцией json_encode
     */
    public function jsonSerialize ( )
    {
        return \get_object_vars ( $this );
    }
}
