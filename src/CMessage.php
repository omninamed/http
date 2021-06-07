<?php

namespace Http;

/**
 * Реализация интерфейса IMessage
 * Представляет HTTP сообщение.
 * Все set-методы возвращают $this
 */
class CMessage implements IMessage
{
    /**
     * Массив заголовков сообщения вида [ 'Header-Name' => [ 'Value 1', ... ] ]
     * @var array[]
     */
    protected $headers = [ ];

    /**
     * Тело сообщения.
     * @var string
     */
    protected $body = '';

    /**
     * Конструктор.
     * @param type $body
     * @param array $headers
     */
    public function __construct ( string $body = '', array $headers = [ ] )
    {
        $this->setHeaders ( $headers )->setBody ( $body );
    }

    /**
     * Устанавливает заголовок сообщения.
     * @param string $name Регистронезависимая строка определяющая имя заголовка.
     * @param string|array $values Регистрозависимая строка со значением или массив строк-значений заголовка.
     * @return $this
     */
    public function setHeader ( string $name, $values )
    {
        $name = ucwords ( strtolower ( $name ), '-' );

        if ( is_string ( $values ) )
            $this->headers [ $name ] = [ $values ];
        else if ( is_array ( $values ) )
            $this->headers [ $name ] = array_values ( $values );

        return $this;
    }

    /**
     * Возвращает массив строк-значений для указанного заголовка.
     * @param string $name Регистронезависимая строка определяющая имя заголовка.
     * @return string[]|null Массив строк-значний указанного заголовка или null, если указанный заголовок не найден.
     */
    public function getHeader ( string $name ) : ?array
    {
        return $this->headers [ ucwords ( strtolower ( $name ), '-' ) ] ?? null;
    }

    /**
     * Устанавливает заголовки сообщения.
     * @param array $headers Массив заголовков сообщения.
     *     Каждый ключ ДОЛЖЕН быть строкой-именем заголовка,
     *     а каждое значение должно быть строкой-значением или массивом строк-значений для этого заголовка.
     * @return $this
     */
    public function setHeaders ( array $headers )
    {
        foreach ( $headers as $name => $values )
        {
            if ( is_string ( $name ) )
                $name = ucwords ( strtolower ( $name ), '-' );
            else if ( is_int ( $name ) )
                $name = (string) $name;
            else
                continue;

            if ( is_string ( $values ) )
                $this->headers [ $name ] = [ $values ];
            else if ( is_array ( $values ) )
                $this->headers [ $name ] = array_values ( $values );
        }
        return $this;
    }

    /**
     * Возвращает ассоциативный массив заголовков сообщения.
     * @return array Массив заголовков сообщения.
     *     Каждый ключ ДОЛЖЕН быть именем заголовка,
     *     а каждое значение ДОЛЖНО быть массивом строк-значений для этого заголовка.
     */
    public function getHeaders ( ) : array
    {
        return $this->headers;
    }

    /**
     * Устанавливает тело сообщения.
     * @param string $body Тело сообщения.
     * @return $this
     */
    public function setBody ( string $body )
    {
        if ( \is_string ( $body ) )
        {
            $this->body = $body;

            if ( $length = \strlen ( $this->body ) )
            {
                $this->headers [ 'Content-Length' ] = [ $length ];
            }
        }
        return $this;
    }

    /**
     * Возвращает тело сообщения.
     * @return string Тело сообщения.
     */
    public function getBody ( ) : string
    {
        return $this->body;
    }
}
