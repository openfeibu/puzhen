<!-- 轮播图 -->
<div class="min-banner">
    <img src="assets/pc/images/banner2.png" alt="">
</div>
<!-- 主体 -->
<div class="main">
    <div class="codeForm  container w1400">
        <div class="pro-code fr">
            <a href="<?= url('user/index')?>">
                <p class="fl"> <?= lang('my_tea_qrcode'); ?></p>
                <span class="fl">|</span>
                <div class="pro-code-icon fl"></div>
            </a>
        </div>
        <form action="" id="codeForm" onsubmit="return addCode()">
            <div class="codeForm-item">
                <label class="col-lg-2 col-md-2 col-sm-3 col-xs-3 codeForm-label "><?= lang('tea_qrcode_name'); ?><span>*</span></label>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 codeForm-con ">
                    <input type="text" class="tpl-form-input" name="tea_qrcode[<?= $prefix;?>name]" placeholder="<?= lang('tea_qrcode_name_empty'); ?>" required="">
                </div>
            </div>
            <div class="codeForm-item">
                <label class="col-lg-2 col-md-2 col-sm-3 col-xs-3 codeForm-label "><?= lang('teas');?><span>*</span></label>
                <div class="col-lg-4 col-md-4 col-sm-8 col-xs-8 codeForm-con ">
                    <select name="tea_qrcode[tea]" id="" required="">
                        <option value=""><?= lang('please_select'); ?></option>
                        <?php if (isset($teaList)): foreach ($teaList as $item): ?>
                            <option value="<?= $item['code'] ?>" ><?= $item[$prefix.'name']; ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>

            </div>
            <div class="codeForm-item clearfix">
                <label class="col-lg-2 col-md-2 col-sm-3 col-xs-3 codeForm-label "><?= $teaConfig['weight'][$prefix.'name']?><span>*</span></label>
                <div class="col-lg-4 col-md-4 col-sm-9 col-xs-9 codeForm-con clearfix">
                    <select name="tea_qrcode[weight]" class="fl" required="">
                        <option value="" selected><?= lang('please_select'); ?></option>
                        <?php foreach ($teaConfig['weight']['data'] as $config_data):?>
                        <option value="<?= $config_data['value'] ?>" <?= $teaConfig['weight']['default'] == $config_data['value'] ? "selected" : ''?> ><?= $config_data['value'] ?></option>
                        <?php endforeach;?>
                    </select>
                    <div class="unit fl"><?= $teaConfig['weight'][$prefix.'unit']?></div>
                </div>
                <label class="col-lg-2 col-md-2 col-sm-3 col-xs-3 codeForm-label "><?= $teaConfig['frequency'][$prefix.'name']?><span>*</span></label>
                <div class="col-lg-4 col-md-4 col-sm-9 col-xs-9 codeForm-con clearfix">
                    <select name='tea_qrcode[number]' id="changeNumber" class="fl" required="">
                        <option value="" selected><?= lang('please_select'); ?></option>
                        <?php foreach ($teaConfig['frequency']['data'] as $config_data):?>
                            <option value="<?= $config_data['value'] ?>" ><?= $config_data['value'] ?></option>
                        <?php endforeach;?>
                    </select>
                    <div class="unit fl"><?= $teaConfig['frequency'][$prefix.'unit']?></div>
                </div>
            </div>
            <div class="codeForm-data">
                <!-- <div class="codeForm-item">
                    <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2 codeForm-label ">第1泡温度<span>*</span></label>
                    <div class="col-lg-4 col-md-4 col-sm-3 col-xs-3 codeForm-con clearfix">
                        <select name="tea_qrcode[temperature][]" id="" class="code-temperature fl" onchange="changetemperature(this)">
                            <option value=""><?= lang('please_select'); ?></option>
                            <option value="50">50</option>
                            <option value="51">51</option>
                        </select>
                        <div class="unit fl">℃</div>
                    </div>
                    <label class="col-lg-2 col-md-2 col-sm-2 col-xs-2 codeForm-label ">第1泡秒数<span>*</span></label>
                    <div class="col-lg-4 col-md-4 col-sm-3 col-xs-3 codeForm-con clearfix">
                        <select name="tea_qrcode[seconds][]" id="" class="fl">
                            <option value=""><?= lang('please_select'); ?></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                        <div class="unit fl">秒</div>
                    </div>
            </div> -->
            </div>
            <div class="codeForm-btn">
                <div class="codeForm-submit">
                    <button type="submit"><?= lang('generate_tea_qrcode'); ?></button>
                </div>
            </div>
        </form>

    </div>

