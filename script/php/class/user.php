<?php
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/class/exchandler.php');

  class User {
    private $allowEdit = array(
      'pass'
    );

    private $db;

    public function __construct($db) {
      $this -> db = $db;
    }

    /* проверка данных */
    private function checkData(&$data) {
      $data = array_intersect_key($data, array_flip($this -> allowEdit));
    }

    /* форматирование данных */
    private function formatData ($data, $queryType) {
      if ($queryType == 'insert') {
        /* поля         `pass`, `type`, `etc`
           плейсхолдеры  ?,      ?,           */

        return(array(
          '`'.implode('`, `', array_keys($data)).'`',
          '?'.str_repeat(', ?', count($data) - 1)
        ));
      }
      else
      if ($queryType == 'update') {
        /* поля и плейсхолдеры `pass`=:?, `type`=:?, etc */
        $format = '';
          for ($c = 0; $c < count($data); $c++) {
            $pair    = each($data);
            $format .= ($c > 0 ? ', ' : '')."`$pair[0]`=?";
          }

        return($format);
      }
    }

    /* выбор (используется для проверки при добавлении/изменении/удалении) */
    public function select($login) {
      try {
        $query = $this -> db -> prepare("SELECT * FROM `users` WHERE `login`=?");
        $query -> execute(array($login));
      }
      catch (PDOException $e) {
        ExceptionHandler::main($e);
      }

      return($query -> fetch());
    }

    /* добавление */
    public function add($login, $data) {
      if (!$this -> select($login)) {
        $this -> checkData($data);
        $formatData = $this -> formatData($data, 'insert');

        try {
          $query = $this -> db -> prepare("INSERT INTO `users` (`login`, $formatData[0]) VALUES (?, $formatData[1])");
          $query -> execute(array_merge(array($login), array_values($data)));
        }
        catch (PDOException $e) {
          ExceptionHandler::main($e);
        }

        return(true);
      }
      else {
        return(false);
      }
    }

    /* обновление данных */
    public function edit($login, $data) {
      if ($this -> select($login)) {
        $this -> checkData($data);
        $formatData = $this -> formatData($data, 'update');

        try {
          $query = $this -> db -> prepare("UPDATE `users` SET $formatData WHERE (`login`=?)");
          $query -> execute(array_merge(array_values($data), array($login)));
        }
        catch (PDOException $e) {
          ExceptionHandler::main($e);
        }

        return(true);
      }
      else {
        return(false);
      }
    }

    /* удаление */
    public function remove($login) {
      if ($this -> select($login)) {
        try {
          $query = $this -> db -> prepare("DELETE FROM `users` WHERE `login`=?");
          $query -> execute(array($login));
        }
        catch (PDOException $e) {
          ExceptionHandler::main($e);
        }

        return(true);
      }
      else {
        return(false);
      }
    }
  }