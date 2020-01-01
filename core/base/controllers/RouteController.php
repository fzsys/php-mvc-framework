<?php

namespace core\base\controllers;

use core\base\exceptions\RouteException;
use core\base\settings\Settings;

class RouteController extends BaseController
{
    /**
     * Подключаем трейт синглтон
     */
    use Singleton;

    /**
     * Свойство для хранения всех роутов
     */
    protected $routes;

    /**
     * Конструктор
     */
    private function __construct()
    {
        $address_str = $_SERVER['REQUEST_URI'];

        if ($_SERVER['QUERY_STRING']) {
            $address_str = substr($address_str, 0, strpos($address_str, $_SERVER['QUERY_STRING']) - 1);
        }

        //получаем путь к выполняемому скрипту
        $path = substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], 'index.php'));

        //продолжем выполнение только в случае если путь выпоняемого скрипта совпадается с корнем сайта
        if ($path === PATH) {

            //переадресовываем все стр. со слешем вконце на аналогичные без слеша
            if (strrpos($address_str, '/') === strlen($address_str) - 1 && strrpos($address_str, '/') !== strlen(PATH) - 1) {
                $this->redirect(rtrim($address_str, '/'), 301);
            }

            //получаем все роуты с класса настроек
            $this->routes = Settings::get('routes');
            if (!$this->routes) {
                throw new RouteException('Отсутствуют маршруты в базовых настройках', 1);
            }

            //разбиваем запрос из урла на массив
            $url = explode('/', substr($address_str, strlen(PATH)));

            // проверяем урл на принадлежность к админке либо для пользовательской части сайта и получаем соотв. парамеры из настроек
            if ($url[0] && $url[0] === $this->routes['admin']['alias']) {

                array_shift($url);

                //проверяем принадлежность к плагину либо просто к админке
                if ($url[0] && is_dir($_SERVER['DOCUMENT_ROOT'] . PATH . $this->routes['plugins']['path'] . $url[0])) {

                    //получаем название плагина и его класс настроек
                    $plugin = array_shift($url);
                    $pluginSettings = $this->routes['settings']['path'] . ucfirst($plugin) . 'Settings';

                    //если существует класс настроек плагина - получаем его роутинг
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . PATH . $pluginSettings . '.php')) {
                        $pluginSettings = str_replace('/', '\\', $pluginSettings);
                        $this->routes = $pluginSettings::get('routes');
                    }

                    //проверяем на размещение плагина в поддиректории
                    $dir = $this->routes['plugins']['dir'] ? '/' . $this->routes['plugins']['dir'] . '/' : '/';
                    $dir = str_replace('//', '/', $dir);

                    //получаем настройки роутинга плагина
                    $this->controller = $this->routes['plugins']['path'] . $plugin . $dir;
                    $hrUrl = $this->routes['plugins']['hrUrl'];
                    $route = 'plugins';

                } else {

                    //получаем настройки роутинга для админпанели без плагина
                    $this->controller = $this->routes['admin']['path'];
                    $hrUrl = $this->routes['admin']['hrUrl'];
                    $route = 'admin';
                }

            } else {

                //получаем настройки роутинга для пользовательской части сайта
                $hrUrl = $this->routes['user']['hrUrl'];
                $this->controller = $this->routes['user']['path'];
                $route = 'user';
            }


            //получаем параметры роутинга для пользовательской части сайта
            $this->createRoute($route, $url);

            //формируем массив с параметрами из урла запроса (
            if ($url[1]) {
                $count = count($url);
                $key = '';

                if (!$hrUrl) {
                    $i = 1;
                } else {
                    $this->parameters['alias'] = $url[1];
                    $i = 2;
                }

                for (; $i < $count; $i++) {
                    if (!$key) {
                        $key = $url[$i];
                        $this->parameters[$key] = '';
                    } else {
                        $this->parameters[$key] = $url[$i];
                        $key = '';
                    }
                }
            }

        } else {
            throw new RouteException('Некорректная директория сайта', 1);
        }
    }

    /**
     * Метод выбора контроллера и методов для текщего роута
     * @param $var - переменная с укзаателем на текущий роут (админка, плагин или пользовательская часть сайта)
     * @param $arr - массив со всеми параметрами из урла запроса
     */
    private function createRoute($var, $arr)
    {
        $route = [];

        // выбираем контоллер согласно урла либо дефолтный из настроек, если запрос пустой
        if (!empty($arr[0])) {
            if ($this->routes[$var]['routes'][$arr[0]]) {
                $route = explode('/', $this->routes[$var]['routes'][$arr[0]]);
                $this->controller .= ucfirst($route[0] . 'Controller');
            } else {
                $this->controller .= ucfirst($arr[0] . 'Controller');
            }
        } else {
            $this->controller .= $this->routes['default']['controller'];
        }

        // выбираем методы согласно урла либо дефолтный из настроек, если запрос пустой
        $this->inputMethod = $route[1] ? $route[1] : $this->routes['default']['inputMethod'];
        $this->outputMethod = $route[2] ? $route[2] : $this->routes['default']['outputMethod'];

        return;
    }

}