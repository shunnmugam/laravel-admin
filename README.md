<h1>Content Management System using laravel framework</h1>

<h1>Features:</h1><ol>
<li>Cms</li>
<li>Admin interface</li>
<li>Module based app</li>
<li>Theme based</li>
<li>Plugins</li>
<li>Roles and Permissions</li>
<li>Menu creation</li>
<li>User Management</li>
<li>Page Creation</li>
<li>Mail configurations</li>
<li>Site Configuration,etc</li>
</ol>

<h1>Version</h1>
<table>
<thead>
<tr><th>Laravel Version</th><th>Version</th></tr>
</thead>
<tbody>
<tr><td>5.4</td><td>1.0 to 2.0</td></tr>
<tr><td>5.5</td><td>>=2.1</td></tr>
<tr><td>5.6</td><td>>=2.1</td></tr>
<tr><td>5.7</td><td>>=2.1</td></tr>
<tr><td>5.8</td><td>>=2.2</td></tr>
<tr><td>6</td><td>>=2.3</td></tr>
<tr><td>7</td><td>>=2.3</td></tr>
<tr><td>8</td><td>>=2.4</td></tr>
</tbody>
</table>
<h1>Change Logs</h1>
<h3>Version v2.4</h3>
<ol>
  <li>Data table version update</li>
  <li>Seed command bug fix</li>
</ol>
<h3>Version v2.2</h3>
<ol>
  <li>Data table version update</li>
  <li>Bug fix</li>
</ol>
<h3>Version v2.1.1</h3>
<ol>
<li>CRUD Module added<br />
  easy crud module with single command<br />
  <b>php artisan make:cms-module {module-name} {--crud}</b><br />
  eg: <br />
  <code>php artisan make:cms-module test --crud</code><br />
</li>
<li>CRUD view<br />
  create crud views using artisan command<br />
  <b>php artisan make:cms-crudviews</b><br/>
  it will create 2 file inside resources/views/admin<br />
  <ol>
    <li>index.blade.php</li>
    <li>edit.blade.php</li>
  </ol>
  </li>
</ol>
<h1>Install:</h1>
<h3>composer require phpworkers/cms<h3>

<h1>Requiremments:</h1>
<ol>
  <li>Laravel 5.4 or later</li>
  <li>laravelcollective/html: ~5.0</li>
  <li>yajra/laravel-datatables-oracle: ~9.0</li>
  <li>unisharp/laravel-filemanager: ^1.8</li>
</ol>

<h1>After Install:</h1>
<ol>
  <li>Add following Lines to config/app.php providers array<br>
     //html<br>
        Collective\Html\HtmlServiceProvider::class,<br>
        //datatable<br>
        Yajra\DataTables\DatatablesServiceProvider::class,<br>
    Ramesh\Cms\CmsServiceProvider::class,<br></li>
  <li>Add Following Lines to config/app.php  aliases array<br>
        'Form' => Collective\Html\FormFacade::class,<br>
        'Html' => Collective\Html\HtmlFacade::class,<br>
        'Cms' => Ramesh\Cms\Facades\Cms::class,<br>
  </li>
  <li>run   php artisan vendor:publish          (Publishing css,js,config files,core modules,theme,etc)</li>
  <li>run   php artisan vendor:publish --provider="UniSharp\LaravelFilemanager\LaravelFilemanagerServiceProvider"       (Publishing filemanager resources)</li>
  
  
  
  <li>Run Following commands</li>
  <li>composer dump-autoload</li>
  <li>php artisan cms-migrate            (Migrate our tables)</li>
  <li>php artisan db:cms-seed    (Seeding)
  <li>php artisan update:cms-module      (register modules to table)</li>
  <li>php artisan update:cms-plugins     (register plugins)</li>
  <li>php artisan update:cms-menu        (regiser menus)</li>
  <li>Open your web.php<br>
    Remove Following Lines(route)<br>
    Route::get('/', function () {<br>
      return view('welcome');<br>
    });</br>
  </li>
  <li>now go to your site(localhost:8000)</li>
  <li>localhost:8000/administrator<br>
  <h3>Username : admin </h3>
  <h3>Password : admin123</h3>
  </li>
