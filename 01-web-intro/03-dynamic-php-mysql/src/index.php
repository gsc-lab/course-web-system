<?php
// --- DB 연결 ---
// PDO(PHP Data Objects)를 사용하여 MySQL에 접속한다.
// 'host=db'에서 'db'는 docker-compose.yml에 정의된 서비스 이름이다.
// Docker Compose 네트워크 내에서 서비스 이름이 곧 호스트명이 된다.
// charset=utf8mb4: 한글이 깨지지 않도록 UTF-8 문자셋으로 연결
try {
    $pdo = new PDO('mysql:host=db;dbname=example;charset=utf8mb4', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('DB 연결 실패: ' . $e->getMessage());
}

// --- POST 요청 처리: 새 사용자 등록 ---
// 폼에서 submit하면 같은 페이지로 POST 요청이 전송된다.
// 등록 후 header()로 리다이렉트하여 새로고침 시 중복 등록을 방지한다 (PRG 패턴).
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    if ($name && $email) {
        $stmt = $pdo->prepare('INSERT INTO users (name, email) VALUES (?, ?)');
        $stmt->execute([$name, $email]);
    }
    header('Location: /');   // PRG(Post-Redirect-Get) 패턴
    exit;
}

// --- 사용자 목록 조회 ---
$stmt = $pdo->query('SELECT * FROM users ORDER BY id');
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>동적 Web - PHP + MySQL</title>
    <style>
        table { border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 8px; }
        input { padding: 4px; margin-right: 5px; }
    </style>
</head>
<body>
    <h1>사용자 목록</h1>

    <?php // --- 사용자 등록 폼 --- ?>
    <?php // form의 method="POST"로 설정하면 서버에 데이터를 전송한다. ?>
    <form method="POST">
        <input type="text" name="name" placeholder="이름" required>
        <input type="email" name="email" placeholder="이메일" required>
        <button type="submit">등록</button>
    </form>

    <?php // --- DB에서 읽어온 데이터를 테이블로 출력 --- ?>
    <table>
        <tr><th>ID</th><th>이름</th><th>이메일</th><th>등록일</th></tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <?php // htmlspecialchars(): XSS 방지를 위해 HTML 특수문자를 이스케이프 ?>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= $user['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
