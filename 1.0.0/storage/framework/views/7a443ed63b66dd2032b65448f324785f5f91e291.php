<div class="main">
    <?php echo Theme::widget('breadcrumb')->render(); ?>

    <div class="main_full">
        <?php echo Theme::partial('message'); ?>

        <div class="layui-col-md12">
            <div class="tabel-message">
                <div class="layui-inline tabel-btn">
                    <button class="layui-btn layui-btn-warm "><a href="<?php echo e(url('/admin/banner/create')); ?>"><?php echo e(trans('app.add')); ?>轮播图</a></button>
                    <button class="layui-btn layui-btn-primary " data-type="del" data-events="del"><?php echo e(trans('app.delete')); ?></button>
                </div>
                <!--  <div class="layui-inline">
                   <input class="layui-input" name="id" id="demoReload" placeholder="<?php echo e(trans('app.search')); ?>轮播图" autocomplete="off">
                 </div>
                 <button class="layui-btn" data-type="reload"><?php echo e(trans('app.search')); ?></button> -->
            </div>

            <table id="fb-table" class="layui-table"  lay-filter="fb-table">

            </table>
        </div>
    </div>
</div>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-sm" lay-event="edit"><?php echo e(trans('app.edit')); ?></a>
    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del"><?php echo e(trans('app.delete')); ?></a>
</script>
<script type="text/html" id="imageTEM">
    <img src="{{d.image}}" alt="" height="28">
</script>
<script>
    var main_url = "<?php echo e(guard_url('banner')); ?>";
    var delete_all_url = "<?php echo e(guard_url('banner/destroyAll')); ?>";
    layui.use(['jquery','element','table'], function(){
        var $ = layui.$;
        var table = layui.table;
        var form = layui.form;
        table.render({
            elem: '#fb-table'
            ,url: '<?php echo e(guard_url('banner')); ?>'
            ,cols: [[
                {checkbox: true, fixed: true}
                ,{field:'id',title:'ID', width:80, sort: true}
                ,{field:'title',title:'<?php echo e(trans('app.title')); ?>', sort: true,edit:'text'}
                ,{field:'image',title:'<?php echo e(trans('app.image')); ?>', width:200,toolbar:'#imageTEM',}
                ,{field:'url',title:'<?php echo e(trans('banner.label.url')); ?>', sort: true}
                ,{field:'order',title:'<?php echo e(trans('app.order')); ?>', sort: true}
                ,{field:'type_desc',title:'<?php echo e(trans('app.type')); ?>', sort: true}
                ,{field:'score',title:'<?php echo e(trans('app.actions')); ?>', width:200, align: 'right',toolbar:'#barDemo'}
            ]]
            ,id: 'fb-table'
            ,height: 'full-200'
        });
    });
</script>
<?php echo Theme::partial('common_handle_js'); ?>