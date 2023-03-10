<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">编辑优惠券</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">优惠券名称 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="coupon[name]"
                                           value="<?= $model['name'] ?>" placeholder="请输入优惠券名称" required>
                                    <small>例如：满100减10</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">优惠券颜色 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[color]"
                                               value="10" <?= $model['color']['value'] == 10 ? 'checked' : '' ?>
                                               data-am-ucheck>
                                        蓝色
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[color]" value="20"
                                            <?= $model['color']['value'] == 20 ? 'checked' : '' ?>
                                               data-am-ucheck>
                                        红色
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[color]" value="30"
                                            <?= $model['color']['value'] == 30 ? 'checked' : '' ?>
                                               data-am-ucheck>
                                        紫色
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[color]" value="40"
                                            <?= $model['color']['value'] == 40 ? 'checked' : '' ?>
                                               data-am-ucheck>
                                        黄色
                                    </label>
                                </div>
                            </div>
                            <div class="am-form-group" data-x-switch>
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">优惠券类型 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[coupon_type]" value="10"
                                               data-am-ucheck
                                               data-switch-box="switch-coupon_type"
                                               data-switch-item="coupon_type__10"
                                            <?= $model['coupon_type']['value'] == 10 ? 'checked' : '' ?>>
                                        满减券
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[coupon_type]" value="20"
                                               data-am-ucheck
                                               data-switch-box="switch-coupon_type"
                                               data-switch-item="coupon_type__20"
                                            <?= $model['coupon_type']['value'] == 20 ? 'checked' : '' ?>>
                                        折扣券
                                    </label>
                                </div>
                            </div>
                            <div class="am-form-group switch-coupon_type coupon_type__10 <?= $model['coupon_type']['value'] == 10 ? '' : 'hide' ?>">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">减免金额 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" min="0.01" class="tpl-form-input" name="coupon[reduce_price]"
                                           value="<?= $model['reduce_price'] ?>" placeholder="请输入减免金额" required>
                                </div>
                            </div>
                            <div class="am-form-group switch-coupon_type coupon_type__20 <?= $model['coupon_type']['value'] == 20 ? '' : 'hide' ?>">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">折扣率 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" min="0" max="10" class="tpl-form-input"
                                           name="coupon[discount]"
                                           value="<?= $model['discount'] ?>" placeholder="请输入折扣率" required>
                                    <small>折扣率范围0-10，9.5代表9.5折，0代表不折扣</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">最低消费金额 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" min="1" class="tpl-form-input" name="coupon[min_price]"
                                           value="<?= $model['min_price'] ?>" placeholder="请输入最低消费金额" required>
                                </div>
                            </div>

                            <div class="am-form-group am-padding-top" data-x-switch>
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">适用范围 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[apply_range]" value="10"
                                               data-am-ucheck
                                               data-switch-box="switch-apply_range"
                                               data-switch-item="apply_range__10"
                                            <?= $model['apply_range'] == 10 ? 'checked' : '' ?>>
                                        全部产品
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[apply_range]" value="20"
                                               data-am-ucheck
                                               data-switch-box="switch-apply_range"
                                               data-switch-item="apply_range__20"
                                            <?= $model['apply_range'] == 20 ? 'checked' : '' ?>>
                                        指定产品
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[apply_range]" value="30"
                                               data-am-ucheck
                                               data-switch-box="switch-apply_range"
                                               data-switch-item="apply_range__30"
                                            <?= $model['apply_range'] == 30 ? 'checked' : '' ?>>
                                        排除产品
                                    </label>
                                </div>
                            </div>
                            <div class="am-form-group switch-apply_range apply_range__20 <?= $model['apply_range'] == 20 ? '' : 'hide' ?>">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="widget-become-goods am-form-file am-margin-top-xs">
                                        <button type="button" @click.stop="onSelectGoods"
                                                class="j-selectGoods upload-file am-btn am-btn-secondary am-radius">
                                            <i class="am-icon-cloud-upload"></i> 选择产品
                                        </button>
                                        <div class="widget-goods-list uploader-list am-cf">
                                            <?php if (!$applyGoodsList->isEmpty()): foreach ($applyGoodsList as $goods): ?>
                                                <div class="file-item">
                                                    <a href="<?= $goods['goods_image'] ?>"
                                                       title="<?= $goods['goods_name'] ?>" target="_blank">
                                                        <img src="<?= $goods['goods_image'] ?>">
                                                    </a>
                                                    <input type="hidden"
                                                           name="coupon[apply_range_config][applyGoodsIds][]"
                                                           value="<?= $goods['goods_id'] ?>">
                                                    <i class="iconfont icon-shanchu file-item-delete"
                                                       data-name="产品"></i>
                                                </div>
                                            <?php endforeach; endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group switch-apply_range apply_range__30 <?= $model['apply_range'] == 30 ? '' : 'hide' ?>">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="widget-become-goods am-form-file am-margin-top-xs">
                                        <button type="button" @click.stop="onSelectGoods"
                                                class="j-selectGoods2 upload-file am-btn am-btn-secondary am-radius">
                                            <i class="am-icon-cloud-upload"></i> 选择产品
                                        </button>
                                        <div class="widget-goods-list2 uploader-list am-cf">
                                            <?php if (!$excludedGoodsList->isEmpty()): foreach ($excludedGoodsList as $goods): ?>
                                                <div class="file-item">
                                                    <a href="<?= $goods['goods_image'] ?>"
                                                       title="<?= $goods['goods_name'] ?>" target="_blank">
                                                        <img src="<?= $goods['goods_image'] ?>">
                                                    </a>
                                                    <input type="hidden"
                                                           name="coupon[apply_range_config][excludedGoodsIds][]"
                                                           value="<?= $goods['goods_id'] ?>">
                                                    <i class="iconfont icon-shanchu file-item-delete"
                                                       data-name="产品"></i>
                                                </div>
                                            <?php endforeach; endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group am-padding-top" data-x-switch>
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">到期类型 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[expire_type]" value="10"
                                               data-am-ucheck
                                               data-switch-box="switch-expire_type"
                                               data-switch-item="expire_type__10"
                                            <?= $model['expire_type'] == 10 ? 'checked' : '' ?>>
                                        领取后生效
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[expire_type]" value="20"
                                               data-am-ucheck
                                               data-switch-box="switch-expire_type"
                                               data-switch-item="expire_type__20"
                                            <?= $model['expire_type'] == 20 ? 'checked' : '' ?>>
                                        固定时间
                                    </label>
                                </div>
                            </div>
                            <div class="am-form-group switch-expire_type expire_type__10 <?= $model['expire_type'] == 10 ? '' : 'hide' ?>">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">有效天数 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" min="1" class="tpl-form-input" name="coupon[expire_day]"
                                           value="<?= $model['expire_day'] ?>" placeholder="请输入有效天数" required>
                                </div>
                            </div>
                            <div class="am-form-group switch-expire_type expire_type__20 <?= $model['expire_type'] == 20 ? '' : 'hide' ?>">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">时间范围 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="j-startTime am-form-field am-margin-bottom-sm"
                                           name="coupon[start_time]"
                                           value="<?= $model['start_time']['value'] > 1 ? $model['start_time']['text'] : '' ?>"
                                           placeholder="请选择开始日期"
                                           required>
                                    <input type="text" class="j-endTime am-form-field"
                                           name="coupon[end_time]"
                                           value="<?= $model['end_time']['value'] > 1 ? $model['end_time']['text'] : '' ?>"
                                           placeholder="请选择结束日期" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">发放总数量 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" min="-1" class="tpl-form-input" name="coupon[total_num]"
                                           value="<?= $model['total_num'] ?>" required>
                                    <small>限制领取的优惠券数量，-1为不限制</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">排序 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" min="0" class="tpl-form-input" name="coupon[sort]"
                                           value="<?= $model['sort'] ?>" required>
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

