<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">编辑服务网点</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 服务网点名称 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="distributor[distributor_name]"
                                           placeholder="请输入服务网点名称" value="<?= $model['distributor_name'] ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 服务网点图片 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="am-form-file">
                                        <div class="am-form-file">
                                            <button type="button"
                                                    class="upload-file am-btn am-btn-secondary am-radius">
                                                <i class="am-icon-cloud-upload"></i> 选择图片
                                            </button>
                                            <div class="uploader-list am-cf">
                                                <div class="file-item">
                                                    <a href="<?= $model['image']['file_path'] ?>"
                                                       title="点击查看大图" target="_blank">
                                                        <img src="<?= $model['image']['file_path'] ?>">
                                                    </a>
                                                    <input type="hidden" name="distributor[image_id]"
                                                           value="<?= $model['image_id'] ?>">
                                                    <i class="iconfont icon-shanchu file-item-delete"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="help-block am-margin-top-sm">
                                            <small>尺寸750x538像素以上，大小2M以下 (可拖拽图片调整显示顺序 )</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group am-padding-top">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 联系人 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="distributor[linkman]"
                                           placeholder="请输入服务网点联系人" value="<?= $model['linkman'] ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 联系电话 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input " name="distributor[phone]"
                                           placeholder="请输入服务网点联系电话" value="<?= $model['phone'] ?>" >
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 营业时间 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input  test-item" name="distributor[distributor_hours]"
                                           placeholder="请输入营业时间" id="time_range">
                                </div>
                            </div>
                            <div class="am-form-group am-padding-top">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 服务网点区域 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="x-region-select" data-region-selected>
                                        <select name="distributor[province_id]"
                                                data-province
                                                data-id="<?= $model['province_id'] ?>"
                                                required>
                                            <option value="">请选择省份</option>
                                        </select>
                                        <select name="distributor[city_id]"
                                                data-city
                                                data-id="<?= $model['city_id'] ?>"
                                                required>
                                            <option value="">请选择城市</option>
                                        </select>
                                        <select name="distributor[region_id]"
                                                data-region
                                                data-id="<?= $model['region_id'] ?>"
                                                required>
                                            <option value="">请选择地区</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 详细地址 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="distributor[address]"
                                           placeholder="请输入详细地址" value="<?= $model['address'] ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 服务网点坐标 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="am-block">
                                        <input type="text" style="background: none !important;" id="coordinate"
                                               class="tpl-form-input" name="distributor[coordinate]"
                                               placeholder="请选择服务网点坐标"
                                               value="<?= $model['latitude'] ?>,<?= $model['longitude'] ?>"
                                               readonly=""
                                               required>
                                    </div>
                                    <div class="am-block am-padding-top-xs">
                                        <iframe id="map" src="<?= url('distributor/getpoint') ?>"
                                                width="915"
                                                height="610"></iframe>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group am-padding-top">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 服务网点简介 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <textarea class="am-field-valid" rows="5" placeholder="请输入服务网点简介"
                                              name="distributor[summary]"><?= $model['summary'] ?></textarea>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">服务网点排序 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" class="tpl-form-input" name="distributor[sort]"
                                           value="<?= $model['sort'] ?>" required>
                                    <small>数字越小越靠前</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 服务网点状态 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="distributor[status]" value="1" data-am-ucheck
                                            <?= $model['status'] == 1 ? 'checked' : '' ?>>
                                        启用
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="distributor[status]" value="0" data-am-ucheck
                                            <?= $model['status'] == 0 ? 'checked' : '' ?>>
                                        禁用
                                    </label>
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

<!-- 图片文件列表模板 -->
<script id="tpl-file-item" type="text/template">
    {{ each list }}
    <div class="file-item">
        <a href="{{ $value.file_path }}" title="点击查看大图" target="_blank">
            <img src="{{ $value.file_path }}">
        </a>
        <input type="hidden" name="{{ name }}" value="{{ $value.file_id }}">
        <i class="iconfont icon-shanchu file-item-delete"></i>
    </div>
    {{ /each }}
</script>

<!-- 文件库弹窗 -->
{{include file="layouts/_template/file_library" /}}

<script src="assets/store/js/select.region.js?v=1.2"></script>
<script src="assets/common/plugins/laydate/laydate.js"></script>
<script>
    /**
     * 设置坐标
     */
    function setCoordinate(value) {
        var $coordinate = $('#coordinate');
        $coordinate.val(value);
        // 触发验证
        $coordinate.trigger('change');
    }
</script>
<script>
    $(function () {

        // 选择图片
        $('.upload-file').selectImages({
            name: 'distributor[image_id]'
        });

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();
    
        laydate.render({
            elem: '#time_range'
            ,type: 'time'
            ,format: 'HH:mm'
            ,range: '~'
            ,value: '<?= $model['distributor_hours'] ?>'
            ,trigger:'click'
        });
    });
</script>
