<?php

namespace core\base\controllers;

trait Singleton
{
    /**
     * Свойство хранения обьекта класса
     */
    static private $_instance;

    /**
     * Запрещаем клонирование обьекта
     */
    private function __clone()
    {
    }

    /**
     * Запрещаем создание обьекта класса напрямую
     */
    private function __construct()
    {
    }

    /**
     * Метод получения екземпляра класса
     */
    static public function instance()
    {
        if (self::$_instance instanceof self) {
            return self::$_instance;
        }

        self::$_instance = new self;

        if(method_exists(self::$_instance, 'connect')) {
            self::$_instance->connect();
        }

        return self::$_instance;
    }


}