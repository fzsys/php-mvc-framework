<?php

namespace core\base\settings;

class ShopSettings
{
    use BaseSettings;

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

}