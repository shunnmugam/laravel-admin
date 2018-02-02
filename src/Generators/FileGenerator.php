<?php
namespace Ramesh\Cms\Generators;
use File;
use Storage;
use Cms;
use Illuminate\Filesystem\Filesystem;

use Ramesh\Cms\Exceptions\FileAlreadyExistException;

class FileGenerator
{
    /*
     *protected modulename
     */
    protected $modulename;
    /*
     * protected class
     */
    protected $classname;
    /*
     * protected namespace
     */
    protected $namespace;
    /*
    *protected tablename
    */
    protected $tablename;
    /*
     * protected event
     */
    protected $event;
    /*
     * protected path
     */
    protected $path;
    /*
     * temprory variable
     */
    protected $temprory;
    public $filename;

    /*****************Objects*****************/
    /*
     * filesystem
     */
    protected  $filesystem;
    /*******************File variable*******************/
    /*
     * controller
     */
    protected $content = false;
    /*
     * set module name
     */
    public function setModule($modulename)
    {
        $this->modulename = $modulename;
        return $this;
    }
    /*
     * set class name
     */
    public function setClass($classname)
    {
        $this->classname = $classname;
        return $this;
    }
    /*
     * set namespace
     */
    public function setNamespace($namespace)
    {
      if (DIRECTORY_SEPARATOR == '/') {
        $namespace = str_replace('/', '\\', $namespace);
      }

      // if (DIRECTORY_SEPARATOR == '\\') {
      //   // windows
      // }
        $this->namespace = $namespace;
        return $this;
    }
    /*
     * set event
     */
    public function setEvent($eventname)
    {
        $this->event = $eventname;
        return $this;
    }
    /*
     * set module path
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }


    /*
     * make controller file from stub
     */

