# 04 - Ajax Web (Vanilla JS)

페이지 새로고침 없이 JavaScript(fetch API)로 서버 데이터를 비동기 요청하여 화면을 갱신한다.

## 구성도

```
브라우저 ─── index.html 로드 ──▶ Nginx
  │                               (:80)
  │
  └── JS: fetch() ──▶ /api.php ──▶ PHP-FPM ──▶ MySQL
                                    (:9000)    (:3306)
       ◀── JSON 응답 ──────────────┘
  │
  └── DOM 부분 업데이트 (동적 영역만 갱신)
```

## 기술 스택

| 컨테이너 | 이미지 | 역할 |
|-----------|--------|------|
| web | nginx:alpine | 정적 파일 + FastCGI 프록시 |
| php | php:8.3-fpm (커스텀) | JSON API 제공 |
| db | mysql:8.0 | 데이터 저장소 |

## 실행

```bash
docker compose up
# http://localhost:8080 접속 → "데이터 불러오기" 버튼 클릭
```

## 핵심 개념

- **Ajax**: Asynchronous JavaScript and XML. 페이지 전체를 새로고침하지 않고 서버와 비동기 통신
- **fetch API**: Promise 기반 HTTP 요청 API (XMLHttpRequest의 후속)
- **부분 업데이트**: 정적 영역(페이지 로드 시각)은 유지되고, 동적 영역(테이블)만 갱신됨을 시각적으로 확인
- **JSON**: 서버-클라이언트 간 데이터 교환 형식 (XML보다 경량)
- **03과의 차이**: 03은 서버에서 HTML을 완성하여 전달(SSR), 04는 클라이언트에서 JSON을 받아 DOM을 조작(CSR)

## 파일 구조

```
04-ajax-vanilla/
├── Dockerfile           # PHP + pdo_mysql
├── docker-compose.yml   # 3개 컨테이너
├── nginx.conf           # FastCGI 프록시
├── sql/
│   └── init.sql         # 초기 데이터
└── src/
    ├── api.php          # JSON API 엔드포인트
    └── index.html       # 프론트엔드 (fetch API + 정적/동적 영역 분리)
```
