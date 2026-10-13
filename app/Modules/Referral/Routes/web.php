<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Referral\Controllers\ReferralController;

Route::middleware(['web'])->group(function () {
    Route::get('/referrals', [ReferralController::class, 'index'])->name('referrals.index');
    Route::get('/referrals/create', [ReferralController::class, 'create'])->name('referrals.create');
    Route::post('/referrals', [ReferralController::class, 'store'])->name('referrals.store');
    Route::post('/referrals/{referral}/status', [ReferralController::class, 'updateStatus'])->name('referrals.status');
});
