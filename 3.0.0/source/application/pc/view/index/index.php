<!-- 轮播图 -->
<div class="banner">
    <div class="swiper-container swiper-container-banner-pc ">
        <div class="swiper-wrapper">
            <?php if(!empty($pcBannerList)): foreach($pcBannerList as $item): ?>
            <div class="swiper-slide">
                <a href="<?= $item['link'] ?: 'javascript:;'; ?>"><img src="<?= $item['image']['file_path'] ?? ''; ?>" width="100%"></a>
            </div>
            <?php endforeach; endif;?>
        </div>
        <div class="swiper-pagination swiper-pagination-banner swiper-pagination-banner-pc"></div>
    </div>
    <div class="swiper-container swiper-container-banner-h5">
        <div class="swiper-wrapper">
            <?php if(!empty($mobileBannerList)): foreach($mobileBannerList as $item): ?>
                <div class="swiper-slide">
                    <a href="<?= $item['link'] ?: 'javascript:;'; ?>"><img src="<?= $item['image']['file_path'] ?? ''; ?>" width="100%"></a>
                </div>
            <?php endforeach; endif;?>
        </div>
        <div class="swiper-pagination swiper-pagination-banner swiper-pagination-banner-h5"></div>
    </div>
</div>

<!-- 主体 -->
<div class="main">
    <!-- 八卦 -->
    <div class="bagua">
        <img src="assets/pc/images/bagua.png" alt="">
        <div class="bagua-test">
            <div class="bagua-diy">
                <div class="bagua-diy-title pull-left">
                    <p><a href="<?= url('tea_qrcode/add');?>"><?= lang('make_tea_way'); ?><br/>DIY</a></p>
                </div>
                <div class="bagua-diy-test pull-left">
                    <?= lang('home_text_1');?>
                    <a class="bagua-diy-more " href="#<?= url('tea_qrcode/add');?>">
                        <?= lang('learn_more'); ?>>
                    </a>
                </div>

            </div>
            <div class="bagua-tuijian">

                <div class="bagua-tuijian-test pull-left">
                    <?= lang('home_text_2');?>
                    <a class="bagua-tuijian-more " href="<?= url('goods/index');?>">
                        <?= lang('learn_more'); ?>>
                    </a>
                </div>
                <div class="bagua-tuijian-title pull-left">
                    <p><a href="<?= url('goods/index');?>"><?= lang('make_tea_way'); ?><br/><?= lang('recommend_abbr'); ?></a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- 产品中心 -->
    <div class="producCenter">
        <img class="hiddenh5" src="assets/pc/images/bg2.png" alt="">
        <img  class="hiddenpc" src="assets/pc/images/bg3.png" alt="">
        <div class="producCenter-test">
            <div class="producCenter-test-t">
                <?= lang('product_center'); ?>
            </div>
            <div class="producCenter-test-des">
                <?= lang('home_text_3');?>
            </div>
            <div class="producCenter-test-more">
                <a href="<?= url('goods/index'); ?>"><?= lang('search_more'); ?></a>
            </div>
        </div>

    </div>
    <!-- 关于我们 -->
    <div class="about">
        <div class="about-b">
            <div class="about-title">
                <img src="assets/pc/images/about.png" alt="" />
                <p><?= lang('about_puzhen'); ?></p>
            </div>
            <div class="about-company"><?= $setting['store']['values'][$prefix.'company'] ?: $setting['store']['values']['company'];?></div>
            <div class="clearfix"></div>
            <div class="about-des"><?= lang('home_text_4'); ?></div>
            <div class="about-more">
                <a href="#"><?= lang('learn_more'); ?></a>
            </div>
        </div>
    </div>
</div>


