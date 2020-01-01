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
        'test' => [1, 2, 3],
    ];

    private $defaultTable = 'teachers';

    private $formTemplates = PATH . 'core/admin/views/include/form_templates/';

    private $projectTables = [
        'teachers' => [
            'name' => 'Учителя',
        ],
        'students' => [
            'name' => 'Ученики',
        ],
    ];

    /**
     * Свойство хранения шаблонов для основных полей
     */
    private $templateArr = [
        'text' => ['name'],
        'textarea' => ['content', 'keywords'],
        'radio' => ['visible'],
        'select' => ['menu_position', 'parent_id'],
        'img' => ['img'],
        'gallery_img' => ['gallery_img'],
    ];

    private $translate = [
        'name' => ['Название', 'Не более 100 символов'],
        'keywords' => ['Ключевые слова', 'Не более 70 символов'],
        'content' => ['Контент', ''],
    ];

    private $radio = [
        'visible' => ['Нет', 'Да', 'default' => 'Да'],
    ];

    private $rootItems = [
        'name' => 'Корневая',
        'tables' => ['articles'],
    ];

    private $blockNeedle = [
        'vg-rows' => [],
        'vg-img' => ['img'],
        'vg-content' => ['content', 'keywords'],
    ];

    private $validation = [
        'name' => ['empty' => true, 'trim' => true,],
        'price' => ['int' => true,],
        'login' => ['empty' => true, 'trim' => true,],
        'password' => ['crypt' => true, 'empty' => true],
        'keywords' => ['count' => 70, 'trim' => true],
        'description' => ['count' => 160, 'trim' => true],
    ];

    private $expansion = 'core/admin/expansion/';

    private $messages = 'core/base/messages/';

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