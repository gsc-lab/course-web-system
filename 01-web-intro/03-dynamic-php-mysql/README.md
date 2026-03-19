# 03 - 동적 Web (PHP + MySQL)

Nginx + PHP-FPM + MySQL 3-tier 아키텍처로 데이터베이스 연동 웹 페이지를 구성한다.

## 구성도

```
브라우저 ──▶ Nginx ──▶ PHP-FPM ──▶ MySQL
             (:80)     (:9000)     (:3306)
                          │
                          ▼
                    PDO로 DB 조회
                          │
                          ▼
                    HTML 테이블 생성 → 브라우저에 반환
```

## 기술 스택

| 컨테이너 | 이미지 | 역할 |
|-----------|--------|------|
| web | nginx:alpine | 리버스 프록시 |
| php | php:8.3-fpm (커스텀) | PHP + PDO MySQL 드라이버 |
| db | mysql:8.0 | 데이터 저장소 |

## 실행

```bash
docker compose up
# http://localhost:8080 접속
```

## 핵심 개념

- **3-tier 아키텍처**: Web 서버 → Application 서버 → Database 서버 분리
- **PDO (PHP Data Objects)**: DB 종류에 관계없이 동일한 API로 접근할 수 있는 추상화 계층
- **Dockerfile**: 공식 PHP 이미지에 `pdo_mysql` 확장을 추가 설치
- **docker-entrypoint-initdb.d**: MySQL 컨테이너 최초 기동 시 SQL 파일을 자동 실행

## 파일 구조

```
03-dynamic-php-mysql/
├── Dockerfile           # PHP + pdo_mysql 확장 설치
├── docker-compose.yml   # 3개 컨테이너 정의
├── nginx.conf           # FastCGI 프록시 설정
├── sql/
│   └── init.sql         # 테이블 생성 + 샘플 데이터
└── src/
    └── index.php        # DB 조회 → HTML 테이블 렌더링
```
