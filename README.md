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
<h1>Install:</h1>
<h3>composer require phpworkers/cms<h3>

<h1>Requiremments:</h1>
<ol>
  <li>Laravel 5.4</li>
  <li>laravelcollective/html: ~5.0</li>
  <li>yajra/laravel-datatables-oracle: 7.2</li>
  <li>unisharp/laravel-filemanager: ^1.8</li>
</ol>

<h1>After Install:</h1>
<ol>
  <li>Add following Lines to config/app.php providers array<br>
     //html<br>
        Collective\Html\HtmlServiceProvider::class,<br>
        //datatable<br>
        Yajra\Datatables\DatatablesServiceProvider::class,<br>
    Ramesh\Cms\CmsServiceProvider::class,<br></li>
  <li>Add Following Lines to config/app.php  aliases array<br>
        'Form' => Collective\Html\FormFacade::class,<br>
        'Html' => Collective\Html\HtmlFacade::class,<br>
        'Cms' => Ramesh\Cms\Facades\Cms::class,<br>
  </li>
  <li>run   php artisan vendor:publish          (Publishing css,js,config files,core modules,theme,etc)</li>
  
  
  
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
core is folder,that contain core modules <b>(pre-defind)</b> Module<<br>
<i>Note: Don't change any code of core module's</i>

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
<b>php artisan update:cms-module</b>
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
        string "relative path of plugin" 
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
        object "relative path of helpers" 
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
  </tbody>
</table>