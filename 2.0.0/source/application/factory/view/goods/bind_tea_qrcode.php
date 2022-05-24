<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">绑定冲泡码</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 冲泡码 </label>
                                <div class="am-u-sm-9 am-u-md-6 am-u-lg-5 am-u-end">
                                    <div class="am-form-file am-margin-top-xs">
                                        <button type="button"
                                                class="j-selectGoods upload-file am-btn am-btn-secondary am-radius">
                                            <i class="am-icon-cloud-upload"></i> 选择冲泡码
                                        </button>
                                        <div class="widget-tea_qrcode-list uploader-list am-cf">
                                            <?php if(isset($goods['goods_tea_qrcode']['tea_qrcode'])):?>
                                            <div class="file-item">
                                                <a href="<?= $goods['goods_tea_qrcode']['tea_qrcode']['detail_image_url'] ?>" title="<?= $goods['goods_tea_qrcode']['tea_qrcode']['name'] ?>" target="_blank">
                                                    <img src="<?= $goods['goods_tea_qrcode']['tea_qrcode']['detail_image_url'] ?>" class="tea_qrcode_image">
                                                </a>
                                                <input type="hidden" name="tea_qrcode[tea_qrcode_id]" value="<?= $goods['goods_tea_qrcode']['tea_qrcode']['tea_qrcode_id'] ?>">
                                            </div>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 产品 </label>
                                <div class="am-u-sm-9 am-u-md-6 am-u-lg-5 am-u-end">
                                    <div class="am-form-file am-margin-top-xs">
                                        <div class="widget-goods-list uploader-list am-cf">
                                            <div class="file-item">
                                                <a href="<?= $goods['goods_image'] ?>" title="<?= $goods['goods_name'] ?>" target="_blank">
                                                    <img src="<?= $goods['goods_image'] ?>">
                                                </a>
                                                <input type="hidden" name="tea_qrcode[goods_id]" value="<?= $goods['goods_id'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

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


<!-- 冲泡码列表 -->
<script id="tpl-tea_qrcode-list-item" type="text/template">
    {{ each $data }}
    <div class="file-item">
        <a href="{{ $value.detail_image_url }}" title="{{ $value.name }}" target="_blank">
            <img src="{{ $value.detail_image_url }}" class="tea_qrcode_image">
        </a>
        <input type="hidden" name="tea_qrcode[tea_qrcode_id]" value="{{ $value.tea_qrcode_id }}">
    </div>
    {{ /each }}
</script>

<script src="assets/store/js/select.data.js?v=<?= $version ?>"></script>
<script>
    $(function () {

        // 选择冲泡码
        var $teaQrcodeList = $('.widget-tea_qrcode-list');
        $('.j-selectGoods').selectData({
            title: '选择冲泡码',
            uri: 'tea_qrcode/lists&factory_id=<?= $goods['factory_id'] ?>',
            dataIndex: 'tea_qrcode_id',
            done: function (data) {
                data = [data[0]];
                var $html = $(template('tpl-tea_qrcode-list-item', data));
                $teaQrcodeList.html($html);
            }
        });


        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

    });
</script>
