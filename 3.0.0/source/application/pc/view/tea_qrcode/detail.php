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
                        <div class="codeDetail-data-title"><?= lang('tea_qrcode_detail') ?></div>
                        <div class="codeDetail-data-con clearfix">
                            <?php foreach($detail['data']['temperature_arr'] as $k => $temperature): ?>
                                <div class="codeDetail-data-item fl">
                                    <?= lang('tea_qrcode_detail_list_show',[
                                            'sn' =>$k+1,
                                        'temperature' => $temperature,
                                        'seconds' => $detail['data']['seconds_arr'][$k] ?? '' ,
                                        'frequency_unit' => $teaConfig['frequency']['unit'] ,
                                        'temperature_unit' => $teaConfig['temperature']['unit'] ,
                                        'seconds_unit' => $teaConfig['seconds']['unit']])?>
                                </div>
                            <?php endforeach;?>

                        </div>
                    </div>
                    <?php if($editPermission):?>
                        <div class="codeDetail-btn">
                            <div class="codeDetail-updata fl"><a href="<?= url('tea_qrcode/edit','tea_qrcode_id='.$detail['tea_qrcode_id']);?>"><?= lang('edit'); ?></a></div>
                            <div class="codeDetail-detele fl"><?= lang('delete'); ?></div>
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