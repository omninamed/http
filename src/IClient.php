<?php

namespace Http;

/**
 * Интерфейс HTTP клиента.
 * Все реализации set-методов ДОЛЖНЫ возвращать $this
 */
interface IClient
{
    /**
     * Отправляет подготовленный HTTP запрос.
     * @param \Http\IRequest $request Подготовленный запрос.
     * @return \Http\IResponse Результат запроса.
     */
    public function sendRequest ( IRequest $request ) : IResponse;
}
