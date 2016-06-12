<?php
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/class/exchandler.php');

  class Catalog {
    private static $navOffset = 2;

    private $allowEdit = array(
      'title',
      'artist',
      'year',
      'genre',
      'cond',
      'price',
      'amount'
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
           плейсхолдеры  ?,      ?,      ?    */

        return(array(
          '`'.implode('`, `', array_keys($data)).'`',
          '?'.str_repeat(', ?', count($data) - 1)
        ));
      }
      else
      if ($queryType == 'update') {
        /* поля и плейсхолдеры `pass`=:pass, `type`=:type, etc */
        $format = '';
          for ($c = 0; $c < count($data); $c++) {
            $pair    = each($data);
            $format .= ($c > 0 ? ', ' : '')."`$pair[0]`=?";
          }

        return($format);
      }
    }

    public function getItem($id) {
      try {
        $query = $this -> db -> prepare("SELECT * FROM `catalog` WHERE id=?");
        $query -> execute(array($id));
      }
      catch(PDOException $e) {
        ExceptionHandler::main($e);
      }

      return($query -> fetch());
    }

    public function getAll($page, $lim, $order, $desc = false) {
      /* TODO сейчас только общий список, в дальнейшем выборки по категориям */
      $bnd  = ceil($this -> getCount() / $lim) ?: 1;
      $page = ($page >= 1 && $page <= $bnd) ? $page : $bnd;

      /* каталог */
      $ofs  = $lim*($page - 1);
      $desc = ($desc) ? 'DESC' : '';

      try {
        $query = $this -> db -> query("SELECT * FROM `catalog` ORDER BY `$order` $desc LIMIT $ofs, $lim");
      }
      catch(PDOException $e) {
        ExceptionHandler::main($e);
      }

      /* возврат каталога */
      return($query -> fetchAll());
    }

    public function getCount() {
      try {
        $query = $this -> db -> query("SELECT COUNT(*) FROM `catalog`");
      }
      catch(PDOException $e) {
        ExceptionHandler::main($e);
      }

      return($query -> fetch(PDO::FETCH_NUM)[0]);
    }

    public function addItem($data) {
      $this -> checkData($data);
      $formatData = $this -> formatData($data, 'insert');

      try {
        $query = $this -> db -> prepare("INSERT INTO `catalog` ($formatData[0]) VALUES ($formatData[1])");
        $query -> execute(array_values($data));
      }
      catch (PDOException $e) {
        ExceptionHandler::main($e);
      }
    }

    public function editItem($id, $data) {
      if ($this -> getItem($id)) {
        $this -> checkData($data);
        $formatData = $this -> formatData($data, 'update');

        try {
          $query = $this -> db -> prepare("UPDATE `catalog` SET $formatData WHERE `id`=?");
          $query -> execute(array_merge(array_values($data), array($id)));
        }
        catch(PDOException $e) {
          ExceptionHandler::main($e);
        }

        return(true);
      }
      else {
        return(false);
      }
    }

    public function removeItem($id) {
      if ($this -> getItem($id)) {
        try {
          $query = $this -> db -> prepare("DELETE FROM `catalog` WHERE `id`=?");
          $query -> execute(array($id));
        }
        catch(PDOException $e) {
          ExceptionHandler::main($e);
        }

        return(true);
      }
      else {
        return(false);
      }
    }
  }