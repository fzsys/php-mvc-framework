<?php

namespace core\base\settings;

use core\base\controllers\Singleton;

class Settings
{
    /**
     * Подключаем трейт синглтон
     */
     use Singleton;

    /**
     * Свойство хранения роутов
     */
    private $routes = [
        'admin' => [
            'alias' => 'admin',
            'path' => 'core/admin/controllers/',
            'hrUrl' => false,
            'routes' => [
            ]
        ],
        'settings' => [
            'path' => 'core/base/settings/',
        ],
        'plugins' => [
            'path' => 'core/plugins/',
            'hrUrl' => false,
            'dir' => false,
        ],
        'user' => [
            'path' => 'core/user/controllers/',
            'hrUrl' => true,
            'routes' => [
            ]
        ],
        'default' => [
            'controller' => 'IndexController',
            'inputMethod' => 'inputData',
            'outputMethod' => 'outputData',
        ],
        'test' => [1,2,3],
    ];

    private $defaultTable = 'teachers';

    /**
     * Свойство хранения шаблонов для основных полей
     */
    private $templateArr = [
        'text' => ['name', 'phone', 'address'],
        'textarea' => ['content', 'keywords'],
    ];

    private $expansion = 'core/admin/expansion/';

    /**
     * Метод получения свойства обьекта
     */
    static public function get($property)
    {
        return self::instance()->$property;
    }

    /**
     * Метод получения и обьединения свойств обьекта класса Settings и обьекта плагина
     */
    public function clueProperties($class)
    {
        $baseProperties = [];

        foreach ($this as $name => $item) {
            $property = $class::get($name);
            if (is_array($property) && is_array($item)) {
                $baseProperties[$name] = $this->arrayMergeRecursive($this->$name, $property);
                continue;
            }

            if (!$property) {
                $baseProperties[$name] = $this->$name;
            }
        }

        return $baseProperties;
    }

    /**
     * Метод рекурсивной склейки массивов
     */
    public function arrayMergeRecursive()
    {
        $arrays = func_get_args();
        $base = array_shift($arrays);
        foreach ($arrays as $array) {
            foreach ($array as $k => $v) {
                if (is_array($v) && is_array($base[$k])) {
                    $base[$k] = $this->arrayMergeRecursive($base[$k], $v);
                } else {
                    if (is_int($k)) {
                        if (!in_array($v, $base)) {
                            array_push($base, $v);
                            continue;
                        }
                    }
                    $base[$k] = $v;
                }
            }
        }
        return $base;
    }
}