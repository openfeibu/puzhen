<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\NavRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use Route;

class NavRepository extends BaseRepository implements NavRepositoryInterface
{

    /**
     * Booting the repository.
     *
     * @return null
     */
    public function boot()
    {
        $this->fieldSearchable = config('model.nav.nav.search');
    }

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return config('model.nav.nav.model');
    }
    public function top($category_id)
    {
        return $this->where(['parent_id' => 0,'category_id' =>$category_id,'is_menu' => 1,'show' => 1])->orderBy('order','asc')->orderBy('id','asc')->get();
    }

    public function topParent($id)
    {
        $nav = $this->where(['id' => $id])->first();
        if($nav->parent_id)
        {
            return $this->topParent($nav->parent_id);
        }
        return $nav;
    }
    public function children($parent_id)
    {
        return $this->where(['parent_id' => $parent_id,'is_menu' => 1,'show' => 1])->orderBy('order','asc')->orderBy('id','asc')->get();
    }
    public function allNavs()
    {
        return $this->where(['show' => 1])->orderBy('order','asc')->orderBy('id','asc')->get();
    }
    /**
     * Permission Menus
     * @return array
     */
    public function navs($category_id)
    {
        $menus = [];
        $father =$this->top($category_id);

        if($father) {
            foreach ($father as $item) {
                $item->active = ($item->slug == Route::currentRouteName()) ? true : false;
                $item = $this->sub($item);
                $menus[] = $item;
            }
        }

        return $menus;
    }
    public function sub($item)
    {
        $sub = $this->children($item->id);
        if(!$sub->isEmpty())
        {
            foreach ($sub as $key => $sub_item)
            {
                $sub_item->active = $sub_item->slug == Route::currentRouteName() ? true : false;
                $sub_item->sub = $this->sub($sub_item);
                $item->active ? true : $item->active  = $sub_item->active;
            }
            $item->sub = $sub;
        }
        return $item;
    }
    public function navList($id,$list=[])
    {
        $nav = $this->model->where('id',$id)->first();
        if(!$nav)
        {
            return $list;
        }
        array_unshift($list,$nav->toArray());
        if($nav->parent_id)
        {
            return $this->navList($nav->parent_id,$list);
        }
        return $list;
    }
    public function navTab($parent_id)
    {
        return $this->children($parent_id);
    }
    /*
    public function navs($category_id)
    {
        $navs = [];
        $top_navs = $this->top($category_id);

        $menus = [];

        if($top_navs) {
            foreach ($top_navs as $item) {

                $active = if_uri(ltrim($item->url,'/')) || if_uri($item->url) || if_uri_pattern($item->url.'/*') || if_uri_pattern(ltrim($item->url,'/').'/*');
                $sub = $this->children($item->id);

                if(!$sub->isEmpty())
                {
                    foreach ($sub as $key => $sub_item)
                    {
                        $sub_item->active = if_uri(ltrim($sub_item->url,'/')) || if_uri($sub_item->url) ;
                        $active ? true : $active  = $sub_item->active;
                    }
                    $item->sub = $sub;
                }
                $item->active = $active ?? false;
                $menus[] = $item;
            }
        }

        return $menus;
    }
    */
}
