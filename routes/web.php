<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\CinetPayController;
use App\Http\Controllers\CinetPayCallbackController;
use App\Http\Controllers\TelechargementController;
use App\Http\Controllers\TransfertController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\SecurityController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//
Route::get('language/{lang}', [LanguageController::class, 'language'])->name('language');


Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

Route::get('/inscription', [InscriptionController::class, 'inscription'])->name('inscription');
Route::post('/inscription', [InscriptionController::class, 'SaveInscription'])->name('SaveInscription');

Route::get('/livre/{livre_id}', [HomeController::class, 'details_livre'])->name('details_livre');

Route::get('/panier', [HomeController::class, 'panier'])->name('panier');
Route::post('/commande', [CommandeController::class, 'SaveCommande'])->name('SaveCommande');
Route::get('/checkout', [CommandeController::class, 'checkout'])->name('checkout');

Route::get('/commandes', [CommandeController::class, 'commandes'])->name('commandes');
Route::get('/commande/{commande_id}', [CommandeController::class, 'DetailsCommande'])->name('DetailsCommande');

Route::post('/initpaiementcinetpay', [CinetPayController::class, 'initPaiementCinetPay'])->name('initPaiementCinetPay');
Route::post('/notify', [CinetPayCallbackController::class, 'notify'])->name('notify');
Route::get('/retour', [CinetPayController::class, 'retour'])->name('retour');
Route::post('/retour', [CinetPayController::class, 'retour'])->name('retour_post');
Route::get('/paiementaconfirmer', [CinetPayCallbackController::class, 'PaiementAConfirmer'])->name('PaiementAConfirmer');
Route::get('/paiement_reussie', [CinetPayCallbackController::class, 'paiement_reussie'])->name('paiement_reussie');
Route::get('/paiement_echoue', [CinetPayCallbackController::class, 'paiement_echoue'])->name('paiement_echoue');

Route::get('/telechargements', [TelechargementController::class, 'telechargements'])->name('telechargements');
Route::get('/telecharger/{id}', [TelechargementController::class, 'telecharger'])->name('telecharger');



Route::get('/sendmoney', [TransfertController ::class, 'sendMoney'])->name('sendMoney');
Route::get('/eov', [TransfertController ::class, 'ExecuterOrdresVirements'])->name('ExecuterOrdresVirements');

// Route::get('/clear-cache', function() {
    // Artisan::call('cache:clear');
    // Artisan::call('route:clear');
    // Artisan::call('view:clear');
    // Artisan::call('config:clear');
    // return "Cache is cleared";
// });


require __DIR__.'/auth.php';
