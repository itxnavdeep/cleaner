<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Models\State;
use App\Models\User;
use App\Models\UserDetails;
use App\Http\Livewire\Customer;
use App\Http\Livewire\CustomerUpdate;
use App\Http\Controllers\admin\AdminController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

//Home
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('sigup', function () {
    $title = array(
        'active' => 'signup',
    );
    return view('home.signup', compact('title'));
})->name('signup');

Route::get('signup-customers', function () {
    $title = array(
        'active' => 'signup-customers',
    );
    $states = State::all();
    return view('auth.register-customer', compact('title', 'states'));
})->name('signup-customers');

Route::get('signup-cleaner', function () {
    $title = array(
        'active' => 'signup-cleaner',
    );
    $states = State::all();
    return view('auth.register-cleaner', compact('title', 'states'));
})->name('signup-cleaner');


Route::middleware(['auth', 'verified'])->group(function () {
    //admin
    Route::get('/admin-customer', function () {
        $title = array(
            'active' => 'admin-account',
        );
        return view('admin.dashboard');
    })->name('admin-customer');
    
    
 //cleaner
    Route::get('/admin-cleaner', function () {
        $title = array(
            'active' => 'admin-cleaner',
        );
        return view('admin.cleaner');
    })->name('admin-cleaner');

    //Customer
    Route::get('/update-account/{id}', function () {
        $title = array(
            'active' => 'admin-account',
        );
       return view('admin.customer-edit');
        })->name('customer-update');

    // Route::get('/customer-edit/{id}', \App\Http\Livewire\Admin\CustomerUpdate::class)->name('customer-edit');
});


Route::middleware(['auth', 'verified'])->group(function () {


    //customer
    Route::get('/customer-account', function () {
        $title = array(
            'active' => 'customer-account',
        );
        return view('customer.account', compact('title'));
    })->name('customer-account');

    //cleaner
    Route::get('cleaner-account', function () {
        $title = array(
            'active' => 'cleaner-profile',
        );
        return view('cleaner.account', compact('title'));
    })->name('cleaner-account');

    Route::get('cleaner-team', function () {
        $title = array(
            'active' => 'cleaner-profile',
        );
        return view('cleaner.team', compact('title'));
    })->name('cleaner-team');
});
