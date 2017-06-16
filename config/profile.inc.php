<?php
	//系统配置
	define('WEBNAME', '联创优学');
	define('PAGE_SIZE', 20);
	define('ARTICLE_SIZE', 5);
	define('NAV_SIZE', 8);
	define('UPDIR', '/upload/');

	//轮播器配置
	define('RO_TIME', 3);
	define('RO_NUM', 3);

	//广告服务
	define('ADVER_TEXT_NUM', 5);
	define('ADVER_PIC_NUM', 3);

	//不可修改的配置

	//数据库配置
	define('DB_HOST', 'qdm109666364.my3w.com');	//数据库主机
	define('DB_USER', 'qdm109666364');				//数据库用户名
	define('DB_PASS', 'renxinwei');			//数据库密码
	define('DB_NAME', 'qdm109666364_db');				//数据库
	define('DB_PORT', '3306');				//端口
	//系统配置
	define('GPC', get_magic_quotes_gpc());			//mysql转义功能是否已打开
	@define('PREV_URL', $_SERVER['HTTP_REFERER']);	//上页地址
//	define('MARK', ROOT_PATH.'/images/yc.png');		//水印图片
//	//模板配置信息
//	define('TPL_DIR', ROOT_PATH.'/templates/');		//模板目录
//	define('TPL_C_DIR', ROOT_PATH.'/templates_c/');	//编译目录
//	define('CACHE_DIR', ROOT_PATH.'/cache/');		//缓存目录

	//联系信息
	define('TEL', '053188822881');

	//网站目录
	define('WEB_PATH', 'http://192.168.1.100/uniteedu/lcyx/lcr');
	//图片目录
	define('IMG_PATH', WEB_PATH . '/images');
?>
