<?php
namespace cms\core\user\helpers;

//helpers
use Auth;
use Session;
use File;
//models
use cms\core\user\Models\UserModel;


//others
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
class User
{
    function __construct()
    {

    }
    /*
     * get active user group
     */
    static function getUserGroup($id=false)
    {
        $user = self::getUser($id);
        if(!$user)
            return false;

        $group = array();
        foreach ($user->group as $groups)
        {
            $group[] = $groups['id'];
        }
        return $group;
    }
    /*
     * get active user group
     */
    static function getUserGroupName($id=false)
    {
        $user = self::getUser($id);

        if(!$user)
            return false;

        $group = array();
        foreach ($user->group as $groups)
        {
            $group[] = $groups['name'];
        }
        return $group;
    }
    /*
     * get active user
     */
    static function getUser($id=false)
    {
        if($id==false)
            $id = Session::get('ACTIVE_USER');

        if(!$id)
            return false;

        return (object) $user = UserModel::with('group')->find($id)->toArray();
    }
    /*
     * check user is super admin
     */
    static function isSuperAdmin($id=false)
    {
        $user = self::getUserGroup($id);
        if(!$user)
            return false;

        return in_array(1,$user);

    }

    /*
     * check user is available or not
     * parameter : $condition : array
     * ['password'] is required
     */

    public static function check($condition)
    {

        if (Auth::attempt($condition))
        {
            return true;
        }

        return false;
    }
    /*
     * check user is login or not
     *
     * not login means redirect to login page
     */
    public static function isLogin()
    {
        $id = Session::get('ACTIVE_USER');
        if(!$id)
            return false;

        return true;
    }
    /*
     * create image
     */
    public function imageCreate($image,$path,$is_admin_view=true)
    {
        if($is_admin_view)
            $path=public_path().DIRECTORY_SEPARATOR.'photos'.DIRECTORY_SEPARATOR.'1'.DIRECTORY_SEPARATOR.$path;
        else
            $path=public_path().DIRECTORY_SEPARATOR.$path;

        if(!File::exists($path)) {
            $result = File::makeDirectory($path,0777, true);

        }
        $ext=$image->getClientOriginalExtension();
        $uploadDirectory=$path.DIRECTORY_SEPARATOR;
        $name=time().rand().".".$ext;
        //echo gettype($uploadDirectory);
        if (!move_uploaded_file($image, $uploadDirectory.$name)) {

            return false;
        }
        else
        {
            $this->createThumbnail($path.DIRECTORY_SEPARATOR,$name,$ext);
            $name = str_replace(public_path(),'',$path.$name);

            $name = str_replace(DIRECTORY_SEPARATOR, '/', $name);

            return $name;
        }
    }

    public function createThumbnail($path_to_image_directory,$hash,$filetype,$width=200) {

        $thumbnailpath = $path_to_image_directory.'thumbs'.DIRECTORY_SEPARATOR;
        if(!File::exists($thumbnailpath)) {
            $result = File::makeDirectory($thumbnailpath , 0777, true);
        }

        if(is_int($width) && $width > 0)
        {
            $filename = $hash;
            if($filetype == "jpg" || $filetype == "jpeg") {
                $im = imagecreatefromjpeg($path_to_image_directory.$filename);
            }else if ($filetype == "png") {
                $im = imagecreatefrompng($path_to_image_directory.$filename);
            }else if ($filetype == "gif") {
                $im = imagecreatefromgif($path_to_image_directory.$filename);
            }

            $ox = imagesx($im);
            $oy = imagesy($im);

            if($ox > 0)
            {
                $final_width_of_image = $width;
                $nx = $final_width_of_image;
                $ny = floor($oy * ($final_width_of_image / $ox));
                $nm = imagecreatetruecolor($nx, $ny);

                $whiteBackground = imagecolorallocate($nm, 255, 255, 255);
                imagefill($nm,0,0,$whiteBackground); // fill the background with white

                imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);

                if($filetype == "jpg" || $filetype == "jpeg") {
                    imagejpeg($nm, $thumbnailpath.$hash,100);
                }else if ($filetype == "png") {
                    imagepng($nm, $thumbnailpath.$hash,9);
                }else if ($filetype == "gif") {
                    imagegif($nm, $thumbnailpath.$hash);
                }
            }
            else
            {
                $sfile = $path_to_image_directory.$hash.".".$filetype;
                $sfilename = $thumbnailpath.$hash.".".$filetype;
                copy($sfile, $sfilename);
            }
        }
    }

    public function deleteImage($path_to_image_directory = "/",$image = "") {
        $fname = $image;
        $thumbnailpath = $path_to_image_directory.'thumbs'.DIRECTORY_SEPARATOR;
        // $fsplit = explode('.',$fname);
        // $fname_small = $fsplit[0]."_small.".$fsplit[1];

        if($this->fileexistcheck($path_to_image_directory,$fname))
            unlink($path_to_image_directory.$fname);

        if($this->fileexistcheck($thumbnailpath,$fname))
            unlink($thumbnailpath.$fname);

    }

    public function fileexistcheck($imagelink = '/', $filename = '')
    {
        if(file_exists($imagelink.$filename))
            return true;
        else
            return false;

    }

    /*
     * upload a file
     */
    public function fileUpload($image,$path,$is_admin_view=true)
    {
        if($is_admin_view)
            $path=public_path().DIRECTORY_SEPARATOR.'photos'.DIRECTORY_SEPARATOR.'1'.DIRECTORY_SEPARATOR.$path;
        else
            $path=public_path().DIRECTORY_SEPARATOR.$path;

        if(!File::exists($path)) {
            $result = File::makeDirectory($path,0777, true);
        }
        $ext=$image->getClientOriginalExtension();
        $uploadDirectory=$path.DIRECTORY_SEPARATOR;
        $name=time().rand().".".$ext;
        //echo gettype($uploadDirectory);
        if (!move_uploaded_file($image, $uploadDirectory.$name)) {
            return false;
        }
        else
        {
            $name = str_replace(public_path(),'',$path.$name);
            $name = str_replace(DIRECTORY_SEPARATOR, '/', $name);
            return $name;
        }
    }


}