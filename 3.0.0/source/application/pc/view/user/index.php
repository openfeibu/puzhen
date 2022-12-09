
<!-- 轮播图 -->
{{include file="layouts/banner" /}}
<!-- 主体 -->
<div class="main">
    {{include file="user/header" /}}
    <!-- 列表 -->
    <div class="product-list w1400 container">
        {{include file="user/nav" /}}

        <div class="product-list-con w1400 clearfix">
            <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
            <div class="product-list-con-item  col-lg-3 col-md-3 col-sm-6 col-xs-6 ">

                <a href="<?= url('tea_qrcode/detail','tea_qrcode_id='.$item['tea_qrcode_id']);?>">
                    <div class="img"><img class="transition500" src="<?= $item[$prefix.'detail_image'] ? $item[$prefix.'detail_image'] : ($item['detail_image'] ?: $item['en_detail_image']); ?>" ></div>
                    <div class="test">
                        <div class="test-bottom">
                            <div class="test-code clearfix">
                                <div class="test-code-l fl">
                                    <div class="n fb-overflow-1"><?= $item[$prefix.'name'] ? $item[$prefix.'name'] : ($item['name'] ?: $item['en_name']); ?></div>
                                    <div class="c"><?= $item['data'][$prefix.'tea_name'] ?: $item['data']['tea_name']; ?> · <?= $item['data']['weight'] ?><?= lang('g')?> · <?= $item['data']['number'] ?><?= lang('tea.times')?></div>
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
