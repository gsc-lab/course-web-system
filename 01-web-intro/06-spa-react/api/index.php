<?php
// --- SPA용 REST API 백엔드 ---
// React(프론트엔드)와 PHP(백엔드)가 별도 서버로 분리되어 있으므로
// CORS(Cross-Origin Resource Sharing) 헤더가 필요하다.

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');                  // 모든 출처 허용 (학습용)
header('Access-Control-Allow-Methods: GET, POST, DELETE'); // 허용할 HTTP 메서드
header('Access-Control-Allow-Headers: Content-Type');      // 허용할 요청 헤더

// CORS preflight 요청(OPTIONS) 처리: 브라우저가 본 요청 전에 보내는 사전 검사
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

$pdo = new PDO('mysql:host=db;dbname=example;charset=utf8mb4', 'root', 'root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($uri, '/'));

// /api/users or /api/users/{id}
if ($segments[0] === 'api' && isset($segments[1]) && $segments[1] === 'users') {
    $id = $segments[2] ?? null;

    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
                $stmt->execute([$id]);
                echo json_encode($stmt->fetch(PDO::FETCH_ASSOC) ?: ['error' => 'Not found'], JSON_UNESCAPED_UNICODE);
            } else {
                $stmt = $pdo->query('SELECT * FROM users');
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
            }
            break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare('INSERT INTO users (name, email) VALUES (?, ?)');
            $stmt->execute([$data['name'], $data['email']]);
            http_response_code(201);
            echo json_encode(['id' => $pdo->lastInsertId()]);
            break;

        case 'DELETE':
            if (!$id) { http_response_code(400); echo json_encode(['error' => 'ID required']); break; }
            $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
            $stmt->execute([$id]);
            echo json_encode(['deleted' => $stmt->rowCount()]);
            break;

        default:
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Not found']);
}
