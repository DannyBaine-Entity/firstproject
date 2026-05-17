<?php
include "connection2.php";

header('Content-Type: application/json');

try {
$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? $_GET['id'] : null;

    // Connect to database using PDO
    $conn = new PDO("mysql:host=localhost;dbname=testdb", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle different HTTP methods
    switch ($method) {
        case 'GET':
            // Get user data - either specific user by ID or all users
            if ($id) {
                // Fetch single user
                $stmt = $conn->prepare("SELECT id, username, email, rolez FROM users WHERE id = ?");
                $stmt->execute([$id]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                // Return user data or error if not found
                echo json_encode($user ? $user : ['error' => 'User not found']);
            } else {
                // Fetch all users
                $stmt = $conn->prepare("SELECT id, username, email, rolez FROM users");
                $stmt->execute();
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($users);
            }
            break;

case 'POST':
            // Create new user
            // Get data from JSON or form post
            $data = json_decode(file_get_contents('php://input'), true);
            if (!$data) $data = $_POST;
            // Validate data
            if (!$data || !is_array($data)) {
                echo json_encode(['error' => 'Invalid data']);
                break;
            }
          
            $username = $data['username'];
            $email = $data['email'];
            $password = $data['password'];
            $rolez = isset($data['rolez']) && $data['rolez'] == '1' ? 1 : 0;
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            // Insert new user into database
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, rolez) VALUES (?, ?, ?, ?)");
            $stmt->execute([$username, $email, $hashed, $rolez]);
            echo json_encode(['message' => 'User created']);
            break;



             default:
            // Handle unsupported HTTP methods
            echo json_encode(['error' => 'Method not allowed']);
    }

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}





?>