<?php
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/class/exchandler.php');
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/class/db.php');
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/class/user.php');

  function deployer() {
    global $MSG;

    $startAccount = array(
      'login' => 'admin',
      'data'  => array(
        'pass' => password_hash('rockstar', PASSWORD_BCRYPT)
      )
    );

    $db = DB::connect();

    if (!$db -> query("SHOW TABLES") -> fetch()) {
      try {
        $db -> exec("CREATE TABLE `users` (
          `id`     INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          `login`  VARCHAR(20) NOT NULL,
          `pass`   VARCHAR(60) NOT NULL
        )");

        $db -> exec("CREATE TABLE `edit_keys` (
          `id`     INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          `user`   VARCHAR(20) NOT NULL,
          `key`    VARCHAR(20) NOT NULL,
          `date`   DATETIME
        )");

        $db -> exec("CREATE TABLE `catalog` (
          `id`     INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          `title`  VARCHAR(100),
          `artist` VARCHAR(100),
          `year`   INT(4),
          `genre`  VARCHAR(20),
          `cond`   VARCHAR(20),
          `price`  INT(8) UNSIGNED,
          `amount` INT(8) UNSIGNED
        )");
      }
      catch (PDOException $e) {
        ExceptionHandler::main($e);
      }

      $user = new User($db);
      $user -> add($startAccount['login'], $startAccount['data']);

      $MSG = array('таблицы развёрнуты!', 0);
    }
  }
  deployer();