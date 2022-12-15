<div class="product-list-con w1400 clearfix">
    <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
    <div class="product-list-con-item  col-lg-3 col-md-3 col-sm-6 col-xs-6 ">
        <a href="<?= url('goods/detail&goods_id='.$item['goods_id']) ?>">
            <div class="img ">
				<div class="imgPic transition500" style="background:url(<?= $item[$prefix.'goods_image'] ?: $item['goods_image'] ?>) no-repeat center/cover"></div>
				<img  src="assets/pc/images/proBg.png" alt="">
			</div>
            <div class="test">
                <div class="test-title">
                    <div class="name fb-overflow-1"><?= $item[$prefix.'goods_name'] ?: $item['goods_name']; ?></div>
                    <div class="collection <?= $item['is_collection']>0 ? "active" : ''?>" ></div>

                </div>
                <div class="test-des fb-overflow-2">
                    <?= $item[$prefix.'selling_point'] ?: $item['selling_point']; ?>
                </div>
                <div class="test-bottom">
                    <?php if(isset($item['goods_tea_qrcode']['tea_qrcode']) && $item['goods_tea_qrcode']['tea_qrcode']): ?>

                    <div class="test-code clearfix">
                        <div class="test-code-l ">
                            <div class="n fb-overflow-1"><?= $item['goods_tea_qrcode']['tea_qrcode'][$prefix.'name'] ?: $item['goods_tea_qrcode']['tea_qrcode']['name'] ?></div>
                            <div class="c fb-overflow-1">
                                <?= $item['goods_tea_qrcode']['tea_qrcode']['data'][$prefix.'tea_name'] ?: $item['goods_tea_qrcode']['tea_qrcode']['data']['tea_name'] ?> · <?= $item['goods_tea_qrcode']['tea_qrcode']['data']['weight'] ?><?= lang('g')?> · <?= $item['goods_tea_qrcode']['tea_qrcode']['data']['number'] ?><?= lang('tea.times')?></div>
                        </div>
                        <div class="test-code-r "><?= lang('to_make_tea')?></div>
                    </div>
                    <?php else: ?>
                    <div class="test-more">
                        <div class="test-more-btn">
                        <?= lang('learn_more') ?>
                        </div>
                    </div>
                    <?php endif; ?>
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
