<?php
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/class/exchandler.php');
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/class/exchandler.php');
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/class/db.php');
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/class/page.php');

  set_exception_handler(array('ExceptionHandler', 'main'));

  /* системные сообщения */
  $MSG;

  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/function.php');
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/deployer.php');

  /* авторизация */
  require_once(realpath($_SERVER['DOCUMENT_ROOT']).'/script/php/auth.php');

  $PAGE = new Page($_GET['p']);

  /* подключение php-скриптов */
  foreach ($PAGE -> getPHP() as $v) {
    require_once(realpath($_SERVER['DOCUMENT_ROOT']).$v);
  }
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Магазин Винила</title>
<link href='https://fonts.googleapis.com/css?family=Raleway:400,100|Roboto:300&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
 <link rel="stylesheet" href="/style/css/reset.css">
    <link rel="stylesheet" href="/style/css/main.css">
<?php foreach ($PAGE -> getCSS() as $v) { /* подключение стилей */ ?>
    <link rel="stylesheet" href="<?= $v; ?>">
<?php } ?>
    <script src="/script/js/jquery.js"></script>
    <script src="/script/js/cookie.js"></script>
    <script src="/script/js/main.js"></script>
<?php foreach ($PAGE -> getJS() as $v) { /* подключение js-скриптов */ ?>
    <script src="<?= $v; ?>"></script>
<?php } ?>

<?php if ($MSG): /* вывод сообщений  I'm trying*/ ?>
    <script>$(function() { showMessage('<?= $MSG[0]; ?>', <?= $MSG[1]; ?>); });</script>
<?php endif; ?>
  </head>
  <body>
    <div class="message" id="message"></div>
    <div class="canvas">
      <div class="canvas-wrap">
        <div class="user-bar">
          <span class="ub-nav-panel">
            <a class="ub-text-button ub-font" href="/?p=catalog">каталог</a>

          </span>
          <span class="ub-login-panel">
<?php if (!$_SESSION['login']): /* логин-меню */ ?>
            <span id="lg-short">
              <span class="ub-font ub-text-button" id="lg-show">вход</span>
            </span>
            <span id="lg-full">
              <form id="lg-form" method="post">
                <input type="text" class="ub-font ub-input" name="login" placeholder="логин">
                <input type="password" class="ub-font ub-input" name="pass" placeholder="пароль">

                <span class="ub-font ub-button" id="lg-submit">вход</span>
              </form>
            </span>
<?php else: ?>
            <form id="lg-form" method="post">
              <span class="ub-font ub-text">
                Добро пожаловать, <span id="ub-user-name"><?= $_SESSION['login']; ?></span>
              </span>

              <input type="hidden" name="logout">
              <span class="ub-font ub-button" id="lg-submit">выход</span>
            </form>
<?php endif; ?>
          </span>
        </div>

        <div class="logo-wrap">
          <span class="logo-text">Vinyl Shop</span>
        </div>


<?php
  foreach ($PAGE -> getCont() as $v) { /* подключение контента */
    require_once(realpath($_SERVER['DOCUMENT_ROOT']).$v);
  }
?>

        <div class="footer">
          <div class="ft-bar">
            <span class="ft-bar-text">
              &copy; 1990-2016 Record Trade Inc.<br>
              &copy; 2016 A.Potapov. Все права защищены.

            </span>

          </div>
        </div>
      </div>
    </div>
  </body>
</html>