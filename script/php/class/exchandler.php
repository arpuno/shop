<?php
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/function.php');


  class ExceptionHandler {
    /* вывод и запись в файл */
    public static function defaultHandler($e) {
      echo((string)$e);
      writeLog((string)$e, '/temp/log');
    }

    /* запись в файл */
    public static function PDOExceptionHandler($e) {
      echo((string)$e);
      writeLog((string)$e, '/temp/log/db');
    }

    /* назначение обработчика */
    public static function main($e) {
      /* список назначений */
      $redirect = array(
        'PDOException' => 'PDOExceptionHandler'
      );

      /* назначение */
      if (isset($redirect[get_class($e)])) {
        call_user_func(array(get_class(), $redirect[get_class($e)]), $e);
      }
      else {
        self::defaultHandler($e);
      }
    }
  }

  //set_exception_handler(array('ExceptionHandler', 'main'));