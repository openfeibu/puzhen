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
                                <label class="am-u-sm-4 am-u-md-3 am-u-lg-2 am-form-label form-require"> 冲泡码名称 </label>
                                <div class="am-u-sm-8 am-u-md-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="tea_qrcode[name]"
                                           placeholder="请输入冲泡码方案名称" required>
                                </div>
                            </div>
                            <?php if($goods):?>
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
                            <?php else:?>

                            <?php endif;?>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-md-3 am-u-lg-2 am-form-label form-require">茶类 </label>
                                <div class="am-u-sm-9 am-u-md-9 am-u-end">
                                    <select name="tea_qrcode[tea]" required
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
                                <label class="am-u-sm-3 am-u-md-3 am-u-lg-2 am-form-label form-require"> 茶量 </label>

                                <div class="am-u-sm-9 am-u-md-9 am-u-end">
                                    <div class="am-u-sm-12 am-u-md-6" style="padding-left:0">
                                        <select name="tea_qrcode[weight]"
                                                data-am-selected="{searchBox: 0, btnSize: 'sm',
												 placeholder:'请选择', maxHeight: 400}">
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                           
                                            <option value="5" selected >5</option>
                                         
                                            <option value="6">6</option>
                                         
                                            <option value="7">7</option>
                                           
                                            <option value="8">8</option>
                                          
                                            <option value="9">9</option>
    
                                            <option value="10">10</option>
                                           
                                            <option value="11">11</option>
                                           
                                            <option value="12">12</option>
                                            
                                            <option value="13">13</option>
                                     
                                            <option value="14">14</option>
                                           
                                            <option value="15">15</option>

                                        </select>
                                        <label class="am-form-label am-text-left">克</label>
                                    </div>

                                </div>

                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-md-3 am-u-lg-2 am-form-label form-require"> 泡数 </label>
                                <div class="am-u-sm-9 am-u-md-9 am-u-end">
                                    <div class="am-u-sm-12 am-u-md-6" style="padding-left:0">
                                        <select id="changeNumber" name="tea_qrcode[number]"
                                                data-am-selected="{searchBox: 0, btnSize: 'sm',
												 placeholder:'请选择', maxHeight: 400}">
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8" selected>8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                            <option value="20">20</option>
                                            <option value="21">21</option>
                                            <option value="22">22</option>
                                            <option value="23">23</option>
                                            <option value="24">24</option>
                                            <option value="25">25</option>

                                        </select>
                                        <label class="am-form-label am-text-left">泡</label>
                                    </div>

                                </div>
                            </div>

                            <div class="am-form-group " style="background: #cae5ff;padding:10px 0">
                                <label class="am-u-sm-4 am-u-md-3 am-u-lg-2 am-form-label form-require mb2"> 批量填写温度 </label>
                                <div class="am-u-sm-8 am-u-md-3 mb2">
                                    <div class="am-u-sm-10 am-u-md-8">
                                        <input type="text" class="tpl-form-input temperature-pl"
                                               placeholder="70°C-100°C"  value="">
                                    </div>
                                    <label class="am-u-sm-2 am-u-md-4 am-form-label am-text-left">°C</label>

                                </div>

                                <label class="am-u-sm-4 am-u-md-3 am-u-lg-2 am-form-label form-require mb2"> 批量填写秒数 </label>
                                <div class="am-u-sm-8 am-u-md-3 am-u-end mb2">
                                    <div class="am-u-sm-10 am-u-md-8">
                                        <input type="text" class="tpl-form-input seconds-pl" 
                                               placeholder="1秒-99秒"  value="">
                                    </div>
                                    <label class="am-u-sm-2 am-u-md-4 am-form-label am-text-left">秒</label>
                                </div>
                            </div>

                            <div id="form-line">
                                <!--  <div class="am-form-group form-line-item">
                                     <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 第1泡温度 </label>
                                     <div class="am-u-sm-3">
                                         <div class="am-u-sm-8">
                                             <input type="text" class="tpl-form-input" name="tea_qrcode[temperature][]"
                                                    placeholder="请输入温度" required value="8">
                                         </div>
                                         <label class="am-u-sm-4 am-form-label am-text-left">°C</label>
                                     </div>

                                     <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 第1泡秒数 </label>
                                     <div class="am-u-sm-3 am-u-end">
                                         <div class="am-u-sm-8">
                                             <input type="text" class="tpl-form-input" name="tea_qrcode[seconds][]"
                                                placeholder="请输入秒数" required value="8">
                                         </div>
                                         <label class="am-u-sm-4 am-form-label am-text-left">秒</label>
                                     </div>
                                 </div> -->
                            </div>

                            <div class="am-form-group">
                                <div class="am-u-sm-12 am-u-sm-push-1 am-margin-top-lg">
                                    <button type="submit" class="j-submit   am-btn am-btn-secondary ">生成冲泡码
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
        initNumber();
        $("#changeNumber").change(function(){
            initNumber()
        })
        function initNumber(){
            var number = $("[name='tea_qrcode[number]']").val();
            var html=$("#form-line").html();
            var nowNumber = $("#form-line").find(".form-line-item").length || 0;
            console.log(number,nowNumber)
            if(number > nowNumber){
                var j = number - nowNumber;
                for(var i=1;i<=j;i++){

                    html += ' <div class="am-form-group form-line-item codedata-item">'+
                        '<label class="am-u-sm-4 am-u-md-3 am-u-lg-2 am-form-label form-require mb2"> 第'+(i+nowNumber)+'泡温度 </label>'+
                        '<div class="am-u-sm-8 am-u-md-3 mb2">'+
                        '<div class="am-u-sm-10 am-u-md-8">'+
                        '<input class="temperatureVal" type="number" max="100" min="70" class="tpl-form-input" name="tea_qrcode[temperature][]" placeholder="请输入温度" required value="90" data-validationMessage="请输入70-100">'+
                        '</div>'+
                        '<label class="am-u-sm-2 am-u-md-4 am-form-label am-text-left">°C</label>'+
                        '</div>'+
                        '<label class="am-u-sm-4 am-u-md-3 am-form-label form-require mb2"> 第'+(i+nowNumber)+'泡秒数 </label>'+
                        '<div class="am-u-sm-8 am-u-md-3 mb2 am-u-end">'+
                        '<div class="am-u-sm-10 am-u-md-8">'+
                        '<input type="number"   max="99" min="1" class="tpl-form-input secondsVal" name="tea_qrcode[seconds][]" placeholder="请输入秒数" required value="3" data-validationMessage="请输入1-99">'+
                        '</div>'+
                        '<label class="am-u-sm-2 am-u-md-4 am-form-label am-text-left">秒</label>'+
                        '</div>'+
                        '</div>'
                }
                $("#form-line").html(html)
            }else if(number < nowNumber){

                for(var i=nowNumber;i>=number;i--){

                    $("#form-line").find(".form-line-item").eq(i).remove();

                }

            }

        }

        $(".temperature-pl").bind("input propertychange",function(event){
            $("#form-line").find(".form-line-item").find(".temperatureVal").val($(this).val())
        });
        $(".seconds-pl").bind("input propertychange",function(event){
            $("#form-line").find(".form-line-item").find(".secondsVal").val($(this).val())
        });

    });
</script>
