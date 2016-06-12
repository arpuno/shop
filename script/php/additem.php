<?php
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/class/db.php');
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/class/catalog.php');

  $db = DB::connect();
  $cat = new Catalog($db);

  if ($_POST) {
    $cat -> addItem($_POST);
    $MSG = array('товар добавлен!', 0);
  }
?>