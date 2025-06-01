<?php
require_once 'vendor/autoload.php'; // Path ke Composer autoload

$client = new Google_Client();
$client->setClientId('167023857534-gu24shptcce1lbbpgi1c0d2fcuab0f13.apps.googleusercontent.com'); // Ganti dengan Client ID kamu
$client->setClientSecret('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'); // Ganti dengan Client Secret kamu
$client->setRedirectUri('http://localhost/caferacing/callback.php'); // Ganti nama folder kamu
$client->addScope("email");
$client->addScope("profile");
$client->setPrompt('select_account');

$login_url = $client->createAuthUrl();
header('Location: ' . filter_var($login_url, FILTER_SANITIZE_URL));
exit();
