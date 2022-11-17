<?php

namespace app\pc\controller;

use app\pc\model\Article as ArticleModel;
use app\pc\model\article\Category as CategoryModel;

/**
 * 产品分类控制器
 * Class Goods
 * @package app\api\controller
 */
class Article extends Controller
{

    /**
     * 文章详情
     * @param $article_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function detail($article_id)
    {
        $detail = ArticleModel::detail($article_id);
        return $this->fetch('detail', compact('detail'));
    }

    public function contact()
    {
        return $this->fetch('contact');
    }
}