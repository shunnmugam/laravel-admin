<?php
namespace cms\core\blog\helpers;

//models
use cms\core\blog\Models\BlogModel;
use cms\core\blog\Models\BlogCategoryModel;
class Blog
{
    /*
     * get single blog using blog title
     */
    public static function getBlog($name)
    {
        $data = BlogModel::with('category')
            ->where('status','=',1)
            ->where('title','=',$name)
            ->first();

        return $data;
    }
    /*
     * get multiple blogs using category
     */
    public static function getBlogByCategory($category)
    {
        $data = BlogModel::whereHas('category', function ($query) use ($category) {
                $query->where('name', '=', $category);
            })
            ->where('status','=',1)
            ->get();
        print_r($data);exit;
        return $data;
    }
}