</ol>
<h1>Documents</h1>
    <ul>
      <li>Folder Structure</li>
      <li>Theme</li>
      <li>What is Module?</li>
      <li>Core</li>
      <li>Local</li>
      <li>List of core modules</li>
      <li>Create Own module
      <li>Artisian Commands</li>
      <li>Skin</li>
      <li>Helper</li>
      <li>Core Helper functions</li>
      <li>Plugins</li>
    </ul>
<h3>Folder Structure</h3>
<p>
  <h4>Main path</h4>
<br>
  cms (main)<br>
    |<br>
    |__core<br>
    |  |<br>
    |  |__core modules<br>
    |<br>
    |<br>
    |__local<br>
     &nbsp|<br>
     &nbsp|__themes<br>
     &nbsp&nbsp|<br>
     &nbsp&nbsp|__local modules<br>



  1.cms : cms path is the main path of our app,that contain 

      1.1 : core
      1.2 : local

    1.1 : core : core path is core module path ,that contain number of core modules,avoid to write core modules

        1.1.1 : core modules -> core path contain number of core modules

    1.2 : local : local path contain theme,we can create multiple theme

      1.2.1 : local modules -> theme path contain number of local module(user create module)
</p>
<h4>Skin path</h4>
<br>
<p>
  public
    public (main)<br>
    |<br>
    |_skin<br>
    &nbsp;|<br>
    &nbsp;|__theme name<br>
    &nbsp;&nbsp;&nbsp;|<br>
    &nbsp;&nbsp;&nbsp;|__css,js,vendor,fonts,etc <br>
    
    1 : public ->public folder is default folder in laravel

        1.1 : skin -> skin folder is our assets folder

        1.1.1 : theme name -> folder name is theme name , that contain css, fonts ,js,etc
</p>
<h3>
  Theme
</h3>
Theme is main part of our package,we can create multiple theme,our package is theme and moduler based,all theme is placed on cms->local folder <br>
Default theme is <b>theme1</b>

<h4>Create Theme</h4>
  Just create new folder inside of cms->local.<br>

<h4>Change theme</h4>
  If you want to change theme?its very easy <br>
  Go to adminpanel->site configuration->change theme <br>
<br>
<br>
<h3>Modules</h3>
Module is is a mechanism to group controller, views, modules, etc that are related, otherword module is pice of code or package of laravel

<h3>Core</h3>
core is folder,that contain core modules <b>(pre-defind)</b> Module<br>
<i>Note: Don't change any code of core module's </i>

<h3>Local</h3>
local folder contain local module,which is created by user

<h3>Create own module</h3>
<b>php artisan make:cms-module {module-name} </b>
<br>
eg : <b>php artisan make:cms-module helloworld</b>
<br>helloworld module is created under current theme folder
<br>
then register our module to database for feature use
<br>
<b>php artisan update:cms-module</b> <br />
<h5>Where is the entry point (provider) of the module?</h5>
open provider folder under cms/local/{module} <br />
that provider is same as laravel provider so boot and register method is important and additionaly we have some functions <br />
<ol>
  <li>
    registerRoot   -> registerRoot method is used to registreing our custom module routes
  </li>
  <li>
    registerAdminRoot -> registerAdminRoot method is used to registering our custom module admin routes
  </li>
  <li>
    registerViews -> registerViews method is used to registering our custom module views
  </li>
</ol>
if you want to enable this method,just uncommands calls inside register method of your provider
thats all :) ,lets see files in modules,<br>
<ol>
<li>module.json ->file</li>
<li>composer.json ->file</li>
<li>menu.xml -> file</li>
<li>routes.php -> file</li>
<li>adminroutes -> file</li>
<li>Controller  -> folder</li>
<li>Database ->folder</li>
<li>Models -> folder</li>
<li>config -> folder</li>
<li>resourcesc-> folder</li>
<li>Events -> folder</li>
<li>Listeners -> folder</li>
<li>Mail -> folder</li>
<li>Middleware -> folder</li>
<li>helpers ->folder</li>
</ol>

