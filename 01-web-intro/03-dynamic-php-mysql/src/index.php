<?php
// --- DB 연결 및 데이터 조회 ---
// PDO(PHP Data Objects)를 사용하여 MySQL에 접속한다.
// 'host=db'에서 'db'는 docker-compose.yml에 정의된 서비스 이름이다.
// Docker Compose 네트워크 내에서 서비스 이름이 곧 호스트명이 된다.
try {
    $pdo = new PDO('mysql:host=db;dbname=example', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // 오류 발생 시 예외 던지기
    $stmt = $pdo->query('SELECT * FROM users');
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);   // 연관 배열로 전체 결과 가져오기
} catch (PDOException $e) {
    die('DB 연결 실패: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>동적 Web - PHP + MySQL</title>
</head>
<body>
    <h1>사용자 목록</h1>
    <table border="1">
        <tr><th>ID</th><th>이름</th><th>이메일</th><th>등록일</th></tr>
        <!-- PHP의 대체 문법(foreach/endforeach)으로 HTML 템플릿 내에서 반복 출력 -->
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <!-- htmlspecialchars(): XSS 방지를 위해 HTML 특수문자를 이스케이프 -->
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= $user['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
