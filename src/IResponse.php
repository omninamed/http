<?php

namespace Http;

/**
 * Интерфейс HTTP ответа.
 * Все реализации set-методов должны возвращать $this
 */
interface IResponse extends IMessage
{
    /**
     * Устанавливает код ответа (состояния)
     * @param int $status_code Код ответа (состояния)
     * @return $this
     */
    public function setStatus ( int $status_code );

    /**
     * Возвращает код ответа (состояния)
     * @return int Код ответа (состояния)
     */
    public function getStatus ( ) : int;
}
