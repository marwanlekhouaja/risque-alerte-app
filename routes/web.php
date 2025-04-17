<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\ReclamationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/import', function () {
    return view('import.importData');
});
Route::post('/import', [App\Http\Controllers\importExcel::class, 'import'])->name('import.excel');    

// Auth routes
Route::get('/login', [App\Http\Controllers\AuthController::class, 'show'])->name('auth.show');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('auth.login');
Route::get('/register', [App\Http\Controllers\AuthController::class, 'show_register_page'])->name('auth.register_page');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('auth.register');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout'); // ✅ corrigé ici

// Admin
Route::get('/admin/panel', [AdminController::class, 'showAdminPanel'])->name('admin.panel');
Route::get('/admin/profile', [AdminController::class, 'editProfile'])->name('admin.profile')->middleware('auth');
Route::put('/admin/profile/update', [AdminController::class, 'updateProfile'])->name('admin.updateProfile')->middleware('auth');

Route::get('/incidents/liste', [IncidentController::class, 'liste'])->name('incidents.liste'); // add ->middleware('auth') si besoin

// App protected routes
Route::resource('users', App\Http\Controllers\UserController::class)->middleware('auth'); 
Route::resource('incidents', IncidentController::class);   
Route::resource('reclamations', ReclamationController::class)->middleware('auth');
Route::resource('categories', App\Http\Controllers\CategorieController::class)->middleware('auth');
// Public OR protected route — selon ton choix

// fallback
Route::fallback(function () {
    return redirect()->route('auth.show')->withErrors('Vous devez être connecté pour accéder à cette page.');
});
 ?>