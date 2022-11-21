<!-- 头部 -->
<header class="navbar-fixed-top  fadeInUp animated" data-wow-duration=".6s" data-wow-delay=".3s">
    <div class="headerBg transition500">
        <div class="container w1400">
            <div class="logo ">
                <a href="<?= $base_url ?? url('') ?>">
                    <h1 hidden=""><?= $setting['store']['values'][$prefix.'company'] ?: $setting['store']['values']['company'];?></h1>
                    <img  src="assets/pc/images/logo.png" alt="<?= $setting['store']['values'][$prefix.'company'] ?: $setting['store']['values']['company'];?>" class="block">
                </a>
            </div>
            <div class="headerLeft pull-left">
                <div class="lang pull-left">
                    <div class="lang-con">
                        <?= $think_lang =='zh-cn' ? '中文':'English'?><span class="caret"></span>
                    </div>
                    <dl>
                        <dd class="active"><a href="<?= url('index/index&lang=zh-cn')?>">中文</a></dd>
                        <dd><a href="<?= url('index/index&lang=en-us')?>">English</a></dd>
                    </dl>

                </div>
                <div class="home-btn pull-left">
                    <a href="<?= $base_url ?? url('') ?>"><?= lang('home') ?></a>
                </div>
            </div>

            <div class="nav">
                <ul>
                    <?php if(!empty($navList)): foreach ($navList as $key => $item): ?>
                    <li <?php if(request()->pathinfo() == 'pc/'.$item['url']): ?> class="active" <?php endif;?> >
                        <a href="<?= $pc_url.'/'.$item['url'] ?>"><?= $item[$prefix.'name'] ?: $item['name'] ?></a>

                    </li>
                    <?php if($key==1):?>
                    <li></li>
                    <?php endif;?>
                    <?php endforeach; endif;?>

                </ul>
            </div>
            <div class="headerRight pull-right">
                <div class="login-b pull-left">
                    <?php if(isset($pc['is_login']) && $pc['is_login']):?>
                        <a href="<?= url('user/index') ?>"><?= $pc['user']['nickName']?></a>
                    <?php else:?>
                    <a href="<?= url('passport/login') ?>"><?= lang('login') ?></a>
                    <?php endif;?>
                </div>
                <div class="headerRight-line pull-left hiddenh5">

                </div>
                <!--
                <div class="login-b pull-left hiddenh5">
                    <a href="<?= url('/factory') ?>" target="_blank">厂家登录</a>
                </div>
                <div class="headerRight-line pull-left hiddenh5">

                </div>
                -->
                <div class="search-b pull-left hiddenh5 fixed-nav-item-search">

                </div>
                <div class="menu pull-left"></div>
            </div>

            <!-- <div class="menu"></div> -->

        </div>
    </div>
</header>