<?php
/**
 * Закрываем доступ к скрипту напрямую
 */
if (!defined('VG_ACCESS')) {
    die('access denied');
}

/**
 * Пути к шаблонам сайта
 */
const TEMPLATE = 'templates/default';
const ADMIN_TEMPLATE = 'core/admin/views';

/**
 * Настройки куки для пользователей
 */
const COOKIE_VERSION = '1.0.0';
const CRYPT_KEY = '';
const COOKIE_TIME = 60;

/**
 * Время блокмровки после попытки брутфорса
 */
const BLOCK_TIME = 3;

/**
 * Параметры постраничной навигации - количество записей на одной стр и количество ссылок в пагинации
 */
const QTY = 8;
const QTY_LINKS = 3;

/**
 * Пути к стилям и скриптам
 */
const ADMIN_CSS_JS = [
    'styles' => [],
    'scripts' => [],
];
const USER_CSS_JS = [
    'styles' => [],
    'scripts' => [],
];