    public function MakeController($resource=false)
    {
        if($resource)
            $filename = __DIR__.'/../stubs/module/Controllers/ModuleRController.stub';
        else
            $filename = __DIR__.'/../stubs/module/Controllers/ModuleController.stub';

        $contents = File::get($filename);
        $this->setNamespace('cms'.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Controllers');
        $contents = $this->changeNamespace($contents);
        $contents = $this->changeClass($contents);
        $this->content = $contents;
        $this->makePath('Controllers');

        $this->setPath($this->path.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR.$this->classname.".php");
        return $this;
    }
    /*
     * make controller file from stub
     */

    public function MakeModel()
    {
        $filename = __DIR__.'/../stubs/module/Models/Model.stub';

        $contents = File::get($filename);
        $this->setNamespace('cms'.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Models');
        $contents = $this->changeNamespace($contents);
        $contents = $this->changeClass($contents);
        $this->content = $contents;
        $this->makePath('Models');

        $this->setPath($this->path.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Models'.DIRECTORY_SEPARATOR.$this->classname.".php");

        return $this;
    }
    /*
     * make migration file from stub
     */

    public function MakeMigration($create=false,$table=false)
    {
        if($create){
            $this->tablename = $create;
            $filename = __DIR__.'/../stubs/module/Database/Migration/createmigtration.stub';
        }
        elseif ($table) {
            $this->tablename = $table;
            $filename = __DIR__.'/../stubs/module/Database/Migration/tablemigration.stub';
        }
        else
            $filename = __DIR__.'/../stubs/module/Database/Migration/Migration.stub';

        $contents = File::get($filename);
        $this->temprory = $this->classname;
        $this->classname = $this->dashesToCamelCase($this->classname);
        $contents = $this->changeClass($contents);
        $contents = $this->changeTable($contents);
        $this->content = $contents;
        $this->makePath('Database'.DIRECTORY_SEPARATOR.'Migration');

        $this->filename = date("Y_m_d").'_'.time().'_'.$this->temprory;
        $this->setPath($this->path.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Database'.DIRECTORY_SEPARATOR.'Migration'.DIRECTORY_SEPARATOR.$this->filename.".php");

        return $this;
    }
    /*
     * make command
     */
    public function MakeCommand()
    {
        $filename = __DIR__.'/../stubs/module/Console/Commands/command.stub';

        $contents = File::get($filename);
        $this->setNamespace('cms'.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Console'.DIRECTORY_SEPARATOR.'Commands');
        $contents = $this->changeNamespace($contents);
        $contents = $this->changeClass($contents);
        $this->content = $contents;
        $this->makePath('Console'.DIRECTORY_SEPARATOR.'Commands');

        $this->setPath($this->path.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Console'.DIRECTORY_SEPARATOR.'Commands'.DIRECTORY_SEPARATOR.$this->classname.".php");

        return $this;
    }
    /*
     * make event
     */
    public function MakeEvent()
    {
        $filename = __DIR__.'/../stubs/module/Events/event.stub';

        $contents = File::get($filename);
        $this->setNamespace('cms'.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Events');
        $contents = $this->changeNamespace($contents);
        $contents = $this->changeClass($contents);
        $this->content = $contents;
        $this->makePath('Events');

        $this->setPath($this->path.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Events'.DIRECTORY_SEPARATOR.$this->classname.".php");

        return $this;
    }
    /*
     * make event
     */
    public function MakeJob()
    {
        $filename = __DIR__.'/../stubs/module/Jobs/job.stub';

        $contents = File::get($filename);
        $this->setNamespace('cms'.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Jobs');
        $contents = $this->changeNamespace($contents);
        $contents = $this->changeClass($contents);
        $this->content = $contents;
        $this->makePath('Jobs');

        $this->setPath($this->path.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Jobs'.DIRECTORY_SEPARATOR.$this->classname.".php");

        return $this;
    }
    /*
     * make event listener
     */
    public function MakeListener()
    {
        $filename = __DIR__.'/../stubs/module/Listeners/listener.stub';

        $contents = File::get($filename);
        $this->setNamespace('cms'.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Listeners');
        $contents = $this->changeNamespace($contents);
        $contents = $this->changeClass($contents);
        $contents = $this->changeEvent($contents);
        $contents = $this->changeEventPath($contents);
        $this->content = $contents;
        $this->makePath('Listeners');

        $this->setPath($this->path.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Listeners'.DIRECTORY_SEPARATOR.$this->classname.".php");

        return $this;
    }
    /*
     * make mail
     */
    public function MakeMail($view='view.name',$markdown=false)
    {
        $filename = __DIR__.'/../stubs/module/Mail/mail.stub';

        $contents = File::get($filename);
        $this->setNamespace('cms'.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Mail');
        $contents = $this->changeNamespace($contents);
        $contents = $this->changeClass($contents);
        $contents = $this->changeEvent($contents);
        $contents = $this->changeEventPath($contents);
        if($markdown)
            $contents = $this->changeStrings($contents,'{text}','markdown("'.$markdown.'")');
        else
            $contents = $this->changeStrings($contents,'{text}','view("'.(($view == false) ? "view.name" : $view).'")');
        $this->content = $contents;
        $this->makePath('Mail');

        $this->setPath($this->path.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Mail'.DIRECTORY_SEPARATOR.$this->classname.".php");

        return $this;
    }
    /*
     * make mail
     */
    public function MakeNotification($markdown=false)
    {
        $filename = __DIR__.'/../stubs/module/Notifications/notification.stub';

        $contents = File::get($filename);
        $this->setNamespace('cms'.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Notifications');
        $contents = $this->changeNamespace($contents);
        $contents = $this->changeClass($contents);
        $contents = $this->changeEvent($contents);
        $contents = $this->changeEventPath($contents);
        if($markdown)
            $contents = $this->changeStrings($contents,'{text}','markdown("'.$markdown.'")');
        else {
            $text = "line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!')";
            $contents = $this->changeStrings($contents, '{text}', $text);
        }
        $this->content = $contents;
        $this->makePath('Notifications');

        $this->setPath($this->path.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Notifications'.DIRECTORY_SEPARATOR.$this->classname.".php");

        return $this;
    }
    /*
     * make middleware
     */
    public function MakeMiddleware()
    {
        $filename = __DIR__.'/../stubs/module/Middleware/middleware.stub';

        $contents = File::get($filename);
        $this->setNamespace('cms'.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Middleware');
        $contents = $this->changeNamespace($contents);
        $contents = $this->changeClass($contents);
        $this->content = $contents;
        $this->makePath('Middleware');

        $this->setPath($this->path.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Middleware'.DIRECTORY_SEPARATOR.$this->classname.".php");

        return $this;
    }
    /*
     * make middleware
     */
    public function MakeProvider()
    {
        $filename = __DIR__.'/../stubs/module/Providers/provider.stub';

        $contents = File::get($filename);
        $this->setNamespace('cms'.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Providers');
        $contents = $this->changeNamespace($contents);
        $contents = $this->changeClass($contents);
        $contents = $this->changeStrings($contents,'{module}',$this->modulename);
        $this->content = $contents;
        $this->makePath('Providers');

        $this->setPath($this->path.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Providers'.DIRECTORY_SEPARATOR.$this->classname.".php");

        return $this;
    }
    /*
     * make middleware
     */
    public function MakeSeeder()
    {
        $filename = __DIR__.'/../stubs/module/Database/Seeds/seeder.stub';

        $contents = File::get($filename);
        $this->setNamespace('cms'.DIRECTORY_SEPARATOR.Cms::getModulesPath().DIRECTORY_SEPARATOR.Cms::getCurrentTheme().DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Database'.DIRECTORY_SEPARATOR.'seeds');
        $contents = $this->changeNamespace($contents);
        $contents = $this->changeClass($contents);
        $this->content = $contents;
        $this->makePath('Database'.DIRECTORY_SEPARATOR.'seeds');

        $this->setPath($this->path.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Database'.DIRECTORY_SEPARATOR.'seeds'.DIRECTORY_SEPARATOR.$this->classname.".php");

        return $this;
    }
    /*
     * make module.json
     */
    public function makeModuleJson()
    {
        $filename = __DIR__.'/../stubs/module/module.stub';

        $contents = File::get($filename);
        $contents = $this->changeClass($contents);
        $contents = $this->changeStrings($contents,'{module}',$this->modulename);
        $contents = $this->changeStrings($contents,'{C-module}',ucfirst($this->modulename));
        $this->content = $contents;
        $this->makePath('');
        $this->setPath($this->path.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR."module.json");
        return $this;
    }
    /*
     * make module.json
     */
    public function makeModuleComposer()
    {
        $filename = __DIR__.'/../stubs/module/composer.stub';

        $contents = File::get($filename);
        $contents = $this->changeClass($contents);
        $contents = $this->changeStrings($contents,'{module}',$this->modulename);
        $this->content = $contents;
        $this->makePath('');
        $this->setPath($this->path.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR."composer.json");
        return $this;
    }
    /*
     * Namespace change
     */
    protected function changeNamespace($file)
    {
        return str_replace("{namespace}",$this->namespace,$file);
    }
    /*
     * Class change
     */
    protected function changeClass($file)
    {
        return str_replace("{class}",$this->classname,$file);
    }
    /*
    *change table in migration file
    */
    protected function changeTable($file)
    {
        return str_replace("{table}",$this->tablename,$file);
    }
    /*
    *change table in migration file
    */
    protected function changeEvent($file)
    {
        return str_replace("{event}",$this->event,$file);
    }
    /*
    *change table in migration file
    */
    protected function changeEventPath($file)
    {
        return str_replace("{eventpath}",'cms'.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.'Events'.DIRECTORY_SEPARATOR.$this->event,$file);
    }
    /*
     * change strings
     */
    protected function changeStrings($file,$from_string,$to_string)
    {
        return str_replace($from_string,$to_string,$file);
    }
    /*
     * make path
     */
    protected function makePath($pathname)
    {
        $path = $this->path.DIRECTORY_SEPARATOR.$this->modulename.DIRECTORY_SEPARATOR.$pathname;
        if (!File::exists($path))
        {
            File::makeDirectory($path, 0777, true, true);
        }
    }
    /*
     * final creation
     */
    public function create()
    {
        $path = $this->path;
       // echo $path;exit;
        /*check file exits or not*/
        $this->fileCheck($path);
        File::put($path,$this->content);

    }

    /*
     * file check
     */
    protected function fileCheck($path)
    {
        $this->filesystem = new Filesystem();
        if ($this->filesystem->exists($path)) {
            throw new FileAlreadyExistException('File already exists!');
        }


    }

    /*********************common functions************************/
    /*
     * make camelcase word
     */
    protected function dashesToCamelCase($string)
    {
        $str = str_replace('_', '', ucwords($string, '_'));
        return $str;
    }

}
