<?php
/**
 * Закрываем доступ к скрипту напрямую
 */
if (!defined('VG_ACCESS')) {
    die('access denied');
}

/**
 * Константа абсолютного пути сайта
 */
const SITE_URL = 'http://mvc.loc';

/**
 * Константа корневой директории сайта (для возможности использования поддиректорий)
 */
const PATH = '/';

/**
 * Константы подкючения к базе данных
 */
const HOST = 'localhost';
const USER = 'admin';
const PASS = '123qwE';
const DB_NAME = 'mvc';
