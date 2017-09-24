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
Run Following artisan commands
<ol>
  <li>php artisan vendor:publish          (Publishing css,js,config files,core modules,theme,etc)</li>
  <li>php artisan cms-migrate            (Migrate our tables)</li>
  <li>php artisan update:cms-module      (register modules to table)</li>
  <li>php artisan update:cms-plugins     (register plugins)</li>
  <li>php artisan update:cms-menu        (regiser menus)</li>
