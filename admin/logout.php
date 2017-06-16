<?php
session_start();
unset($_SESSION['admin']);
require substr(dirname(__FILE__), 0, -6).'/init.inc.php';
Tool::alertLocation('退出成功！', 'login.php');
