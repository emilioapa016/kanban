<?php

$host = 'localhost';
$db = 'kanban_board';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$method = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

$urlParts = explode('/', trim($requestUri, '/'));

$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'POST':
        if (!isset($input['title'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO items (title, stage) VALUES (?, ?)");
        $stmt->execute([$input['title'], 1]);

        $id = $pdo->lastInsertId();
        $newItem = ['id' => $id, 'title' => $input['title'], 'stage' => 1];

        http_response_code(201);
        echo json_encode($newItem);
        break;

    case 'PUT':
        $id = end($urlParts) ?? null;
        if (!isset($input['stage']) || !in_array($input['stage'], [1, 2, 3])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid stage value']);
            exit;
        }

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID is required']);
            exit;
        }

        $stmt = $pdo->prepare("UPDATE items SET stage = ? WHERE id = ?");
        $stmt->execute([$input['stage'], $id]);

        $stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
        $stmt->execute([$id]);
        $item = $stmt->fetch();

        if (!$item) {
            http_response_code(404);
            echo json_encode(['error' => 'Item not found']);
            exit;
        }

        http_response_code(200);
        echo json_encode($item);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}

