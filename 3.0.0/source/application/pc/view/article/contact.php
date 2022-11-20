<!-- 轮播图 -->
<div class="min-banner">
    <img src="assets/pc/images/banner2.png" alt="">
</div>
<!-- 主体 -->
<div class="main">
    <!-- 列表 -->
    <div class="contact-page w1400 container">
        <div class="contact-top clearfix">
            <div class="about-page-contact-map  col-lg-6 col-md-6 col-sm-12 col-xs-12 nopadding fl">
                <div id="allmap"></div>
            </div>
            <div class="about-page-contact-test contact-page-contact-test col-lg-6 col-md-6 col-sm-12 col-xs-12 nopadding fr">
                <div class="about-page-contact-test-title">
                    <p><?= lang('contact_us'); ?></p>
                    <span>CONTACT US</span>
                </div>
                <div class="about-page-contact-test-address">
                    <p><?= lang('address'); ?></p>
                    <span><?= $setting['store']['values'][$prefix.'address'] ?: $setting['store']['values']['address'];;?></span>
                </div>
                <div class="about-page-contact-test-phone">
                    <p><?= lang('tel'); ?></p>
                    <span><?= $setting['store']['values']['tel'];?></span>
                </div>
                <div class="about-page-contact-test-email">
                    <p><?= lang('email'); ?></p>
                    <span><?= $setting['store']['values']['email'];?></span>
                </div>
            </div>
        </div>
        <div class="contact-page-contact-code col-lg-12 col-md-12 col-sm-12 col-xs-12  ">
            <div class="contact-page-contact-code-title">
                <p><?= lang('follow_us'); ?></p>
                <span>FOLLOW US</span>
            </div>
            <div class="ewm">
                <img src="assets/pc/images/code.jpeg" alt="" />
            </div>
        </div>


    </div>


</div>

<script type="text/javascript" src="http://api.map.baidu.com/getscript?v=2.0&amp;ak=5jCnjnCesElvVDufg6yjGMrlYimVXk5f&amp;services=&amp;t=20200327103013"></script>

<script>
    let sContent =`<h4 style='margin:0 0 5px 0;padding:0.1em 0;font-size:16px;text-align:center;'><?= $setting['store']['values'][$prefix.'company'] ?: $setting['store']['values']['company'];?></h4>`
    let map = new BMap.Map("allmap");
    let point2 = new BMap.Point("113.055517","23.138691");
    let marker2 = new BMap.Marker(point2);
    map.addControl(new BMap.OverviewMapControl());              //添加缩略地图控件
    map.enableScrollWheelZoom();                            //启用滚轮放大缩小
    let infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象
    map.addOverlay(marker2);
    map.disable3DBuilding();
    map.centerAndZoom(point2, 18);

    marker2.openInfoWindow(infoWindow);
    // map.addEventListener("click",function(e){
    // 	console.log(e.point.lng + "," + e.point.lat);
    // });
</script>