<!DOCTYPE HTML>
<html class=" fb-web oxh">
<!-- <div class="product-item col-lg-3 col-md-3 col-sm-6 col-xs-6 wow bounceIn animated" data-wow-duration=".6s" data-wow-delay=".4s">        -->
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=0">
    <meta name="format-detection" content="telephone=no">
    <title><?= $setting['pc']['values'][$prefix.'name'] ?: $setting['pc']['values']['name'];?></title>
    <meta name="description" content="<?= $setting['pc']['values'][$prefix.'name'] ?: $setting['pc']['values']['name'];?>">
    <meta name="keywords" content="<?= $setting['pc']['values'][$prefix.'name'] ?: $setting['pc']['values']['name'];?>">
    <link rel="icon" type="image/png" href="assets/common/i/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="assets/pc/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/pc/css/fb-main.css">
    <link rel="stylesheet" type="text/css" href="assets/pc/css/animate.min.css">
    <script>
        BASE_URL = '<?= isset($base_url) ? $base_url : '' ?>';
        PC_URL = '<?= isset($pc_url) ? $pc_url : '' ?>';
        lang_arr = <?= $lang_arr ?>;
        pc_root = BASE_URL + 'index.php?s=/pc/';
    </script>
    <script src="assets/pc/js/jquery.min.js"></script>
    <script src="assets/pc/js/jquery.validate.min.js"></script>
    <script src="assets/pc/js/swiper-3.4.2.jquery.min.js"></script>
    <link href="assets/pc/css/swiper-3.4.2.min.css" rel="stylesheet" />
    <script src="assets/pc/js/fb-main.js"></script>
    <script src="assets/pc/js/wow.min.js"></script>
    <script src="assets/common/js/jquery.form.min.js"></script>
    <script src="assets/common/plugins/layer/layer.js"></script>
    <!--[if lte IE 9]>
    <script src="assets/pc/js/respond.js"></script>
    <script src="assets/pc/js/tqj_html5shiv.js"></script>
    <![endif]-->
    <script>
        $.ajax_error = function (jqXHR, textStatus, errorThrown) {
            if($.parseJSON(jqXHR.responseText).code === -1){
                layer.msg(jqXHR.responseText.message);
                window.location.href = "<?= url('passport/login')?>";
            }else{
                layer.msg(lang_arr['server_error']);
            }
        }
    </script>
</head>
<!--[if lte IE 9]>
<div class="text-xs-center marginBottom0 bg-blue-grey-100 alert">
    <button type="button" class="close" aria-label="Close" data-dismiss="alert">
        <span>×</span>
    </button>
    你正在使用一个 <strong>过时</strong> 的浏览器。请 <a href=https://browsehappy.com/ target=_blank>升级您的浏览器</a>，以提高您的体验。</div>
<![endif]-->
<body>

<!-- 头部 -->
{{include file="layouts/header" /}}

<!-- 主体 -->
{__CONTENT__}
<!-- 尾部 -->
{{include file="layouts/footer" /}}

</body>

<script>
    $(function() {
        var mySwiper = new Swiper('.swiper-container-banner-pc', {
            loop: true,
            autoplay: 6000,
            autoHeight: true,
            pagination: '.swiper-pagination-banner-pc',
            paginationClickable :true
        })
        var mySwiper = new Swiper('.swiper-container-banner-h5', {
            loop: true,
            autoplay: 6000,
            autoHeight: true,
            pagination: '.swiper-pagination-banner-h5',
            paginationClickable :true
        })
        $(window).on("resize",function(){
            var w = $(window).width();
            if(w<=992){
                $(".swiper-container-banner-pc").hide();
                $(".swiper-container-banner-h5").show().css("opacity","1");
            }else{
                $(".swiper-container-banner-pc").show().css("opacity","1");;
                $(".swiper-container-banner-h5").hide();
            }

        })
        $(window).resize();
    })
</script>
</html>