<h4>module.json</h4>
<code>
  {
  "name": "helloworld",
  "version": "0.0.1",
  "type" : "local",
  "providers": [
    "Providers\\HelloworldServiceProvider"
  ]
}

</code>
<br>
<table>
  <thead>
    <tr>
      <th>
        Parameter
      </th>
      <th>
        Data type
      </th>
      <th>
        Use
      </th>
      <th>
        is optional?
      </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
        name
      </td>
      <td>
        string 
      </td>
      <td>
        name of the module
      </td>
      <td>
        NO
      </td>
    </tr>
    <tr>
      <td>
        version
      </td>
      <td>
        string 
      </td>
      <td>
        version of the module
      </td>
      <td>
        NO
      </td>
    </tr>
    <tr>
      <td>
        type
      </td>
      <td>
        string (core/local) 
      </td>
      <td>
        type of the module
      </td>
      <td>
        NO
      </td>
    </tr>
    <tr>
      <td>
        providers
      </td>
      <td>
        Array 
      </td>
      <td>
        Provider of this module,provider is register point of our module
      </td>
      <td>
        NO
      </td>
    </tr>
    <tr>
      <td>
        plugins
      </td>
      <td>
        string (relative path of plugin)
      </td>
      <td>
        plugin path,that used to defind plugin
      </td>
      <td>
        YES
      </td>
    </tr>
    <tr>
      <td>
        helpers
      </td>
      <td>
        object (relative path of helpers)
      </td>
      <td>
        helpers path,that used to defind helpers,helpers contain common functions,we can use any where
        <br>
        eg:<br>
        <code>
          "helpers" : {
              "HelperName1":"cms\\core\\blog\\helpers\\Blog",
              "HelperName2":"some path",
              ....
            }
        </code>
      </td>
      <td>
        YES
      </td>
    </tr>
    <tr>
      <td>
        search
      </td>
      <td>
        object (relative path of search class)
      </td>
      <td>
        search path,that used to defind search helper,search class functions, this is used to make our module is searchable
        <br>
        eg:<br>
        <code>
          "helpers" : {
              "HelperName1":"cms\\core\\blog\\helpers\\Blog",
              "HelperName2":"some path",
              ....
            }
        </code>
      </td>
      <td>
        YES
      </td>
    </tr>
    <tr>
      <td>configuration</td>
      <td>string (view file path of configuration)</td>
      <td>configuration is used to view or edit module configuration
        eg:<br />
        <code>
          "configuration" : "user::admin.configuration.configuration",
        </code>
        <br />
        Above example is taken from user module,that mean user configuration is place on cms/core/user/admin/configuration/configuraion.blade.php
      </td>
      <td>
        YES
      </td>
    </tr>
    <tr>
      <td>configuration_data</td>
      <td>string (configuration data function path)</td>
      <td>configuration data is get module configuration from function,its define function name,this function should return module configuration<br />
        eg:<br />
        <code>
          "configuration_data" : "\\cms\\core\\user\\Controllers\\UserController@getConfigurationData"
        </code>
        <br />
        Above example is taken from user module, <br />
        that mean user configuration function is place on <b>cms/core/user/controller/UserController.php <b>and function name is <b>getConfigurationData</b>
        <br />
        <code>
          /* <br />
           * configurations option<br />
           */<br />
          public function getConfigurationData()<br />
          {<br />
              $group = UserGroupModel::where('status',1)->where('id','!=',1)->orderBy('group','Asc')->pluck("group","id");<br />
              return ['user_group'=>$group];<br />
          }<br />
        </code>
        <br />
        Above function return available user groups
      </td> 
      <td>
        YES
      </td>
    </tr>
  </tbody>
