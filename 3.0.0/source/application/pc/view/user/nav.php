<div class="product-list-tab w1400 container">
    <ul class="clearfix">
        <li <?php if($routeUri == 'user/index'): ?> class="active" <?php endif;?> ><a href="<?= url('user/index') ?>"><?= lang('tea_qrcode');?></a></li>
        <li <?php if($routeUri == 'collection/index'): ?> class="active" <?php endif;?>><a href="<?= url('collection/index') ?>"><?= lang('my_collection');?></a></li>

    </ul>

</div>