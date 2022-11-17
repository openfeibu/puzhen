
<!-- 轮播图 -->
<div class="min-banner">
    <img src="assets/pc/images/banner2.png" alt="">
</div>
<!-- 主体 -->
<div class="main">
    {{include file="user/header" /}}
    <!-- 列表 -->
    <div class="product-list w1400 container">
        {{include file="user/nav" /}}

        <div class="product-list-con w1400 clearfix">
            <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
            <div class="product-list-con-item  col-lg-3 col-md-3 col-sm-6 col-xs-6 ">

                <a href="#">
                    <div class="img"><img class="transition500" src="<?= $item['detail_image'] ?>" alt="<?= $item['name'] ?>"></div>
                    <div class="test">
                        <div class="test-bottom">
                            <div class="test-code clearfix">
                                <div class="test-code-l fl">
                                    <div class="n fb-overflow-1"><?= $item['name'] ?></div>
                                    <div class="c"><?= $item['data']['tea_name'] ?> · <?= $item['data']['weight'] ?><?= lang('g')?> · <?= $item['data']['number'] ?><?= lang('tea.number')?></div>
                                </div>
                                <div class="test-code-r fr"><?= lang('to_make_tea')?></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; else: ?>
                <div class="nodata">
                    <div class="test"><?= lang('nodata'); ?></div>
                </div>
            <?php endif; ?>
        </div>
        <div class="pagination-box">
            <?= $list->render() ?>
        </div>
    </div>
</div>
