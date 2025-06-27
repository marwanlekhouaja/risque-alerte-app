<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientServiceController;
use App\Http\Controllers\importExcel;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\IncidentControllerForClient;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ReclamationController;
use App\Models\Incident;
use Carbon\Traits\Localization;
use GeoIp2\Record\Location;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// routes of import
Route::get('/import', function () {
    return view('import.importData');
})->middleware(['auth','admin']);
Route::post('/import', [App\Http\Controllers\importExcel::class, 'import'])->name('import.excel');
Route::post('/import/auto', [importExcel::class, 'autoImport'])->name('import.auto');


// Auth routes
Route::get('/', [App\Http\Controllers\AuthController::class, 'show'])->name('auth.show');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('auth.login');
Route::get('/register', [App\Http\Controllers\AuthController::class, 'show_register_page'])->name('auth.register_page');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('auth.register');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
// Admin
Route::get('/admin/panel', [AdminController::class, 'showAdminPanel'])->name('admin.panel');
Route::get('/admin/profile', [AdminController::class, 'editProfile'])->name('admin.profile')->middleware('auth');
Route::put('/admin/profile/update', [AdminController::class, 'updateProfile'])->name('admin.updateProfile')->middleware('auth');

Route::get('/incidents/liste', [IncidentController::class, 'liste'])->name('incidents.liste'); // add ->middleware('auth') si besoin

// App protected routes
Route::resource('users', App\Http\Controllers\UserController::class)->middleware('auth');
Route::resource('incidents', IncidentController::class)->middleware('auth');
Route::resource('reclamations', ReclamationController::class)->middleware('auth');
Route::resource('categories', App\Http\Controllers\CategorieController::class)->middleware('auth');
// Public OR protected route — selon ton choix

// Pour marquer UNE notification lue
Route::post('/notifications/mark-as-read/{id}', function($id) {
    $notification = auth()->user()->notifications()->findOrFail($id);
    $notification->markAsRead();
    return response()->noContent();
});

// Pour marquer TOUTES notifications lues
Route::post('/notifications/mark-all-as-read', function() {
    auth()->user()->unreadNotifications->markAsRead();
    return response()->noContent();
});


// routes of chargeclientele
// Route::middleware(['auth','chargeclientele'])->group(function () {
//     Route::get('/clientservice/dashboard', [ClientServiceController::class, 'dashboard'])->name('client_service.dashboard');
//     Route::post('/clientservice/validate/{id}', [ClientServiceController::class, 'validate'])->name('client_service.validate');
//     Route::post('/clientservice/reject/{id}', [ClientServiceController::class, 'reject'])->name('client_service.reject');
// });

Route::middleware(['auth', 'chargeclientele'])->group(function () {
    Route::get('/clientservice/dashboard', [ClientServiceController::class, 'index'])->name('chargeclientele.dashboard');
    Route::put('/incident/{id}/valider', [IncidentController::class, 'valider'])->name('incident.valider');
});

Route::get('/incident/create',[IncidentControllerForClient::class,'create'])->name('incident.create');
Route::post('/incident/create',[IncidentControllerForClient::class,'store'])->name('incident.store');


Route::get('/location',[LocationController::class,'index']);

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');
Route::post('/save-location', function (Request $request) {
    // Traitement côté serveur
    dd($request->all());
})->name('save.location');

Route::get('/incidentsconfirmer',function(Request $request,)
{
    return response()->json(Incident::all(),200);
});

// routes of notifications
Route::post('/notifications/mark-as-read/{id}', function ($id) {
    $notification = auth()->user()->notifications()->find($id);
    if ($notification) {
        $notification->markAsRead();
    }
    return response()->json(['status' => 'ok']);
})->middleware('auth');

Route::post('/notifications/mark-all-as-read', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return response()->json(['status' => 'all_read']);
})->middleware('auth');

?>



