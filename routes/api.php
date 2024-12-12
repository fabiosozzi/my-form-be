<?php

use Illuminate\Support\Facades\Route;
use App\Actions\Contact\CreateNewContact;
use App\Http\Middleware\CheckSecretApiKey;
use App\Actions\Contact\DeleteExistingContact;
use App\Actions\Contact\ExportContactToCSV;
use App\Actions\Contact\UpdateExistingContact;

Route::middleware('auth:sanctum')->name('api.')->group(function () {
    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::put('/{contact}', UpdateExistingContact::class)->name('update');
        Route::delete('/{contact}', DeleteExistingContact::class)->name('delete');
        Route::post('/export', ExportContactToCSV::class)->name('export');
    });
});

Route::middleware(CheckSecretApiKey::class)->name('api.')->group(function () {
    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::post('/', CreateNewContact::class)->name('create');
    });
});