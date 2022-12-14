<?php

use app\common\enum\DeliveryType as DeliveryTypeEnum;

?>
<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">商城设置</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require"> 商城名称 </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="store[name]"
                                           value="<?= $values['name'] ?? '' ?>" required>
                                </div>
                            </div>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">联系方式</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label "> 公司名称 </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="store[company]"
                                           value="<?= $values['company']  ?? '' ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label "> 英文公司名称 </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="store[en_company]"
                                           value="<?= $values['en_company']  ?? '' ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label "> 地址 </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="store[address]"
                                           value="<?= $values['address']  ?? '' ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label "> 英文地址 </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="store[en_address]"
                                           value="<?= $values['en_address']  ?? '' ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label "> 电话 </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="store[tel]"
                                           value="<?= $values['tel'] ?? '' ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label "> 邮箱 </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="store[email]"
                                           value="<?= $values['email'] ?? '' ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label "> 英文邮箱 </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="store[en_email]"
                                           value="<?= $values['en_email'] ?? '' ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label "> 版权 </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="store[right]"
                                           value="<?= $values['right'] ?? '' ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label "> 版权英文 </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="store[en_right]"
                                           value="<?= $values['en_right'] ?? '' ?>" required>
                                </div>
                            </div>
                            <!--
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label"> 经纬度 </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="store[longitude]"
                                           value="<?= $values['longitude'] ?? '' ?>" required>
                                    <input type="text" class="tpl-form-input" name="store[latitude]"
                                           value="<?= $values['latitude'] ?? '' ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label"> 获取点位 </label>
                                <div class="am-u-sm-9">
                                    <div class="am-u-sm-6">
                                        <input id="keyword" type="text"  class="tpl-form-input" placeholder="输入地址搜索" value="">
                                    </div>
                                    <input type="button" value="搜索" class="am-btn am-btn-primary am-radius am-btn-sm"  onclick="searchKeyword()">
                                    <div class="am-u-sm-12">
                                        <div class="help-block">
                                            <small>点击地图快速获取经纬度</small>
                                        </div>
                                        <div id="map"></div>
                                    </div>
                                </div>
                            </div>
                            -->
                            <!--
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label form-require"> 配送方式 </label>
                                <div class="am-u-sm-9">
                                    <?php foreach (DeliveryTypeEnum::data() as $item): ?>
                                        <label class="am-checkbox-inline">
                                            <input type="checkbox" name="store[delivery_type][]"
                                                   value="<?= $item['value'] ?>" data-am-ucheck
                                                <?= in_array($item['value'], $values['delivery_type']) ? 'checked' : '' ?>>
                                            <?= $item['name'] ?>
                                        </label>
                                    <?php endforeach; ?>
                                    <div class="help-block">
                                        <small>注：配送方式至少选择一个</small>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl"> 物流查询API</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label"> 快递100 Customer </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="store[kuaidi100][customer]"
                                           value="<?= $values['kuaidi100']['customer'] ?>">
                                    <small>用于查询物流信息，<a href="https://www.kuaidi100.com/openapi/"
                                                       target="_blank">快递100申请</a></small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label"> 快递100 Key </label>
                                <div class="am-u-sm-9">
                                    <input type="text" class="tpl-form-input" name="store[kuaidi100][key]"
                                           value="<?= $values['kuaidi100']['key'] ?>">
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
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&key=YVHBZ-LNORJ-N2WFY-FDDOG-YZQRK-XOFQ2"></script>
<script>
    $(function () {

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();
        window.onload = function(){
            init();
        }
    });
</script>
<script>
    var geocoder,map,markers = [];
    var init = function() {
        var center = new qq.maps.LatLng(<?= $values['latitude'] ?? '' ?>, <?= $values['longitude'] ?? '' ?>);
        map = new qq.maps.Map(document.getElementById('map'),{
            center: center,
            zoom: 15
        });

        //调用Poi检索类
        geocoder = new qq.maps.Geocoder({

            complete : function(result){
                console.log(result)
                map.setCenter(result.detail.location);
                var marker = new qq.maps.Marker({
                    map:map,
                    position: result.detail.location
                });
                markers.push(marker)
                document.getElementsByName('store[longitude]')[0].value = result.detail.location.lng;
                document.getElementsByName('store[latitude]')[0].value = result.detail.location.lat;

                qq.maps.event.addListener(marker,'click',function(event) {
                    document.getElementsByName('store[longitude]')[0].value = event.latLng.getLng();
                    document.getElementsByName('store[latitude]')[0].value = event.latLng.getLat();
                })


            },
            //若服务请求失败，则运行以下函数
            error: function() {
                alert("无法获取地址，请检查地址是否正确");
            }
        });

        //添加监听事件  获取鼠标点击事件
        qq.maps.event.addListener(map, 'click', function(event) {
            document.getElementsByName('store[longitude]')[0].value = event.latLng.getLng();
            document.getElementsByName('store[latitude]')[0].value = event.latLng.getLat();
            if(!marker) {
                marker=new qq.maps.Marker({
                    position:event.latLng,
                    map:map
                });
                return;
            }
            marker.setPosition(event.latLng);
        });
        var marker = new qq.maps.Marker({
            position: center,
            map: map,
            //draggable: true,
            content: '<?= $values['address'] ?? '' ?>'
        });


    }
    //清除地图上的marker
    function clearOverlays(overlays) {
        var overlay;
        while (overlay = overlays.pop()) {
            overlay.setMap(null);
        }
    }
    //调用poi类信接口
    function searchKeyword() {
        var keyword = document.getElementById("keyword").value;
        //region = new qq.maps.LatLng(39.936273,116.44004334);
        clearOverlays(markers);

        // searchService.setPageCapacity(5);
        geocoder.getLocation(keyword);//根据中心点坐标、半径和关键字进行周边检索。

    }
</script>
