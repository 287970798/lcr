<?php
/*
 * png()方法，
 * 其中参数$text表示生成二位的的信息文本；
 * 参数$outfile表示是否输出二维码图片 文件，默认否；
 *
 * 参数$level表示容错率，也就是有被覆盖的区域还能识别，
 * 分别是 L（QR_ECLEVEL_L，7%），M（QR_ECLEVEL_M，15%），Q（QR_ECLEVEL_Q，25%），H（QR_ECLEVEL_H，30%）；
 *
 * 参数$size表示生成图片大小，默认是3；
 *
 * 参数$margin表示二维码周围边框空白区域间距值；参数$saveandprint表示是否保存二维码并 显示
 *
 * png($text, $outfile=false, $level=QR_ECLEVEL_L, $size=3, $margin=4,
$saveandprint=false)
 *
 * */
include 'includes/phpqrcode.php';
$str = 'http://uniteedu.cn/lcyx/lcr/apply/?pid='.$_GET['id'];
QRcode::png($str, false, 'L', 5);