# S/W 인터페이스 설계 및 구현

웹 시스템 수업 예제 및 실습 코드 저장소입니다.

## 사전 준비

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) 설치
- Git 설치

## 목차

| 단원 | 주제 | 스택 |
|------|------|------|
| 01-web-intro/01-static-web | 정적 Web | Nginx |
| 01-web-intro/02-dynamic-php | 동적 Web (PHP) | Nginx + PHP-FPM |
| 01-web-intro/03-dynamic-php-mysql | 동적 Web (PHP + MySQL) | Nginx + PHP-FPM + MySQL |
| 01-web-intro/04-ajax-vanilla | Ajax Web | Nginx + PHP-FPM + MySQL |
| 01-web-intro/05-restful-api | RESTful API + Ajax | Nginx + PHP-FPM + MySQL |
| 01-web-intro/06-spa-react | SPA (React) | Nginx + Node + PHP-FPM + MySQL |
| 02-nginx | 웹서버 설정 | Nginx |
| 03-html | HTML | - |
| 04-css | CSS | - |

## 실행 방법

각 예제 폴더로 이동한 뒤:

```bash
docker compose up
```

종료:

```bash
docker compose down
```
