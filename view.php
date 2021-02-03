<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Статистика по Уведомляшке</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="../bootstrap-4.5.2-dist/css/nicedo.css">

  <!-- Пользовательский CSS -->
  <style>
    /* Кастомизация Bootstrap */
    .container {
      max-width: 99vw;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="row mt-4">
      <div class="col">
        <?= $tableCurrent ?>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col">
        <?= $table ?>
      </div>
    </div>
  </div>
</body>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="../bootstrap-4.5.2-dist/js/jquery-3.5.1.min.js"></script>
<script src="../bootstrap-4.5.2-dist/js/popper.min.js"></script>
<script src="../bootstrap-4.5.2-dist/js/bootstrap.min.js"></script>

</html>