<?php
Route::get('/',function(){
    return view('layout::site.welcome');
})->name('home');
/*assets*/
Route::get('/assets/{module}/{type}/{file}', [ function ($module, $type, $file) {
    $module = ucfirst($module);

    $path = base_path("cms/local/".Cms::getCurrentTheme()."/$module/resources/assets/$type/$file");

    if (\File::exists($path)) {
        //return response()->download($path, "$file");
        if($type == 'js'){
            return response()->file($path, array('Content-Type' => 'application/javascript'));
        }else{
            return response()->file($path, array('Content-Type' => 'text/css'));
        }
    }

    return response()->json([ ], 404);
}]);
