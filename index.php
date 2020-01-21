<?php
/**
 * Константа запрещающая доступ к скриптам напрямую
 */
define('VG_ACCESS', true);

/**
 * Отправляем http заголовки клиенту
 */
header('Content-type:text/html;charset=utf-8');

/**
 * Запускаем сессию
 */
session_start();


/**
 * Подключаем конфиг для хранения базовых настроек
 */
require_once 'config.php';

/**
 * Подключаем конфиг для хранения всех внутренних настроек (роутниг, доступы, пути к шаблонам)
 */
require_once 'core/base/settings/internal_settings.php';
require_once 'libraries/functions.php';
/**
 * Подключаем неймспейсы
 */

use core\base\exceptions\DbException;
use core\base\exceptions\RouteException;
use core\base\controllers\RouteController;
use core\base\settings\Settings;
use core\base\settings\ShopSettings;

/**
 * Запускаем роутинг
 */
try {
    RouteController::instance()->route();
} catch (RouteException $e) {
    exit ($e->getMessage());
} catch (DbException $e) {
    exit ($e->getMessage());
}