<?php
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/class/exchandler.php');

  class DB {
   
    public static $dbhost = 'localhost';
    public static $dbname = 'arpunoxy_shop';
    public static $dbuser = 'arpunoxy_admin';
    public static $dbpass = 'fq;+N^![$MVg';

    public static $option  = array(
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );

    public static $pdoInstance;

    /* класс-одиночка */
    private function __construct() {
    }
    private function __clone() {
    }
    private function __wakeup() {
    }

    public static function connect() {
      if (empty(self::$pdoInstance)) {
        try {
          self::$pdoInstance = new PDO('mysql:host='.self::$dbhost.';dbname='.self::$dbname.';charset=utf8',
            self::$dbuser, self::$dbpass, self::$option);
        }
        catch (PDOException $e) {
          ExceptionHandler::main($e);
        }
      }

      return(self::$pdoInstance);
    }
  }
