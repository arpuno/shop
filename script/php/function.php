<?php
  /* запись логов */
  function writeLog($data, $path) {
    $path = realpath($_SERVER['DOCUMENT_ROOT']).$path;

    @mkdir($path, 0777, true);
    file_put_contents($path.'/'.date('Y-m-d H-i-s').'.log', $data);
  }

  /* случайные значения */
  function genRandom($len) {
    $set = '0123456789abcdef';
    $val = '';

    for ($c = 0; $c < $len; $c++) {
      $val .= $set[mt_rand(0, 15)];
    }

    return($val);
  }