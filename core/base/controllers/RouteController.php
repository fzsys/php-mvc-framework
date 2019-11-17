<?php

namespace core\base\controllers;

class RouteController
{
    /**
     * Запрещаем создание обьекта контроллера через конструктор
     */
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * Свойство для хранения обьекта класса
     */
    static private $_instance;

    /**
     * Мктод получения обьекта класса
     */
    static public function getInstance()
    {
        if (self::$_instance instanceof self) {
            return self::$_instance;
        } else {
            return self::$_instance = new self;
        }
    }

}