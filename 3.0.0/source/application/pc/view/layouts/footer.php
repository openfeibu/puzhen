<div class="footer clearfix">
    <div class="footer-con clearfix">
        <div class="container w1060 clearfix">
            <div class="footer-con-left col-lg-10 col-md-10 col-sm-12 col-xs-12 " >
                <div class="footer-info">
                    <p><?= lang('address') ?><?= lang(': ') ?>佛山市南海区狮山镇321国道仙溪段广东生物医药产业基地一期第一组团B栋十楼</p>
                    <p><?= lang('tel') ?><?= lang(': ') ?>0757-81184899</p>
                    <p>©️2020 佛山朴真茶业有限公司版权所有  粤ICP备2020107685号</p>
                    <p><a href="http://www.feibu.info" target="_blank">广州飞步信息科技有限公司</a> 提供技术支持</p>
                </div>
            </div>
            <div class="footer-con-right col-lg-2 col-md-2 col-sm-12 col-xs-12  ">
                <div class="footer-ewm">
                    <img src="assets/pc/images/code.jpeg" alt="" />
                    <p><?= lang('wechat_public_account') ?></p>
                </div>
            </div>

        </div>
        <div class="container footer-logo w1060">
            <p><?= \app\common\model\Setting::getItem('pc',$wxapp_id)['name'] ?></p>
        </div>
    </div>

</div>

<!-- 移动端导航 -->
<div id="wap-nav">
    <div class="nav-box transition500">
        <div class="wap-header">
            <span class="wapNav-close icon_close"></span>
        </div>

        <ul>
            <li class="active">
                <a href="index.html">首页</a>
                <div class="line transition "></div>
            </li>
            <li>
                <a href="list.html">产品中心</a>

            </li>
            <li>
                <a href="news.html">资讯中心</a>
            </li>

            <li>
                <a href="about.html">关于朴真</a>
            </li>
            <li>
                <a href="contact.html">联系我们</a>
            </li>
            <li>
                <a href="#">厂家登录</a>
            </li>
            <li>
                <div class="nav-search fixed-nav-item-search">搜索</div>
            </li>
        </ul>
    </div>
</div>
<div class="fixed-search">
    <div class="fixed-search-close"></div>
    <div class="fixed-search-form">
        <form action="<?= url('goods/index') ?>" method="post">
            <div class="fixed-search-form-input"><input type="text" placeholder="请输入搜索的内容" name="search"></div>
            <div class="fixed-search-form-submit"><button type="submit">搜索</button></div>
        </form>
    </div>
</div>
<!-- 加载 -->
<div class="fb-loading" style="display: none;">
    <div class="loader-inner ball-clip-rotate-pulse">
        <div></div>
        <div></div>
    </div>
</div>