</div>
<script>
    function addCode()
    {
        let load = layer.load(2);
        $("#codeForm").ajaxSubmit({
            url: "<?= url('tea_qrcode/add');?>",
            type: 'post',
            success: function(data) { // data 保存提交后返回的数据，一般为 json 数据
                layer.close(load);
                if (data.code === 1) {
                    layer.msg(data.msg, {time: 1500, anim: 1}, function () {
                        window.location.href=data.url;
                    });
                    return true;
                }
                layer.msg(data.msg);
                return false;
            }
        })
        return false;
    }
    $(function() {


        $("#changeNumber").change(function(){
            initNumber()
        })
        function initNumber(){
            var number = $("[name='tea_qrcode[number]']").val();
            var html='';
            var nowNumber = $(".codeForm-data").find(".codeForm-item").length || 0;
            console.log(number,nowNumber)
            if(number > nowNumber){
                var j = number - nowNumber;
                for(var i=1;i<=j;i++){
                    html += `<div class="codeForm-item clearfix">
                        <label class="col-lg-2 col-md-2 col-sm-3 col-xs-3 codeForm-label "><?= lang('no.');?>`+(i+nowNumber)+`<?= lang('no.temp');?><span>*</span></label>
                        <div class="col-lg-4 col-md-4 col-sm-9 col-xs-9 codeForm-con clearfix">
                            <select name="tea_qrcode[temperature][]" class="code-temperature fl" onchange="changetemperature(this)" required="" >
                                <option value=""><?= lang('please_select'); ?></option>
                               <?php foreach ($teaConfig['temperature']['data'] as $config_data):?>
                                <option value="<?= $config_data['value']; ?>" <?= $teaConfig['temperature']['default'] == $config_data['value'] ? "selected" : '';?> ><?= $config_data['value']; ?></option>
                                <?php endforeach;?>
                            </select>
                            <div class="unit fl"><?= $teaConfig['temperature'][$prefix.'unit']?></div>
                        </div>
                        <label class="col-lg-2 col-md-2 col-sm-3 col-xs-3 codeForm-label "><?= lang('no.');?>`+(i+nowNumber)+`<?= lang('no.seconds');?><span>*</span></label>
                        <div class="col-lg-4 col-md-4 col-sm-9 col-xs-9 codeForm-con clearfix">
                            <select name="tea_qrcode[seconds][]" class="code-seconds fl" onchange="changeseconds(this)" required="" >
                                <option value=""><?= lang('please_select'); ?></option>
                                  <?php foreach ($teaConfig['seconds']['data'] as $config_data):?>
                                <option value="<?= $config_data['value']; ?>" <?= $teaConfig['seconds']['default'] == $config_data['value'] ? "selected" : '';?> ><?= $config_data['value']; ?></option>
                                <?php endforeach;?>
                            </select>
                            <div class="unit fl"><?= $teaConfig['seconds'][$prefix.'unit']?></div>
                        </div>
                    </div>`;
                }
               
                $(".codeForm-data").append(html)
            }else if(number < nowNumber){

                for(var i=nowNumber;i>=number;i--){

                    $(".codeForm-data").find(".codeForm-item").eq(i).remove();

                }

            }

        }

    });
    function changetemperature(that){
        console.log($(that))
        var index = $(that).index(".code-temperature")
        var val = $(that).val();
        for(var i = index+1; i<$(".code-temperature").length;i++){
            $(".code-temperature").eq(i).val(val)
        }

    }
    function changeseconds(that){
        console.log($(that))
        var index = $(that).index(".code-seconds")
        var val = $(that).val();
        for(var i = index+1; i<$(".code-seconds").length;i++){
            $(".code-seconds").eq(i).val(val)
        }

    }
</script>