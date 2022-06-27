<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">添加用户茶电器</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3  am-u-lg-2 am-form-label form-require"> 选择用户 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="widget-become-goods am-form-file am-margin-top-xs">
                                        <button type="button"
                                                class="j-selectUser upload-file am-btn am-btn-secondary am-radius">
                                            <i class="am-icon-cloud-upload"></i> 选择用户
                                        </button>
                                        <div class="user-list uploader-list am-cf">
                                        </div>
                                        <div class="am-block">
                                            <small>选择后不可更改</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3  am-u-lg-2 am-form-label form-require"> 选择设备 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="widget-become-goods am-form-file am-margin-top-xs">
                                        <button type="button"
                                                class="j-selectEquipment upload-file am-btn am-btn-secondary am-radius">
                                            <i class="am-icon-cloud-upload"></i> 选择设备
                                        </button>
                                        <div class="equipment-list uploader-list am-cf">
                                        </div>
                                        <div class="am-block">
                                            <small>选择后不可更改</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 联系人 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <input type="text" class="tpl-form-input" name="user_equipment[linkname]"
                                           placeholder="请输入联系人" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 手机号码 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <input type="text" class="tpl-form-input" name="user_equipment[phone]"
                                           placeholder="请输入手机号码" required>
                                </div>
                            </div>
                            <div class="am-form-group am-padding-top">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 购买日期 </label>
                                <div class="am-u-sm-9 am-u-md-6 am-u-lg-5 am-u-end">
                                    <input type="text" class="j-laydate-start am-form-field"
                                           name="user_equipment[buy_date]"
                                           value="<?= date('Y-m-d') ?>"
                                           placeholder="点击选择日期"
                                           required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 序列号 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <input type="text" class="tpl-form-input" name="user_equipment[equipment_sn]"
                                           placeholder="请输入序列号" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 凭证</label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="am-form-file">
                                        <div class="am-form-file">
                                            <button type="button"
                                                    class="upload-file upload-image am-btn am-btn-secondary am-radius">
                                                <i class="am-icon-cloud-upload"></i> 选择图片
                                            </button>
                                            <div class="uploader-list am-cf">
                                            </div>
                                        </div>
                                        <div class="help-block am-margin-top-sm">
                                            <small>大小10M以下 (可拖拽图片调整显示顺序 )</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">保修日期 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?= $warranty_setting['warranty_days'] ?>天
                                </div>
                                <!--
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="am-u-sm-6">
                                        <input type="number" class="tpl-form-input" name="user_equipment[setting_warranty_days]" value="<?= $warranty_setting['warranty_days'] ?>" required>
                                    </div>
                                    <label class="am-u-sm-6 am-form-label am-text-left">天</label>
                                </div>
                                -->
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">基础包换日期 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?= $warranty_setting['basic_change_days'] ?>天
                                </div>
                                <!--
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="am-u-sm-6">
                                        <input type="number" class="tpl-form-input" name="user_equipment[setting_basic_change_days]" value="<?= $warranty_setting['basic_change_days'] ?>" required>
                                    </div>
                                    <label class="am-u-sm-6 am-form-label am-text-left">天</label>
                                </div>
                                -->
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">赠送包换日期 </label>
                                <div class="am-u-sm-9 am-u-end am-padding-top-xs">
                                    <?= $warranty_setting['change_days'] ?>天
                                </div>
                                <!--
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="am-u-sm-6">
                                        <input type="number" class="tpl-form-input" name="user_equipment[setting_change_days]" value="<?= $warranty_setting['change_days'] ?>" required>
                                    </div>
                                    <label class="am-u-sm-6 am-form-label am-text-left">天</label>
                                </div>
                                -->
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

<!-- 图片文件列表模板 -->
{{include file="layouts/_template/tpl_file_item" /}}

<!-- 文件库弹窗 -->
{{include file="layouts/_template/file_library" /}}


<!-- 用户列表模板 -->
<script id="tpl-user-item" type="text/template">
    {{ each $data }}
    <div class="file-item">
        <a href="{{ $value.avatarUrl }}" title="{{ $value.nickName }} (ID:{{ $value.user_id }})" target="_blank">
            <img src="{{ $value.avatarUrl }}">
        </a>
        <input type="hidden" name="user_equipment[user_id]" value="{{ $value.user_id }}">
    </div>
    {{ /each }}
</script>
<!-- 设备列表模板 -->
<script id="tpl-equipment-item" type="text/template">
    {{ each $data }}
    <div class="file-item">
        <a href="{{ $value.equipment_image }}" title="{{ $value.equipment_name }} (ID:{{ $value.model }})" target="_blank">
            <img src="{{ $value.equipment_image }}">
        </a>
        <input type="hidden" name="user_equipment[equipment_id]" value="{{ $value.equipment_id }}">
    </div>
    {{ /each }}
</script>
<script src="assets/common/js/vue.min.js"></script>
<script src="assets/common/plugins/laydate/laydate.js"></script>
<script src="assets/common/js/ddsort.js"></script>
<script src="assets/store/js/select.data.js?v=<?= $version ?>"></script>

<script>

    $(function () {

        // 选择图片
        $('.upload-image').selectImages({
            name: 'user_equipment[images][]'
            , multiple: true
        });

        // 图片列表拖动
        $('.uploader-list').DDSort({
            target: '.file-item',
            delay: 100, // 延时处理，默认为 50 ms，防止手抖点击 A 链接无效
            floatStyle: {
                'border': '1px solid #ccc',
                'background-color': '#fff'
            }
        });
        // 选择用户
        $('.j-selectUser').click(function () {
            var $userList = $('.user-list');
            $.selectData({
                title: '选择用户',
                uri: 'user/lists',
                dataIndex: 'user_id',
                done: function (data) {
                    var user = [data[0]];
                    $userList.html(template('tpl-user-item', user));
                }
            });
        });
        // 选择设备
        $('.j-selectEquipment').click(function () {
            var $userList = $('.equipment-list');
            $.selectData({
                title: '选择用户',
                uri: 'equipment/lists',
                dataIndex: 'equipment_id',
                done: function (data) {
                    var user = [data[0]];
                    $userList.html(template('tpl-equipment-item', user));
                }
            });
        });
        // 日期选择器
        laydate.render({
            elem: '.j-laydate-start'
            , type: 'date'
            ,max:' <?= date('Y-m-d') ?>'
            ,trigger:'click'
        });
        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

    });
</script>
