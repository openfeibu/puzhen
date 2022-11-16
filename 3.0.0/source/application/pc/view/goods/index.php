
<!-- 轮播图 -->
<div class="min-banner">
    <img src="assets/pc/images/banner2.png" alt="">
</div>

<div class="main">
    <!-- 列表 -->
    <div class="product-list w1400 container">
        <?php if(empty($param['search'])): ?>
        <div class="product-list-tab w1400 container">
            <ul class="clearfix">
                <?php if (!empty($categoryList)): foreach ($categoryList as $first_key=> $first): ?>
                <li <?php if($first_key == 0): ?>class="active"<?php endif;?> category_id="<?= $first['category_id'] ?>"><?= $first['name'] ?></li>
                <?php endforeach; endif; ?>
            </ul>

            <?php if (!empty($categoryList)): foreach ($categoryList as $first_key => $first): ?>
            <ol class="clearfix" <?php if($first_key == 0): ?>style="display:block"<?php endif;?> >
                <?php if (isset($first['child'])): foreach ($first['child'] as $two_key => $two): ?>
                <li <?php if($two_key == 0): ?>class="active"<?php endif;?> category_id="<?= $two['category_id'] ?>"><?= $two['name'] ?></li>
                <?php endforeach; endif; ?>
            </ol>
            <?php endforeach; endif; ?>

        </div>
        <?php endif;?>
        <div id="goods_list">

        </div>
    </div>
</div>
<script>
    $(function (){
        var url= "<?= url('index')?>";
        var category_id = "<?= $param['category_id'] ?>";
        $(".product-list-tab ul li").on("click",function(){
            var index = $(this).index(".product-list-tab ul li")
            $(this).addClass("active").siblings("li").removeClass("active");
            $(".product-list-tab ol").eq(index).show().siblings("ol").hide();

            $(".product-list-tab ol li").removeClass("active");
            $(".product-list-tab ol").eq(index).find('li:eq(0)').addClass("active");
            category_id = $(".product-list-tab ol").eq(index).find('li:eq(0)').attr('category_id');
            $.loadProduct();
        })
        $(".product-list-tab ol li").on("click",function(){
            $(this).addClass("active").siblings("li").removeClass("active");
            category_id = $(this).attr('category_id');
            $.loadProduct();
        })
        var ajax_data = <?= json_encode($param) ?>;
        ajax_data.listRows = 2;
        $.loadProduct = function (url){
            ajax_data.category_id = category_id;
            var load = layer.load(2);
            $.ajax({
                url : url,
                data : ajax_data,
                type : 'get',
                success : function (data) {
                    layer.close(load);
                    if(data.code == 0)
                    {
                        layer.msg(data.msg);
                    }else{
                        $("#goods_list").html(data);
                    }
                },
                error : function (jqXHR, textStatus, errorThrown) {
                    layer.close(load);
                    $.ajax_error(jqXHR, textStatus, errorThrown);
                }
            });
        };
        $('body').on('click','.pagination a',function () {
            var url = $(this).attr('href');
            $.loadProduct(url);
            return false;
        });

        $.loadProduct();
    })
</script>
