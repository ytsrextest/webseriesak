<?php
session_start();
require_once("lib/autoload.php");
if(file_exists(__DIR__ . "/../.env")) {
    $dotenv = new Dotenv\Dotenv(__DIR__ . "/../");
    $dotenv->load();
}

// testing
Braintree_Configuration::environment('sandbox');

//production
// Braintree_Configuration::environment('production');

Braintree_Configuration::merchantId('7tfb3bxpbkgs3xtm');
Braintree_Configuration::publicKey('54zcqxf27q2mbhyg');
Braintree_Configuration::privateKey('b6318c656defd3e9501256aaab75d8ad');
?>