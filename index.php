<?php
/**
 * Константа запрещающая доступ к скриптам напрямую
 */
define('VG_ACCESS', true);

/**
 * Отправляем http заголовки клиенту
 */
header('Content-type:text/html:charset=utf-8');

/**
 * Запускаем сессию
 */
session_start();

/**
 * Конфиг для хранения базовых настроек
 */
require_once 'config.php';

/**
 * Конфиг для хранения всех внутренних настроек (роутниг, доступы, пути к шаблонам)
 */
require_once 'core/base/settings/internal_settings.php';