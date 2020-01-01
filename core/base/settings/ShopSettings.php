<?php

namespace core\base\settings;

use core\base\controllers\Singleton;

class ShopSettings
{
    use Singleton {
        instance as traitInstance;
    }

    /**
     * Свойство хранения основных настроек из класса Settings
     */
    private $baseSettings;

    /**
     * Свойство хранения шаблонов для полей плагина
     */
    private $templateArr = [
        'text' => ['price', 'short', 'name'],
        'textarea' => ['goods_content'],
    ];

    private $routes = [
        'plugins' => [
            'path' => 'core/plugins/',
            'hrUrl' => false,
            'dir' => false,
            'routes' => [
            ]
        ],
        'test' => [4,2,3],
    ];

//    private $expansion = 'core/plugin/expansion/';

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

        self::traitInstance()->baseSettings = Settings::instance();
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