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
      <li>Core</li>
      <li>Local</li>
      <li>What is Module?</li>
      <li>List of core modules</li>
      <li>Artisian Commands</li>
      <li>Skin</li>
      <li>Helper</li>
      <li>Core Helper functions</li>
      <li>Plugins</li>
    </ul>
