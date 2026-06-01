<?php

use Illuminate\Support\Facades\Route;
use Modules\TourBooking\App\Models\Service;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Admin\ProfileController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\LoginController;

use App\Http\Controllers\Admin\FrontEndManagementController;
use App\Http\Controllers\Auth\LoginController as UserLoginController;
use App\Http\Controllers\Auth\RegisterController as UserRegisterController;


use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\Agent\ProfileController as AgentProfileController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\SidebarBadgeController;
use App\Http\Controllers\LiveChatController;
use App\Http\Controllers\Admin\LiveChatController as AdminLiveChatController;
use Illuminate\Support\Facades\Artisan;

Route::group(['middleware' => ['HtmlSpecialchars', 'MaintenanceMode']], function () {

    // 301 Redirects for slug cleanup (Phase E)
    Route::permanentRedirect('/tour-booking/service/modi-mollitia-quas-s-dasd-dasd-', '/tour-booking');
    Route::permanentRedirect('/tour-booking/service/Vel eveniet debitis', '/tour-booking');
    Route::permanentRedirect('/tour-booking/service/Aut est nobis ipsum', '/tour-booking');
    Route::permanentRedirect('/tour-booking/service/two-hour-walking-tour-of-manhattan', '/tour-booking');
    Route::permanentRedirect('/tour-booking/service/american-parks-trail-end-rapid-city-express', '/tour-booking');
    Route::permanentRedirect('/tour-booking/service/modern-stefano-la-piazze-wergeland', '/tour-booking');
    Route::permanentRedirect('/tour-booking/service/vatican-museums-sistine-chapel-skip-the', '/tour-booking');
    Route::permanentRedirect('/tour-booking/service/when-you-visit-the-eternal-dubai-city', '/tour-booking');
    Route::permanentRedirect('/tour-booking/service/the-pulau-seribu-jakarta-indonesia', '/tour-booking');
    Route::permanentRedirect('/tour-booking/service/southwestern-switzerland-akam-city', '/tour-booking');
    Route::permanentRedirect('/tour-booking/service/win-cities-on-opposite-sides-of-the', '/tour-booking');
    Route::permanentRedirect('/tour-booking/service/buenos-aires-calafate-chalten-ushuaia', '/tour-booking');
    Route::permanentRedirect('/explore/exploring-the-green-spac-realar-residence-area-harmony', '/explore/exploring-green-spaces-natural-harmony-in-egypt');

    Route::get('migrate', function () {
        Artisan::call('migrate');
    });

    Route::get('clear', function () {
        Artisan::call('optimize:clear');
    });

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/offers', [\Modules\TourBooking\App\Http\Controllers\Front\FrontServiceController::class, 'offers'])->name('offers');

    Route::get('tours', function () {
        return redirect()->route('front.tourbooking.tours', [], 301);
    })->name('tours');

    Route::get('tour/{slug}', function (string $slug) {
        if (Service::where('slug', $slug)->where('status', true)->exists()) {
            return redirect()->route('front.tourbooking.services.show', ['slug' => $slug], 301);
        }

        return redirect()->route('front.tourbooking.tours', [], 302);
    })->name('tour');

    Route::get('/theme/{theme}', [HomeController::class, 'switchTheme'])->name('theme.switch');
    Route::get('/home', [HomeController::class, 'themeVariation'])->name('theme.variation');

    Route::get('/about-us', [HomeController::class, 'about_us'])->name('about-us');

    Route::get('/explores', [HomeController::class, 'blogs'])->name('blogs');
    Route::get('/explore/{slug}', [HomeController::class, 'blog'])->name('blog');
    Route::post('/store-blog-comment/{id}', [HomeController::class, 'store_blog_comment'])->name('store-blog-comment');

    Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
    Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');

    Route::get('/privacy-policy', [HomeController::class, 'privacy_policy'])->name('privacy-policy');
    Route::get('/terms-conditions', [HomeController::class, 'terms_conditions'])->name('terms-conditions');

    Route::get('/custom-page/{slug}', [HomeController::class, 'custom_page'])->name('custom-page');

    Route::get('/contact-us', [HomeController::class, 'contact_us'])->name('contact-us');

    Route::get('/language-switcher', [HomeController::class,  'language_switcher'])->name('language-switcher');
    Route::get('/currency-switcher', [HomeController::class, 'currency_switcher'])->name('currency-switcher');


    Route::get('/download-file/{file}', [HomeController::class, 'download_file'])->name('download-file');


    Route::get('/teams', [HomeController::class, 'teams'])->name('teams');
    Route::get('/team/{slug}', [HomeController::class, 'teamPerson'])->name('teamPerson');

    Auth::routes();

    Route::get('/login', function () {
        return redirect()->route('user.login');
    });

    Route::get('/register', function () {
        return redirect()->route('user.register');
    });

    Route::group(['as' => 'user.', 'prefix' => 'user'], function () {
        Route::controller(UserLoginController::class)->group(function () {

            Route::get('/login', 'custom_login_page')->name('login');
            Route::post('/store-login', 'store_login')->name('store-login');
            Route::get('/logout', 'student_logout')->name('logout');

            Route::get('login/google', 'redirect_to_google')->name('login-google');
            Route::get('/callback/google', 'google_callback')->name('callback-google');

            Route::get('login/facebook', 'redirect_to_facebook')->name('login-facebook');
            Route::get('/callback/facebook', 'facebook_callback')->name('callback-facebook');

            Route::get('/forget-password', 'custom_forget_page')->name('forget-password');

            Route::post('/send-forget-password', 'send_custom_forget_pass')->name('send-forget-password');
            Route::get('/reset-password', 'custom_reset_password')->name('reset-password');
            Route::post('/store-reset-password/{token}', 'store_reset_password')->name('store-reset-password');

            Route::controller(UserRegisterController::class)->group(function () {
                Route::get('/register', 'custom_register_page')->name('register');
                Route::post('/store-register', 'store_register')->name('store-register');
                Route::get('/register-verification', 'register_verification')->name('register-verification');
            });
        });
    });

    Route::get('/agent/register', [UserProfileController::class, 'agent_register'])->name('agent-register');
    Route::post('/agent/register/submit', [UserProfileController::class, 'agent_register_submit'])->name('agent-register.submit');

    Route::group(['as' => 'user.', 'prefix' => 'user'], function () {

        Route::group(['middleware' => 'auth:web'], function () {

            Route::get('/dashboard', [UserProfileController::class, 'dashboard'])->name('dashboard');

            Route::get('/edit-profile', [UserProfileController::class, 'edit_profile'])->name('edit-profile');
            Route::put('/update-profile', [UserProfileController::class, 'update_profile'])->name('update-profile');

            Route::get('/change-password', [UserProfileController::class, 'change_password'])->name('change-password');
            Route::put('/update-password', [UserProfileController::class, 'update_password'])->name('update-password');


            Route::get('/create-agent', [UserProfileController::class, 'create_agent'])->name('create-agent');
            Route::post('/agent-application', [UserProfileController::class, 'agent_application'])->name('agent-application');


            Route::get('/account-delete', [UserProfileController::class, 'account_delete'])->name('account-delete');
            Route::delete('/confirm-account-delete', [UserProfileController::class, 'confirm_account_delete'])->name('confirm-account-delete');


            // sidebar live badge counts (polled by user layout)
            Route::get('/sidebar-badges', [SidebarBadgeController::class, 'counts'])->name('sidebar-badges');

            // orders
            Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
            Route::get('/order/details/{order_id}', [OrderController::class, 'order_show'])->name('order_show');
            Route::get('/transactions/history', [OrderController::class, 'transactions'])->name('transactions');

            // live chat
            Route::prefix('live-chat')->name('live-chat.')->controller(LiveChatController::class)->group(function () {
                Route::get('/', 'chatPage')->name('page');
                Route::get('unread', 'unreadCount')->name('unread');
                Route::post('new', 'newChat')->name('new');
                Route::get('{chatId}', 'chatPage')->name('show');
                Route::get('{chatId}/messages', 'getMessages')->name('messages');
                Route::post('{chatId}/send', 'send')->name('send');
                Route::post('start', 'startOrGet')->name('start');
            });
        });
    });


    Route::group(['as' => 'agent.', 'prefix' => 'agent'], function () {

        Route::group(['middleware' => ['auth:web', 'CheckAgent']], function () {

            Route::get('/migrate', function () {
                Artisan::call('migrate');
                return 'Migration completed!';
            });

            Route::get('/clear', function () {
                Artisan::call('optimize:clear');
                return 'Cache cleared!';
            });

            Route::get('/link', function () {
                Artisan::call('storage:link');
                return 'Storage link created!';
            });

            Route::get('/dashboard', [AgentProfileController::class, 'dashboard'])->name('dashboard');

            Route::get('/edit-profile', [AgentProfileController::class, 'edit_profile'])->name('edit-profile');
            Route::put('/update-profile', [AgentProfileController::class, 'update_profile'])->name('update-profile');

            Route::get('/agent-profile', [AgentProfileController::class, 'agent_profile'])->name('agent-profile');
            Route::put('/update-agent-profile', [AgentProfileController::class, 'update_agent_profile'])->name('update-agent-profile');

            Route::get('/change-password', [AgentProfileController::class, 'change_password'])->name('change-password');
            Route::put('/update-password', [AgentProfileController::class, 'update_password'])->name('update-password');

            Route::get('/account-delete', [AgentProfileController::class, 'account_delete'])->name('account-delete');
            Route::delete('/confirm-account-delete', [AgentProfileController::class, 'confirm_account_delete'])->name('confirm-account-delete');
        });
    });

    Route::group(['as' => 'staff.', 'prefix' => 'staff'], function () {
        Route::group(['middleware' => ['auth:web', 'CheckStaff', 'CheckStaffRoutePermission']], function () {
            Route::get('/dashboard', [StaffDashboardController::class, 'dashboard'])->name('dashboard');

            Route::controller(FrontEndManagementController::class)->name('front-end.')->group(function () {
                Route::get('/frontend-section', 'index')->name('frontend-section');
                Route::get('/section/{id}', 'section')->name('section');
                Route::put('store/{key}/{id?}', 'store')->name('store');
                Route::get('/frontend-field-template', 'getFieldTemplate')->name('field-template');
                Route::post('/upload-image', [App\Http\Controllers\Admin\UploadController::class, 'editorImage'])->name('upload-image');
            });

            // Live Chat
            Route::prefix('live-chat')->name('live-chat.')->controller(AdminLiveChatController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('json', 'indexJson')->name('json');
                Route::get('{id}', 'show')->name('show');
                Route::post('{id}/send', 'send')->name('send');
                Route::put('{id}/close', 'close')->name('close');
                Route::put('{id}/reopen', 'reopen')->name('reopen');
                Route::get('{id}/messages', 'getMessages')->name('messages');
            });
        });
    });
});



Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {

    Route::get('login', [LoginController::class, 'custom_login_page'])->name('login');
    Route::post('store-login', [LoginController::class, 'store_login'])->name('store-login');
    Route::post('store-register', [LoginController::class, 'store_register'])->name('store-register');
    Route::post('logout', [LoginController::class, 'admin_logout'])->name('logout');


    Route::group(['middleware' => ['auth:admin']], function () {

        Route::get('/', [DashboardController::class, 'dashboard']);
        Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

        Route::controller(ProfileController::class)->group(function () {
            Route::get('edit-profile', 'edit_profile')->name('edit-profile');
            Route::put('profile-update', 'profile_update')->name('profile-update');
            Route::put('update-password', 'update_password')->name('update-password');
        });

        // Menu Management System
        Route::controller(App\Http\Controllers\Admin\MenuController::class)->group(function () {
            Route::get('menus', 'index')->name('menus.index');
            Route::get('menus/create', 'create')->name('menus.create');
            Route::post('menus', 'store')->name('menus.store');
            Route::get('menus/{id}/edit', 'edit')->name('menus.edit');
            Route::put('menus/{id}', 'update')->name('menus.update');
            Route::delete('menus/{id}', 'destroy')->name('menus.destroy');

            // Menu Items
            Route::post('menus/{id}/add-item', 'addMenuItem')->name('menus.add-item');
            Route::put('menu-items/{id}', 'updateMenuItem')->name('menu-items.update');
            Route::delete('menu-items/{id}', 'deleteMenuItem')->name('menu-items.destroy');

            // Get menu item data for editing
            Route::get('menu-items/{id}/edit', 'getMenuItem')->name('menu-items.edit');

            // Update menu structure (order and hierarchy)
            Route::post('menus/update-structure', 'updateMenuStructure')->name('menus.update-structure');
        });

        Route::controller(UserController::class)->group(function () {
            Route::get('user-list', 'user_list')->name('user-list');
            Route::get('user-create', 'user_create')->name('user-create');
            Route::post('user-store', 'user_store')->name('user-store');
            Route::get('pending-user', 'pending_user')->name('pending-user');
            Route::get('user-show/{username}', 'user_show')->name('user-show');
            Route::post('user-login-as/{id}', 'login_as_user')->name('user-login-as');
            Route::delete('user-delete/{id}', 'user_destroy')->name('user-delete');
            Route::put('user-status/{id}', 'user_status')->name('user-status');
            Route::put('user-update/{id}', 'update')->name('user-update');
            Route::get('user-update/{id}', function($id) {
                $user = \App\Models\User::find($id);
                if ($user) {
                    return redirect()->route('admin.user-show', $user->username);
                }
                return redirect()->route('admin.user-list');
            });

            Route::get('seller-list', 'seller_list')->name('seller-list');
            Route::get('pending-seller', 'pending_seller')->name('pending-seller');
            Route::get('seller-show/{username}', 'seller_show')->name('seller-show');

            Route::get('agent-create', 'agent_create')->name('agent-create');
            Route::post('agent-store', 'agent_store')->name('agent-store');

            Route::get('seller-joining-request', 'seller_joining_request')->name('seller-joining-request');
            Route::get('seller-joining-detail/{id}', 'seller_joining_detail')->name('seller-joining-detail');
            Route::put('seller-joining-approval/{id}', 'seller_joining_approval')->name('seller-joining-approval');
            Route::put('seller-joining-reject/{id}', 'seller_joining_reject')->name('seller-joining-reject');
        });

        Route::controller(App\Http\Controllers\Admin\StaffController::class)->group(function () {
            Route::get('staff-list', 'index')->name('staff-list');
            Route::get('staff-create', 'create')->name('staff-create');
            Route::post('staff-store', 'store')->name('staff-store');
            Route::get('staff-show/{id}', 'show')->name('staff-show');
            Route::get('staff-edit/{id}', 'edit')->name('staff-edit');
            Route::put('staff-update/{id}', 'update')->name('staff-update');
            Route::delete('staff-delete/{id}', 'destroy')->name('staff-delete');
            Route::post('staff-login-as/{id}', 'loginAsStaff')->name('staff-login-as');
            Route::get('staff-role-matrix', 'roleMatrix')->name('staff-role-matrix');
            Route::post('staff-role-matrix', 'updateRoleMatrix')->name('staff-role-matrix.update');
            Route::get('agent-role-matrix', 'agentRoleMatrix')->name('agent-role-matrix');
            Route::post('agent-role-matrix', 'updateAgentRoleMatrix')->name('agent-role-matrix.update');
        });

        // Theme Management
        Route::controller(App\Http\Controllers\Admin\ThemeController::class)->group(function () {
            Route::get('themes', 'index')->name('themes.index');
            Route::get('themes/create', 'create')->name('themes.create');
            Route::get('themes/{theme}', 'show')->name('themes.show');
            Route::post('themes/{theme}/activate', 'activate')->name('themes.activate');
            Route::delete('themes/{theme}', 'destroy')->name('themes.destroy');
        });

        // Frontend Management
        Route::controller(FrontEndManagementController::class)->name('front-end.')->group(function () {
            Route::get('/frontend-section', 'index')->name('frontend-section');
            Route::get('/section/{id}', 'section')->name('section');
            Route::put('store/{key}/{id?}', 'store')->name('store');
            Route::get('/frontend-field-template', 'getFieldTemplate')->name('field-template');
            Route::post('/upload-image', [App\Http\Controllers\Admin\UploadController::class, 'editorImage'])->name('upload-image');
        });

        // Live Chat
        Route::prefix('live-chat')->name('live-chat.')->controller(AdminLiveChatController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('json', 'indexJson')->name('json');
            Route::get('{id}', 'show')->name('show');
            Route::post('{id}/send', 'send')->name('send');
            Route::put('{id}/close', 'close')->name('close');
            Route::put('{id}/reopen', 'reopen')->name('reopen');
            Route::get('{id}/messages', 'getMessages')->name('messages');
        });
    });
});
