<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NutritionistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/home', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test-page');
});

Route::get('/setup', function () {
    return view('setup-database');
});

Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isNutritionist()) {
        return redirect()->route('nutritionist.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Users Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    
    // Patients Management
    Route::get('/patients', [AdminController::class, 'patients'])->name('patients');
    Route::post('/patients', [AdminController::class, 'storePatient'])->name('patients.store');
    Route::get('/patients/{patient}', [AdminController::class, 'showPatient'])->name('patients.show');
    
    // Nutrition Assessments
    Route::get('/nutrition', [AdminController::class, 'nutrition'])->name('nutrition');
    Route::post('/nutrition', [AdminController::class, 'storeNutrition'])->name('nutrition.store');
    Route::get('/nutrition/{nutrition}', [AdminController::class, 'showNutrition'])->name('nutrition.show');
    
    // Inventory Management
    Route::get('/inventory', [AdminController::class, 'inventory'])->name('inventory');
    Route::post('/inventory', [AdminController::class, 'storeInventory'])->name('inventory.store');
    Route::get('/inventory/{inventory}', [AdminController::class, 'showInventory'])->name('inventory.show');
    Route::post('/inventory/transaction', [AdminController::class, 'storeTransaction'])->name('inventory.transaction');
    
    // Transactions
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');
    Route::post('/transactions', [AdminController::class, 'storeTransaction'])->name('transactions.store');
    
    // Reports
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
});

// Nutritionist Routes
Route::middleware(['auth', 'nutritionist'])->prefix('nutritionist')->name('nutritionist.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [NutritionistController::class, 'dashboard'])->name('dashboard');
    
    // Patients Management - Nutritionists can view and manage patients
    Route::get('/patients', [NutritionistController::class, 'patients'])->name('patients');
    Route::post('/patients', [NutritionistController::class, 'storePatient'])->name('patients.store');
    Route::get('/patients/{patient}', [NutritionistController::class, 'showPatient'])->name('patients.show');
    
    // Nutrition Assessments - Core functionality for nutritionists
    Route::get('/nutrition', [NutritionistController::class, 'nutrition'])->name('nutrition');
    Route::post('/nutrition', [NutritionistController::class, 'storeNutrition'])->name('nutrition.store');
    Route::get('/nutrition/{nutrition}', [NutritionistController::class, 'showNutrition'])->name('nutrition.show');
    
    // Reports - Nutritionists can view reports
    Route::get('/reports', [NutritionistController::class, 'reports'])->name('reports');
});

require __DIR__.'/auth.php';
