<?php
// --- JSON API 엔드포인트 ---
// 이 파일은 HTML이 아닌 JSON 데이터를 반환하는 API 역할을 한다.
// 브라우저의 JavaScript(XMLHttpRequest)가 이 엔드포인트를 호출한다.

header('Content-Type: application/json; charset=utf-8');  // 응답 형식을 JSON으로 지정

$pdo = new PDO('mysql:host=db;dbname=example', 'root', 'root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->query('SELECT * FROM users');
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// JSON_UNESCAPED_UNICODE: 한글이 \uXXXX로 이스케이프되지 않도록 설정
echo json_encode($users, JSON_UNESCAPED_UNICODE);
