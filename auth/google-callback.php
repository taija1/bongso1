<?php
require_once '../config/config.php';
require_once '../vendor/autoload.php';

// Initialize Google Client
$client = new Google_Client([
    'client_id' => $config['social']['google']['client_id'],
    'client_secret' => $config['social']['google']['client_secret']
]);

try {
    // Get payload data
    $payload = $client->verifyIdToken($_POST['credential']);
    
    if ($payload) {
        $userData = [
            'google_id' => $payload['sub'],
            'email' => $payload['email'],
            'name' => $payload['name'],
            'picture' => $payload['picture'],
            'locale' => $payload['locale']
        ];

        // TODO: Check if user exists in database
        // TODO: Create new user if not exists
        // TODO: Create session
        
        echo json_encode([
            'success' => true,
            'message' => 'Đăng nhập thành công!',
            'redirect' => '/dashboard.php'
        ]);
    }
} catch(Exception $e) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Xác thực thất bại: ' . $e->getMessage()
    ]);
}
