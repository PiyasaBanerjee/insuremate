<?php
require 'vendor/autoload.php';

$client = new \GuzzleHttp\Client(['cookies' => true, 'http_errors' => false]);
$response = $client->get('http://127.0.0.1:8000/admin/login');
$html = (string) $response->getBody();

preg_match('/name="_token" value="([^"]+)"/', $html, $matches);
$token = $matches[1] ?? null;
echo "Token: $token\n";

$response = $client->post('http://127.0.0.1:8000/admin/login', [
    'form_params' => [
        '_token' => $token,
        'email' => 'admin@example.com',
        'password' => 'password',
    ]
]);

echo "Status: " . $response->getStatusCode() . "\n";
echo "Body: " . substr($response->getBody(), 0, 100) . "...\n";
