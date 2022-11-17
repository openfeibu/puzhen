<div class="user-info w1400 container clearfix">
    <div class="user-info-left">
        <div class="img"><img src="<?= $user['avatarUrl'] ?>" alt="" /></div>
        <div class="text">
            <div class="name"><?= $user['nickName'] ?></div>
            <div class="con">
                <?= lang('tea_qrcode') ?>：<span><?= $teaQrCodeCount ?></span>
                <?= lang('collection') ?>：<span><?= $collectionCount ?></span>
            </div>
        </div>
    </div>
    <div class="user-set fr">
        <a href="<?= url('user/detail') ?>">
            <p class="fl"><?= lang('setting') ?></p>
            <span class="fl">|</span>
            <div class="user-set-icon fl"></div>
        </a>
    </div>
</div>