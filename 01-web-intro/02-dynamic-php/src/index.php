<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>동적 Web - PHP</title>
</head>
<body>
    <h1>동적 Web 페이지</h1>
    <?php
    // 단축 출력 태그(<?=)는 echo와 동일하다.
    // 정적 HTML과 달리 서버에서 실행 시점의 데이터를 동적으로 생성한다.
    ?>
    <p>현재 서버 시간: <?= date('Y-m-d H:i:s') ?></p>
    <p>PHP 버전: <?= phpversion() ?></p>
</body>
</html>
