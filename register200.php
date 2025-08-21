<?php
// Database connection
$pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password);

$data = json_decode(file_get_contents('php://input'), true);

$email = $data['email'] ?? '';
$password = $data['password'] ?? '';
$gender = $data['gender'] ?? '';

// Validate input
if (empty($email) || empty($password) || empty($gender)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
    exit;
}

// Check if user exists
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    echo json_encode(['status' => 'error', 'message' => 'User already exists']);
    exit;
}

// Hash password and create user
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$verificationToken = bin2hex(random_bytes(32));

$stmt = $pdo->prepare("INSERT INTO users (email, password, gender, verification_token) VALUES (?, ?, ?, ?)");
if ($stmt->execute([$email, $hashedPassword, $gender, $verificationToken])) {
    // Send verification email (implementation would go here)
    echo json_encode(['status' => 'success', 'message' => 'User registered. Please check your email for verification.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Registration failed']);
}
?>