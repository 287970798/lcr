<?php
session_start();
$_SESSION['apply_id'] = 3;
require dirname(__FILE__) . '/init.inc.php';
$apply_id = $_SESSION['apply_id'];

$pM = new PointModel();
$pM->owner_id = $apply_id;
$p = $pM->getPoint();
echo $p->unavailablePoint?:0;
