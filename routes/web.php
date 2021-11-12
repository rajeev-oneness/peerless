<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('home');
    // return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// user common routes
Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
    // profile
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [HomeController::class, 'profile'])->name('user.profile');
        Route::post('update', [HomeController::class, 'profileUpdate'])->name('user.profile.update');
        Route::post('password/update', [HomeController::class, 'passwordUpdate'])->name('user.password.update');
        Route::post('image/update', [HomeController::class, 'imageUpdate'])->name('user.profile.image.update');
    });

    // employee
    Route::group(['prefix' => 'employee'], function () {
        Route::get('/', [UserController::class, 'index'])->name('user.employee.list');
        Route::get('/create', [UserController::class, 'create'])->name('user.employee.create');
        Route::post('/store', [UserController::class, 'store'])->name('user.employee.store');
        Route::post('/show', [UserController::class, 'show'])->name('user.employee.show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.employee.edit');
        Route::post('/{id}/update', [UserController::class, 'update'])->name('user.employee.update');
        Route::post('/destroy', [UserController::class, 'destroy'])->name('user.employee.destroy');
        Route::post('/block', [UserController::class, 'block'])->name('user.employee.block');
    });

    // borrower
    Route::group(['prefix' => 'borrower'], function () {
        Route::get('/', [BorrowerController::class, 'index'])->name('user.borrower.list');
        Route::get('/create', [BorrowerController::class, 'create'])->name('user.borrower.create');
        Route::post('/store', [BorrowerController::class, 'store'])->name('user.borrower.store');
        Route::post('/show', [BorrowerController::class, 'show'])->name('user.borrower.show');
        Route::get('/{id}/view', [BorrowerController::class, 'details'])->name('user.borrower.details');
        Route::get('/{id}/edit', [BorrowerController::class, 'edit'])->name('user.borrower.edit');
        Route::post('/{id}/update', [BorrowerController::class, 'update'])->name('user.borrower.update');
        Route::post('/destroy', [BorrowerController::class, 'destroy'])->name('user.borrower.destroy');
    });

    // role
    Route::group(['prefix' => 'employee/role'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('user.role.list');
        Route::post('/store', [RoleController::class, 'store'])->name('user.role.store');
        Route::post('/show', [RoleController::class, 'show'])->name('user.role.show');
        Route::post('/destroy', [RoleController::class, 'destroy'])->name('user.role.destroy');
    });

    // agreement
    Route::group(['prefix' => 'agreement'], function () {
        Route::get('/', [AgreementController::class, 'index'])->name('user.agreement.list');
        Route::get('/create', [AgreementController::class, 'create'])->name('user.agreement.create');
        Route::post('/store', [AgreementController::class, 'store'])->name('user.agreement.store');
        Route::post('/show', [AgreementController::class, 'show'])->name('user.agreement.show');
        Route::get('/{id}/view', [AgreementController::class, 'details'])->name('user.agreement.details');
        Route::get('/{id}/edit', [AgreementController::class, 'edit'])->name('user.agreement.edit');
        Route::post('/{id}/update', [AgreementController::class, 'update'])->name('user.agreement.update');
        Route::post('/destroy', [AgreementController::class, 'destroy'])->name('user.agreement.destroy');
        Route::get('/{id}/fields', [AgreementController::class, 'fieldsIndex'])->name('user.agreement.fields');
        Route::post('/fields/store', [AgreementController::class, 'fieldsStore'])->name('user.agreement.fields.store');
        // pdf
        Route::get('/{id}/pdf/view', [PDFController::class, 'showPdf'])->name('user.agreement.pdf.view');
        Route::get('/{id}/pdf/download', [PDFController::class, 'generatePdf'])->name('user.agreement.pdf.download');
    });

    // field
    Route::group(['prefix' => 'field'], function () {
        Route::get('/', [FieldController::class, 'index'])->name('user.field.list');
        Route::get('/create', [FieldController::class, 'create'])->name('user.field.create');
        Route::post('/store', [FieldController::class, 'store'])->name('user.field.store');
        Route::post('/show', [FieldController::class, 'show'])->name('user.field.show');
        Route::get('/{id}/view', [FieldController::class, 'details'])->name('user.field.details');
        Route::get('/{id}/edit', [FieldController::class, 'edit'])->name('user.field.edit');
        Route::post('/{id}/update', [FieldController::class, 'update'])->name('user.field.update');
        Route::post('/destroy', [FieldController::class, 'destroy'])->name('user.field.destroy');
    });

    // logs
    Route::group(['prefix' => 'logs'], function () {
        Route::get('/', [LogController::class, 'logsIndex'])->name('user.logs');
        Route::get('/mail', [LogController::class, 'logsMail'])->name('user.logs.mail');
        Route::get('/notification', [LogController::class, 'logsNotification'])->name('user.logs.notification');
        Route::post('/notification/readall', [LogController::class, 'notificationReadAll'])->name('user.logs.notification.readall');
    });

    // notification
    Route::post('/read', [HomeController::class, 'notificationRead'])->name('user.notification.read');

    // pdf
    // Route::get('/agreement/view', [PDFController::class, 'showPdf'])->name('user.loan.pdf.view');
    // Route::get('/pdf', [PDFController::class, 'generatePdf'])->name('user.loan.pdf.download');
});
