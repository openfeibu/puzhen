<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">添加冲泡码</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 冲泡码方案名称 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="tea_qrcode[name]"
                                           placeholder="请输入冲泡码方案名称" required>
                                </div>
                            </div>
                            <?php if($goods):?>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 商品 </label>
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
                            <?php else:?>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 工厂 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <select name="tea_qrcode[factory_id]" require
                                            data-am-selected="{searchBox: 1, btnSize: 'sm', placeholder:'请选择', maxHeight: 400}"
                                    >
                                        <option value=""></option>
                                        <?php if (isset($factoryList) && !$factoryList->isEmpty()):
                                            foreach ($factoryList as $item): ?>
                                                <option value="<?= $item['factory_id'] ?>">
                                                    <?= $item['factory_name'] ?></option>
                                            <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            <?php endif;?>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">茶类 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <select name="tea_qrcode[tea]"
                                            data-am-selected="{searchBox: 1, btnSize: 'sm',
                                             placeholder:'请选择', maxHeight: 400}">
                                        <option value=""></option>
                                        <?php if (isset($teaList)): foreach ($teaList as $item): ?>
                                            <option value="<?= $item['code'] ?>" ><?= $item['name'] ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                    <!--
                                    <small class="am-margin-left-xs">
                                        <a href="<?= url('tea_qrcode/add') ?>">去添加</a>
                                    </small>
                                    -->
                                </div>
                            </div>
                            <div class="am-form-group am-padding-top">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 茶量 </label>

                                <div class="am-u-sm-6 am-u-end">
                                    <div class="am-u-sm-6" style="padding-left:0">
										<select name="tea_qrcode[weight]"
												data-am-selected="{searchBox: 0, btnSize: 'sm',
												 placeholder:'请选择', maxHeight: 400}">
												<option value="3">3</option>
												<option value="3.5">3.5</option>
												<option value="4">4</option>
										        <option value="4.5">4.5</option>
												<option value="5" selected >5</option>
												<option value="5.5">5.5</option>
												<option value="6">6</option>
										        <option value="6.5">6.5</option>
												<option value="7">7</option>
												<option value="7.5">7.5</option>
												<option value="8">8</option>
										        <option value="8.5">8.5</option>
												<option value="9">9</option>
												<option value="10.5">10.5</option>
												<option value="11">11</option>
										        <option value="11.5">11.5</option>
												<option value="12">12</option>
												<option value="12.5">12.5</option>
												<option value="13">13</option>
										        <option value="13.5">13.5</option>
												<option value="14">14</option>
										        <option value="14.5">14.5</option>
												<option value="15">15</option>
										       
										</select>
                                    </div>
                                    <label class="am-u-sm-6 am-form-label am-text-left">克</label>
                                </div>

                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 泡数 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="tea_qrcode[number]"
                                           placeholder="请输入泡数" required value="8">
                                </div>
                            </div>
                            <?php for($i=0;$i<8;$i++): ?>
                                <div class="am-form-group">

                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 温度 </label>
                                    <div class="am-u-sm-3">
                                        <div class="am-u-sm-8">
                                            <input type="text" class="tpl-form-input" name="tea_qrcode[temperature][]"
                                                   placeholder="请输入温度" required value="8">
                                        </div>
                                        <label class="am-u-sm-4 am-form-label am-text-left">°C</label>
                                    </div>

                                    <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 秒数 </label>
                                    <div class="am-u-sm-3 am-u-end">
                                        <div class="am-u-sm-8">
                                            <input type="text" class="tpl-form-input" name="tea_qrcode[seconds][]"
                                               placeholder="请输入秒数" required value="8">
                                        </div>
                                        <label class="am-u-sm-4 am-form-label am-text-left">秒</label>
                                    </div>
                                </div>
                            <?php endfor;?>

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


<script>

    $(function () {

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

    });
</script>
