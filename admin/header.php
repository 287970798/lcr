<?php $acls = 'active';?>
<header>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#example-navbar-collapse">
                    <span class="sr-only">切换导航</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="#" class="navbar-brand logo">
                    <img src="<?php echo IMG_PATH;?>/lcr-logo.png" width="60" alt="联创优学">
                </a>
                <a class="navbar-brand" href="#">管理系统 <span class="badge">v1.0</span></a>
            </div>
            <div class="collapse navbar-collapse lcr-nav" id="example-navbar-collapse">
                <ul class="nav navbar-nav" style="float: none;">
                    <li class="dropdown <?php if (@$nav == '联创人') echo $acls;?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-home"></span> 联创人 <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo WEB_PATH?>/admin">申请列表</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo WEB_PATH?>/admin/apply/copy.php">复制</a></li>
                        </ul>
                    </li>
                    <li class="dropdown <?php if (@$nav == '招生管理') echo $acls;?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-education"></span> 招生管理 <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo WEB_PATH?>/admin/student">全部学员</a></li>
                            <li><a href="<?php echo WEB_PATH?>/admin/student/add.php">新增学员</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo WEB_PATH?>/admin/project">全部项目</a></li>
                            <li><a href="<?php echo WEB_PATH?>/admin/project/add.php">新增项目</a></li>
                            <li><a href="<?php echo WEB_PATH?>/admin/student/copy.php">复制</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo WEB_PATH?>/admin/consultant">优学顾问</a></li>
                            <li><a href="<?php echo WEB_PATH?>/admin/consultant/add.php">新增顾问</a></li>
                        </ul>
                    </li>
                    <li class="<?php if (@$nav == '管理员') echo $acls;?>"><a href="#"><span class="glyphicon glyphicon-user"></span> 管理员</a></li>
                    <li class="dropdown <?php if (@$nav == '系统') echo $acls;?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-cog"></span> 系统 <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#">系统设置</a></li>
                            <li><a href="#">二维码设置</a></li>
                            <li><a href="#">其它设置</a></li>
                            <li class="divider"></li>
                            <li><a href="#">帮助</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo WEB_PATH?>/admin/logout.php" onclick="javascript:return confirm('确定要退出管理系统吗？') ? true : false;"><span class="glyphicon glyphicon-off"></span> 退出</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>