<?php
// --- RESTful API 프론트 컨트롤러 ---
// 모든 /api/ 요청이 이 파일 하나로 라우팅된다 (nginx.conf의 try_files 참고).
// HTTP 메서드(GET/POST/PUT/DELETE)에 따라 CRUD 동작을 수행한다.
//
// RESTful 규칙:
//   GET    /api/users      → 전체 조회 (Read)
//   GET    /api/users/{id} → 단건 조회 (Read)
//   POST   /api/users      → 생성 (Create)
//   PUT    /api/users/{id} → 수정 (Update)
//   DELETE /api/users/{id} → 삭제 (Delete)

header('Content-Type: application/json; charset=utf-8');

$pdo = new PDO('mysql:host=db;dbname=example;charset=utf8mb4', 'root', 'root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// URI에서 HTTP 메서드와 경로 세그먼트를 추출하여 라우팅
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($uri, '/'));   // 예: "/api/users/3" → ["api", "users", "3"]

if ($segments[0] === 'api' && isset($segments[1]) && $segments[1] === 'users') {
    $id = $segments[2] ?? null;              // URI에 ID가 포함되었는지 확인

    switch ($method) {
        case 'GET':
            if ($id) {
                // prepare(): SQL 인젝션 방지를 위한 Prepared Statement
                $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
                $stmt->execute([$id]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($user ?: ['error' => 'Not found'], JSON_UNESCAPED_UNICODE);
            } else {
                $stmt = $pdo->query('SELECT * FROM users');
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
            }
            break;

        case 'POST':
            // php://input: POST 요청의 raw body를 읽는다 (JSON 파싱)
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare('INSERT INTO users (name, email) VALUES (?, ?)');
            $stmt->execute([$data['name'], $data['email']]);
            http_response_code(201);         // 201 Created: 리소스 생성 성공
            echo json_encode(['id' => $pdo->lastInsertId()], JSON_UNESCAPED_UNICODE);
            break;

        case 'PUT':
            if (!$id) { http_response_code(400); echo json_encode(['error' => 'ID required']); break; }
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare('UPDATE users SET name = ?, email = ? WHERE id = ?');
            $stmt->execute([$data['name'], $data['email'], $id]);
            echo json_encode(['updated' => $stmt->rowCount()]);
            break;

        case 'DELETE':
            if (!$id) { http_response_code(400); echo json_encode(['error' => 'ID required']); break; }
            $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
            $stmt->execute([$id]);
            echo json_encode(['deleted' => $stmt->rowCount()]);
            break;

        default:
            http_response_code(405);         // 405 Method Not Allowed
            echo json_encode(['error' => 'Method not allowed']);
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Not found']);
}
