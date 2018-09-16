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
     * get single blog using blog id
     */
    public static function getBlogById($id)
    {
        $data = BlogModel::with('category')
            ->where('status','=',1)
            ->where('id','=',$id)
            ->first();

        return $data;
    }
    /*
     * get multiple blogs using category
     */
    public static function getBlogByCategory($category,$paginate=false)
    {
        $data = BlogModel::whereHas('category', function ($query) use ($category) {
            if(is_array($category))
                $query->whereIn('id', $category);
            else
                $query->where('id', '=', $category);
        })
            ->where('status','=',1);
        if($paginate==false)
            $data =$data->get();
        else
            $data = $data->paginate($paginate);

        if(count((array) $data)==0)
            $data = array();
        elseif ($paginate==false)
            $data = $data->toArray();

        return $data;
    }

    public static function getCategoryByParent($parent)
    {
        $data =  BlogCategoryModel::where('parent','=',$parent)->get();

        if(count((array) $data)==0)
            $data = array();
        else
            $data = $data->toArray();

        return $data;
    }

    /*
     * get category by name
     */
    public static function getCategory($name)
    {
        $data =  BlogCategoryModel::where('name','=',$name)->first();

        if(count((array) $data)==0)
            $data = array();
        else
            $data = $data->toArray();

        return $data;
    }
    /*
     * get category by id
     */
    public static function getCategoryById($id)
    {
        $data =  BlogCategoryModel::where('id','=',$id)->first();

        if(count((array) $data)==0)
            $data = array();
        else
            $data = $data->toArray();

        return $data;
    }
    /*
     * get category tree
     */
    public static function getCategoryTree($start=0)
    {
        $data =  BlogCategoryModel::where('status','=',1)->get();

        if(count((array) $data)!=0)
        {
            return self::buildTree($data->toArray(),$start);
        }
    }


    protected static function buildTree(array $elements, $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['parent'] == $parentId) {
                $children = self::buildTree($elements, $element['id']);
                if ($children) {
                    $element['child'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }
}