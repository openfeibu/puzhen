<div class="product-list-tab w1400 container">
    <ul class="clearfix">
        <li <?php if($routeUri == 'user/index'): ?> class="active" <?php endif;?> ><a href="<?= url('user/index') ?>">冲泡码</a></li>
        <li <?php if($routeUri == 'collection/index'): ?> class="active" <?php endif;?>><a href="<?= url('collection/index') ?>">我的收藏</a></li>

    </ul>

</div>