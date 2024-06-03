<?php
	session_start();

	function pdo(): PDO {
			static $pdo;

			if (!$pdo) {
					$config = require __DIR__.'/config.php';
					$dsn = 'mysql:dbname='.$config['db_name'].';host='.$config['db_host'];
					$pdo = new PDO($dsn, $config['db_user'], $config['db_pass']);
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			return $pdo;
	}

	function flash($message) {
      $_SESSION['flash_message'] = $message;
  }

  function get_flash_message() {
      if (isset($_SESSION['flash_message'])) {
          $msg = $_SESSION['flash_message'];
          unset($_SESSION['flash_message']);
          return $msg;
      }
      return null;
  }
?>