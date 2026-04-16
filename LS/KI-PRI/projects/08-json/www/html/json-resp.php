<?php
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $input = json_decode(file_get_contents('php://input'), true);

  $name = $input['name'] ?? 'Guest';
  $email = $input['email'] ?? 'unknown';
  $response = [
    'message' => 'Hello ' . htmlspecialchars($name) . ', received: ' . htmlspecialchars($email),
    'timestamp' => date('Y-m-d H:i:s')
  ];
} else {
  $response = [
    'error' => 'Invalid request method. Please use POST.'
  ];
}

echo json_encode($response);
