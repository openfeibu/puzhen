<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">编辑冲泡码</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 冲泡码方案名称 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="tea_qrcode[name]"
                                           placeholder="请输入门店名称" value="<?= $model['name'] ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">茶类 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?= $model['data']['tea_name'] ?>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 茶量 </label>

                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?= $model['data']['weight'] ?>克
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 泡数 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?= $model['data']['number'] ?>克
                                </div>
                            </div>
                            <?php foreach($model['data']['temperature_arr'] as $k => $temperature): ?>
                                <div class="am-form-group">

                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">第<?= $k+1; ?>泡 温度 </label>
                                    <div class="am-u-sm-3">
                                        <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                            <?= $temperature ?>°C
                                        </div>
                                    </div>

                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 秒数 </label>
                                    <div class="am-u-sm-3 am-u-end">
                                        <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                            <?php if(isset($model['data']['seconds_arr'][$k])):?>
                                            <?= $model['data']['seconds_arr'][$k] ?>秒
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                            <!--
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 选择产品 </label>
                                <div class="am-u-sm-9 am-u-md-6 am-u-lg-5 am-u-end">
                                    <div class="am-form-file am-margin-top-xs">
                                        <button type="button"
                                                class="j-selectGoods upload-file am-btn am-btn-secondary am-radius">
                                            <i class="am-icon-cloud-upload"></i> 选择产品
                                        </button>
                                        <div class="widget-goods-list uploader-list am-cf">
                                            <?php if(isset($model['goods_tea_qrcode']['goods'])):?>
                                            <div class="file-item">
                                                <a href="<?= $model['goods_tea_qrcode']['goods']['image'][0]['file']['file_path'] ?>"
                                                   title="点击查看大图" target="_blank">
                                                    <img src="<?= $model['goods_tea_qrcode']['goods']['image'][0]['file']['file_path'] ?>">
                                                </a>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            -->
                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                    <button type="submit" class="j-submit am-btn am-btn-secondary">提交
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 产品列表 -->
<script id="tpl-goods-list-item" type="text/template">
    {{ each $data }}
    <div class="file-item">
        <a href="{{ $value.image }}" title="{{ $value.goods_name }}" target="_blank">
            <img src="{{ $value.image }}">
        </a>
        <input type="hidden" name="active[goods_id]" value="{{ $value.goods_id }}">
    </div>
    {{ /each }}
</script>

<!-- 文件库弹窗 -->
{{include file="layouts/_template/file_library" /}}
<script src="assets/store/js/select.data.js?v=<?= $version ?>"></script>
<script>
    $(function () {

        // 选择产品
        var $goodsList = $('.widget-goods-list');
        $('.j-selectGoods').selectData({
            title: '选择产品',
            uri: 'goods/lists&factory_id=<?= $model['factory_id'] ?>',
            dataIndex: 'goods_id',
            done: function (data) {
                data = [data[0]];
                var $html = $(template('tpl-goods-list-item', data));
                $goodsList.html($html);
            }
        });

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();
    });
</script>
