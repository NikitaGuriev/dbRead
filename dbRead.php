<?php

/**
 * Отчет по Уведомляшке за месяц
 * Формат времени: YYYY-MM-DD HH:MM:SS.000000
 */

/** Блок логирования ошибок PHP */
ini_set('display_errors', 0);
ini_set('log_errors', 'on');
ini_set('error_log', __DIR__ . '/error.log');

/** Блок пользовательских функций */

if ($_REQUEST['password'] == 'password') {
  /** Подключение модулей */
  require_once __DIR__ . '/funcs/GDD.php';
  require_once __DIR__ . '/funcs/Parser.php';

  /** Блок определения констант */
  define('TABLE_NAME', 'TABLE_NAME');
  define('CURRENT_YEAR_MONTH_SECOND', date('Y-m') . '-02 00:00:00.000000'); // Второе число текущего месяца
  define('CURRENT_YEAR_MONTH_FIRST', date('Y-m') . '-01 00:00:00.000000'); // Второе число текущего месяца
  define('CURRENT_YEAR_MONTH', date('Y-m-d') . ' ' . date('H:i:s') . '.000000'); // Текущее число текущего месяца
  define(
    'LAST_YEAR_MONTH',
    date('Y-m', strtotime('first day of -1 month')) . '-01 00:00:00.000000'
  ); // Первое число предыдущего месяца
  define('FILE_NAME', 'scriptBot.php');

  /** Константы для работы с БД */
  define('DB_USERNAME', 'DB_USERNAME');
  define('DB_PASSWORD', 'DB_PASSWORD');
  define('DB_NAME', 'DB_NAME');

  /** Блок алгоритма работы */
  /** Блок выборки данных за прошлый месяц */
  /** Подключение к БД */
  $GDD = new GDD('localhost', DB_USERNAME, DB_PASSWORD, DB_NAME);

  /** Получение данных из БД */
  $queryString =
    'SELECT * FROM ' .
    TABLE_NAME .
    ' WHERE dateTime<=\'' .
    CURRENT_YEAR_MONTH_SECOND .
    '\' AND dateTime>=\'' .
    LAST_YEAR_MONTH .
    '\' AND file=\'' .
    FILE_NAME .
    '\'';
  $getData = $GDD->getTableData($queryString);

  /** Общее количество сообщений */
  $totalMessages = $GDD->getTotalRows($getData);

  /** Наполнение массива с данными */
  $rowsData = $GDD->fetchAssocAllData($getData);

  /** Подключение парсера */
  $parser = new Parser($rowsData);

  /** Построение массива */
  $parser->buildArray('portal', 'id');

  /** Построение таблицы */
  $table = $parser->buildTable(
    'Статистика сообщений по порталам за прошлый месяц (с ' .
      date('d.m.Y H:i:s', strtotime(LAST_YEAR_MONTH)) .
      ' по ' .
      date('d.m.Y H:i:s', strtotime(CURRENT_YEAR_MONTH_SECOND)) .
      ')'
  );

  /** Блок выборки данных за текущий месяц */
  /** Подключение к БД */
  $currentMonthGDD = new GDD('localhost', DB_USERNAME, DB_PASSWORD, DB_NAME);

  /** Получение данных из БД */
  $queryStringCurrent =
    'SELECT * FROM ' .
    TABLE_NAME .
    ' WHERE dateTime<=\'' .
    CURRENT_YEAR_MONTH .
    '\' AND dateTime>=\'' .
    CURRENT_YEAR_MONTH_FIRST .
    '\' AND file=\'' .
    FILE_NAME .
    '\'';
  $getDataCurrent = $currentMonthGDD->getTableData($queryStringCurrent);

  /** Общее количество сообщений */
  $totalMessagesCurrent = $currentMonthGDD->getTotalRows($getDataCurrent);

  /** Наполнение массива с данными */
  $rowsDataCurrent = $currentMonthGDD->fetchAssocAllData($getDataCurrent);

  /** Подключение парсера */
  $parserCurrent = new Parser($rowsDataCurrent);

  /** Построение массива */
  $parserCurrent->buildArray('portal', 'id');

  /** Построение таблицы */
  $tableCurrent = $parserCurrent->buildTable(
    'Статистика сообщений по порталам за текущий месяц (с ' .
      date('d.m.Y H:i:s', strtotime(CURRENT_YEAR_MONTH_FIRST)) .
      ' по ' .
      date('d.m.Y H:i:s', strtotime(CURRENT_YEAR_MONTH)) .
      ')'
  );

  require_once __DIR__ . '/view.php';
} else {
  http_response_code(403);
  die();
}
