<?php
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/class/db.php');
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/class/user.php');
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/class/keymanager.php');

  $SESSION_NAME = 'sid';

  session_name($SESSION_NAME);
  session_start();

  $db = DB::connect();

  /* вход */
  if (isset($_POST['login']) && !$_SESSION['login']) {
    $user = new User($db);
    $loginData = $user -> select($_POST['login']);

    /* проверка */
    if ($loginData) {
      if (password_verify($_POST['pass'], $loginData['pass'])) {
        /* сессия */
        $_SESSION['login'] = $loginData['login'];

        /* установка ключа редактирования */
        $keymgr = new KeyManager($db);
        setcookie('editkey', $keymgr -> setKey($loginData['login']), time() + 60*60*24, '/');
      }
      else {
        $MESSAGE = array('неверный пароль!', 1);
      }
    }
    else {
      $MESSAGE = array('неверный логин!', 1);
    }
  }

  /* выход */
  if (isset($_POST['logout']) && $_SESSION['login']) {
    (new KeyManager($db)) -> removeKey($_SESSION['login']);

    session_unset();
    session_destroy();
  }