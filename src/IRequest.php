<?php

namespace Http;

/**
 * Интерфейс HTTP запроса.
 * Все реализации set-методов ДОЛЖНЫ возвращать $this
 */
interface IRequest extends IMessage
{
    /**
     * Устанавливает метод запроса.
     * @param string $method Регистрозависимая строка определяющая метод запроса.
     */
    public function setMethod ( string $method );

    /**
     * Возвращает метод запроса.
     * @return string Метод запроса ('GET', 'POST' и т.д.)
     */
    public function getMethod ( ) : string;

    /**
     * Устанавливает URI запроса.
     * @param string $uri URI запроса.
     */
    public function setUri ( string $uri );

    /**
     * Возвращает URI запроса.
     * @return string URI запроса.
     */
    public function getUri ( ) : string;
}
