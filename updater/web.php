Route::prefix('update')->group(function() {
  Route::get('/version', 'UpdateController@upversion')->name('update.version');
});