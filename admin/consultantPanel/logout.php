<?php
session_start();
//退出
$_SESSION['consultant'] = null;
header('location:login.php');