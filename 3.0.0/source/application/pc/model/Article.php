<?php

namespace app\pc\model;

use app\api\model\Article as ApiArticleModel;
use app\common\exception\BaseException;


/**
 * 文章模型
 * Class Article
 * @package app\api\model
 */
class Article extends ApiArticleModel
{

    public static function detail($article_id)
    {
        try{
            return parent::detail($article_id);
        }catch (\Exception $e)
        {
            return false;
        }

    }

}