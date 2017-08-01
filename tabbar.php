<?php
    $logA = new LogAction();
    $logA->pickPage();
?>
<div style="height: 58px;"></div>
<div class="weui-footer weui-footer_fixed-bottom" style="margin-bottom: -8px;">
    <div class="weui-tab">
        <div class="weui-tab__panel">
        </div>
        <div class="weui-tabbar">
            <a href="<?php echo WEB_PATH;?>/my.php" class="weui-tabbar__item <?php if ($nav == 'index') echo 'weui-bar__item_on';?>">
                <i class="fa fa-user-circle-o weui-tabbar__icon"></i>
                <p class="weui-tabbar__label">我的</p>
            </a>
            <a href="<?php echo WEB_PATH;?>/student/" class="weui-tabbar__item <?php if ($nav == 'student') echo 'weui-bar__item_on';?>">
                <i class="fa fa-graduation-cap weui-tabbar__icon"></i>
                <p class="weui-tabbar__label">学员</p>
            </a>
            <a href="/yxh" class="weui-tabbar__item <?php if ($nav == 'yxh') echo 'weui-bar__item_on';?>">
                <i class="fa fa-group weui-tabbar__icon"></i>
                <p class="weui-tabbar__label">优学汇</p>
            </a>
            <a href="<?php echo WEB_PATH;?>/point" class="weui-tabbar__item <?php if ($nav == 'point') echo 'weui-bar__item_on';?>">
                <i class="fa fa-hourglass-2 weui-tabbar__icon"></i>
                <p class="weui-tabbar__label">积分</p>
            </a>
            <a href="<?php echo WEB_PATH;?>/getSub" class="weui-tabbar__item <?php if ($nav == 'getSub') echo 'weui-bar__item_on';?>">
                <i class="fa fa-qrcode weui-tabbar__icon"></i>
                <p class="weui-tabbar__label">推广</p>
            </a>
            <!--
            <a href="<?php /*echo WEB_PATH;*/?>/getQrcode" class="weui-tabbar__item <?php /*if ($nav == 'qrcode') echo 'weui-bar__item_on';*/?>">
                <i class="fa fa-qrcode weui-tabbar__icon"></i>
                <p class="weui-tabbar__label">推广</p>
            </a>
            -->
        </div>
    </div>
</div>