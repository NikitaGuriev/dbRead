<?php

/** Класс для работы с таблицей БД через mysqli */
class GDD
{
  public $host;
  public $dbUserLogin;
  public $dbUserPassword;
  public $dbName;
  public $mysqli;
  public $queryResult;

  /**
   * Конструктор объекта
   * @param string $host Сервер
   * @param string $dbUserLogin Пользователь
   * @param string $dbUserPassword Пароль
   * @param string $dbName Название
   * @return object mysqli-компонент
   */
  public function __construct($host, $dbUserLogin, $dbUserPassword, $dbName)
  {
    $this->mysqli = new mysqli($host, $dbUserLogin, $dbUserPassword, $dbName);

    $this->host = $host;
    $this->dbUserLogin = $dbUserLogin;
    $this->dbUserPassword = $dbUserPassword;
    $this->dbName = $dbName;

    return $this->mysqli;
  }

  public function closeConnection()
  {
    return $this->mysqli->close();
  }

  /**
   * Получить данные по таблице
   * @param string $tableName Название таблицы
   * @param string $query Тело запроса
   * @return object|string Массив данных или not_found (если ничего не найдено)
   */
  public function getTableData($query)
  {
    $this->queryResult = $this->mysqli->query($query);
    if ($this->queryResult->num_rows == 0) {
      return 'not_found';
    } else {
      return $this->queryResult;
    }
  }

  /**
   * Подсчет количества найденных записей
   * @param object $queryResult Результат выполнения запроса mysqli->query
   * @return int Количество найденных записей
   */
  public function getTotalRows()
  {
    return $this->queryResult->num_rows;
  }

  /**
   * Преобразовать данные в ассоциативный массив
   * @param object $queryResult Результат выполнения запроса mysqli->query
   * @return array Массив с данными из таблицы
   */
  public function fetchAssocAllData()
  {
    while ($fetchData = $this->queryResult->fetch_assoc()) {
      $rowsData[] = $fetchData;
    }
    return $rowsData;
  }
}
