<?php
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/class/db.php');
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/class/catalog.php');

  /* сортировка */
  function getSort($mtd) {
    $sortList = array(
      'title'  => array('tl' => 'tld'),
      'genre'  => array('gr' => 'grd'),
      'cond'   => array('cd' => 'cdd'),
      'price'  => array('pr' => 'prd'),
      'amount' => array('am' => 'amd')
    );

    $sort = array();
      foreach ($sortList as $k => $v) {
        foreach ($v as $k2 => $v2) {
          $v[$k2] = array($v2, '&uarr;');
          $v[$v2] = array($k2, '&darr;');

          $sort[$k] = isset($v[$mtd]) ? $v[$mtd] : array($k2, '');
        }
      }

    return($sort);
  }

  /* навигация */
  function getNav($page, $bnd) {
    $ofs = 2;
    $page = ($page >= 1 && $page <= $bnd) ? $page : $bnd;

    if ($page - $ofs < 1) {
      $beg = 1;
      $end = (2*$ofs + 1 > $bnd) ? $bnd : 2*$ofs + 1;
    }
    else
    if ($page + $ofs > $bnd) {
      $beg = ($bnd - 2*$ofs < 1) ? 1 : $bnd - 2*$ofs;
      $end = $bnd;
    }
    else {
      $beg = $page - $ofs;
      $end = $page + $ofs;
    }

    $nav = array();
      $nav[] = array('&laquo;', 1, false);

      for ($i = $beg; $i <= $end; $i++) {
        $nav[] = array($i, $i, ($i == $page) ? true : false);
      }

      $nav[] = array('&raquo;', $bnd, false);

    return($nav);
  }

  $defSort  = 'tl';
  $defLimit = 10;

  $sortList = array(
    'tl' => 'title',
    'gr' => 'genre',
    'cd' => 'cond',
    'pr' => 'price',
    'am' => 'amount'
  );

  /* tl title true, tld title false, etc */
  foreach ($sortList as $k => $v) {
    $sortList[$k]     = array($v, false);
    $sortList[$k.'d'] = array($v, true);
  }

  /* валидация */
  $page = is_numeric($_GET['n']) ? $_GET['n'] : 1;
  $sort = isset($sortList[$_GET['s']]) ? $_GET['s']: $defSort;

  $db = DB::connect();

  $cat = new Catalog($db);
  $bnd = ceil($cat -> getCount() / $defLimit) ?: 1;

  $data = array(
    'sort' => getSort($sort),
    'nav'  => getNav($page, $bnd),
    'cat'  => $cat -> getAll($page, $defLimit, $sortList[$sort][0], $sortList[$sort][1])
  );