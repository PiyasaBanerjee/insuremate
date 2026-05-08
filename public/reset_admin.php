<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$admin = \App\Models\Admin::where('email', 'admin@insurance.com')->first();
if ($admin) {
    $admin->password = \Illuminate\Support\Facades\Hash::make('password');
    $admin->save();
    echo "Admin password reset successfully!";
} else {
    echo "Admin not found! Creating one...";
    \App\Models\Admin::create([
        'name' => 'Super Admin',
        'email' => 'admin@insurance.com',
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
    ]);
    echo "Created successfully.";
}
