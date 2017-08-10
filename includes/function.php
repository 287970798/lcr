<?php
/**
 * Author: Ren Date: 2017/8/7 0007 Time: 下午 2:43
 */
if (!function_exists('dump')) {
    function dump($data) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}