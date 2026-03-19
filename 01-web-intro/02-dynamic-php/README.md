# 02 - 동적 Web (PHP)

Nginx와 PHP-FPM을 연동하여 서버에서 동적으로 HTML을 생성하는 구성이다.

## 구성도

```
브라우저 ─── HTTP 요청 ──▶ Nginx ─── .php 요청 ──▶ PHP-FPM ─── 동적 HTML 반환
                           (:80)    FastCGI        (:9000)
```

## 기술 스택

| 컨테이너 | 이미지 | 역할 |
|-----------|--------|------|
| web | nginx:alpine | 리버스 프록시 + 정적 파일 서빙 |
| php | php:8.3-fpm | PHP 스크립트 실행 (FastCGI) |

## 실행

```bash
docker compose up
# http://localhost:8080 접속
```

## 핵심 개념

- **CGI/FastCGI**: 웹 서버가 동적 콘텐츠 생성을 외부 프로세스에 위임하는 프로토콜이다.
- **PHP-FPM**: FastCGI Process Manager. PHP 프로세스를 풀(pool)로 관리하여 성능을 높인다.
- **리버스 프록시**: Nginx가 `.php` 요청을 PHP-FPM에 전달하고 결과를 클라이언트에 반환한다.

## 파일 구조

```
02-dynamic-php/
├── docker-compose.yml   # Nginx + PHP-FPM 2개 컨테이너 정의
├── nginx.conf           # Nginx → PHP-FPM FastCGI 프록시 설정
└── src/
    └── index.php        # 서버 시간과 PHP 버전을 동적으로 출력
```
