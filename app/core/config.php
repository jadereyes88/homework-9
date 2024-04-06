<?php

// Initialize an empty array to hold environment variables
$env = [];

// the path to the .env file
$envFilePath = '/Users/jadereyes82/homework-9/.env'; // This is an absolute path

// Checking if the .env file exists
if (file_exists($envFilePath)) {
    // Read the file line by line
    $lines = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Split each line into key and value
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $env[$key] = $value;
        }
    }
} else {
    die("Error: .env file not found at $envFilePath");
}

