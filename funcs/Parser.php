<?php

/** Класс для парсинга данных */
class Parser
{
  public $data;
  public $buildedArray;
  public $tableOuterHTML;
  public $tableCaption;

  /**
   * Конструктор объекта данных
   * @param array $data Данные для парсера
   * @return void
   */
  public function __construct($data)
  {
    $this->data = $data;
  }

  /**
   * Построить массив
   * @param string $keyName Ключи массива
   * @param string $keyValue Значения ключа
   * @return array Готовый массив
   */
  public function buildArray($keyName, $keyValue)
  {
    foreach ($this->data as $rowData) {
      $this->buildedArray[$rowData[$keyName]][] = $rowData[$keyValue];
    }
    return $this->buildedArray;
  }

  /**
   * Построить таблицу Bootstrap
   * @param string $tableCaption Заголовок таблицы (caption)
   * @return string HTML-код страницы
   */
  public function buildTable($tableCaption)
  {
    $recordCount = 1;
    ob_start();
    arsort($this->buildedArray);
    ?>
    <table class="table table-hover table-responsive">
      <caption><?= $tableCaption ?></caption>
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Портал</th>
          <th scope="col">Количество запросов</th>
        </tr>
      </thead>
      <tbody>
        <?php $messages = 0; ?>
        <?php foreach ($this->buildedArray as $baKey => $baArr): ?>
          <?php $messages += count($baArr); ?>
          <tr>
            <th scope="row"><?= $recordCount ?></th>
            <td><?= $baKey ?></td>
            <td><?= count($baArr) ?></td>
          </tr>
          <?php $recordCount++; ?>
        <?php endforeach; ?>

        <tr>
          <th scope="row" colspan="2">Итого</th>
          <td><?= $messages ?></td>
        </tr>
      </tbody>
    </table>
<?php
$this->tableOuterHTML = ob_get_contents();
ob_end_clean();
$this->tableCaption = $tableCaption;
return $this->tableOuterHTML;
  }
}
