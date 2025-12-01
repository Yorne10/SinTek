<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get the first user
$user = User::first();

if (!$user) {
    echo "No users found in database!\n";
    exit(1);
}

echo "Testing login for user: " . $user->email . "\n";
echo "User found: " . $user->name . "\n";

// Check for bad characters in user data
echo "Checking user data encoding...\n";
foreach ($user->toArray() as $key => $value) {
    if (is_string($value) && !mb_check_encoding($value, 'UTF-8')) {
        echo "BAD ENCODING in user field '$key': $value\n";
    }
}

// Simulate what AuthService does
$token = $user->createToken('auth-token')->plainTextToken;
echo "Token created.\n";

if ($user->role === 'worker') {
    echo "Loading worker data...\n";
    $user->load('worker.positions');
    if ($user->worker) {
        foreach ($user->worker->toArray() as $key => $value) {
            if (is_string($value) && !mb_check_encoding($value, 'UTF-8')) {
                echo "BAD ENCODING in worker field '$key': $value\n";
            }
        }
    }
}

$response = [
    'success' => true,
    'message' => 'Inicio de sesión exitoso',
    'data' => [
        'user' => $user,
        'token' => $token
    ]
];

echo "Attempting to JSON encode response...\n";
$json = json_encode($response);

if ($json === false) {
    echo "JSON ENCODE ERROR: " . json_last_error_msg() . "\n";
} else {
    echo "JSON encode successful!\n";
}
