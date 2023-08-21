<?php

use App\Http\Controllers\HomeController;
use App\Http\Livewire\AllEntreprise;
use App\Http\Livewire\Alluser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use \App\Http\Livewire\Authentification;
use App\Http\Livewire\Utilisateur\Passertest;
use App\Jobs\sendEmailOffre;
use App\Models\User;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/send',[HomeController::class,'hello']);
// Route::get('/entreprise',\App\Http\Livewire\Admin\Entreprisses::class);
Route::get('/dashboard',\App\Http\Livewire\Layoutslivewire\Dashboard\Dashboard::class)->name('dashboard')->middleware('verifyAuth');
Route::get('/login',\App\Http\Livewire\Authentification::class)->name('Authentification');
Route::get('/setting',\App\Http\Livewire\Setting::class)->name('setting');

Route::get('/utilisateur',\App\Http\Livewire\Alluser::class)->name('utilisateur')->middleware('verifyAuth');
Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/details/{id}',[HomeController::class,'show'])->name('ProfileUser')->middleware('verifyAuth');
Route::get('/demandeStage/{opp?}/{idD?}',\App\Http\Livewire\AlldemandeStage::class)->name('AllDemandeStage')->middleware('verifyAuth');

// EntrepriseAll
Route::get('/allentreprise/{opp?}/{idD?}',\App\Http\Livewire\AllEntreprise::class)
    ->name('allEntreprise')->middleware('verifyAuth');
// sendEMail
Route::post('/sendEmail',[HomeController::class,'sendEmail'])->name('envoyerEmail');

Route::get('/logout', function () {
    $guard=Auth::getDefaultDriver();
    Auth::guard($guard)->logout();
    Session::flush();
return redirect('/');
})->name('logout');

Route::get('/passerTest/{idtest?}',Passertest::class)->name('passerTest')->middleware('verifyAuth');

// ismail
Route::get('/alloffres',\App\Http\Livewire\Alloffres::class)->name('alloffres')->middleware('verifyAuth');
Route::get('/alloffres/{op?}/{id2?}',\App\Http\Livewire\Alloffres::class)->name('alloffresid')->middleware('verifyAuth');
Route::post('/alloffres',\App\Http\Livewire\Alloffres::class)->name('alloffresid')->middleware('verifyAuth');

// contacte
Route::get('/contact',function(){
    return view('layouts.contact');
})->name('contact');
Route::get('/linkstorage', function () {
    Artisan::call('storage:link'); // this will do the command line job
});