</table>
<h4>composer.json</h4>
<code>
  {
  "name": "cms/user",
  "description": "",
  "authors": [
    {
      "name": "Ramesh",
      "email": "shunramit@gmail.com"
    }
  ],
  "autoload": {
    "psr-4": {     
    }
  }
}
</code><br />
composer.json file is contain detail about module and author and that contain autoload
<br />
just leave it this one, we will add autoload feature in later
<br />
<h4>menu.xml</h4>
menu.xml is used for add menu and menu group in adminpanel like joomla menu
<br />
<pre class='brush: xml;'>
  &lt; ?xml version="1.0" encoding="utf-8"? &gt;
 &lt;menus>
     &lt;group name="General" order="0">
         &lt;menugroup name="Users" icon="fa fa-user" order="0">
             &lt;menu name="View Users" route="user.index" />
             &lt;menu name="Add User" route="user.create" />
          &lt;/menugroup>
      &lt;/group>
  &lt;/menus>
</pre>
<table>
  <thead>
    <tr>
      <th>
        Tag
      </th>
      <th>
        Use
      </th>
      <th>
        Parent
      </th>
      <th>
        Attributes
      </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
         <code>&lt;menus></code>
      </td>
      <td>
        menus tag is main tag of the menu.xml,that is bootstarp of menu.xml
      </td>
      <td>
        NULL
      </td>
      <td>
        NULL
      </td>
    </tr>
    <tr>
      <td>
         <code>&lt;group></code>
      </td>
      <td>
        group tag is defind menu type,default type is general,you can create own group using name attribute
      </td>
      <td>
        <code>&lt;menus></code>
      </td>
      <td>
        <ul>
          <li>name <br />
            name attribute is defind name of the menu type<br />
            name is mandtory attribute
          </li>
          <li>
            order <br />
            order attribute defind order of the menutype
          </li>
        </ul>
      </td>
    </tr>
    <tr>
      <td>
         <code>&lt;menugroup></code>
      </td>
      <td>
        menugroup tag is defind menu group for example user module menus is placed under user menugroup
        <i>Menugroup is optional</i>
      </td>
      <td>
        <code>&lt;menus></code>
      </td>
      <td>
        <ul>
          <li>name <br />
            name attribute is defind name of the menu group<br />
            name is mandtory attribute
          </li>
          <li>
            order <br />
            order attribute defind order of the menu group
          </li>
        </ul>
      </td>
    </tr>
    <tr>
      <td>
         <code>&lt;menu></code>
      </td>
      <td>
        menu tag is used to give a link otherword its just clickable link
      </td>
      <td>
        <code>&lt;menus> OR &lt;menugroup> </code>
      </td>
      <td>
        <ul>
          <li>name <br />
            name attribute is defind name of the menu group<br />
            name is mandtory attribute
          </li>
          <li>icon <br />
            icon attribute is used to add font awsome icon<br />
          </li>
          <li>route <br />
            route attribute is accept named route<br />
            <i>if you want add url?just use <b>is_url </b> attribute <br />
              eg : <br />
              <code>
                &lt;menu name="Module Configurations" route="/administrator/configurations/module/1" is_url="1"/>
              </code>
            </i>
          </li>
          <li>is_url <br />
            is_url attribute is used to identify given menu route is url or named route,if is_url="1" means given route is url otherwise given route is named roue
          </li>
          <li>
            order <br />
            order attribute defind order of the menu group
          </li>
        </ul>
      </td>
    </tr>
  </tbody>
</table>
<h4>
  routes.php
</h4>
<p>routes.php file contain routes of the frontend app exclude admin routes<br />
don't have routes.php?,just create it.. :) <br />
if you don't like file name?<br />
we have good solution for you <br />
go to your module main provider and find registerRoot function then change it <br />
</p>
<h4>adminroutes.php</h4>
<p>
  adminroutes.php file contain routes of the admin <br />
  this file is include admin middlewares and admin route group with administrator prefix<br />
  if you dont want admin middleware of current module <br />
  go to your module provider and find registerAdminRoot method and remove middleware
