<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Job;
use App\Http\Controllers\JobController;

// PUBLIC API's and ROUTES
Route::get('/', 'HomeController@index')->name('Home');
Route::get('robots.txt', 'RobotsController');

// Views
Route::view('/about', 'website.about')->name('About');
Route::view('/fintech', 'website.fintech')->name('Fintech');
Route::view('/contact', 'website.contact')->name('Contact');
Route::view('/privacy-policy', 'website.privacy-policy')->name('privacy-policy');

// User
Route::get('/register', 'CompanyController@register')->name('register');
Route::get('/new-user/{company_id}', ['as'=>'new-user','uses'=>'UserController@newUserView']);
Route::post('/new-user-register', 'UserController@createNewUser')->name('new-user-register');

// Job
Route::get('/job/{id}/{slug}', ['as'=>'website.job.show','uses'=>'HomeController@showJob']);
Route::post('/search', 'JobController@search')->name('search');
Route::post('/job/apply/{job_id}', 'ApplicationController@apply')->name('apply');
//Route::post('/save_job/{job_id}', 'JobController@saveUserJob')->name('save_job');
//Route::get('/job/myjobs', ['as'=>'website.job.myjobs','uses'=>'JobController@userSavedJobs']);
//Route::get('/job/appliedjobs', ['as'=>'website.job.appliedjobs','uses'=>'JobController@userAppliedJobs']);
//Route::post('/unsave_job/{job_id}', 'JobController@unsaveUserJob')->name('unsave_job');

Route::get('/search', function(Request $request){
    $job_controller = new JobController();
    return $job_controller->getJobSearch($request->title);
});

// Event 
Route::get('/events', 'HomeController@getEventsPage')->name('Events');
Route::get('/events/list', 'HomeController@getEvents');
Route::get('/event/{id}/{slug}', ['as'=>'event_show','uses'=>'HomeController@showEvent']);

// Newsletter
Route::post('/newsletter/create-ajax-newsletter', 'NewsletterController@createAjaxNewsletter');
Route::get('/newsletter/{newsletterId}/delete', 'NewsletterController@deleteNewsletter')->name('delete-newsletter');
Route::get('/subscribe', 'NewsletterController@subscribePage')->name('subscribe_page');

// Companies
Route::get('/companies', 'HomeController@getCompaniesAndSectors')->name('Companies');
Route::get('/companies/get', ['as'=> 'companies_get', 'uses'=>'HomeController@getCompanies']);
Route::get('/company/{company}/{slug}', ['as'=> 'company_show', 'uses'=>'HomeController@showCompany']);

// Associations
Route::get('/associations', 'HomeController@getAssociationsPage')->name('Associations');
Route::get('/associations/get', ['as'=> 'companies_get', 'uses'=>'HomeController@getAssociations']);
Route::get('/association/{company}/{slug}', ['as'=> 'association_show', 'uses'=>'HomeController@showCompany']);

// Education
Route::get('/education', 'HomeController@getEducationPage')->name('Education');
Route::get('/education/institutes', 'HomeController@getInstitutes');
Route::get('/education/{institute}/{slug}', 'HomeController@showInstitute');


// Third Party API's
// Linkedin
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('{provider}/callback', 'Auth\LoginController@callback');
Route::get('/auth/redirect/{provider}', 'Auth\LoginController@redirect');
//Route::get('/callback/{provider}', 'Auth\LoginController@callback');

// Testing email routes
/*
Route::get('/mail/inviteUser', function(){
    $company_id = 1;
    $newsletter = false;
    return view('mails.inviteUser', compact('company_id', 'newsletter'));
});

Route::get('/mail/jobAlert', function(){
    $jobs = Job::limit(10)->get();
    $id = 1;
    $newsletter = true;
    return view('mails.jobAlert', compact('jobs', 'id', 'newsletter'));
});

Route::get('/mail/jobApplication', function(){
    $newsletter = false;
    $job_applied = 'Software Developer';
    $name = 'Luiz Wynne';
    $email = 'luwynne@aol.co.uk';
    $phone = ' 9823498';
    $linkedin = 'https://linksinedi/0923409234';
    $cover_letter = '
        <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </p>
    ';
    return view('mails.jobapplication', compact('job_applied', 'name', 'email', 'phone', 'linkedin', 'cover_letter', 'newsletter'));
});

Route::get('/mail/payment', function(){
    $newsletter = false;
    $payment_package = 'Package 3';
    $payment_amount = (float)699.00;
    $payment_date = '05/04/2020';
    return view('mails.payment', compact('payment_package', 'payment_amount', 'payment_date', 'newsletter'));
});
*/

Auth::routes();
// PRIVATE API's AND ROUTES

//registering company with an already registered/authenticated user
Route::get('/auth/companyRegister', 'CompanyController@registerCompany');
Route::post('companyStore', 'CompanyController@store')->name('companyStore');

