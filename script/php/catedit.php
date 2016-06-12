<?php
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/class/db.php');
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/class/catalog.php');
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/class/keymanager.php');

  header("Content-Type: application/json; charset=UTF-8");

  $db = DB::connect();

  if ((new KeyManager($db)) -> checkKey($_GET['k'])) {
    $cat = new Catalog($db);

    if ($_GET['m'] == 'edit') {
      $cat -> editItem($_GET['id'], $_GET);
      $resp = array('товар отредактирован!', 0, 0);
    }
    else
    if ($_GET['m'] == 'remove') {
      $cat -> removeItem($_GET['id']);
      $resp = array('товар удалён!', 0, 1);
    }
  }
  else {
    $resp = array('ошибка доступа!', 1, 2);
  }

  echo(json_encode($resp));