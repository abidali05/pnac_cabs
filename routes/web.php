<?php

use App\Http\Controllers\admin\ApplicationController;
use App\Http\Controllers\CertificationBodies\InspectionBodyController;
use App\Http\Controllers\HalalCertification\HalalCertificationBodyController;
use App\Http\Controllers\admin\AssessmentController;
use App\Http\Controllers\admin\ClientSatisficationController;
use App\Http\Controllers\admin\SchemeController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\ProfileController;
use Illuminate\Console\Application;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/optimize', function () {
    Artisan::call('optimize');

    return 'Optimized successfully!';
});

Route::get('/create-storage-link', function () {
    Artisan::call('storage:link');

    return 'Storage link created!';
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'profile.complete'])->name('dashboard');

// Route::get('/index', function () {
//     return view('index');
// })->middleware(['auth', 'verified'])->name('index');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // marks user as verified

    return redirect('/dashboard'); // or wherever
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('active-account/{email}', [UserController::class, 'active_account'])->name('active_account');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/change-password', [PasswordController::class, 'changePassword'])->name('change.password');

    Route::middleware('profile.complete')->group(function () {
        // Application
        Route::controller(ApplicationController::class)->prefix('application')->as('application.')->group(function () {

            Route::get('index', 'applicationIndex')->name('index');
            Route::get('create', 'applicationCreate')->name('create');
            Route::post('store', 'applicationStore')->name('store');
            Route::get('edit/{id}/{category}', 'applicationEdit')->name('edit');
            Route::get('show/{id}/{category}', 'applicationShow')->name('show');
            Route::post('update/{id}', 'applicationUpdate')->name('update');
            Route::delete('destroy/{id}/{category}', 'applicationDestroy')->name('destroy');

            Route::post('store/certification-bodies', 'storeCertification')->name('store.certification');
            Route::put('update/certification-bodies/{id}', 'updateCertification')->name('update.certification');
            Route::post('{applicationForLab}/save-basic-info', 'saveBasicInfo')->name('saveBasicInfo');
            Route::post('{applicationForLab}/save-about-yourself', 'saveAboutYourself')->name('saveAboutYourself');
            Route::post('{applicationForLab}/save-about-staff', 'saveAboutStaff')->name('saveAboutStaff');
            Route::post('{applicationForLab}/save-calibration-scope', 'saveCalibrationScope')->name('saveCalibrationScope');
            Route::post('{applicationForLab}/save-testing-scope', 'saveTestingScope')->name('saveTestingScope');
            Route::post('{applicationForLab}/save-ptp-scope', 'savePtpScope')->name('savePtpScope');
            Route::post('{applicationForLab}/save-pcb-scope', 'savePcbScope')->name('savePcbScope');
            Route::post('{applicationForLab}/save-personnel-scope', 'savePersonnelScope')->name('savePersonnelScope');
            Route::post('{applicationForLab}/save-calibration-facility', 'saveCalibrationFacility')->name('saveCalibrationFacility');
            Route::post('{applicationForLab}/save-other-approvals', 'saveOtherApprovals')->name('saveOtherApprovals');
            Route::post('{applicationForLab}/save-declaration', 'saveDeclaration')->name('saveDeclaration');

            Route::post('certification-bodies/{cbApplication}/{section}/save', 'saveCbSection')->name('certification.save-section');
            Route::post('certification-bodies/{cbApplication}/documents', 'uploadCbDocument')->name('certification.documents.store');
            Route::delete('certification-bodies/{cbApplication}/documents/{document}', 'deleteCbDocument')->name('certification.documents.destroy');

            // Route::post('medical-laboratory/{mlabApplication}/{step}/save', 'saveMedicalLaboratoryStep')->name('medical-laboratory.save-step');
            // Route::post('medical-laboratory/{mlabApplication}/documents', 'uploadMedicalLaboratoryDocument')->name('medical-laboratory.documents.store');
            // Route::delete('medical-laboratory/{mlabApplication}/documents/{document}', 'deleteMedicalLaboratoryDocument')->name('medical-laboratory.documents.destroy');
            Route::get('view-scope', 'viewScope')->name('view.scope');
            Route::post('certification-bodies/basic-info', 'saveCertificationBodiesBasicInfo')->name('certificationBodies.saveBasicInfo');
            Route::post('certification-bodies/about-yourselves/{general}', 'saveCertificationBodiesAboutYourselves')->name('certificationBodies.saveAboutYourselves');
            Route::post('certification-bodies/staff/{general}', 'saveCertificationBodiesStaff')->name('certificationBodies.saveStaff');
            Route::post('certification-bodies/scope/{general}', 'saveCertificationBodiesScope')->name('certificationBodies.saveScope');
            Route::post('certification-bodies/quality-system/{general}', 'saveCertificationBodiesQualitySystem')->name('certificationBodies.saveQualitySystem');
            Route::post('certification-bodies/approvals/{general}', 'saveCertificationBodiesApprovals')->name('certificationBodies.saveApprovals');
            Route::post('certification-bodies/declaration/{general}', 'saveCertificationBodiesDeclaration')->name('certificationBodies.saveDeclaration');

            Route::get('submited-application', 'submitedApplication')->name('submited.index');
            Route::get('view/submited-application/{id}', 'viewSubmitedApplication')->name('submited.view');

            Route::get('/get-iaf-codes/{clusterId}', 'getIafCodes')->name('get.iaf.codes');

            Route::get('/get-technical-areas/{mainId}', 'getTechnicalAreas');
            Route::get('/get-descriptions/{mainId}/{areaId}', 'getDescriptions');

            Route::get('/get-categories', 'getCategories')->name('get.categories');
            Route::get('/get-subcategories', 'getSubcategories')->name('get.subcategories');

        });
        // Document store
        Route::post('/document-detail/create', [ApplicationController::class, 'documentStore'])->name('document-detail.create');

        Route::get('/client-satisfication', [ClientSatisficationController::class, 'clientSatisficationIndex'])->name('client-satisfication.index');
        Route::post('/client-satisfication/store', [ClientSatisficationController::class, 'clientSatisficationStore'])->name('client-satisfication.store');

        Route::get('/message-notification/index', [ClientSatisficationController::class, 'messageNotificationIndex'])->name('message.notification.index');
        Route::get('/message-notification/detail/{id}', [ClientSatisficationController::class, 'messageNotificationDetail'])->name('message.notification.detail');

        Route::get('/assessment/index', [AssessmentController::class, 'assessmentIndex'])->name('assessment.index');

        // Route::post('application/general-info/store', [ApplicationController::class, 'applicationGeneralStore'])->name('application.general.store');
        // Route::post('application/about-your-selves/store', [ApplicationController::class, 'applicationYourselvesStore'])->name('application.yourselves.store');
        // Route::post('application/about-your-staff/store', [ApplicationController::class, 'applicationYourstaffStore'])->name('application.yourstaff.store');
        // Route::post('application/scope/store', [ApplicationController::class, 'applicationScopeStore'])->name('application.scope.store');
        // Route::post('application/calibration-facility/store', [ApplicationController::class, 'applicationCalibrationFacilityStore'])->name('application.calibrationFacility.store');
        // Route::post('application/other-approvals/store', [ApplicationController::class, 'applicationOtherApprovalsStore'])->name('application.otherapprovals.store');
        // Route::post('application/declaration/store', [ApplicationController::class, 'applicationDeclarationStore'])->name('application.declaration.store');
        Route::prefix('medical-laboratory')->group(function () {
            Route::post('/save-step1/{mlabApplication}', [ApplicationController::class, 'saveMlabStep1'])->name('mlab.saveStep1');
            Route::post('/save-step2/{mlabApplication}', [ApplicationController::class, 'saveMlabStep2'])->name('mlab.saveStep2');
            Route::post('/save-step3/{mlabApplication}', [ApplicationController::class, 'saveMlabStep3'])->name('mlab.saveStep3');
            Route::post('/save-step4/{mlabApplication}', [ApplicationController::class, 'saveMlabStep4'])->name('mlab.saveStep4');
            Route::post('/save-step5/{mlabApplication}', [ApplicationController::class, 'saveMlabStep5'])->name('mlab.saveStep5');
            Route::post('/save-step6/{mlabApplication}', [ApplicationController::class, 'saveMlabStep6'])->name('mlab.saveStep6');
            Route::post('/upload-document/{mlabApplication}', [ApplicationController::class, 'uploadMlabDocument'])->name('mlab.uploadDocument');
            Route::delete('/delete-document/{mlabApplication}/{document}', [ApplicationController::class, 'deleteMlabDocument'])->name('mlab.deleteDocument');
        });
        // Scheme
        Route::resource('scheme', SchemeController::class);

        // Halal Certification Body Accreditation (F-01/17)
        Route::prefix('halal-certification-body')->as('hcb.')->group(function () {
            Route::get('create', [HalalCertificationBodyController::class, 'create'])->name('create');
            Route::post('{application}/step1', [HalalCertificationBodyController::class, 'saveStep1'])->name('step1.save');
            Route::post('{application}/step2', [HalalCertificationBodyController::class, 'saveStep2'])->name('step2.save');
            Route::post('{application}/step3', [HalalCertificationBodyController::class, 'saveStep3'])->name('step3.save');
            Route::post('{application}/step4', [HalalCertificationBodyController::class, 'saveStep4'])->name('step4.save');
            Route::post('{application}/step5', [HalalCertificationBodyController::class, 'saveStep5'])->name('step5.save');
            Route::post('{application}/step6', [HalalCertificationBodyController::class, 'saveStep6'])->name('step6.save');
            Route::post('{application}/step7', [HalalCertificationBodyController::class, 'saveStep7'])->name('step7.save');
            Route::post('{application}/documents', [HalalCertificationBodyController::class, 'uploadDocument'])->name('documents.store');
            Route::delete('{application}/documents/{document}', [HalalCertificationBodyController::class, 'deleteDocument'])->name('documents.destroy');
        });

        // Inspection Body Accreditation (F-01/10 / ISO/IEC 17020)
        Route::prefix('inspection-body')->as('inspection-body.')->group(function () {
            Route::get('create', [InspectionBodyController::class, 'create'])->name('create');
            Route::post('{application}/step1', [InspectionBodyController::class, 'saveStep1'])->name('step1.save');
            Route::post('{application}/step2', [InspectionBodyController::class, 'saveStep2'])->name('step2.save');
            Route::post('{application}/step3', [InspectionBodyController::class, 'saveStep3'])->name('step3.save');
            Route::post('{application}/step4', [InspectionBodyController::class, 'saveStep4'])->name('step4.save');
            Route::post('{application}/documents', [InspectionBodyController::class, 'uploadDocument'])->name('documents.store');
            Route::delete('{application}/documents/{document}', [InspectionBodyController::class, 'deleteDocument'])->name('documents.destroy');
        });

    });
});

require __DIR__.'/auth.php';