//companies that are already registered
Route::group(['middleware'=>'companyRegistered'], function (){

    // routes Dashboard section
    Route::get('admin/home', 'CompanyController@index');

    // account admin access
    Route::group(['middleware'=>'companyAdmin'], function (){
        Route::get('admin/products', 'PlanController@getProductsPage')->name('products');
        Route::post('admin/products', 'PlanController@getProductsPageWithDiscount')->name('products_discount');
        Route::view('admin/subscribe', 'admin.subscribe');
        Route::post('admin/subscribe_process', 'CheckoutController@subscribe_process');
        Route::view('admin/subscribe_success', 'admin.subscribe_success');
    });

    // BO api's
    Route::group(['prefix' => 'api'], function() {
        Route::get('/company_info','CompanyController@getCompanyInfo');
        Route::get('/vacancies', 'JobController@getCompanyJobs');
        Route::post('/job/createJob', 'JobController@createJob')->name('createJob');
        Route::patch('/job/editJob/{jobId}', 'JobController@editJob')->name('editJob');
        Route::get('/applications', 'ApplicationController@getApplications');
        Route::get('/billing', 'PaymentController@getPayments');
        Route::get('/billing/{payment}/download', 'PaymentController@downloadPayment');
        Route::get('/users', 'CompanyController@companyUser');
        Route::post('/new-user', 'CompanyController@inviteNewUser')->name('admin-new-user');
        Route::patch('/user/change_user_role/{user_id}', 'CompanyController@changeUserRole')->name('changeUserRole');
        Route::delete('/user/delete_company_user/{user_id}', 'CompanyController@deleteCompanyUser')->name('deleteCompanyUser');
        Route::get('/logged_user','CompanyController@getLoggedUser');
        Route::get('/company_sectors','CompanySectorController@getCompanySectors');
        Route::patch('/company/{company_id}','CompanyController@updateCompany');
        Route::get('/company_logo','CompanyController@getCompanyLogo');
        Route::get('/company_vimeo_video','CompanyController@getCompanyVimeoVideo');
        Route::get('/company_youtube_video','CompanyController@getCompanyYoutubeVideo');
        Route::post('/company/save_logo', 'CompanyController@saveCompanyLogo');
        Route::post('/company/save_vimeo_video', 'CompanyController@saveCompanyVimeoVideo');
        Route::get('/events', 'EventController@getEvents');
        Route::get('/event/file_name/{event_id}', 'EventController@getEventFileName');
        Route::post('/event/createEvent', 'EventController@createEvent');
        Route::patch('/event/editEvent/{event_id}', 'EventController@editEvent');
        Route::get('/courses', 'CourseController@getCourses');
        Route::post('/course/createCourse', 'CourseController@createCourse');
        Route::patch('/course/editCourse/{event_id}', 'CourseController@editCourse');
        Route::get('/countries','CountryController@getCountries');
    });

    // super admin
    Route::group(['middleware'=>'superAdmin'], function (){
        // Home
        Route::get('superadmin/home', 'SuperAdminController@index')->name('super_admin_home');

        // Company
        Route::get('superadmin/company/{company}/edit', ['as'=>'company-edit','uses'=>'SuperAdminController@showCompany']);
        Route::post('superadmin/company/{company}/edit', ['as'=>'company-save','uses'=>'SuperAdminController@updateCompany']);
        
        // Jobs
        //Route::get('superadmin/jobs', 'SuperAdminController@renderJobsPage')->name('super_admin_jobs');
        //Route::get('superadmin/jobs/{job_id}', ['uses'=>'SuperAdminController@getNotApprovedJob']);
        //Route::post('superadmin/jobs/{job_id}', ['uses'=>'SuperAdminController@approveJob']);
        
        // Events
        Route::get('superadmin/events', 'SuperAdminController@renderEventsPage')->name('super_admin_events');
        Route::get('superadmin/events/{event_id}', ['uses'=>'SuperAdminController@getNotApprovedEvent']);
        Route::post('superadmin/events/{event_id}', ['uses'=>'SuperAdminController@approveEvent']);
        Route::get('superadmin/create_event', 'SuperAdminController@renderCreateEventPage')->name('super_admin_create_events');
        Route::post('superadmin/create_event', ['uses'=>'SuperAdminController@createEvent']);
        Route::get('superadmin/edit_event/{event_id}', 'SuperAdminController@renderEditEventPage')->name('super_admin_edit_events');
        Route::post('superadmin/edit_event/{event_id}', ['uses'=>'SuperAdminController@editEvent'])->name('super_admin_edit_events_post');
        Route::get('superadmin/external_events', 'SuperAdminController@renderExternalEventsPage')->name('super_admin_external_events');

        // Courses
        Route::get('superadmin/courses', 'SuperAdminController@renderCoursesPage')->name('super_admin_courses');
        Route::get('superadmin/courses/{course_id}', ['uses'=>'SuperAdminController@getNotApprovedCourse']);
        Route::post('superadmin/courses/{course_id}', ['uses'=>'SuperAdminController@approveCourse']);

        // Education institutes
        Route::get('superadmin/create_education_institute', 'SuperAdminController@renderCreateEducationInstitutePage')->name('super_admin_create_education_institute');
        Route::post('superadmin/create_education_institute', ['uses'=>'SuperAdminController@createEducationInstitute']);
        Route::get('superadmin/education_institutes', 'SuperAdminController@getEducationInstitutes')->name('super_admin_education_institute');
        Route::get('superadmin/edit_education_institute/{institute_id}', ['uses'=>'SuperAdminController@renderEditEducationInstitutePage']);
        Route::post('superadmin/edit_education_institute/{institute_id}', ['uses'=>'SuperAdminController@editEducationInstitute']);
    });

});




