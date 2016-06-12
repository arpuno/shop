<?php
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/function.php');
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/class/exchandler.php');
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/class/db.php');

  class KeyManager {
    private $db;

    public function __construct($db) {
      $this -> db = $db;
    }

    /* добавление */
    public function setKey($user) {
      /* удаление предыдущего (при истечении сессии) */
      $this -> removeKey($user);

      $key = genRandom(20);

      try {
        $query = $this -> db -> prepare("INSERT INTO `edit_keys` (`user`, `key`, `date`) VALUES (?, ?, NOW())");
        $query -> execute(array($user, $key));
      }
      catch (PDOException $e) {
        ExceptionHandler::main($e);
      }

      return($key);
    }

    /* проверка */
    public function checkKey($key) {
      try {
        $query = $this -> db -> prepare("SELECT * FROM `edit_keys` WHERE `key`=?");
        $query -> execute(array($key));
      }
      catch (PDOException $e) {
        ExceptionHandler::main($e);
      }

      if ($data = $query -> fetch()) {
        if ((new DateTime()) -> getTimestamp() - (new DateTime($data['date'])) -> getTimestamp() > 60*60*24) {

          return(0);
        }
        else {

          return(1);
        }
      }
      else {

        return(2);
      }
    }

    /* удаление */
    public function removeKey($user) {
      try {
        $query = $this -> db -> prepare("DELETE FROM `edit_keys` WHERE `user` = ?");
        $query -> execute(array($user));
      }
      catch (PDOException $e) {
        ExceptionHandler::main($e);
      }

      if ($query -> rowCount()) {
        return(true);
      }
      else {
        return(false);
      }
    }
  }