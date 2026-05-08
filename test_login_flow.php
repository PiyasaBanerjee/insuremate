<?php
require 'vendor/autoload.php';
// 1. Get User Login Form
$client = new \GuzzleHttp\Client(['cookies' => true, 'http_errors' => false]);
$res = $client->get('http://127.0.0.1:8000/login');
preg_match('/name="_token" value="([^"]+)"/', (string) $res->getBody(), $matches);
$token = $matches[1] ?? null;

// 2. Login as User (I'll just try to login, even if it fails authentication, we get a session)
$res = $client->post('http://127.0.0.1:8000/login', [
    'form_params' => [
        '_token' => $token,
        'email' => 'user@example.com',
        'password' => 'password',
    ]
]);

// 3. Get Admin Login Form
$res = $client->get('http://127.0.0.1:8000/admin/login');
preg_match('/name="_token" value="([^"]+)"/', (string) $res->getBody(), $matches);
$adminToken = $matches[1] ?? null;

// 4. Submit Admin Login
$res = $client->post('http://127.0.0.1:8000/admin/login', [
    'form_params' => [
        '_token' => $adminToken,
        'email' => 'admin@email.com',
        'password' => 'password',
    ]
]);

echo "Status: " . $res->getStatusCode() . "\n";
echo "Body: " . substr($res->getBody(), 0, 100) . "...\n";
