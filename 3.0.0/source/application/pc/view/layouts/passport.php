<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="renderer" content="webkit"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="icon" type="image/png" href="assets/common/i/favicon.ico"/>
    <meta name="apple-mobile-web-app-title" content=""/>
    <script src="assets/common/js/jquery.min.js"></script>
    <script>
        BASE_URL = '<?= isset($base_url) ? $base_url : '' ?>';
        STORE_URL = '<?= isset($store_url) ? $store_url : '' ?>';
    </script>
</head>

<body data-type="">
<span>{$Think.lang.test}--{:lang('test') </span>
<span>{$Think.lang.name} <?= lang('test') ?> </span>
<br/>
<button type="button" lang='cn' class="btn">中文</button>
<button type="button" lang='en' class="btn">英文</button>
<button type="button" lang='其他语言' class="btn">其他语言</button>
<script type="text/javascript">
    $('.btn').click(function(){
        var data = {'lang':$(this).attr('lang')}
        $.get("{:url('index/lang')}",data,function(){
            location.reload();
        })
    })
</script>

{__CONTENT__}
<script src="assets/common/plugins/layer/layer.js"></script>
<script src="assets/common/js/jquery.form.min.js"></script>
<script>
    $(function () {
        
    });
</script>
</body>

</html>
