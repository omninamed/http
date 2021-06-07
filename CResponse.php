<?php

namespace Http;

require_once 'services/api/Http/IResponse.php';
require_once 'services/api/Http/CMessage.php';

/**
 * Реализация интерфейса IResponse
 * Представляет HTTP ответ.
 * Все set-методы возвращают $this
 */
class CResponse extends CMessage implements IResponse, \JsonSerializable
{
    /**
     * Код ответа (состояния)
     * @var int
     */
    protected $status_code;

    /**
     * Конструктор.
     * @param string $body Тело ответа.
     * @param int $status Код ответа.
     */
    public function __construct ( int $status_code, string $body )
    {
        parent::__construct ( );

        $this->setStatus ( $status_code )->setBody ( $body );
    }

    /**
     * Устанавливает код ответа (состояния)
     * @param int $status_code Код ответа (состояния)
     * @return $this
     */
    public function setStatus ( int $status_code )
    {
        $this->status_code = $status_code;
        return $this;
    }

    /**
     * Возвращает код ответа (состояния)
     * @return int Код ответа (состояния)
     */
    public function getStatus ( ) : int
    {
        return $this->status_code;
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