</p>
<h4>Folders of the modules</h4>
<table>
  <thead>
    <tr>
      <th>
        Name
      </th>
      <th>
        Use
      </th>
      <th>
        Sub-folders
      </th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
        Controller
      </td>
      <td>
        controller folder contain controllers
      </td>
      <td>
        -
      </td>
    </tr>
    <tr>
      <td>
        Database
      </td>
      <td>
        Database folder contain migrations and seeds
      </td>
      <td>
        Migration  -> that contain migrations
        Seeds  -> that contain seeds
      </td>
    </tr>
    <tr>
      <td>Models</td>
      <td>Models folder contain Models class</td>
      <td>-</td>
    </tr>
    <tr>
      <td>helpers</td>
      <td>helpers folder contain helpers class</td>
      <td>-</td>
    </tr>
    <tr>
      <td>providers</td>
      <td>providers folder contain providers class</td>
      <td>-</td>
    </tr>
    <tr>
      <td>resources</td>
      <td>resources folder contain assets and views</td>
      <td>views,assets</td>
    </tr>
    <tr>
      <td>Mail</td>
      <td>Mail folder contain Mail class</td>
      <td>-</td>
    </tr>
    <tr>
      <td>Events</td>
      <td>Events folder contain Events class</td>
      <td>-</td>
    </tr>
    <tr>
      <td>Listeners</td>
      <td>Listeners folder contain Listeners class</td>
      <td>-</td>
    </tr>
    <tr>
      <td>Middleware</td>
      <td>Middleware folder contain Middleware class</td>
      <td>-</td>
    </tr>
    <tr>
      <td>Console</td>
      <td>Console folder contain artisan comands</td>
      <td>Commands</td>
    </tr> 
    <tr>
      <td>config </td>
      <td>config folder contain config array like roles (deprecated) and mailer configurations</td>
      <td>-</td>
    </tr>
  </tbody>
</table>
<h3>Artisian Commands</h3>
<p>we provide more artisan commands</p>
<p>imagin we have more than 30 artisan commands,its not remebarable,but you know default laravel commands so we have some idea,we added one common word for all laravel commands,thats it,now easily you can remember our commands</p>
eg: <br />
default command for creating laravel controller is <br />
<b>php artisan make:controller {controller-name} </b>
<br />
our comand is <br />
<b>php artisan make:<u>cms-</u>controller {controller-name} <u>{module-name}</u></b>
<br />
deafult migrate command is <br>
<b>php artisan migrate</b>
our migrate command is <br>
<b>php artisan cms-migrate</b> <br>
and one more we have our own commands,its not high count,but very usefull
<h4>List of our commands</h4>
<ol>
  <li>
    <b>php artisan make:cms-module {module-name}</b>
    <br />
    this is used to make new module
  </li>
  <li>
    <b>php artisan update:cms-menu</b> <br>
    this command is used to update or register menus
  </li>
</ol>
<h4>create new artisan commands for your module</h4>
if you want create new comand <br />
<b>php artisan make:cms-command {command-name} {module-name}</b>
<br>
file is created under console/commands folder inside of your module
<br>
<h4>how to enable own commands?</h4>
<br>
open your module provider then create commands array <br>
eg : 
<br />
<pre>
    /*
     * artisan command
     */
    protected $commands = [
        'cms\core\{module-name}\Console\Commands\{Commandclass}'
    ];
</pre>
please replace module-name and commandclass like
<pre>
    /*
     * artisan command
     */
    protected $commands = [
        'cms\core\menu\Console\Commands\AdminMenu'
    ];
</pre>
<br>
then create method <br>
<pre>
    /*
     * register commands
     */
    protected function registerCommand()
    {
        $this->commands($this->commands);
    }
</pre>
then add following line to register method
<pre>
  $this->registerCommand();
</pre>
eg:
<pre>
  public function register()
  {
      $this->registerViews();
      $this->registerRoot();
      $this->registerAdminRoot();
      $this->registerCommand();
  }
</pre>

<h1>What is next?</h1>
  now i am working on moving this package to react,V3.O will release soon

