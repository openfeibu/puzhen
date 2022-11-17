
<!-- 轮播图 -->
<div class="min-banner">
    <img src="assets/pc/images/banner2.png" alt="">
</div>
<!-- 主体 -->
<div class="main">
    <!-- 列表 -->
    <?php if (!empty($detail)): ?>
    <div class="product-detail w1400 container">
        <div class="product-detail-top clearfix">
            <div class="pro-img fb-inline-block">
                <div class="swiper-container swiper-container-pro ">
                    <div class="swiper-wrapper">
                        <?php if (!empty($detail['image'])): foreach ($detail['image'] as $image): ?>
                        <div class="swiper-slide">
                            <a href="#"><img src="<?= $image['file_path'] ?>" width="100%"></a>
                        </div>
                        <?php endforeach; endif; ?>
                    </div>
                    <div class="swiper-pagination swiper-pagination-pro"></div>
                </div>
            </div>
            <div class="pro-test fb-inline-block">
                <div class="name"><?= $detail['goods_name'] ?></div>
                <div class="des"><?= $detail['selling_point'] ?></div>
                <div class="pro-test-line clearfix">
                    <div class="pro-money fl">
                        <?= lang('reference_retail_price') ?>：<span>￥<?= $detail['first_money'] ?></span>
                    </div>
                    <div class="pro-collection fr">
                        <p class="fl"> <?= $detail['is_collection']>0 ? lang('collected') : lang('add_to_collection')?></p>
                        <span class="fl">|</span>
                        <div class="pro-collection-icon fl"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-detail-bottom clearfix ">
            <div class="product-detail-right col-lg-3 col-md-3">
                <?php if(isset($detail['goods_tea_qrcode']['tea_qrcode']) && $detail['goods_tea_qrcode']['tea_qrcode']): ?>
                <div class="official-code">
                    <div class="con-title"><?= lang('official_qrcode') ?></div>
                    <div class="official-code-img"><img src="<?= $detail['goods_tea_qrcode']['tea_qrcode']['detail_image'] ?>" alt=""></div>
                </div>
                <?php endif; ?>
                <div class="recommended">
                    <div class="con-title"><?= lang('puzhen_recommend') ?></div>
                    <ul>
                        <?php if (!$recommend_list->isEmpty()): foreach ($recommend_list as $item): ?>
                        <li>
                            <a href="<?= url('goods/detail&goods_id='.$item['goods_id']) ?>">
                                <div class="img fb-inline-block"><img src="<?= $item['goods_image'] ?>" alt=""></div>
                                <div class="test fb-inline-block">
                                    <div class="name fb-overflow-1"><?= $item['goods_name'] ?></div>
                                    <div class="des fb-overflow-2"><?= $item['selling_point'] ?></div>
                                </div>
                            </a>
                        </li>
                        <?php endforeach; ?>

                        <?php endif; ?>
                    </ul>
                </div>

            </div>
            <div class="product-detail-con nopadding col-lg-9 col-md-9">
                <?= $detail['content'] ?>
            </div>

        </div>
    </div>
    <?php else: ?>
        <div class="nodata">
            <div class="test"><?= lang('nodata'); ?></div>
        </div>
    <?php endif; ?>
</div>


<script>
    $(function() {
        var mySwiper = new Swiper('.swiper-container-pro', {
            loop: true,
            autoplay: 6000,
            autoHeight: true,
            pagination: '.swiper-pagination-pro',
            paginationClickable :true
        })
        $(".pro-collection").on("click",function(){
            var that = $(this);
            var load = layer.load(2)
            $.ajax({
                url : "<?= url('collection/add','type=Goods')?>",
                data : {'id':'<?= $detail['goods_id'] ?>'},
                type : 'post',
                success : function (data) {
                    layer.close(load);
                    if(data.data.is_collection == 1)
                    {
                        that.find("p").text("<?= lang('collected') ?>");
                    }else{
                        that.find("p").text("<?= lang('add_to_collection') ?>");
                    }
                    layer.msg(data.msg);
                },
                error : function (jqXHR, textStatus, errorThrown) {
                    layer.close(load);
                    $.ajax_error(jqXHR, textStatus, errorThrown);
                }
            });

        })
    })
</script>