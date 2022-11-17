<!-- 轮播图 -->
<div class="min-banner">
    <img src="assets/pc/images/banner2.png" alt="">
</div>
<!-- 主体 -->
<div class="main">
    <!-- 列表 -->
    <div class="codeDetail-detail w1400 container">
        <?php if($detail):?>
            <div class="codeDetail-detail-top clearfix">
                <div class="codeDetail-img fb-inline-block">
                    <img src="<?= $detail['detail_image']; ?>" width="100%">
                </div>
                <div class="codeDetail-test fb-inline-block">
                    <div class="name"><?= $detail['name']; ?></div>
                    <div class="des"><?= $detail['data']['tea_name'] ?> · <?= $detail['data']['weight'] ?><?= lang('g')?> · <?= $detail['data']['number'] ?><?= lang('tea.number')?></div>
                    <div class="codeDetail-data">
                        <div class="codeDetail-data-title">详细方案</div>
                        <div class="codeDetail-data-con clearfix">
                            <?php foreach($detail['data']['temperature_arr'] as $k => $temperature): ?>
                                <div class="codeDetail-data-item fl">第<?= $k+1; ?>泡：温度<?= $temperature ?>度3秒
                                    ，时间<?= $detail['data']['seconds_arr'][$k] ?>秒；
                                </div>

                            <?php endforeach;?>
                            <div class="codeDetail-data-item fl">第1泡：温度92度，时间3秒；</div>
                            <div class="codeDetail-data-item fl">第2泡：温度92度，时间3秒；</div>
                            <div class="codeDetail-data-item fl">第3泡：温度92度，时间3秒；</div>
                            <div class="codeDetail-data-item fl">第4泡：温度92度，时间3秒；</div>
                            <div class="codeDetail-data-item fl">第5泡：温度92度，时间3秒；</div>
                            <div class="codeDetail-data-item fl">第6泡：温度92度，时间3秒；</div>
                            <div class="codeDetail-data-item fl">第7泡：温度92度，时间3秒；</div>
                            <div class="codeDetail-data-item fl">第8泡：温度92度，时间3秒；</div>
                            <div class="codeDetail-data-item fl">第9泡：温度92度，时间3秒；</div>
                        </div>
                    </div>
                    <?php if($editPermission):?>
                        <div class="codeDetail-btn">
                            <div class="codeDetail-updata fl"><a href="<?= url('tea_qrcode/edit','tea_qrcode_id='.$detail['tea_qrcode_id']);?>">修改</a></div>
                            <div class="codeDetail-detele fl">删除</div>
                        </div>
                    <?php endif;?>
                </div>
            </div>
        <?php else: ?>
            <div class="nodata">
                <div class="test"><?= lang('nodata'); ?></div>
            </div>
        <?php endif; ?>
    </div>

</div>
<script>
    $(function() {

        $(".codeDetail-detele").on("click",function(){

            fb_alert("删除")
        })
    })
</script>