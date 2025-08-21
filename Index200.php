<?php
// EternalBliss Backend API
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'config.php';

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'register':
        require_once 'register.php';
        break;
    case 'login':
        require_once 'login.php';
        break;
    case 'forgot_password':
        require_once 'forgot_password.php';
        break;
    case 'process_payment':
        require_once 'process_payment.php';
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}
?>