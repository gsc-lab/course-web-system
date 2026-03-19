# 05 - RESTful API + Ajax

HTTP 메서드(GET/POST/PUT/DELETE)를 활용한 RESTful API로 사용자 CRUD를 구현한다.

## 구성도

```
브라우저 (fetch API)
  │
  ├── GET    /api/users      → 전체 목록 조회
  ├── GET    /api/users/{id} → 단건 조회
  ├── POST   /api/users      → 사용자 생성
  ├── PUT    /api/users/{id} → 사용자 수정
  └── DELETE /api/users/{id} → 사용자 삭제
        │
        ▼
      Nginx → PHP-FPM(프론트 컨트롤러) → MySQL
```

## 기술 스택

| 컨테이너 | 이미지 | 역할 |
|-----------|--------|------|
| web | nginx:alpine | 리버스 프록시 + /api/ 라우팅 |
| php | php:8.3-fpm (커스텀) | RESTful API 처리 |
| db | mysql:8.0 | 데이터 저장소 |

## 실행

```bash
docker compose up
# http://localhost:8080 접속
```

## 핵심 개념

- **REST (Representational State Transfer)**: URI로 자원을 식별하고, HTTP 메서드로 행위를 표현하는 아키텍처 스타일
- **프론트 컨트롤러 패턴**: 모든 API 요청을 단일 PHP 파일(`api/index.php`)에서 라우팅
- **Prepared Statement**: SQL 인젝션 방지를 위해 `?` 플레이스홀더 사용
- **fetch API**: XMLHttpRequest를 대체하는 Promise 기반 HTTP 요청 API
- **04와의 차이**: 04는 단순 GET 조회만, 05는 완전한 CRUD + RESTful 설계

## 파일 구조

```
05-restful-api/
├── Dockerfile           # PHP + pdo_mysql
├── docker-compose.yml   # 3개 컨테이너
├── nginx.conf           # /api/ → 프론트 컨트롤러 라우팅
├── sql/
│   └── init.sql         # 초기 데이터
└── src/
    ├── api/
    │   └── index.php    # RESTful API 라우터 (GET/POST/PUT/DELETE)
    └── index.html       # 프론트엔드 (fetch로 CRUD 호출)
```
