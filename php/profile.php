<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

try {
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);
    
    $mongo = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    
    $userId = $_REQUEST['userId'] ?? '';
    $sessionToken = $_REQUEST['sessionToken'] ?? '';
    
    if (empty($userId) || empty($sessionToken)) {
        echo json_encode(['success' => false, 'message' => 'Invalid session']);
        exit;
    }
    
    // Verify the session
    $sessionData = $redis->get($sessionToken);
    if (!$sessionData) {
        echo json_encode(['success' => false, 'message' => 'Session expired']);
        exit;
    }
    
    $session = json_decode($sessionData, true);
    if ($session['userId'] != $userId) {
        echo json_encode(['success' => false, 'message' => 'Invalid session']);
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Get the data of the User Profile
        $filter = ['userId' => (int)$userId];
        $query = new MongoDB\Driver\Query($filter);
        $cursor = $mongo->executeQuery('user_management.profiles', $query);
        
        $profile = null;
        foreach ($cursor as $document) {
            $profile = $document;
            break;
        }
        
        echo json_encode([
            'success' => true,
            'profile' => $profile ? [
                'age' => $profile->age ?? '',
                'dob' => $profile->dob ?? '',
                'contact' => $profile->contact ?? '',
                'address' => $profile->address ?? ''
            ] : null
        ]);
        
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Update the data of the User
        $profileData = [
            'userId' => (int)$userId,
            'age' => $_POST['age'] ?? '',
            'dob' => $_POST['dob'] ?? '',
            'contact' => $_POST['contact'] ?? '',
            'address' => $_POST['address'] ?? '',
            'updatedAt' => new MongoDB\BSON\UTCDateTime()
        ];
        
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update(
            ['userId' => (int)$userId],     // filter
            ['$set' => $profileData],       // update data
            ['upsert' => true]              // options
        );
        
        $result = $mongo->executeBulkWrite('user_management.profiles', $bulk);
        
        echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Profile error: ' . $e->getMessage()]);
}
?>