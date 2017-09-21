<?php
namespace Ramesh\Cms\Controller;


class ModuleController extends CmsController
{
    /*
     * name of the module
     */
    protected $name;

    public function __construct($module_name)
    {
        $this->name = $module_name;
    }

    /*
     * get name of the module
     */
    public function getName()
    {
        return $this->name;
    }
    /*
     * get module json
     */
    public function getJson()
    {

    }
    /*
     * get module path
     */
    public function getPath()
    {
        return base_path().DIRECTORY_SEPARATOR.parent::getPath().DIRECTORY_SEPARATOR.parent::getModulesLocalPath().DIRECTORY_SEPARATOR.$this->name;
    }
    /*
     * get module core path
     */
    public function getCorePath()
    {
        return base_path().DIRECTORY_SEPARATOR.parent::getPath().DIRECTORY_SEPARATOR.parent::getModulesCorePath().DIRECTORY_SEPARATOR.$this->name;
    }

    /**********get configuration values*****************/
    /*
     *
     */
    /*
     * get over all module config
     */
    public function getModuleConfig()
    {
        return parent::getConfig()['module'];
    }



}
