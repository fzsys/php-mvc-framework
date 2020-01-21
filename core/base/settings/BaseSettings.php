<?php

namespace core\base\settings;

use core\base\controllers\Singleton;

/**
 * Трейт для подключения любых расширений фреймворка
 */
trait BaseSettings
{
    use Singleton {
        instance as SingletonInstance;
    }

    /**
     * Свойство хранения основных настроек из класса Settings
     */
    private $baseSettings;

    /**
     * Метод получения свойства обьекта
     */
    static public function get($property)
    {
        return self::instance()->$property;
    }

    /**
     * Метод получения екземпляра класса + склейка свойст из основного класса настроек
     */
    static public function instance()
    {
        if (self::$_instance instanceof self) {
            return self::$_instance;
        }

        self::SingletonInstance()->baseSettings = Settings::instance();
        $baseProperties = self::$_instance->baseSettings->clueProperties(get_class());
        self::$_instance->setProperty($baseProperties);
        return self::$_instance;
    }

    /**
     * Метод записи свойств в обьект класса
     */
    protected function setProperty($properties)
    {
        if ($properties) {
            foreach ($properties as $name => $property) {
                $this->$name = $property;
            }
        }
    }
}