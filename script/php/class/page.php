<?php
  class Page {
    private $pageList = array(
      'catalog' => array(
        'auth'    => false,
        'php'     => array('/script/php/catalog.php'),
        'css'     => array('/style/css/catalog.css'),
        'js'      => array('/script/js/catalog.js'),
        'cont'    => array('/page/catalog.php')
      ),
      'add-item' => array(
        'auth'    => true,
        'php'     => array('/script/php/additem.php'),
        'css'     => array('/style/css/additem.css'),
        'js'      => array('/script/js/additem.js'),
        'cont'    => array('/page/additem.php')
      )
    );

    private static $defPage = 'catalog';
    private $page;

    public function __construct($page) {
      if (isset($this -> pageList[$page])) {
        if (!$this -> pageList[$page]['auth'] || $_SESSION['login']) {
          $this -> page = $page;
        }
        else {
          $this -> page = self::$defPage;
        }
      }
      else {
        $this -> page = self::$defPage;
      }
    }

    public function getPHP() {
      return($this -> pageList[$this -> page]['php']);
    }

    public function getCSS() {
      return($this -> pageList[$this -> page]['css']);
    }

    public function getJS() {
      return($this -> pageList[$this -> page]['js']);
    }

    public function getCont() {
      return($this -> pageList[$this -> page]['cont']);
    }
  }