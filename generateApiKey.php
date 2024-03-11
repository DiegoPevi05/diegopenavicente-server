<?php

function generateApiKey($length = 32)
{
    // Characters allowed in the API key
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%&*?';

    // Generate a random string of specified length
    $apiKey = '';
    for ($i = 0; $i < $length; $i++) {
        $apiKey .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $apiKey;
}

// Generate a new API key
$apiKey = generateApiKey(64);

echo "Generated API Key: $apiKey\n";