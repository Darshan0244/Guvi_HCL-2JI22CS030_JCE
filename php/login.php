<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

try {
    $pdo = new PDO('mysql:host=localhost;port=3307;dbname=user_management', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);
    
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Email and password are required']);
        exit;
    }
    
    // Verify the user Passwords or his Credentials
    $stmt = $pdo->prepare("SELECT id, username, email, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user || !password_verify($password, $user['password'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
        exit;
    }
    
    // Create the session token
    $sessionToken = bin2hex(random_bytes(32));
    $sessionData = json_encode([
        'userId' => $user['id'],
        'username' => $user['username'],
        'email' => $user['email'],
        'loginTime' => time()
    ]);
    
    // Store session in Redis -> This will expire in 24hrs
    $redis->setex($sessionToken, 86400, $sessionData);
    
    echo json_encode([
        'success' => true,
        'userId' => $user['id'],
        'username' => $user['username'],
        'email' => $user['email'],
        'sessionToken' => $sessionToken
    ]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Login error: ' . $e->getMessage()]);
}
?>