<!-- 文件库弹窗 -->
{{include file="layouts/_template/file_library" /}}

<!-- 指定的 产品列表 -->
<script id="tpl-goods-list-item" type="text/template">
    {{ each $data }}
    <div class="file-item">
        <a href="{{ $value.image }}" title="{{ $value.goods_name }}" target="_blank">
            <img src="{{ $value.image }}">
        </a>
        <input type="hidden" name="coupon[apply_range_config][applyGoodsIds][]" value="{{ $value.goods_id }}">
        <i class="iconfont icon-shanchu file-item-delete" data-name="产品"></i>
    </div>
    {{ /each }}
</script>

<!-- 排除的 产品列表 -->
<script id="tpl-goods-list-item2" type="text/template">
    {{ each $data }}
    <div class="file-item">
        <a href="{{ $value.image }}" title="{{ $value.goods_name }}" target="_blank">
            <img src="{{ $value.image }}">
        </a>
        <input type="hidden" name="coupon[apply_range_config][excludedGoodsIds][]" value="{{ $value.goods_id }}">
        <i class="iconfont icon-shanchu file-item-delete" data-name="产品"></i>
    </div>
    {{ /each }}
</script>

<script src="assets/common/js/vue.min.js?v=<?= $version ?>"></script>
<script src="assets/store/js/select.data.js?v=<?= $version ?>"></script>
<script>
    /**
     * 时间选择
     */
    $(function () {
        var nowTemp = new Date();
        var nowDay = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0).valueOf();
        var nowMoth = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), 1, 0, 0, 0, 0).valueOf();
        var nowYear = new Date(nowTemp.getFullYear(), 0, 1, 0, 0, 0, 0).valueOf();
        var $startTime = $('.j-startTime');
        var $endTime = $('.j-endTime');

        var checkin = $startTime.datepicker({
            onRender: function (date, viewMode) {
                // 默认 days 视图，与当前日期比较
                var viewDate = nowDay;
                switch (viewMode) {
                    // moths 视图，与当前月份比较
                    case 1:
                        viewDate = nowMoth;
                        break;
                    // years 视图，与当前年份比较
                    case 2:
                        viewDate = nowYear;
                        break;
                }
                return date.valueOf() < viewDate ? 'am-disabled' : '';
            }
        }).on('changeDate.datepicker.amui', function (ev) {
            if (ev.date.valueOf() > checkout.date.valueOf()) {
                var newDate = new Date(ev.date)
                newDate.setDate(newDate.getDate() + 1);
                checkout.setValue(newDate);
            }
            checkin.close();
            $endTime[0].focus();
        }).data('amui.datepicker');

        var checkout = $endTime.datepicker({
            onRender: function (date, viewMode) {
                var inTime = checkin.date;
                var inDay = inTime.valueOf();
                var inMoth = new Date(inTime.getFullYear(), inTime.getMonth(), 1, 0, 0, 0, 0).valueOf();
                var inYear = new Date(inTime.getFullYear(), 0, 1, 0, 0, 0, 0).valueOf();
                // 默认 days 视图，与当前日期比较
                var viewDate = inDay;
                switch (viewMode) {
                    // moths 视图，与当前月份比较
                    case 1:
                        viewDate = inMoth;
                        break;
                    // years 视图，与当前年份比较
                    case 2:
                        viewDate = inYear;
                        break;
                }
                return date.valueOf() <= viewDate ? 'am-disabled' : '';
            }
        }).on('changeDate.datepicker.amui', function (ev) {
            checkout.close();
        }).data('amui.datepicker');
    });
</script>

<script>
    $(function () {

        // swith切换
        var $mySwitch = $('[data-x-switch]');
        $mySwitch.find('[data-switch-item]').click(function () {
            var $mySwitchBox = $('.' + $(this).data('switch-box'));
            $mySwitchBox.hide().filter('.' + $(this).data('switch-item')).show();
        });

        // 选择产品
        var $goodsList = $('.widget-goods-list');
        $('.j-selectGoods').selectData({
            title: '选择产品',
            uri: 'goods/lists',
            dataIndex: 'goods_id',
            done: function (data) {
                var $html = $(template('tpl-goods-list-item', data));
                // 删除文件
                $html.find('.file-item-delete').on('click', function () {
                    $(this).parent().remove();
                });
                $goodsList.append($html);
            }
        });

        // 选择产品
        var $goodsList2 = $('.widget-goods-list2');
        $('.j-selectGoods2').selectData({
            title: '选择产品',
            uri: 'goods/lists',
            dataIndex: 'goods_id',
            done: function (data) {
                var $html = $(template('tpl-goods-list-item2', data));
                // 删除文件
                $html.find('.file-item-delete').on('click', function () {
                    $(this).parent().remove();
                });
                $goodsList2.append($html);
            }
        });

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

    });
</script>
