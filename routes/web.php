<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Auth::routes(['verify' => false]);

// Public Routes
Route::get('/', [App\Http\Controllers\FrontController::class, 'index'])->name('landing');
Route::get('/insurance/compare', [App\Http\Controllers\FrontController::class, 'compare'])->name('compare');
Route::get('/insurance/{slug}', [App\Http\Controllers\FrontController::class, 'category'])->name('frontend.category');
Route::get('/insurance/plan/{slug}', [App\Http\Controllers\FrontController::class, 'showPlan'])->name('frontend.plan');


// Public Routes
Route::get('/', [App\Http\Controllers\FrontController::class, 'index'])->name('landing');
Route::get('/insurance/compare', [App\Http\Controllers\FrontController::class, 'compare'])->name('compare');
Route::get('/insurance/{slug}', [App\Http\Controllers\FrontController::class, 'category'])->name('frontend.category');
Route::get('/insurance/plan/{slug}', [App\Http\Controllers\FrontController::class, 'showPlan'])->name('frontend.plan');


Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.submit');
Route::get('/faq', [App\Http\Controllers\FrontController::class, 'faq'])->name('faq');

Route::get('/test-gemini', function () {
    $key = env('GEMINI_API_KEY');
    if (!$key)
        return response()->json(['error' => 'No key found in .env']);

    $response = \Illuminate\Support\Facades\Http::withHeaders(['Content-Type' => 'application/json'])
        ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$key}", [
            'contents' => [['parts' => [['text' => 'Hello, please reply with exactly the word SUCCESS.']]]]
        ]);

    return response()->json([
        'status' => $response->status(),
        'body' => $response->json()
    ]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/plan/{plan}/apply', [App\Http\Controllers\FrontController::class, 'showApplyForm'])->name('plan.apply');
    Route::post('/plan/{plan}/apply', [App\Http\Controllers\PaymentController::class, 'checkout'])->name('plan.apply.submit');
    Route::get('/payment/success', [App\Http\Controllers\PaymentController::class, 'success'])->name('stripe.success');
    Route::get('/payment/cancel', [App\Http\Controllers\PaymentController::class, 'cancel'])->name('stripe.cancel');

    // Profile Customization
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // Notifications
    Route::post('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::get('/test-notification', function() {
        $user = auth()->user();
        if($user) {
            $user->notify(new \App\Notifications\UpcomingRenewalNotification(
                \App\Models\Policy::first() ?? new \App\Models\Policy(['next_renewal_date' => now()->addDays(5), 'plan' => (object)['name' => 'Test Plan']])
            ));
            return redirect()->route('home')->with('success', 'Test notification sent! Check your bell icon.');
        }
        return "Please log in first!";
    });

    // Claims
    Route::get('/claims/create/{policy}', [App\Http\Controllers\ClaimController::class, 'create'])->name('claims.create');
    Route::post('/claims/create/{policy}', [App\Http\Controllers\ClaimController::class, 'store'])->name('claims.store');
    Route::get('/claims/{claim}/download', [App\Http\Controllers\ClaimController::class, 'download'])->name('claims.download');

    // Renewal
    Route::get('/policy/{policy}/renew', [App\Http\Controllers\PolicyController::class, 'showRenewForm'])->name('policy.renew');
    Route::post('/policy/{policy}/renew', [App\Http\Controllers\PolicyController::class, 'renew'])->name('policy.renew.submit');
    Route::get('/policy/{policy}', [App\Http\Controllers\PolicyController::class, 'show'])->name('policy.show');
    Route::get('/policy/{policy}/download', [App\Http\Controllers\PolicyController::class, 'download'])->name('policy.download');

    Route::get('/test-gemini', function () {
        $key = env('GEMINI_API_KEY');
        if (!$key)
            return response()->json(['error' => 'No key found in .env']);

        $response = \Illuminate\Support\Facades\Http::withHeaders(['Content-Type' => 'application/json'])
            ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$key}", [
                'contents' => [['parts' => [['text' => 'Hello, please reply with exactly the word SUCCESS.']]]]
            ]);

        return response()->json([
            'status' => $response->status(),
            'body' => $response->json()
        ]);
    });

    // Support Tickets (User)
    Route::resource('tickets', App\Http\Controllers\SupportTicketController::class)->only(['index', 'create', 'store', 'show']);

    // Real-Time Chat Widget
    Route::get('/chat/history', [App\Http\Controllers\ChatController::class, 'history'])->name('chat.history');
    Route::post('/chat/send', [App\Http\Controllers\ChatController::class, 'sendMessage'])->name('chat.send');

    // Agent Portal
    Route::get('/agent/apply', [App\Http\Controllers\Agent\DashboardController::class, 'applyForm'])->name('agent.apply');
    Route::post('/agent/apply', [App\Http\Controllers\Agent\DashboardController::class, 'applyStore'])->name('agent.apply.store');
    Route::get('/agent/dashboard', [App\Http\Controllers\Agent\DashboardController::class, 'index'])->name('agent.dashboard');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});


// Admin Routes
// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {


    Route::middleware('admin')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Manage Categories
        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
        // Manage Plans
        Route::resource('plans', App\Http\Controllers\Admin\PlanController::class);
        // Manage Policies
        Route::resource('policies', App\Http\Controllers\Admin\PolicyController::class)->except(['destroy']);
        Route::post('policies/{policy}/resend', [App\Http\Controllers\Admin\PolicyController::class, 'resendDocument'])->name('policies.resend');
        // Manage Claims
        Route::get('claims/export', [App\Http\Controllers\Admin\ClaimController::class, 'export'])->name('claims.export');
        Route::resource('claims', App\Http\Controllers\Admin\ClaimController::class);
        // Manage Tickets
        Route::resource('tickets', App\Http\Controllers\Admin\TicketController::class)->only(['index', 'update', 'show']);

        // Manage Payments
        Route::get('/payments', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');

        // Manage Contact Messages
        Route::get('/contacts', [App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contacts.index');
        Route::delete('/contacts/{contactMessage}', [App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contacts.destroy');

        // Manage Users
        Route::resource('users', App\Http\Controllers\Admin\UserController::class)->except(['show']);

        // Manage Agents
        Route::get('/agents', [App\Http\Controllers\Admin\AgentController::class, 'index'])->name('agents.index');
        Route::get('/agents/{agent}', [App\Http\Controllers\Admin\AgentController::class, 'show'])->name('agents.show');
        Route::patch('/agents/{agent}/approve', [App\Http\Controllers\Admin\AgentController::class, 'approve'])->name('agents.approve');
        Route::patch('/agents/{agent}/reject', [App\Http\Controllers\Admin\AgentController::class, 'reject'])->name('agents.reject');
        Route::patch('/agents/{agent}/mark-paid', [App\Http\Controllers\Admin\AgentController::class, 'markPaid'])->name('agents.mark_paid');
    });
});
